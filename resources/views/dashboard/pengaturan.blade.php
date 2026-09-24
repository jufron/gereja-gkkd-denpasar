<x-be.layouts.app title="Pengaturan" description="Kelola identitas gereja, tampilan, notifikasi, dan integrasi">

    <main class="mx-auto w-full max-w-6xl flex-1 space-y-6" x-data="{ tab: 'identitas' }">

        <x-be.page-header
            title="Pengaturan"
            description="Kelola identitas gereja, tampilan, notifikasi, dan integrasi."
        />

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[230px_1fr]">

            {{-- Tab nav --}}
            <nav class="flex gap-2 overflow-x-auto pb-2 lg:flex-col lg:overflow-visible lg:pb-0" aria-label="Tab pengaturan">
                @php
                    $tabs = [
                        ['id' => 'identitas', 'label' => 'Identitas Gereja', 'icon' => 'fa-church'],
                        ['id' => 'kontak', 'label' => 'Kontak & Sosial', 'icon' => 'fa-share-nodes'],
                        ['id' => 'tampilan', 'label' => 'Tampilan', 'icon' => 'fa-palette'],
                        ['id' => 'notifikasi', 'label' => 'Notifikasi', 'icon' => 'fa-bell'],
                        ['id' => 'integrasi', 'label' => 'Integrasi & API', 'icon' => 'fa-cubes'],
                        ['id' => 'keamanan', 'label' => 'Keamanan Sistem', 'icon' => 'fa-shield-halved'],
                    ];
                @endphp

                @foreach ($tabs as $tab)
                    <button
                        type="button"
                        @click="tab = '{{ $tab['id'] }}'"
                        :class="tab === '{{ $tab['id'] }}' ? 'bg-accent/10 font-semibold text-accent' : 'text-muted hover:bg-ink/5 hover:text-ink'"
                        class="inline-flex shrink-0 items-center gap-2.5 rounded-xl px-3.5 py-2.5 text-sm transition-colors"
                    >
                        <i class="fa-solid {{ $tab['icon'] }} w-4 text-center text-xs"></i>
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </nav>

            {{-- Panels --}}
            <div class="space-y-6">

                {{-- IDENTITAS --}}
                <div x-show="tab === 'identitas'" class="space-y-6">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Identitas Gereja</h3>
                            <p class="text-xs text-muted">Informasi ini tampil di seluruh bagian situs dan dashboard.</p>
                        </div>
                        <div class="p-5">
                            {{-- TODO: sambungkan ke tabel settings (logo upload + storage). --}}
                            <div class="flex flex-col gap-4 border-b border-line pb-6 sm:flex-row sm:items-center">
                                <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-[#121212] ring-1 ring-ink/10">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo GKKD Denpasar" class="h-full w-full origin-top-left translate-x-[-9%] translate-y-[-40%] scale-[1.75]">
                                </div>
                                <div>
                                    <button type="button" class="be-btn be-btn-ghost">
                                        <i class="fa-solid fa-image text-[11px]"></i> Ganti Logo
                                    </button>
                                    <p class="mt-2 text-[11px] text-muted">JPG, PNG, atau WEBP. Maks 2MB.</p>
                                </div>
                            </div>

                            <form class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <x-be.field label="Nama Gereja" for="churchName">
                                    <input id="churchName" type="text" value="GKKD Denpasar" class="be-input">
                                </x-be.field>
                                <x-be.field label="Singkatan" for="churchAbbr">
                                    <input id="churchAbbr" type="text" value="GKKD" class="be-input">
                                </x-be.field>
                                <x-be.field label="Tagline" for="churchTagline" class="sm:col-span-2">
                                    <input id="churchTagline" type="text" value="Gereja Kerapatan Injil Kerajaan Allah" class="be-input">
                                </x-be.field>
                                <x-be.field label="Visi" for="churchVision" class="sm:col-span-2">
                                    <textarea id="churchVision" rows="3" class="be-input !h-auto py-2.5">Menjadi gereja Tuhan Yesus Kristus yang melakukan kehendak Bapa agar kemuliaan-Nya dinyatakan mulai dari Pulau Bali sampai kepada suku-suku bangsa.</textarea>
                                </x-be.field>
                                <x-be.field label="Misi" for="churchMission" class="sm:col-span-2">
                                    <textarea id="churchMission" rows="3" class="be-input !h-auto py-2.5">Membangun nilai-nilai kehidupan yang berpusat pada pengorbanan Yesus Kristus; membangun Keluarga Allah yang terus bertumbuh dalam kasih; membangun murid Kristus melalui kelompok pemuridan.</textarea>
                                </x-be.field>
                                <x-be.field label="Alamat" for="churchAddress" class="sm:col-span-2">
                                    <input id="churchAddress" type="text" value="Denpasar, Bali" class="be-input">
                                </x-be.field>
                                <x-be.field label="Telepon" for="churchPhone">
                                    <input id="churchPhone" type="tel" value="0361-123456" class="be-input">
                                </x-be.field>
                                <x-be.field label="Email" for="churchEmail">
                                    <input id="churchEmail" type="email" value="info@gkkdbali.org" class="be-input">
                                </x-be.field>
                                <div class="flex justify-end sm:col-span-2">
                                    <x-be.button icon="fa-check">Simpan Perubahan</x-be.button>
                                </div>
                            </form>
                        </div>
                    </x-be.card>
                </div>

                {{-- KONTAK & SOSIAL --}}
                <div x-show="tab === 'kontak'" style="display: none;">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Kontak &amp; Sosial</h3>
                            <p class="text-xs text-muted">Tautan dan kontak yang tampil di footer serta halaman kontak.</p>
                        </div>
                        {{-- TODO: sambungkan ke tabel settings. --}}
                        <div class="p-5">
                            <form class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <x-be.field label="Website" for="socialWebsite">
                                    <input id="socialWebsite" type="url" value="https://gereja-gkkd-denpasar.org" class="be-input">
                                </x-be.field>
                                <x-be.field label="WhatsApp" for="socialWhatsapp">
                                    <input id="socialWhatsapp" type="tel" value="6281234567890" class="be-input">
                                </x-be.field>
                                <x-be.field label="Instagram" for="socialInstagram">
                                    <input id="socialInstagram" type="text" value="@gkkdbali" class="be-input">
                                </x-be.field>
                                <x-be.field label="YouTube" for="socialYoutube">
                                    <input id="socialYoutube" type="text" value="GKKD Bali" class="be-input">
                                </x-be.field>
                                <x-be.field label="Facebook" for="socialFacebook">
                                    <input id="socialFacebook" type="text" value="GKKD Bali" class="be-input">
                                </x-be.field>
                                <x-be.field label="Google Maps Embed" for="socialMaps" class="sm:col-span-2">
                                    <input id="socialMaps" type="url" placeholder="https://www.google.com/maps/embed?..." class="be-input">
                                </x-be.field>
                                <div class="flex justify-end sm:col-span-2">
                                    <x-be.button icon="fa-check">Simpan Perubahan</x-be.button>
                                </div>
                            </form>
                        </div>
                    </x-be.card>
                </div>

                {{-- TAMPILAN --}}
                <div x-show="tab === 'tampilan'" style="display: none;" class="space-y-6">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Tampilan</h3>
                            <p class="text-xs text-muted">Pilih tema aplikasi. Berlaku langsung.</p>
                        </div>
                        <div class="p-5">
                            <span class="be-label">Tema</span>
                            <div class="mt-3 grid grid-cols-3 gap-3">
                                @php
                                    $themes = [
                                        ['id' => 'light', 'label' => 'Terang', 'icon' => 'fa-sun'],
                                        ['id' => 'system', 'label' => 'Sistem', 'icon' => 'fa-laptop'],
                                        ['id' => 'dark', 'label' => 'Gelap', 'icon' => 'fa-moon'],
                                    ];
                                @endphp

                                @foreach ($themes as $theme)
                                    <button
                                        type="button"
                                        @click="$store.theme.set('{{ $theme['id'] }}')"
                                        :class="'{{ $theme['id'] }}' === $store.theme.current
                                            ? 'border-accent bg-accent/10 font-semibold text-accent'
                                            : 'border-line text-muted hover:border-accent/40 hover:text-ink'"
                                        class="flex flex-col items-center gap-2 rounded-2xl border px-4 py-5 text-sm transition-colors"
                                    >
                                        <i class="fa-solid {{ $theme['icon'] }} text-lg"></i>
                                        {{ $theme['label'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </x-be.card>
                </div>

                {{-- NOTIFIKASI --}}
                <div x-show="tab === 'notifikasi'" style="display: none;">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Notifikasi</h3>
                            <p class="text-xs text-muted">Pilih kanal untuk setiap peristiwa.</p>
                        </div>
                        {{-- TODO: sambungkan ke tabel notification_settings. --}}
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead>
                                    <tr class="border-b border-line text-[10px] font-semibold uppercase tracking-wider text-muted">
                                        <th class="px-5 py-3">Peristiwa</th>
                                        <th class="px-5 py-3 text-center">Email</th>
                                        <th class="px-5 py-3 text-center">WhatsApp</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-line">
                                    @foreach ([
                                        ['Jemaat baru terdaftar', true, true],
                                        ['Persembahan masuk', true, false],
                                        ['Agenda ibadah terdekat', false, true],
                                        ['Pesan dari formulir kontak', true, true],
                                    ] as $row)
                                        <tr>
                                            <td class="px-5 py-4 font-medium text-ink">{{ $row[0] }}</td>
                                            <td class="px-5 py-4">
                                                <div class="flex justify-center">
                                                    <button type="button" role="switch" aria-checked="{{ $row[1] ? 'true' : 'false' }}" @click="$el.setAttribute('aria-checked', $el.getAttribute('aria-checked') === 'true' ? 'false' : 'true')" class="be-switch bg-ink/20 aria-checked:bg-accent"></button>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="flex justify-center">
                                                    <button type="button" role="switch" aria-checked="{{ $row[2] ? 'true' : 'false' }}" @click="$el.setAttribute('aria-checked', $el.getAttribute('aria-checked') === 'true' ? 'false' : 'true')" class="be-switch bg-ink/20 aria-checked:bg-accent"></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </x-be.card>
                </div>

                {{-- INTEGRASI & API --}}
                <div x-show="tab === 'integrasi'" style="display: none;">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Integrasi &amp; API</h3>
                            <p class="text-xs text-muted">Kredensial layanan pihak ketiga. Simpan dengan aman.</p>
                        </div>
                        {{-- TODO: sambungkan ke tabel integrations (enkripsi untuk secret). --}}
                        <div class="space-y-6 p-5">
                            <div class="border-b border-line pb-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600">
                                        <i class="fa-brands fa-whatsapp text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-ink">WhatsApp API</h4>
                                        <p class="text-xs text-muted">Untuk OTP dan notifikasi.</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <x-be.field label="Provider" for="waProvider">
                                        <select id="waProvider" class="be-input">
                                            <option>Fonnte</option>
                                            <option>Wablas</option>
                                            <option>Twilio</option>
                                        </select>
                                    </x-be.field>
                                    <x-be.field label="Token API" for="waToken">
                                        <input id="waToken" type="password" placeholder="••••••••" class="be-input">
                                    </x-be.field>
                                </div>
                            </div>

                            <div class="border-b border-line pb-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-500/10 text-red-600">
                                        <i class="fa-brands fa-google text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-ink">Google OAuth</h4>
                                        <p class="text-xs text-muted">Login cepat dengan akun Google.</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <x-be.field label="Client ID" for="googleClientId">
                                        <input id="googleClientId" type="text" placeholder="xxxxx.apps.googleusercontent.com" class="be-input">
                                    </x-be.field>
                                    <x-be.field label="Client Secret" for="googleClientSecret">
                                        <input id="googleClientSecret" type="password" placeholder="••••••••" class="be-input">
                                    </x-be.field>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-accent/10 text-accent">
                                        <i class="fa-solid fa-qrcode text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-ink">Payment / QRIS</h4>
                                        <p class="text-xs text-muted">Untuk persembahan online.</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <x-be.field label="Server Key" for="pgServerKey">
                                        <input id="pgServerKey" type="password" placeholder="••••••••" class="be-input">
                                    </x-be.field>
                                    <x-be.field label="Webhook URL" for="pgWebhook">
                                        <div class="flex gap-2">
                                            <input id="pgWebhook" type="url" value="{{ config('app.url') }}/webhook/persembahan" class="be-input" readonly>
                                            <button type="button" onclick="navigator.clipboard?.writeText(document.getElementById('pgWebhook').value)" class="be-btn be-btn-ghost shrink-0" title="Salin">
                                                <i class="fa-solid fa-copy text-[11px]"></i>
                                            </button>
                                        </div>
                                    </x-be.field>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <x-be.button icon="fa-check">Simpan Integrasi</x-be.button>
                            </div>
                        </div>
                    </x-be.card>
                </div>

                {{-- KEAMANAN SISTEM --}}
                <div x-show="tab === 'keamanan'" style="display: none;" class="space-y-6">
                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Keamanan Sistem</h3>
                            <p class="text-xs text-muted">Kebijakan sesi dan autentikasi.</p>
                        </div>
                        {{-- TODO: sambungkan ke config dinamis / tabel settings. --}}
                        <div class="divide-y divide-line">
                            @foreach ([
                                ['label' => 'Wajibkan 2 Faktor (2FA)', 'desc' => 'Semua admin harus memasang aplikasi authenticator.'],
                                ['label' => 'Catat log aktivitas', 'desc' => 'Setiap autentikasi dan perubahan data dicatat.'],
                                ['label' => 'Mode pemeliharaan', 'desc' => 'Situs publik sementara nonaktif untuk pengunjung.'],
                            ] as $row)
                                <div class="flex items-center justify-between gap-4 p-5">
                                    <div>
                                        <h4 class="text-sm font-bold text-ink">{{ $row['label'] }}</h4>
                                        <p class="text-xs text-muted">{{ $row['desc'] }}</p>
                                    </div>
                                    <button type="button" role="switch" aria-checked="false" @click="$el.setAttribute('aria-checked', $el.getAttribute('aria-checked') === 'true' ? 'false' : 'true')" class="be-switch shrink-0 bg-ink/20 aria-checked:bg-accent"></button>
                                </div>
                            @endforeach
                        </div>
                    </x-be.card>

                    <x-be.card class="overflow-hidden">
                        <div class="border-b border-line p-5">
                            <h3 class="text-base font-bold text-ink">Kebijakan Password</h3>
                            <p class="text-xs text-muted">Minimal panjang dan kompleksitas kata sandi.</p>
                        </div>
                        <div class="p-5">
                            <form class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <x-be.field label="Panjang Minimal" for="pwMin">
                                    <input id="pwMin" type="number" value="8" min="6" max="128" class="be-input">
                                </x-be.field>
                                <x-be.field label="Masa Berlaku Sesi (menit)" for="sessionLife">
                                    <input id="sessionLife" type="number" value="120" min="5" class="be-input">
                                </x-be.field>
                                <div class="flex justify-end sm:col-span-2">
                                    <x-be.button icon="fa-check">Terapkan Kebijakan</x-be.button>
                                </div>
                            </form>
                        </div>
                    </x-be.card>
                </div>

            </div>
        </div>

    </main>

</x-be.layouts.app>
