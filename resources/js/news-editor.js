/**
 * Alpine component: inisialisasi Quill pada elemen x-ref="quillEl".
 *
 * Fitur:
 *  - Sinkronisasi ke input hidden x-ref="contentInput" via event text-change.
 *  - Upload gambar (drop, paste, toolbar) via fetch POST ke
 *    dashboard.berita.upload-gambar; SANGKAEA base64 — selalu upload ke server.
 *  - Preview banner live saat file dipilih.
 *
 * Catatan: Quill 2 tidak punya API resmi untuk menonaktifkan gambar base64
 * sepenuhnya. Solusi: override clipboard matcher + interceptor paste/drop
 * untuk mengirim file ke server dan gunakan insertEmbed('image', url).
 */

import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Daftar modul Alpine global yang harus tersedia di semua page (app.js).
window.Alpine.data('newsForm', () => ({
    loading: false,
    previewUrl: null,
    hapusBanner: false,
    mediaOpen: false,
    mediaList: [],
    mediaLoading: false,
    mediaPage: 1,
    mediaLastPage: 1,
    mediaQuery: '',

    /** Dipanggil saat file banner dipilih di input <input type="file">. */
    bacaBanner(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            this.previewUrl = e.target.result;
        };
        reader.readAsDataURL(file);
    },

    /** Buka modal pustaka media & muat daftar. */
    async openMedia() {
        this.mediaOpen = true;
        await this.loadMedia();
    },

    async loadMedia() {
        this.mediaLoading = true;
        try {
            const mediaUrl = this.$root?.dataset?.mediaUrl
                || document.querySelector('[data-media-url]')?.dataset?.mediaUrl
                || '/dashboard/admin/media';
            const res = await fetch(`${mediaUrl}?q=${encodeURIComponent(this.mediaQuery)}&page=${this.mediaPage}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (!res.ok) throw new Error('Gagal memuat pustaka media');
            const data = await res.json();
            this.mediaList = data.media.data;
            this.mediaLastPage = data.media.last_page;
        } finally {
            this.mediaLoading = false;
        }
    },

    mediaBuka(side) {
        if (side === 'next' && this.mediaPage < this.mediaLastPage) {
            this.mediaPage++;
        } else if (side === 'prev' && this.mediaPage > 1) {
            this.mediaPage--;
        } else {
            return;
        }
        this.loadMedia();
    },

    /** Sisipkan gambar dari pustaka ke posisi kursor Quill. */
    insertMedia(media) {
        const quill = this.$refs.quillEl?.__quill;
        if (!quill) return;
        const range = quill.getSelection(true);
        quill.insertEmbed(range.index, 'image', media.url);
        quill.setSelection(range.index + 1);
        this.mediaOpen = false;
    },

    /**
        // Inisialisasi Quill editor.
     * Dipanggil sekali dari x-init di view form berita.
     */
    initQuill() {
        const el = this.$refs.quillEl;
        if (!el) {
            console.warn('newsForm: $refs.quillEl tidak ditemukan — cek scope x-data/x-ref di berita-form.');
            return;
        }
        if (el.__quill) return; // sudah inisialisasi

        const quill = new Quill(el, {
            modules: {
                toolbar: '#quill-toolbar',
            },
            theme: 'snow',
        });

        el.__quill = quill;

        // Sinkronisasi content ke input hidden
        quill.on('text-change', (delta, oldDelta, source) => {
            if (source === 'user') {
                this.$refs.contentInput.value = quill.root.innerHTML;
            }
        });

        // Intercept semua penyisipan gambar — ganti base64 dengan upload.
        // 1. Toolbar upload button (via clipboard / file picker)
        quill.container.addEventListener('paste', (e) => {
            const items = Array.from(e.clipboardData.items);
            const imageItem = items.find((it) => it.type.startsWith('image/'));

            if (imageItem) {
                e.preventDefault();
                const file = imageItem.getFile();
                this.uploadQuillImage(file, quill);
            }
        });

        quill.root.addEventListener('drop', (e) => {
            const files = Array.from(e.dataTransfer.files);
            const imageFiles = files.filter((f) => f.type.startsWith('image/'));
            if (imageFiles.length) {
                e.preventDefault();
                imageFiles.forEach((f) => this.uploadQuillImage(f, quill));
            }
        });

        // 2. Toolbar "insert image" default — ganti handler
        const toolbar = quill.getModule('toolbar');
        toolbar.addHandler('image', () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.click();

            input.onchange = () => {
                const file = input.files[0];
                if (file) this.uploadQuillImage(file, quill);
            };
        });

        // 3. Ubah lebar gambar via dropdown "Ukuran gambar".
        // Select ini sengaja TIDAK memakai kelas `ql-*` supaya Quill tidak
        // mencoba me-bind ke format yang tidak ada; kita pasang listener sendiri.
        const widthSelect = this.$root.querySelector('.image-width-select');
        if (widthSelect) {
            widthSelect.addEventListener('change', () => {
                const value = widthSelect.value;
                widthSelect.value = '';

                if (!value) return;

                const sel = quill.getSelection();
                if (!sel || sel.length > 0) return;

                const blot = quill.getLeaf(sel.index);
                if (!blot || !blot[0] || blot[0].domNode.tagName !== 'IMG') return;

                blot[0].domNode.setAttribute('width', value);
                // Tandai sebagai perubahan user supaya sinkron ke input hidden.
                quill.update('user');
                quill.setSelection(sel.index);
            });
        }

        // Inisialisasi teks dari input hidden (saat edit).
        // Quill 2: pakai setContents + clipboard.convert (dangerouslySetHTML
        // hanya ada di Quill 1).
        const existing = this.$refs.contentInput.value || '';
        if (existing) {
            quill.setContents(quill.clipboard.convert({ html: existing }), 'silent');
        }
    },

    /**
     * Upload satu file ke server, kemudian sisipkan <img> ke posisi kursor Quill.
     */
    async uploadQuillImage(file, quill) {
        const url = await this.uploadFile(file);
        const range = quill.getSelection(true);
        quill.insertEmbed(range.index, 'image', url);
        quill.setSelection(range.index + 1);
    },

    /**
     * Kirim file ke endpoint upload-gambar; kembalikan URL publik.
     */
    async uploadFile(file) {
        const formData = new FormData();
        formData.append('upload', file);

        const uploadUrl = this.$root?.dataset?.uploadUrl ||
            document.querySelector('[data-upload-url]')?.dataset?.uploadUrl ||
            '/dashboard/admin/berita/upload-gambar';

        const res = await fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        });

        if (!res.ok) {
            alert('Upload gagal: ' + res.statusText);
            throw new Error('Upload failed');
        }

        const data = await res.json();
        return data.url;
    },
}));
