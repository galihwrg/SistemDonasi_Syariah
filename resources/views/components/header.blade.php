@props([
    'title' => null,
    'wideLayout' => true,
])

<header class="px-4 sm:px-6 md:px-8 py-3.5 flex items-center justify-between border-b border-[#dadad7]/50 bg-[#f9f9f6]/95 backdrop-blur-md sticky top-0 z-40">
    {{-- Brand Logo & Title --}}
    <div class="flex items-center gap-6">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-transform active:scale-95" aria-label="Beranda Kuantum Pelopor">
            <x-application-logo class="h-10 w-auto object-contain rounded-xl shadow-xs" />
            <div class="flex flex-col text-left">
                <h1 class="font-serif text-[16px] md:text-[18px] leading-tight font-semibold text-[#0f382c] tracking-tight group-hover:text-[#1a5c44] transition-colors">
                    Kuantum Pelopor
                </h1>
                <p class="text-[10px] md:text-[11px] tracking-normal text-[#735c00] font-semibold mt-0.5">
                    Galeri Visual Islami
                </p>
            </div>
        </a>

        {{-- Desktop Header Navigation Links (Otomatis tampil di desktop >= md) --}}
        <nav class="hidden md:flex items-center gap-6 pl-4 border-l border-[#dadad7]/60">
            <a href="{{ route('home') }}" class="text-xs lg:text-sm font-semibold {{ request()->routeIs('home') ? 'text-[#0f382c] font-bold border-b-2 border-[#0f382c] pb-0.5' : 'text-[#717975] hover:text-[#0f382c]' }} transition-colors">
                Beranda
            </a>
            <a href="{{ route('jelajah') }}" class="text-xs lg:text-sm font-semibold {{ request()->routeIs('jelajah*') ? 'text-[#0f382c] font-bold border-b-2 border-[#0f382c] pb-0.5' : 'text-[#717975] hover:text-[#0f382c]' }} transition-colors">
                Jelajah Galeri
            </a>
            <a href="{{ route('koleksi') }}" class="text-xs lg:text-sm font-semibold {{ request()->routeIs('koleksi*') ? 'text-[#0f382c] font-bold border-b-2 border-[#0f382c] pb-0.5' : 'text-[#717975] hover:text-[#0f382c]' }} transition-colors">
                Koleksi Saya
            </a>
            <a href="{{ route('waktu-salat') }}" class="text-xs lg:text-sm font-semibold {{ request()->routeIs('waktu-salat*') ? 'text-[#0f382c] font-bold border-b-2 border-[#0f382c] pb-0.5' : 'text-[#717975] hover:text-[#0f382c]' }} transition-colors">
                Jadwal Salat & Kiblat
            </a>
            @auth
                <a href="{{ route('artworks.my') }}" class="text-xs lg:text-sm font-semibold {{ request()->routeIs('artworks.my*') ? 'text-[#0f382c] font-bold border-b-2 border-[#0f382c] pb-0.5' : 'text-[#717975] hover:text-[#0f382c]' }} transition-colors">
                    Postingan Saya
                </a>
            @endauth
        </nav>
    </div>

    {{-- Right Cluster Actions --}}
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="{{ route('unggah') }}"
           class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#0f382c] hover:bg-[#1a5c44] text-white text-xs lg:text-sm font-semibold shadow-xs transition-all active:scale-95">
            <span class="material-symbols-outlined text-[16px] text-[#fed65b]">add</span>
            <span>Unggah Karya</span>
        </a>
        {{-- Notification Button & Dropdown --}}
        @auth
            @php
                $unreadNotifs = auth()->user()->unreadNotifications;
                $unreadCount = $unreadNotifs->count();
                $allNotifs = auth()->user()->notifications()->take(5)->get();
            @endphp
            <div class="relative" id="notification-wrapper">
                <button aria-label="Notifikasi ({{ $unreadCount }} baru)"
                        id="btn-notification-trigger"
                        type="button"
                        onclick="toggleNotificationDropdown()"
                        class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#414845] hover:bg-[#e8e8e5] transition-colors active:scale-95 relative">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                    @if ($unreadCount > 0)
                        <span class="absolute top-1.5 right-1.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#ba1a1a] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#ba1a1a] ring-2 ring-[#f9f9f6]"></span>
                        </span>
                    @endif
                </button>

                {{-- Notification Dropdown Modal/Pop-up --}}
                <div id="notification-dropdown"
                     class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-[#c1c8c3]/40 z-50 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                    <div class="px-4 py-3 bg-[#0f382c] text-white flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-[#fed65b]">notifications</span>
                            <span class="text-xs font-bold font-serif tracking-wide">Pemberitahuan</span>
                            @if ($unreadCount > 0)
                                <span class="px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-[#ba1a1a] text-white">
                                    {{ $unreadCount }} Baru
                                </span>
                            @endif
                        </div>
                        @if ($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.read-all') }}">
                                @csrf
                                <button type="submit" class="text-[11px] text-[#c1ecda] hover:text-white underline transition-colors">
                                    Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="max-h-[360px] overflow-y-auto divide-y divide-[#c1c8c3]/20">
                        @forelse ($allNotifs as $notif)
                            @php
                                $data = $notif->data;
                                $isUnread = $notif->unread();
                                $icon = $data['icon'] ?? 'info';
                                $iconColor = $data['status'] ?? '' === 'approved' ? '#0F382C' : ($data['status'] ?? '' === 'rejected' ? '#BA1A1A' : '#735C00');
                            @endphp
                            <div class="p-3.5 hover:bg-[#f9f9f6] transition-colors flex items-start gap-3 {{ $isUnread ? 'bg-[#f4f7f5]' : '' }}">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 mt-0.5 {{ ($data['status'] ?? '') === 'approved' ? 'bg-[#c1ecda] text-[#002117]' : (($data['status'] ?? '') === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-800') }}">
                                    <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-baseline justify-between gap-1">
                                        <h4 class="text-xs font-bold text-[#0f382c] truncate">
                                            {{ $data['title'] ?? 'Pemberitahuan Akun' }}
                                        </h4>
                                        <span class="text-[10px] text-gray-400 shrink-0">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-[#414845] leading-snug mt-0.5">
                                        {{ $data['message'] ?? '' }}
                                    </p>
                                    @if (!empty($data['admin_notes']))
                                        <div class="mt-1.5 p-2 rounded-lg bg-red-50 border border-red-200 text-[10.5px] text-red-800">
                                            <strong>Catatan Admin:</strong> {{ $data['admin_notes'] }}
                                        </div>
                                    @endif
                                    @if ($isUnread)
                                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" class="mt-2 inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-[10.5px] font-semibold text-[#0f382c] hover:underline flex items-center gap-1">
                                                <span>Buka & Tandai Dibaca</span>
                                                <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ $data['action_url'] ?? route('profile') }}" class="mt-1.5 inline-flex items-center gap-1 text-[10.5px] font-medium text-gray-500 hover:text-[#0f382c]">
                                            <span>Lihat Detail</span>
                                            <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-8 px-4 text-center">
                                <span class="material-symbols-outlined text-[32px] text-gray-300">notifications_paused</span>
                                <p class="text-xs font-medium text-gray-600 mt-1">Belum Ada Notifikasi</p>
                                <p class="text-[10px] text-gray-400">Pemberitahuan status akun Anda akan muncul di sini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-2.5 bg-[#f4f4f1] text-center border-t border-[#c1c8c3]/20">
                        <a href="{{ route('profile') }}" class="text-[11px] font-semibold text-[#0f382c] hover:underline inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">person</span>
                            <span>Buka Status Akun & Profil</span>
                        </a>
                    </div>
                </div>
            </div>

            <script>
                function toggleNotificationDropdown() {
                    const dropdown = document.getElementById('notification-dropdown');
                    if (dropdown) {
                        dropdown.classList.toggle('hidden');
                    }
                }

                // Tutup dropdown jika klik di luar area
                document.addEventListener('click', function(e) {
                    const wrapper = document.getElementById('notification-wrapper');
                    const dropdown = document.getElementById('notification-dropdown');
                    if (wrapper && dropdown && !wrapper.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            </script>
        @else
            {{-- Notification icon for guest --}}
            <button aria-label="Notifikasi"
                    type="button"
                    onclick="window.location.href='{{ route('login') }}'"
                    class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#414845] hover:bg-[#e8e8e5] transition-colors active:scale-95 relative"
                    title="Masuk untuk melihat notifikasi">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
            </button>
        @endauth

        {{-- Contributor / User Avatar --}}
        @auth
            <a href="{{ route('profile') }}"
               class="flex items-center group transition-transform active:scale-95"
               aria-label="Profil Saya ({{ auth()->user()->name }})">
                @if (auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-9 h-9 rounded-full object-cover ring-2 ring-[#0f382c] shadow-xs">
                @else
                    <div class="w-9 h-9 rounded-full bg-[#0f382c] text-white flex items-center justify-center font-bold text-xs ring-2 ring-[#fed65b] shadow-xs group-hover:bg-[#1a5c44] transition-all">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </a>
        @else
            <a href="{{ route('login') }}"
               class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#0f382c] bg-[#e8f5e9] border border-[#a5d6a7]/70 hover:bg-[#c8e6c9] transition-colors shadow-2xs"
               aria-label="Masuk Akun">
                <span class="material-symbols-outlined text-[16px]">login</span>
                <span>Masuk</span>
            </a>
        @endauth
    </div>
</header>
