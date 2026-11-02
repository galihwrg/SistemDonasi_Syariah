<x-layouts.app title="Jelajah Karya Dakwah — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Header Title --}}
        <div>
            <h1 class="text-xl font-bold font-serif text-[#0F382C]">
                Jelajah Karya Dakwah
            </h1>
            <p class="text-xs text-[#6B7280] mt-0.5">
                Kurasi visual syariah beresolusi tinggi bebas wakaf
            </p>
        </div>

        {{-- Search input --}}
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text"
                   placeholder="Cari berdasarkan kata kunci, judul, atau surah..."
                   class="w-full pl-10 pr-4 py-3 rounded-2xl text-xs bg-white border border-[#E5E7EB] placeholder-gray-400 text-gray-800 outline-none focus:border-[#0F382C] focus:ring-2 focus:ring-[#0F382C]/10 transition-all shadow-2xs">
        </div>

        {{-- Filter categories --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none -mx-4 px-4 text-xs">
            <button class="px-3 py-1.5 rounded-full font-medium text-xs bg-[#0F382C] text-white shrink-0">
                Semua
            </button>
            <button class="px-3 py-1.5 rounded-full font-medium text-xs bg-white text-[#6B7280] border border-[#E5E7EB] shrink-0">
                Arsitektur
            </button>
            <button class="px-3 py-1.5 rounded-full font-medium text-xs bg-white text-[#6B7280] border border-[#E5E7EB] shrink-0">
                Alam &amp; Tadabbur
            </button>
            <button class="px-3 py-1.5 rounded-full font-medium text-xs bg-white text-[#6B7280] border border-[#E5E7EB] shrink-0">
                Kaligrafi
            </button>
            <button class="px-3 py-1.5 rounded-full font-medium text-xs bg-white text-[#6B7280] border border-[#E5E7EB] shrink-0">
                Kegiatan Umat
            </button>
        </div>

        {{-- Gallery Grid Placeholder (Will be dynamic in Sprint 2) --}}
        <div class="grid grid-cols-2 gap-3 pt-2">
            @for ($i = 1; $i <= 4; $i++)
                <div class="bg-white rounded-2xl overflow-hidden shadow-2xs border border-[#E5E7EB] flex flex-col">
                    <div class="relative aspect-4/5 bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 opacity-40 text-[#0F382C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#0F382C]/80 text-white">
                            Karya {{ $i }}
                        </span>
                    </div>
                    <div class="p-2.5">
                        <h3 class="text-xs font-bold text-[#0F382C] line-clamp-1 font-serif">
                            Dokumentasi Karya #{{ $i }}
                        </h3>
                        <p class="text-[10px] text-[#6B7280] mt-0.5">
                            Kontributor Dakwah
                        </p>
                    </div>
                </div>
            @endfor
        </div>

    </div>

</x-layouts.app>
