@props([
    'title' => null,
])

<header class="sticky top-0 z-40 bg-[#F9F9F6]/95 backdrop-blur-md border-b border-[#E5E7EB] px-4 py-3">
    <div class="flex items-center justify-between">
        {{-- Logo & Brand Wordmark --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 group transition-transform active:scale-95" aria-label="Beranda Kuantum Pelopor">
            <x-application-logo class="h-9 w-auto object-contain rounded-lg shadow-xs" />
            <div class="flex flex-col text-left">
                <span class="text-sm font-bold tracking-tight text-[#0F382C] font-serif leading-none group-hover:text-[#1A5C44] transition-colors">
                    Kuantum Pelopor
                </span>
                <span class="text-[10px] font-semibold text-[#D4AF37] tracking-wider uppercase leading-tight mt-0.5">
                    Visual Dakwah
                </span>
            </div>
        </a>

        {{-- Right Controls: Notifications & Profile/Avatar --}}
        <div class="flex items-center gap-2">
            {{-- Notification Bell --}}
            <button type="button"
                    aria-label="Notifikasi"
                    class="relative p-2 rounded-xl text-[#0F382C] hover:bg-[#E8F5E9] active:bg-[#C8E6C9] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                {{-- Notification Indicator Dot --}}
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#D4AF37] ring-2 ring-[#F9F9F6]"></span>
            </button>

            {{-- Avatar / User Menu --}}
            @auth
                <a href="{{ route('profile') }}"
                   class="flex items-center group transition-transform active:scale-95"
                   aria-label="Profil Saya ({{ auth()->user()->name }})">
                    @if (auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                             alt="{{ auth()->user()->name }}"
                             class="w-8 h-8 rounded-full object-cover ring-2 ring-[#0F382C]/20 group-hover:ring-[#D4AF37] transition-all">
                    @else
                        <div class="w-8 h-8 rounded-full bg-[#0F382C] text-white flex items-center justify-center font-bold text-xs ring-2 ring-[#D4AF37]/60 shadow-xs group-hover:bg-[#1A5C44] transition-all">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#0F382C] bg-[#E8F5E9] hover:bg-[#C8E6C9] border border-[#A5D6A7]/70 transition-colors shadow-2xs"
                   aria-label="Masuk Akun">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#0F382C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Masuk</span>
                </a>
            @endauth
        </div>
    </div>
</header>
