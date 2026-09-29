<div class="space-y-6">

    {{-- Notifikasi sementara --}}
    @if ($pesan)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="flex items-center gap-3 rounded-2xl border p-4 text-sm font-medium
                {{ $pesanTone === 'error'
                    ? 'border-danger/30 bg-danger/10 text-danger'
                    : 'border-success/30 bg-success/10 text-success' }}"
        >
            <i class="fa-solid {{ $pesanTone === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check' }}"></i>
            <span>{{ $pesan }}</span>
        </div>
    @endif

    {{-- Tabel Role (master) --}}
    <x-be.card class="overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-line p-5 sm:flex-row sm:items-center">
            <div>
                <h3 class="text-base font-bold text-ink">Daftar Role</h3>
                <p class="text-xs text-muted">Total {{ $this->roles->count() }} role terdaftar di sistem.</p>
            </div>
            <x-be.button type="button" icon="fa-plus" wire:click="bukaFormTambah">Tambah Role</x-be.button>
        </div>

        @if ($this->roles->isEmpty())
            <x-be.empty-state
                icon="fa-user-shield"
                title="Belum ada role"
                description="Tambahkan role pertama untuk mulai mengatur hak akses."
            />
        @else
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-line bg-ink/[0.03] text-[11px] font-semibold uppercase tracking-wider text-muted">
                            <th class="px-6 py-3.5">Role</th>
                            <th class="px-6 py-3.5">Jumlah User</th>
                            <th class="px-6 py-3.5">Permission</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line text-xs text-ink/80">
                        @foreach ($this->roles as $role)
                            <tr
                                class="transition-colors hover:bg-ink/[0.02] {{ $this->roleId === (int) $role->id ? 'bg-accent/[0.06]' : '' }}"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent">
                                            <i class="fa-solid fa-user-shield text-xs"></i>
                                        </span>
                                        <div>
                                            <p class="font-bold text-ink">{{ $role->name }}</p>
                                            <p class="text-[11px] text-muted">Guard: {{ $role->guard_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <x-be.badge tone="neutral">{{ $role->users_count }} user</x-be.badge>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($role->permissions->isEmpty())
                                        <span class="text-[11px] text-muted">Tidak ada akses</span>
                                    @else
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($role->permissions as $permission)
                                                <x-be.badge tone="accent">{{ $permission->name }}</x-be.badge>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="pilihRole({{ $role->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-accent hover:text-accent"
                                        >
                                            <i class="fa-solid fa-sliders text-[10px]"></i> Kelola
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaFormUbah({{ $role->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:text-accent"
                                            aria-label="Ubah nama role"
                                        >
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="bukaKonfirmasiHapus({{ $role->id }})"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                            aria-label="Hapus role"
                                        >
                                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-be.card>

    {{-- Panel Detail (master-detail) --}}
    @php
        $role = $this->roleTerpilih();
    @endphp

    @if ($role)
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Permission assignment --}}
            <x-be.card class="overflow-hidden">
                <div class="border-b border-line p-5">
                    <h3 class="text-base font-bold text-ink">Permission Role</h3>
                    <p class="text-xs text-muted">Klik untuk memberi/mencabut akses pada role <span class="font-semibold text-accent">{{ $role->name }}</span>.</p>
                </div>

                <div class="space-y-2 p-5">
                    @foreach ($this->permissions as $permission)
                        @php
                            $aktif = $role->hasPermissionTo($permission->name);
                            $terkunci = $this->permissionTerkunci($role, $permission->name) && $aktif;
                        @endphp
                        <button
                            type="button"
                            @if ($terkunci)
                                disabled
                                aria-disabled="true"
                                title="Permission permanen, tidak bisa dicabut"
                            @else
                                wire:click="togglePermission('{{ $permission->name }}')"
                            @endif
                            class="flex w-full items-center justify-between gap-3 rounded-2xl border p-3.5 text-left transition-colors
                                @if ($terkunci)
                                    cursor-not-allowed border-accent/40 bg-accent/[0.06] opacity-80
                                @elseif ($aktif)
                                    border-accent/40 bg-accent/[0.06] hover:border-accent/60
                                @else
                                    border-line hover:border-ink/20
                                @endif"
                        >
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl
                                    {{ $aktif ? 'bg-accent/15 text-accent' : 'bg-ink/5 text-muted' }}">
                                    <i class="fa-solid {{ $terkunci ? 'fa-lock' : ($aktif ? 'fa-check' : 'fa-lock') }} text-xs"></i>
                                </span>
                                <span class="text-sm font-semibold {{ $aktif ? 'text-ink' : 'text-muted' }}">{{ $permission->name }}</span>
                                @if ($terkunci)
                                    <span class="be-badge bg-accent/10 text-accent">Permanen</span>
                                @endif
                            </div>
                            <span
                                role="switch"
                                aria-checked="{{ $aktif ? 'true' : 'false' }}"
                                class="be-switch pointer-events-none {{ $aktif ? 'bg-accent' : 'bg-ink/20' }}"
                            ></span>
                        </button>
                    @endforeach

                    @if ($this->permissions->isEmpty())
                        <p class="py-6 text-center text-xs text-muted">Belum ada permission terdaftar.</p>
                    @endif
                </div>
            </x-be.card>

            {{-- User assignment --}}
            <x-be.card class="overflow-hidden">
                <div class="border-b border-line p-5">
                    <h3 class="text-base font-bold text-ink">User Pemilik Role</h3>
                    <p class="text-xs text-muted">Kelola user yang memiliki role <span class="font-semibold text-accent">{{ $role->name }}</span>.</p>
                </div>

                {{-- Form assign --}}
                <form wire:submit="assignUser" class="flex items-end gap-3 border-b border-line p-5">
                    <div class="flex-1">
                        <x-be.field label="Assign user" for="userId">
                            <select id="userId" wire:model="userId" class="be-input">
                                <option value="">Pilih user...</option>
                                @foreach ($this->kandidatUser as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} — {{ $user->email }}</option>
                                @endforeach
                            </select>
                        </x-be.field>
                    </div>
                    <x-be.button type="submit" icon="fa-plus">Tambah</x-be.button>
                </form>

                @if (count($errors) > 0 && $errors->has('userId'))
                    <p class="px-5 pt-3 text-[11px] text-danger">{{ $errors->first('userId') }}</p>
                @endif

                {{-- Daftar user pemilik role --}}
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <tbody class="divide-y divide-line text-xs text-ink/80">
                            @foreach ($role->users as $user)
                                <tr class="transition-colors hover:bg-ink/[0.02]">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-accent/10 text-xs font-bold text-accent">
                                                {{ collect(explode(' ', trim($user->name)))->filter()->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
                                            </span>
                                            <div>
                                                <p class="font-bold text-ink">{{ $user->name }}</p>
                                                <p class="text-[11px] text-muted">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            type="button"
                                            wire:click="lepasUser({{ $user->id }})"
                                            wire:confirm="Lepas user ini dari role {{ $role->name }}?"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-line px-3 py-2 text-xs font-semibold text-muted transition-colors hover:border-danger hover:text-danger"
                                        >
                                            <i class="fa-solid fa-xmark text-[10px]"></i> Lepas
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($role->users->isEmpty())
                    <p class="px-5 py-8 text-center text-xs text-muted">Belum ada user pada role ini.</p>
                @endif
            </x-be.card>
        </div>
    @else
        <x-be.card class="overflow-hidden">
            <x-be.empty-state
                icon="fa-hand-pointer"
                title="Pilih sebuah role"
                description="Klik tombol Kelola pada role di atas untuk mengatur permission dan user-nya."
            />
        </x-be.card>
    @endif

    {{-- Modal form tambah/ubah role --}}
    <div
        x-data="{ open: @entangle('formRoleOpen') }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:keydown.escape.window="open = false"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
        style="display: none;"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="flex max-h-[90vh] w-full max-w-md flex-col rounded-3xl bg-card shadow-2xl"
            x-on:click.outside="open = false"
        >
            <div class="flex items-center justify-between border-b border-line p-6">
                <div>
                    <h3 class="text-base font-bold text-ink">{{ $this->roleId ? 'Ubah Nama Role' : 'Tambah Role Baru' }}</h3>
                    <p class="text-xs text-muted">{{ $this->roleId ? 'Ganti nama role yang dipilih.' : 'Buat role kustom dengan nama sendiri.' }}</p>
                </div>
                <button
                    type="button"
                    x-on:click="open = false"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-ink/5 text-muted transition-colors hover:text-ink"
                    aria-label="Tutup"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form wire:submit="simpanRole" class="space-y-5 p-6">
                <x-be.field label="Nama Role" for="nama" :help="$errors->first('nama')">
                    <input
                        id="nama"
                        type="text"
                        wire:model="nama"
                        placeholder="Contoh: Multimedia"
                        class="be-input {{ $errors->has('nama') ? 'border-danger' : '' }}"
                    >
                </x-be.field>

                <div class="flex items-center justify-end gap-2.5">
                    <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                    <x-be.button type="submit" icon="fa-check">{{ $this->roleId ? 'Simpan' : 'Tambah Role' }}</x-be.button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal konfirmasi hapus --}}
    <div
        x-data="{ open: @entangle('hapusOpen') }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-on:keydown.escape.window="open = false"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
        style="display: none;"
    >
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="w-full max-w-md rounded-3xl bg-card p-6 shadow-2xl"
            x-on:click.outside="open = false"
        >
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-danger/10 text-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                <div class="space-y-1.5">
                    <h3 class="text-base font-bold text-ink">Hapus Role?</h3>
                    <p class="text-sm text-muted">
                        Role yang dipilih akan dihapus permanen.
                        Role yang masih dipakai user tidak bisa dihapus.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-2.5">
                <x-be.button type="button" variant="ghost" x-on:click="open = false">Batal</x-be.button>
                <x-be.button type="button" variant="danger" icon="fa-trash-can" wire:click="hapusRole">Hapus Role</x-be.button>
            </div>
        </div>
    </div>

</div>
