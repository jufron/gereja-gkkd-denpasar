/**
 * Alpine component untuk form khotbah: inisialisasi Quill dan sinkronisasi
 * ke input hidden name="content". Tanpa upload gambar (isi pembahasan cukup
 * teks terformat: judul, daftar, kutipan, tautan).
 */

import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Alpine.data('khotbahForm', () => ({
    loading: false,
    previewThumbnail: null,
    previewPreacher: null,

    bacaGambar(event, field) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            this[field] = e.target.result;
        };
        reader.readAsDataURL(file);
    },

    initQuill() {
        const el = this.$refs.quillEl;
        if (!el || el.__quill) return;

        const quill = new Quill(el, {
            modules: { toolbar: '#quill-toolbar' },
            theme: 'snow',
        });

        el.__quill = quill;

        quill.on('text-change', (delta, oldDelta, source) => {
            if (source === 'user') {
                this.$refs.contentInput.value = quill.root.innerHTML;
            }
        });

        const existing = this.$refs.contentInput.value || '';
        if (existing) {
            quill.setContents(quill.clipboard.convert({ html: existing }), 'silent');
        }
    },
}));
