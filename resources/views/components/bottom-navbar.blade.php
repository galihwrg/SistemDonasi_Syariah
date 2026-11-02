<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50 bg-[#f9f9f6]/95 backdrop-blur-md border-t border-[#dadad7]/60 shadow-lg px-2 pt-2 pb-1" aria-label="Navigasi Utama">
    <div class="flex justify-around items-center relative">

        {{-- 1. HOME --}}
        @php
            $isHome = request()->routeIs('home');
        @endphp
        <a href="{{ route('home') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition-colors {{ $isHome ? 'text-[#0f382c]' : 'text-[#5c6460] hover:text-[#0f382c]' }}"
           aria-current="{{ $isHome ? 'page' : 'false' }}">
            <span class="material-symbols-outlined text-[24px]">home</span>
            <span class="text-[11px] {{ $isHome ? 'font-bold' : 'font-medium' }} mt-0.5 tracking-tight leading-none">
                Home
            </span>
            @if ($isHome)
                <span class="w-1.5 h-1.5 bg-[#0f382c] rounded-full mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 bg-transparent rounded-full mt-0.5"></span>
            @endif
        </a>

        {{-- 2. JELAJAH --}}
        @php
            $isJelajah = request()->routeIs('jelajah*');
        @endphp
        <a href="{{ route('jelajah') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition-colors {{ $isJelajah ? 'text-[#0f382c]' : 'text-[#5c6460] hover:text-[#0f382c]' }}"
           aria-current="{{ $isJelajah ? 'page' : 'false' }}">
            <span class="material-symbols-outlined text-[24px]">explore</span>
            <span class="text-[11px] {{ $isJelajah ? 'font-bold' : 'font-medium' }} mt-0.5 tracking-tight leading-none">
                Jelajah
            </span>
            @if ($isJelajah)
                <span class="w-1.5 h-1.5 bg-[#0f382c] rounded-full mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 bg-transparent rounded-full mt-0.5"></span>
            @endif
        </a>

        {{-- 3. UPLOAD / UNGGAH (CENTER FAB) --}}
        @php
            $isUpload = request()->routeIs('unggah*');
        @endphp
        <div class="flex-1 flex justify-center -mt-5">
            <a href="{{ route('unggah') }}"
               aria-label="Unggah Karya Visual Baru"
               class="w-12 h-12 bg-[#0f382c] hover:bg-[#1a5c44] text-white rounded-full flex items-center justify-center shadow-md ring-4 ring-[#f9f9f6] active:scale-95 transition-transform"
               aria-current="{{ $isUpload ? 'page' : 'false' }}">
                <span class="material-symbols-outlined text-[26px] font-bold">add</span>
            </a>
        </div>

        {{-- 4. KOLEKSI --}}
        @php
            $isKoleksi = request()->routeIs('koleksi*');
        @endphp
        <a href="{{ route('koleksi') }}"
           class="flex flex-col items-center justify-center flex-1 py-1 transition-colors {{ $isKoleksi ? 'text-[#0f382c]' : 'text-[#5c6460] hover:text-[#0f382c]' }}"
           aria-current="{{ $isKoleksi ? 'page' : 'false' }}">
            <span class="material-symbols-outlined text-[24px]">bookmark</span>
            <span class="text-[11px] {{ $isKoleksi ? 'font-bold' : 'font-medium' }} mt-0.5 tracking-tight leading-none">
                Koleksi
            </span>
            @if ($isKoleksi)
                <span class="w-1.5 h-1.5 bg-[#0f382c] rounded-full mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 bg-transparent rounded-full mt-0.5"></span>
            @endif
        </a>

        {{-- 5. WAKTU SALAT --}}
        @php
            $isSalat = request()->routeIs('waktu-salat*');
        @endphp
        <a href="{{ route('waktu-salat') }}"
           aria-label="Waktu Salat"
           class="flex flex-col items-center justify-center flex-1 py-1 transition-colors {{ $isSalat ? 'text-[#0f382c]' : 'text-[#5c6460] hover:text-[#0f382c]' }}"
           aria-current="{{ $isSalat ? 'page' : 'false' }}">
            <span class="material-symbols-outlined text-[24px]">schedule</span>
            <span class="text-[11px] {{ $isSalat ? 'font-bold' : 'font-medium' }} mt-0.5 tracking-tight leading-none">
                Waktu Salat
            </span>
            @if ($isSalat)
                <span class="w-1.5 h-1.5 bg-[#0f382c] rounded-full mt-0.5"></span>
            @else
                <span class="w-1.5 h-1.5 bg-transparent rounded-full mt-0.5"></span>
            @endif
        </a>

    </div>

    {{-- iOS Home Bar indicator --}}
    <div class="w-32 h-1 bg-[#1a1c1a]/20 rounded-full mx-auto mt-2 mb-1"></div>
</nav>
