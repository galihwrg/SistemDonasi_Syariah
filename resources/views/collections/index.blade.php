<x-layouts.app title="Koleksi Saya — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Header Title --}}
        <div>
            <h1 class="text-xl font-bold font-serif text-[#0F382C]">
                Koleksi Tersimpan
            </h1>
            <p class="text-xs text-[#6B7280] mt-0.5">
                Karya visual dakwah yang telah Anda bookmark untuk inspirasi
            </p>
        </div>

        {{-- Empty State (if not logged in or no collections) --}}
        <div class="bg-white rounded-3xl p-8 text-center border border-[#E5E7EB] shadow-2xs space-y-3">
            <div class="w-14 h-14 mx-auto rounded-full bg-[#E8F5E9] text-[#0F382C] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                </svg>
            </div>
            <h3 class="text-sm font-bold text-[#0F382C] font-serif">
                Belum Ada Koleksi Tersimpan
            </h3>
            <p class="text-xs text-[#6B7280] max-w-xs mx-auto leading-relaxed">
                Jelajahi ribuan karya visual dakwah dan klik ikon bookmark untuk menyimpannya di sini.
            </p>
            <div class="pt-2">
                <a href="{{ route('jelajah') }}"
                   class="inline-block px-4 py-2.5 rounded-xl text-xs font-bold text-white shadow-xs"
                   style="background: #0F382C;">
                    Mulai Jelajah
                </a>
            </div>
        </div>

    </div>

</x-layouts.app>
