<x-be.layouts.app title="{{ $isEdit ? 'Ubah Berita' : 'Tambah Berita' }}" description="Formulir artikel berita">

    <main class="mx-auto w-full max-w-5xl flex-1 space-y-6">

        <x-be.page-header
            title="Formulir Berita"
            :description="$isEdit ? 'Perbarui artikel: '.$news->title : 'Tulis artikel berita baru.'"
        />

        @if ($errors->any())
            <div class="rounded-xl bg-rose-500/10 p-4 text-sm text-rose-400">
                <ul class="list-disc list-inside space-y-1">
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
              :data-upload-url="route('admin.berita.upload-gambar')"
              @submit="loading = true; $el.submit()">

            @if ($isEdit)
                @method('PUT')
            @endif
            @csrf

            {{-- Quill toolbar (referenced by JS via #quill-toolbar).
                  Not hidden — Quill needs it visible to compute layout and
                  attach button event handlers. --}}
            <div id="quill-toolbar"
                 class="mb-2 flex flex-wrap items-center gap-1 rounded-t-xl border border-slate-300 bg-slate-50 px-3 py-1 dark:border-slate-600 dark:bg-slate-800">
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
                    <button type="button" class="ql-clean"></button>
                </span>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="md:col-span-2 space-y-6">
                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Judul *</label>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}"
                               class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                               required>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Kategori</label>
                        <select name="category_id"
                                class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
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
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Excerpt (opsional)</label>
                        <textarea name="excerpt" rows="3"
                                  class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                                  maxlength="500">{{ old('excerpt', $news->excerpt) }}</textarea>
                    </div>

                    {{-- Content - Quill Editor --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Isi Berita *</label>
                        {{-- Input hidden yang disinkronkan oleh Quill --}}
                        <input type="hidden" name="content" x-ref="contentInput"
                               value="{{ old('content', $news->content) }}">
                        <div x-data
                             x-ref="quillEl"
                             class="quill-content">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    {{-- Banner upload --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Banner / Foto Utama</label>

                        @if (! empty($news->featured_image))
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$news->featured_image) }}"
                                     class="mb-2 h-32 w-full rounded-xl object-cover" alt="Banner saat ini">
                                <label class="flex items-center gap-2 text-xs text-slate-500">
                                    <input type="checkbox" name="hapus_banner" value="1" x-model="hapusBanner">
                                    Hapus banner
                                </label>
                            </div>
                        @endif

                        <input type="file" name="banner" accept="image/*"
                               @change="bacaBanner($event)"
                               class="text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-accent file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-accent/90">
                        <p class="mt-1 text-xs text-slate-500">JPG/PNG/WebP maks 5 MB</p>

                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="mt-3 h-32 w-full rounded-xl object-cover">
                        </template>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status *</label>
                        <div class="mt-2 flex gap-4">
                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                <input type="radio" name="status" value="draft"
                                       {{ old('status', $news->status) === 'draft' ? 'checked' : '' }}>
                                Draft
                            </label>
                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                <input type="radio" name="status" value="published"
                                       {{ old('status', $news->status) === 'published' ? 'checked' : '' }}>
                                Published
                            </label>
                        </div>
                    </div>

                    {{-- Tanggal terbit --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Tanggal Terbit</label>
                        <input type="datetime-local" name="published_at"
                               value="{{ old('published_at', optional($news->published_at)->format('Y-m-d\TH:i')) }}"
                               class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-3 border-t border-slate-200 dark:border-slate-700 pt-6">
                <a href="{{ route('admin.berita') }}"
                   class="rounded-xl border border-slate-300 px-5 py-2 text-sm font-medium text-slate-700 dark:border-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                    Batal
                </a>
                <button type="submit"
                        class="rounded-xl bg-accent px-5 py-2 text-sm font-semibold text-white hover:bg-accent/90"
                        :disabled="loading">
                    <span x-show="!loading">{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}</span>
                    <i class="fa-solid fa-spinner fa-spin" x-show="loading"></i>
                </button>
            </div>

        </form>

    </main>

</x-be.layouts.app>
