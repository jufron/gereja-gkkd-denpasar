<x-be.layouts.app title="Profil Saya" description="Kelola informasi akun dan koneksi layanan Anda">

    <main class="mx-auto w-full max-w-5xl flex-1 space-y-6" x-data="{ photoOpen: false, photoPreview: null }">

        {{-- Account information --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Informasi Akun</h3>
                <p class="text-xs text-muted">Perbarui nama dan alamat email Anda.</p>
            </div>

            <div class="p-5">
                @php $user = auth()->user(); @endphp

                {{-- Avatar & identity --}}
                <div class="flex flex-col gap-4 border-b border-line pb-6 sm:flex-row sm:items-center">
                    <button
                        type="button"
                        @click="photoOpen = true"
                        class="group relative h-20 w-20 shrink-0 overflow-hidden rounded-2xl focus:outline-none focus:ring-2 focus:ring-accent/50 focus:ring-offset-2 focus:ring-offset-card"
                    >
                        <img
                            x-show="photoPreview"
                            :src="photoPreview"
                            alt="Foto Profil"
                            class="h-full w-full object-cover"
                            style="display: none;"
                        >
                        <span
                            x-show="!photoPreview"
                            class="flex h-full w-full items-center justify-center bg-gradient-to-tr from-accent-strong to-accent text-2xl font-bold text-white"
                        >
                            {{ collect(explode(' ', $user->name))->filter()->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                        </span>
                        <span class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 transition-opacity group-hover:opacity-100">
                            <i class="fa-solid fa-camera text-lg text-white"></i>
                        </span>
                    </button>
                    <div class="min-w-0">
                        <h4 class="truncate text-base font-bold text-ink">{{ $user->name }}</h4>
                        <div class="mt-1 flex items-center gap-2">
                            <p class="truncate text-xs text-muted">{{ $user->email }}</p>
                            @if ($user->email_verified_at)
                                <span class="inline-flex shrink-0 items-center rounded-full bg-success/15 px-2 py-0.5 text-[10px] font-semibold text-success">
                                    <i class="fa-solid fa-circle-check mr-0.5 text-[9px]"></i> Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex shrink-0 items-center rounded-full bg-warning/15 px-2 py-0.5 text-[10px] font-semibold text-warning">
                                    <i class="fa-solid fa-clock mr-0.5 text-[9px]"></i> Belum Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- TODO: sambungkan form ke endpoint update profil. --}}
                <form class="grid grid-cols-1 gap-5 pt-6 sm:grid-cols-2">
                    <x-be.field label="Nama Lengkap" for="formName">
                        <input id="formName" type="text" value="{{ $user->name }}" class="be-input">
                    </x-be.field>
                    <x-be.field label="Alamat Email" for="formEmail">
                        <input id="formEmail" type="email" value="{{ $user->email }}" class="be-input">
                    </x-be.field>
                    <div class="flex justify-end sm:col-span-2">
                        <x-be.button icon="fa-check">Simpan Perubahan</x-be.button>
                    </div>
                </form>
            </div>
        </x-be.card>

        {{-- Connected accounts --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Akun Terhubung</h3>
                <p class="text-xs text-muted">Hubungkan akun Google dan WhatsApp untuk login dan verifikasi OTP.</p>
            </div>

            <div class="divide-y divide-line">
                @foreach ([
                    ['icon' => 'fa-google', 'brand' => true, 'name' => 'Google', 'desc' => 'Login cepat dengan akun Google.'],
                    ['icon' => 'fa-whatsapp', 'brand' => true, 'name' => 'WhatsApp', 'desc' => 'Terima kode OTP via WhatsApp API.'],
                ] as $account)
                    <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-ink/5 text-muted">
                                <i class="fa-brands {{ $account['icon'] }} text-lg"></i>
                            </span>
                            <div>
                                <h4 class="text-sm font-bold text-ink">{{ $account['name'] }}</h4>
                                <p class="text-xs text-muted">{{ $account['desc'] }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex rounded-full bg-ink/10 px-2.5 py-1 text-[10px] font-semibold text-muted">Belum Terhubung</span>
                            <button
                                disabled
                                class="be-btn be-btn-ghost cursor-not-allowed opacity-50"
                            >
                                <i class="fa-solid fa-link text-[11px]"></i> Hubungkan
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-be.card>

        {{-- Photo upload modal --}}
        <div
            x-show="photoOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
            style="display: none;"
            @keydown.escape.window="photoOpen = false"
        >
            <div
                x-show="photoOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="w-full max-w-md rounded-3xl bg-card shadow-2xl"
                @click.outside="photoOpen = false"
            >
                <div class="flex items-center justify-between border-b border-line p-6">
                    <div>
                        <h3 class="text-base font-bold text-ink">Ubah Foto Profil</h3>
                        <p class="text-xs text-muted">Unggah foto profil baru Anda.</p>
                    </div>
                    <button @click="photoOpen = false" class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="flex flex-col items-center gap-5 p-6">
                    <img
                        x-show="photoPreview"
                        :src="photoPreview"
                        alt="Pratinjau Foto Profil"
                        class="h-24 w-24 rounded-2xl border border-line object-cover"
                        style="display: none;"
                    >
                    <span
                        x-show="!photoPreview"
                        class="flex h-24 w-24 items-center justify-center rounded-2xl border border-line bg-gradient-to-tr from-accent-strong to-accent text-3xl font-bold text-white"
                    >
                        {{ collect(explode(' ', $user->name))->filter()->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                    </span>

                    <div class="flex w-full flex-col items-center gap-3">
                        <button
                            type="button"
                            @click="$refs.photoInput.click()"
                            class="be-btn be-btn-ghost"
                        >
                            <i class="fa-solid fa-image text-[11px]"></i> Pilih Foto
                        </button>
                        <input
                            x-ref="photoInput"
                            type="file"
                            accept="image/png,image/jpeg,image/webp"
                            class="hidden"
                            @change="photoPreview = URL.createObjectURL($event.target.files[0])"
                        >
                        <p class="text-[11px] text-muted">JPG, PNG, atau WEBP. Maks 2MB.</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2.5 border-t border-line p-6">
                    <button
                        @click="photoOpen = false"
                        class="be-btn be-btn-ghost"
                    >
                        Batal
                    </button>
                    <button
                        x-show="photoPreview"
                        @click="photoPreview = null; photoOpen = false"
                        class="be-btn be-btn-ghost text-danger"
                        style="display: none;"
                    >
                        Hapus Foto
                    </button>
                    <button
                        @click="photoOpen = false"
                        class="be-btn be-btn-primary"
                    >
                        <i class="fa-solid fa-check text-[11px]"></i> Simpan Foto
                    </button>
                </div>
            </div>
        </div>

    </main>

</x-be.layouts.app>
