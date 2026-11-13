<x-be.layouts.app title="{{ $isEdit ? 'Ubah Khotbah' : 'Tambah Khotbah' }}" description="Formulir rangkuman khotbah">

    <main class="mx-auto w-full max-w-6xl flex-1 space-y-6">

        <x-be.page-header
            title="Formulir Khotbah"
            :description="$isEdit ? 'Perbarui khotbah: '.$sermon->title : 'Rekam rangkuman khotbah baru.'"
        >
            <x-slot:actions>
                <a href="{{ route('admin.khotbah.index') }}" class="be-btn be-btn-ghost">
                    <i class="fa-solid fa-list text-[11px]"></i>
                    Daftar Khotbah
                </a>
            </x-slot:actions>
        </x-be.page-header>

        @if ($errors->any())
            <div class="be-card border-rose-300/60 p-4 text-sm text-danger dark:border-rose-500/30" role="alert">
                <p class="mb-1.5 font-semibold">Periksa kembali formulir berikut:</p>
                <ul class="list-inside list-disc space-y-1 text-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $isEdit ? route('admin.khotbah.update', $sermon) : route('admin.khotbah.simpan') }}"
              enctype="multipart/form-data"
              x-data="khotbahForm()"
              x-init="initQuill()"
              @submit="loading = true; $el.submit()">

            @if ($isEdit)
                @method('PUT')
            @endif
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- ============================= KOLOM KIRI ============================= --}}
                <div class="space-y-6 lg:col-span-2">
                    <x-be.card class="p-5 lg:p-6">
                        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-muted">Konten Khotbah</h2>

                        <div class="space-y-5">
                            {{-- Judul --}}
                            <div x-data="{ c: 0 }">
                                <label for="title" class="be-label">Judul *</label>
                                <input type="text" name="title" id="title"
                                       value="{{ old('title', $sermon->title) }}"
                                       maxlength="200"
                                       @input="c = $event.target.value.length"
                                       aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}"
                                       aria-describedby="{{ $errors->has('title') ? 'title-error' : 'title-count' }}"
                                       class="be-input mt-1.5"
                                       required>
                                @error('title')
                                    <p id="title-error" class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p>
                                @else
                                    <p id="title-count" class="mt-1.5 text-[11px] text-muted" aria-live="polite">
                                        <span x-text="c + '/200'">0/200</span>
                                    </p>
                                @enderror
                            </div>

                            {{-- Pengkhotbah + jabatan --}}
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="preacher" class="be-label">Pengkhotbah *</label>
                                    <input type="text" name="preacher" id="preacher"
                                           value="{{ old('preacher', $sermon->preacher) }}"
                                           placeholder="Pdt. Samuel Wijaya"
                                           class="be-input mt-1.5"
                                           required>
                                    @error('preacher')
                                        <p class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label for="preached_at" class="be-label">Tanggal Khotbah *</label>
                                <input type="date" name="preached_at" id="preached_at"
                                       value="{{ old('preached_at', optional($sermon->preached_at)->format('Y-m-d')) }}"
                                       class="be-input mt-1.5"
                                       required>
                                @error('preached_at')
                                    <p class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label for="location" class="be-label">Lokasi</label>
                                <input type="text" name="location" id="location"
                                       value="{{ old('location', $sermon->location) }}"
                                       placeholder="Gedung Utama GKKD Denpasar"
                                       class="be-input mt-1.5">
                            </div>

                            {{-- Isi Pembahasan : Quill --}}
                            <div>
                                <span class="be-label mb-1.5 block">Isi Pembahasan *</span>
                                <input type="hidden" name="content" x-ref="contentInput"
                                       value="{{ old('content', $sermon->content) }}">

                                <div class="quill-content">
                                    <div id="quill-toolbar">
                                        <span class="ql-formats">
                                            <select class="ql-header">
                                                <option selected></option>
                                                <option value="1"></option>
                                                <option value="2"></option>
                                                <option value="3"></option>
                                            </select>
                                        </span>
                                        <span class="ql-formats">
                                            <button type="button" class="ql-bold"></button>
                                            <button type="button" class="ql-italic"></button>
                                            <button type="button" class="ql-underline"></button>
                                            <button type="button" class="ql-strike"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button type="button" class="ql-list" value="ordered"></button>
                                            <button type="button" class="ql-list" value="bullet"></button>
                                            <button type="button" class="ql-blockquote"></button>
                                            <button type="button" class="ql-code-block"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button type="button" class="ql-link"></button>
                                            <button type="button" class="ql-clean"></button>
                                        </span>
                                    </div>

                                    <div id="quill-editor" x-ref="quillEl" class="quill-editor"></div>
                                </div>
                                @error('content')
                                    <p class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-be.card>
                </div>

                {{-- ============================= KOLOM KANAN ============================= --}}
                <div class="space-y-6">
                    {{-- Publikasi --}}
                    <x-be.card class="p-5 lg:p-6">
                        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-muted">Publikasi</h2>

                        <div class="space-y-5">
                            {{-- Status segmented --}}
                            <fieldset>
                                <legend class="be-label">Status *</legend>
                                <div class="mt-2 grid grid-cols-2 gap-1 rounded-xl bg-ink/5 p-1">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="draft" class="peer sr-only"
                                               {{ old('status', $sermon->status) === 'draft' ? 'checked' : '' }}>
                                        <span class="flex h-9 items-center justify-center rounded-lg text-sm font-medium text-muted transition-colors peer-checked:bg-card peer-checked:text-ink peer-checked:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-accent/40">
                                            Draft
                                        </span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="published" class="peer sr-only"
                                               {{ old('status', $sermon->status) === 'published' ? 'checked' : '' }}>
                                        <span class="flex h-9 items-center justify-center rounded-lg text-sm font-medium text-muted transition-colors peer-checked:bg-card peer-checked:text-ink peer-checked:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-accent/40">
                                            Published
                                        </span>
                                    </label>
                                </div>
                            </fieldset>

                            {{-- Tanggal terbit --}}
                            <div>
                                <label for="published_at" class="be-label">Tanggal Terbit</label>
                                <input type="datetime-local" name="published_at" id="published_at"
                                       value="{{ old('published_at', optional($sermon->published_at)->format('Y-m-d\TH:i')) }}"
                                       class="be-input mt-1.5">
                                <p class="mt-1.5 text-[11px] text-muted">
                                    Kosongkan + status Published = waktu sekarang
                                </p>
                            </div>

                            {{-- PPT URL --}}
                            <div>
                                <label for="ppt_url" class="be-label">Link Materi (PPT / Drive)</label>
                                <input type="url" name="ppt_url" id="ppt_url"
                                       value="{{ old('ppt_url', $sermon->ppt_url) }}"
                                       placeholder="https://drive.google.com/..."
                                       class="be-input mt-1.5">
                                <p class="mt-1.5 text-[11px] text-muted">Opsional. Kosong kalau materi belum ada.</p>
                                @error('ppt_url')
                                    <p class="mt-1.5 text-xs text-danger" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-be.card>

                    {{-- Gambar --}}
                    <x-be.card class="p-5 lg:p-6">
                        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-muted">Gambar</h2>

                        <div class="space-y-6">
                            {{-- Thumbnail --}}
                            <div>
                                <h3 class="text-sm font-semibold text-ink">Thumbnail</h3>
                                <p class="mb-3 text-[11px] text-muted">Gambar utama (16:9), opsional.</p>

                                @if ($sermon->thumbnail_url)
                                    <img src="{{ $sermon->thumbnail_url }}"
                                         class="aspect-video w-full rounded-xl object-cover" alt="Thumbnail saat ini">
                                    <label class="mt-2 flex cursor-pointer items-center gap-2 text-sm text-ink">
                                        <input type="checkbox" name="hapus_thumbnail" value="1" x-model="hapusThumbnail"
                                               class="h-4 w-4 accent-accent">
                                        Hapus thumbnail
                                    </label>
                                @else
                                    <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-line-strong bg-ink/[0.03] px-4 py-6 text-center">
                                        <i class="fa-solid fa-image mb-2 text-2xl text-muted"></i>
                                        <p class="text-sm text-ink">Belum ada thumbnail</p>
                                        <p class="mt-1 text-xs text-muted">JPG/PNG/WebP maks 5 MB</p>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <input type="file" name="thumbnail" accept="image/*" id="thumbnail"
                                           @change="bacaGambar($event, 'previewThumbnail')"
                                           class="block w-full text-sm text-muted file:mr-4 file:rounded-lg file:border-0 file:bg-accent file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-accent-strong">
                                </div>

                                <template x-if="previewThumbnail">
                                    <img :src="previewThumbnail" class="mt-3 aspect-video w-full rounded-xl object-cover" alt="Pratinjau thumbnail">
                                </template>
                            </div>
                        </div>
                    </x-be.card>
                </div>
            </div>

            {{-- Action bar sticky --}}
            <div class="sticky bottom-0 z-10 -mx-4 mt-6 border-t border-line-strong bg-canvas/85 px-4 py-4 backdrop-blur lg:-mx-8 lg:px-8">
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('admin.khotbah.index') }}" class="be-btn be-btn-ghost">Batal</a>
                    <button type="submit"
                            :disabled="loading"
                            :aria-busy="loading"
                            class="be-btn be-btn-primary disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="fa-solid fa-spinner fa-spin" x-show="loading" x-cloak></i>
                        <span x-show="!loading">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Khotbah' }}</span>
                        <span x-show="loading" x-cloak>Menyimpan…</span>
                    </button>
                </div>
            </div>

        </form>

    </main>

</x-be.layouts.app>
