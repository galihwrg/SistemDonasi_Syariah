<nav class="fixed bottom-0 left-0 right-0 z-50 flex justify-center pointer-events-none" aria-label="Navigasi Utama">
    <div class="pointer-events-auto w-full max-w-md bg-white/95 backdrop-blur-md border-t border-[#E5E7EB] shadow-[0_-4px_24px_rgba(15,56,44,0.06)] px-2 py-1.5 flex items-end justify-around">

        {{-- 1. HOME --}}
        @php
            $isHome = request()->routeIs('home');
        @endphp
        <a href="{{ route('home') }}"
           class="flex-1 flex flex-col items-center justify-center py-1 transition-all group"
           aria-current="{{ $isHome ? 'page' : 'false' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 transition-transform group-hover:scale-110 {{ $isHome ? 'text-[#0F382C]' : 'text-[#9CA3AF]' }}"
                     fill="{{ $isHome ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="{{ $isHome ? '2' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </div>
            <span class="text-[11px] mt-1 transition-colors {{ $isHome ? 'font-bold text-[#0F382C]' : 'font-medium text-[#6B7280]' }}">
                Home
            </span>
            @if ($isHome)
                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 rounded-full bg-transparent mt-0.5"></span>
            @endif
        </a>

        {{-- 2. JELAJAH --}}
        @php
            $isJelajah = request()->routeIs('jelajah*');
        @endphp
        <a href="{{ route('jelajah') }}"
           class="flex-1 flex flex-col items-center justify-center py-1 transition-all group"
           aria-current="{{ $isJelajah ? 'page' : 'false' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 transition-transform group-hover:scale-110 {{ $isJelajah ? 'text-[#0F382C]' : 'text-[#9CA3AF]' }}"
                     fill="{{ $isJelajah ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="{{ $isJelajah ? '2' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14.25 9.75l-4.5 1.5 1.5 4.5 4.5-1.5-1.5-4.5z" />
                </svg>
            </div>
            <span class="text-[11px] mt-1 transition-colors {{ $isJelajah ? 'font-bold text-[#0F382C]' : 'font-medium text-[#6B7280]' }}">
                Jelajah
            </span>
            @if ($isJelajah)
                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 rounded-full bg-transparent mt-0.5"></span>
            @endif
        </a>

        {{-- 3. UPLOAD / UNGGAH (CENTER FLOATING BUTTON) --}}
        @php
            $isUpload = request()->routeIs('unggah*');
        @endphp
        <div class="flex-1 flex flex-col items-center justify-center relative">
            <a href="{{ route('unggah') }}"
               class="relative -top-3 flex items-center justify-center w-12 h-12 rounded-full transition-all duration-200 transform hover:scale-105 active:scale-95 shadow-md group {{ $isUpload ? 'bg-[#D4AF37] text-[#0F382C] ring-4 ring-[#E8F5E9]' : 'bg-[#0F382C] text-white hover:bg-[#1A5C44] ring-4 ring-[#F9F9F6]' }}"
               aria-label="Unggah Karya Visual Baru"
               aria-current="{{ $isUpload ? 'page' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 transition-transform group-hover:rotate-90 duration-200"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>
            <span class="text-[10px] -mt-2 transition-colors {{ $isUpload ? 'font-bold text-[#0F382C]' : 'font-medium text-[#6B7280]' }}">
                Unggah
            </span>
        </div>

        {{-- 4. KOLEKSI --}}
        @php
            $isKoleksi = request()->routeIs('koleksi*');
        @endphp
        <a href="{{ route('koleksi') }}"
           class="flex-1 flex flex-col items-center justify-center py-1 transition-all group"
           aria-current="{{ $isKoleksi ? 'page' : 'false' }}">
            <div class="relative flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 transition-transform group-hover:scale-110 {{ $isKoleksi ? 'text-[#0F382C]' : 'text-[#9CA3AF]' }}"
                     fill="{{ $isKoleksi ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="{{ $isKoleksi ? '2' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
            </div>
            <span class="text-[11px] mt-1 transition-colors {{ $isKoleksi ? 'font-bold text-[#0F382C]' : 'font-medium text-[#6B7280]' }}">
                Koleksi
            </span>
            @if ($isKoleksi)
                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 rounded-full bg-transparent mt-0.5"></span>
            @endif
        </a>

        {{-- 5. WAKTU SALAT --}}
        @php
            $isSalat = request()->routeIs('waktu-salat*');
        @endphp
        <a href="{{ route('waktu-salat') }}"
           class="flex-1 flex flex-col items-center justify-center py-1 transition-all group"
           aria-current="{{ $isSalat ? 'page' : 'false' }}">
            <div class="relative flex items-center justify-center">
                {{-- Mosque Dome / Prayer Time Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 transition-transform group-hover:scale-110 {{ $isSalat ? 'text-[#0F382C]' : 'text-[#9CA3AF]' }}"
                     fill="{{ $isSalat ? 'currentColor' : 'none' }}"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="{{ $isSalat ? '2' : '1.8' }}">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3c-1.5 2-4 3.5-4 6.5a4 4 0 008 0C16 6.5 13.5 5 12 3z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 11.5v8.25A1.25 1.25 0 005.25 21h13.5A1.25 1.25 0 0020 19.75V11.5M9 21v-4a3 3 0 016 0v4" />
                </svg>
            </div>
            <span class="text-[11px] mt-1 transition-colors {{ $isSalat ? 'font-bold text-[#0F382C]' : 'font-medium text-[#6B7280]' }}">
                Waktu Salat
            </span>
            @if ($isSalat)
                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37] mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 rounded-full bg-transparent mt-0.5"></span>
            @endif
        </a>

    </div>
</nav>
