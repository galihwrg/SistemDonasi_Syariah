<x-layouts.app title="Waktu Salat & Arah Kiblat — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Header Title --}}
        <div>
            <h1 class="text-xl font-bold font-serif text-[#0F382C]">
                Waktu Salat &amp; Arah Kiblat
            </h1>
            <p class="text-xs text-[#6B7280] mt-0.5">
                Pengingat ibadah &amp; penunjuk arah Ka'bah otomatis terintegrasi
            </p>
        </div>

        {{-- Hero Prayer Card --}}
        <div class="rounded-3xl p-5 text-white shadow-md relative overflow-hidden"
             style="background: linear-gradient(135deg, #0F382C 0%, #1A5C44 100%);">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-[#FED65B]">
                        Salat Terdekat
                    </span>
                    <h2 class="text-2xl font-bold font-serif mt-1">
                        Dzuhur • 11:48
                    </h2>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl">
                    🕌
                </div>
            </div>
            <p class="text-xs text-white/80 mt-2">
                Kab. Bogor, Jawa Barat • Waktu Indonesia Barat
            </p>
        </div>

        {{-- Qibla Compass Preview Teaser --}}
        <div class="bg-white rounded-3xl p-6 text-center border border-[#E5E7EB] shadow-2xs space-y-3">
            <div class="w-24 h-24 mx-auto rounded-full bg-[#E8F5E9] border-4 border-[#0F382C]/10 flex items-center justify-center relative shadow-inner">
                <div class="w-2 h-10 rounded-full bg-[#D4AF37] transform -rotate-45 shadow-sm"></div>
                <span class="absolute top-1 text-[10px] font-bold text-[#0F382C]">U</span>
            </div>
            <h3 class="text-xs font-bold text-[#0F382C] font-serif">
                Arah Kiblat: 295° Barat Laut
            </h3>
            <p class="text-[11px] text-[#6B7280]">
                Fitur kompas interaktif aktif pada perangkat yang mendukung sensor orientasi.
            </p>
        </div>

    </div>

</x-layouts.app>
