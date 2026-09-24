<x-be.layouts.app title="Keamanan" description="Ubah kata sandi dan amankan akun Anda">

    <main class="mx-auto w-full max-w-5xl flex-1 space-y-6" x-data="{ otpSent: false, twoFactor: false }">

        <x-be.page-header
            title="Keamanan"
            description="Ubah kata sandi dan amankan akun Anda."
        />

        {{-- Change password --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Ubah Kata Sandi</h3>
                <p class="text-xs text-muted">Pastikan akun menggunakan kata sandi yang panjang dan acak.</p>
            </div>

            {{-- TODO: sambungkan ke endpoint update password. --}}
            <div class="p-5">
                <form class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <x-be.field label="Kata Sandi Saat Ini" for="currentPassword" class="sm:col-span-2">
                        <x-input-password id="currentPassword" name="currentPassword" autocomplete="current-password" placeholder="••••••••" />
                    </x-be.field>
                    <x-be.field label="Kata Sandi Baru" for="newPassword">
                        <x-input-password id="newPassword" name="newPassword" autocomplete="new-password" placeholder="••••••••" />
                    </x-be.field>
                    <x-be.field label="Konfirmasi Kata Sandi" for="confirmPassword">
                        <x-input-password id="confirmPassword" name="confirmPassword" autocomplete="new-password" placeholder="••••••••" />
                    </x-be.field>
                    <div class="flex justify-end sm:col-span-2">
                        <x-be.button icon="fa-key">Perbarui Kata Sandi</x-be.button>
                    </div>
                </form>
            </div>
        </x-be.card>

        {{-- WhatsApp OTP --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Verifikasi WhatsApp OTP</h3>
                <p class="text-xs text-muted">Verifikasi nomor WhatsApp Anda untuk menerima kode OTP via WhatsApp API.</p>
            </div>

            {{-- TODO: integrasikan pengiriman OTP dengan WhatsApp API (lihat Pengaturan > Integrasi). --}}
            <div class="space-y-5 p-5">
                <x-be.field label="Nomor WhatsApp" for="waNumber">
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <div class="relative flex-1">
                            <i class="fa-brands fa-whatsapp absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-success"></i>
                            <input id="waNumber" type="tel" placeholder="0812-3456-7890" class="be-input pl-10">
                        </div>
                        <button
                            type="button"
                            @click="otpSent = true"
                            class="be-btn shrink-0 bg-success text-white hover:brightness-95"
                        >
                            <i class="fa-solid fa-paper-plane text-[11px]"></i> Kirim OTP
                        </button>
                    </div>
                </x-be.field>

                <div x-show="otpSent" x-transition class="rounded-2xl border border-success/25 bg-success-soft p-4 sm:p-5" style="display: none;">
                    <p class="mb-3 text-xs font-medium text-success">
                        <i class="fa-solid fa-circle-check mr-1 text-[11px]"></i>
                        Kode OTP telah dikirim ke nomor WhatsApp Anda. Masukkan 6 digit kode di bawah.
                    </p>
                    <div class="flex items-center gap-2.5">
                        <input
                            type="text"
                            maxlength="6"
                            inputmode="numeric"
                            placeholder="______"
                            class="be-input w-32 text-center text-sm font-bold tracking-[0.3em]"
                        >
                        <button type="button" class="be-btn bg-success text-white hover:brightness-95">
                            <i class="fa-solid fa-check text-[11px]"></i> Verifikasi
                        </button>
                    </div>
                </div>
            </div>
        </x-be.card>

        {{-- Two-factor authentication --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Autentikasi 2 Faktor (2FA)</h3>
                <p class="text-xs text-muted">Tambahkan lapisan keamanan dengan aplikasi seperti Google Authenticator.</p>
            </div>

            <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center">
                <div class="flex items-start gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-accent/10 text-accent">
                        <i class="fa-solid fa-mobile-screen-button text-lg"></i>
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-ink">Aplikasi Authenticator</h4>
                        <p class="text-xs text-muted">Pindai kode QR di Google Authenticator untuk membuat kode 6 digit.</p>
                    </div>
                </div>

                <button
                    type="button"
                    role="switch"
                    :aria-checked="twoFactor.toString()"
                    @click="twoFactor = !twoFactor"
                    class="be-switch shrink-0 bg-ink/20"
                    :class="twoFactor ? 'bg-accent' : ''"
                >
                </button>
            </div>

            <div x-show="twoFactor" x-transition class="border-t border-line p-5" style="display: none;">
                <div class="flex flex-col items-center gap-5 sm:flex-row">
                    <div class="flex h-32 w-32 shrink-0 items-center justify-center rounded-2xl border-2 border-dashed border-line">
                        <i class="fa-solid fa-qrcode text-4xl text-muted/50"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-ink">Pindai Kode QR</h4>
                        <p class="mt-1 max-w-xs text-xs text-muted">Buka Google Authenticator, pilih "Tambah Akun", lalu pindai kode QR di samping.</p>
                        <p class="mt-2 text-[11px] text-muted">
                            <i class="fa-solid fa-circle-info mr-1"></i> Integrasi 2FA akan tersedia setelah backend siap.
                        </p>
                    </div>
                </div>
            </div>
        </x-be.card>

        {{-- Connected devices --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Perangkat Terhubung</h3>
                <p class="text-xs text-muted">Perangkat yang terdeteksi sedang masuk ke akun Anda.</p>
            </div>

            <div class="divide-y divide-line">
                @foreach ($devices as $device)
                    <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center">
                        <div class="flex items-center gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl
                                {{ $device['current'] ? 'bg-accent/10 text-accent' : 'bg-ink/5 text-muted' }}">
                                <i class="fa-solid {{ $device['type'] === 'mobile' ? 'fa-mobile-screen' : 'fa-laptop' }} text-lg"></i>
                            </span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-sm font-bold text-ink">{{ $device['browser'] }} &bull; {{ $device['os'] }}</h4>
                                    @if ($device['current'])
                                        <span class="inline-flex rounded-full bg-success/15 px-2 py-0.5 text-[10px] font-semibold text-success">Saat Ini</span>
                                    @endif
                                </div>
                                <p class="text-xs text-muted">{{ $device['location'] }} &bull; {{ $device['ip'] }} &bull; {{ $device['last_active'] }}</p>
                            </div>
                        </div>

                        @unless ($device['current'])
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="be-btn be-btn-ghost border border-danger/30 text-danger hover:bg-danger/10">
                                    <i class="fa-solid fa-right-from-bracket text-[11px]"></i> Akhiri Sesi
                                </button>
                            </form>
                        @endunless
                    </div>
                @endforeach
            </div>
        </x-be.card>

        {{-- Role & permissions --}}
        <x-be.card class="overflow-hidden">
            <div class="border-b border-line p-5">
                <h3 class="text-base font-bold text-ink">Peran &amp; Hak Akses</h3>
                <p class="text-xs text-muted">Peran akun Anda dan aksi yang diizinkan.</p>
            </div>

            <div class="p-5">
                {{-- TODO: sambungkan ke sistem role/permission. --}}
                <div class="mb-5 flex items-center gap-3 border-b border-line pb-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-accent/10 text-accent">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-ink">Administrator</h4>
                        <p class="text-xs text-muted">Akses penuh untuk mengelola seluruh sistem.</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach (['Kelola User', 'Hak Akses', 'Kelola Berita', 'Kelola Jadwal', 'Kelola Keuangan', 'Pengaturan'] as $permission)
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-accent/20 bg-accent/10 px-3 py-1.5 text-[11px] font-semibold text-accent">
                            <i class="fa-solid fa-check text-[10px]"></i> {{ $permission }}
                        </span>
                    @endforeach
                </div>
            </div>
        </x-be.card>

        {{-- Danger zone --}}
        <div class="overflow-hidden rounded-2xl border border-danger/30 bg-card shadow-sm">
            <div class="border-b border-danger/20 bg-danger-soft/50 p-5">
                <h3 class="text-base font-bold text-danger">Zona Berbahaya</h3>
                <p class="text-xs text-danger/80">Tindakan di bawah ini tidak dapat dibatalkan.</p>
            </div>

            <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center">
                <div class="flex items-start gap-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                        <i class="fa-solid fa-trash-can text-lg"></i>
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-ink">Hapus Akun</h4>
                        <p class="text-xs text-muted">Semua data Anda akan dihapus permanen dari sistem.</p>
                    </div>
                </div>
                <x-be.button variant="danger" icon="fa-trash-can">Hapus Akun</x-be.button>
            </div>
        </div>

    </main>

</x-be.layouts.app>
