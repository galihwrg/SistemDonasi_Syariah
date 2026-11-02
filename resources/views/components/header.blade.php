@props([
    'title' => null,
])

<header class="px-5 py-3 flex items-center justify-between border-b border-[#dadad7]/50 bg-[#f9f9f6]/95 backdrop-blur-md sticky top-0 z-40">
    {{-- Brand Logo & Title --}}
    <a href="{{ route('home') }}" class="flex items-center gap-3 group transition-transform active:scale-95" aria-label="Beranda Kuantum Pelopor">
        <x-application-logo class="h-10 w-auto object-contain rounded-xl shadow-xs" />
        <div class="flex flex-col text-left">
            <h1 class="font-serif text-[16px] leading-tight font-semibold text-[#0f382c] tracking-tight group-hover:text-[#1a5c44] transition-colors">
                Kuantum Pelopor
            </h1>
            <p class="text-[10px] tracking-normal text-[#735c00] font-semibold mt-0.5">
                Galeri Visual Islami
            </p>
        </div>
    </a>

    {{-- Right Cluster Actions --}}
    <div class="flex items-center gap-2">
        {{-- Notification Button --}}
        <button aria-label="Notifikasi"
                type="button"
                class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#414845] hover:bg-[#e8e8e5] transition-colors active:scale-95 relative">
            <span class="material-symbols-outlined text-[20px]">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-[#ba1a1a] ring-2 ring-[#f9f9f6]"></span>
        </button>

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
