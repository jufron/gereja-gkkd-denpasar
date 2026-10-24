<x-be.layouts.app title="{{ $isEdit ? 'Ubah Berita' : 'Tambah Berita' }}" description="Formulir artikel berita">

    <main class="mx-auto w-full max-w-6xl flex-1 space-y-6">

        <x-be.page-header
            title="Formulir Berita"
            :description="$isEdit ? 'Perbarui artikel: '.$news->title : 'Tulis artikel berita baru.'"
        >
            <x-slot:actions>
                <a href="{{ route('admin.berita') }}" class="be-btn be-btn-ghost">
                    <i class="fa-solid fa-list text-[11px]"></i>
                    Daftar Berita
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
              action="{{ $isEdit ? route('admin.berita.update', $news) : route('admin.berita.simpan') }}"
              enctype="multipart/form-data"
              x-data="newsForm()"
              x-init="initQuill()"
              data-upload-url="{{ route('admin.berita.upload-gambar') }}"
              @submit="loading = true; $el.submit()">

            @if ($isEdit)
                @method('PUT')
            @endif
            @csrf

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                {{-- ============================= KONENEN KIRI ============================= --}}
                <div class="space-y-6 lg:col-span-2">
                    <x-be.card class="p-5 lg:p-6">
                        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-muted">Konten Berita</h2>

                        <div class="space-y-5">
                            {{-- Judul --}}
                            <div x-data="{ c: 0 }">
                                <label for="title" class="be-label">Judul *</label>
                                <input type="text" name="title" id="title"
                                       value="{{ old('title', $news->title) }}"
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

                            {{-- Kategori --}}
                            <div>
                                <label for="category_id" class="be-label">Kategori</label>
                                <select name="category_id" id="category_id" class="be-input mt-1.5">
                                    <option value="">Pilih kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $news->news_category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Excerpt --}}
                            <div x-data="{ c: 0 }">
                                <label for="excerpt" class="be-label">Excerpt (opsional)</label>
                                <textarea name="excerpt" id="excerpt" rows="3" maxlength="500"
                                          @input="c = $event.target.value.length"
                                          class="be-input mt-1.5 resize-y">{{ old('excerpt', $news->excerpt) }}</textarea>
                                <p class="mt-1.5 text-[11px] text-muted" aria-live="polite">
                                    <span x-text="c + '/500'">0/500</span>
                                </p>
                            </div>

                            {{-- Isi Berita : Quill --}}
                            <div>
                                <span class="be-label mb-1.5 block">Isi Berita *</span>
                                <input type="hidden" name="content" x-ref="contentInput"
                                       value="{{ old('content', $news->content) }}">

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
                                            <button type="button" class="ql-image"></button>
                                            <select id="image-width" name="image_width" class="image-width-select" aria-label="Ukuran gambar" title="Ukuran gambar">
                                                <option value="">Ukuran gambar</option>
                                                <option value="25%">25%</option>
                                                <option value="50%">50%</option>
                                                <option value="75%">75%</option>
                                                <option value="100%">100%</option>
                                            </select>
                                            <button type="button" class="ql-clean"></button>
                                        </span>
                                    </div>

                                    <div id="quill-editor" x-ref="quillEl" class="quill-editor"></div>
                                </div>
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
                                               {{ old('status', $news->status) === 'draft' ? 'checked' : '' }}>
                                        <span class="flex h-9 items-center justify-center rounded-lg text-sm font-medium text-muted transition-colors peer-checked:bg-card peer-checked:text-ink peer-checked:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-accent/40">
                                            Draft
                                        </span>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="published" class="peer sr-only"
                                               {{ old('status', $news->status) === 'published' ? 'checked' : '' }}>
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
                                       value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\TH:i')) }}"
                                       class="be-input mt-1.5">
                                <p class="mt-1.5 text-[11px] text-muted">
                                    Kosongkan + status Published = waktu sekarang
                                </p>
                            </div>
                        </div>
                    </x-be.card>

                    {{-- Banner --}}
                    <x-be.card class="p-5 lg:p-6">
                        <h2 class="mb-5 text-sm font-semibold uppercase tracking-wide text-muted">Banner / Foto Utama</h2>

                        <div class="space-y-4">
                            @if (! empty($news->featured_image))
                                <img src="{{ asset('storage/'.$news->featured_image) }}"
                                     class="aspect-video w-full rounded-xl object-cover" alt="Banner saat ini">
                                <label class="flex cursor-pointer items-center gap-2 text-sm text-ink">
                                    <input type="checkbox" name="hapus_banner" value="1" x-model="hapusBanner"
                                           class="h-4 w-4 accent-accent">
                                    Hapus banner
                                </label>
                            @else
                                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-line-strong bg-ink/[0.03] px-4 py-8 text-center">
                                    <i class="fa-solid fa-image mb-2 text-2xl text-muted"></i>
                                    <p class="text-sm text-ink">Belum ada banner</p>
                                    <p class="mt-1 text-xs text-muted">JPG/PNG/WebP maks 5 MB</p>
                                </div>
                            @endif

                            <div>
                                <input type="file" name="banner" accept="image/*" id="banner"
                                       @change="bacaBanner($event)"
                                       class="block w-full text-sm text-muted file:mr-4 file:rounded-lg file:border-0 file:bg-accent file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-accent-strong">
                            </div>

                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="aspect-video w-full rounded-xl object-cover" alt="Pratinjau banner">
                            </template>
                        </div>
                    </x-be.card>
                </div>
            </div>

            {{-- Action bar sticky --}}
            <div class="sticky bottom-0 z-10 -mx-4 mt-6 border-t border-line-strong bg-canvas/85 px-4 py-4 backdrop-blur lg:-mx-8 lg:px-8">
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('admin.berita') }}" class="be-btn be-btn-ghost">Batal</a>
                    <button type="submit"
                            :disabled="loading"
                            :aria-busy="loading"
                            class="be-btn be-btn-primary disabled:cursor-not-allowed disabled:opacity-60">
                        <i class="fa-solid fa-spinner fa-spin" x-show="loading" x-cloak></i>
                        <span x-show="!loading">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}</span>
                        <span x-show="loading" x-cloak>Menyimpan…</span>
                    </button>
                </div>
            </div>

        </form>

    </main>

</x-be.layouts.app>
