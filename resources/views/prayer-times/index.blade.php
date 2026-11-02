<x-layouts.app title="Waktu Salat &amp; Arah Kiblat — Kuantum Pelopor Indonesia">

    <div class="px-4 py-3 space-y-3.5">

        {{-- Sub-info Lokasi & Tanggal Hijriyah --}}
        <div class="bg-white rounded-2xl px-4 py-2.5 border border-[#e5e5e0] shadow-2xs flex items-center justify-between text-[11px] text-[#535955]">
            <span class="flex items-center gap-1.5 font-medium">
                <span class="material-symbols-outlined text-[#c59b27] text-[15px]">location_on</span>
                Jakarta, DKI Jakarta
            </span>
            <span class="font-medium text-[#735c00] bg-[#c59b27]/10 px-2.5 py-0.5 rounded-full">
                24 Ramadan 1447 H
            </span>
        </div>

        {{-- 1. Card Ringkas: Waktu Salat Berikutnya --}}
        <section class="rounded-2xl bg-white p-4 border border-[#e5e5e0] shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#c59b27] animate-pulse"></span>
                    <span class="text-[11px] font-semibold tracking-wider uppercase text-[#535955]">
                        Waktu Salat Berikutnya
                    </span>
                </div>
                <span class="text-[11px] font-medium text-[#735c00]">Zona WIB</span>
            </div>

            <div class="mt-2.5 flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-[22px] font-bold text-[#0f382c] leading-tight">
                        Ashar <span class="font-normal text-[16px] text-[#535955]">— 15:18 WIB</span>
                    </h2>
                    <p class="text-[12px] text-[#735c00] font-medium mt-0.5 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                        34 menit lagi menuju Ashar
                    </p>
                </div>
                <button type="button"
                        class="w-9 h-9 rounded-full bg-[#f4f4f1] border border-[#e5e5e0] flex items-center justify-center text-[#0f382c] shrink-0 hover:bg-[#e2e3e0] transition-colors"
                        title="Pengingat Salat">
                    <span class="material-symbols-outlined text-[18px]">notifications_active</span>
                </button>
            </div>
        </section>

        {{-- 2. Kompas / Indikator Arah Kiblat Sederhana --}}
        <section class="bg-white rounded-2xl p-4 border border-[#e5e5e0] shadow-sm">
            <div class="flex items-center justify-between pb-2 border-b border-[#e5e5e0]">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#c59b27]">Panduan Ibadah</span>
                    <h3 class="font-serif text-[15px] font-bold text-[#0f382c] mt-0.5">Arah Kiblat</h3>
                </div>
                <div class="text-right">
                    <span class="inline-block px-2.5 py-0.5 rounded-lg bg-[#f4f4f1] border border-[#e5e5e0] text-[#0f382c] font-serif font-bold text-[14px]">
                        295°
                    </span>
                    <div class="text-[11px] font-semibold text-[#735c00] mt-0.5">Barat Laut (NW)</div>
                </div>
            </div>

            <div class="mt-3 flex items-center justify-center gap-4 py-1">
                {{-- Visual Kompas --}}
                <div class="relative w-24 h-24 rounded-full border border-[#e5e5e0] bg-[#f9f9f6] flex items-center justify-center shrink-0 shadow-inner">
                    <span class="absolute top-1 text-[9px] font-bold text-[#ba1a1a]">U</span>
                    <span class="absolute bottom-1 text-[9px] font-medium text-[#717975]">S</span>
                    <span class="absolute right-1.5 text-[9px] font-medium text-[#717975]">T</span>
                    <span class="absolute left-1.5 text-[9px] font-medium text-[#717975]">B</span>

                    <div class="w-16 h-16 rounded-full border border-dashed border-[#e5e5e0] bg-white flex items-center justify-center relative">
                        {{-- Ka'bah Symbol --}}
                        <div class="absolute top-1 left-2 w-3.5 h-3.5 bg-[#0f382c] rounded-[3px] border border-[#c59b27] flex items-center justify-center shadow-2xs"
                             title="Arah Ka'bah">
                            <span class="w-1.5 h-0.5 bg-[#c59b27] block"></span>
                        </div>

                        {{-- Needle Pointer pointing to Ka'bah (-65deg NW) --}}
                        <div class="w-10 h-10 flex items-center justify-center -rotate-[65deg]">
                            <div class="w-0.5 h-7 bg-gradient-to-t from-neutral-300 via-[#c59b27] to-[#c59b27] rounded-full relative flex justify-center">
                                <div class="w-2 h-2 rounded-full bg-[#c59b27] absolute top-0 -mt-0.5 shadow-xs"></div>
                            </div>
                        </div>

                        {{-- Compass Center Pin --}}
                        <div class="w-2.5 h-2.5 rounded-full bg-[#0f382c] border border-white absolute shadow-xs"></div>
                    </div>
                </div>

                {{-- Panduan Arah --}}
                <div class="flex-1 pl-2">
                    <div class="text-[13px] font-bold text-[#0f382c]">Menghadap Kiblat</div>
                    <p class="text-[11px] text-[#535955] mt-0.5 leading-snug">
                        Putar perangkat hingga jarum emas sejajar dengan simbol Ka'bah.
                    </p>
                    <div class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold text-[#735c00]">
                        <span class="material-symbols-outlined text-[13px] text-[#c59b27]">explore</span>
                        295° NW dari Jakarta
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Jadwal 5 Waktu Salat Polos (List Bersih Sesuai Stitch) --}}
        <section class="bg-white rounded-2xl p-4 border border-[#e5e5e0] shadow-sm">
            <div class="flex items-center justify-between pb-2 border-b border-[#e5e5e0]">
                <div>
                    <h3 class="font-serif text-[15px] font-bold text-[#0f382c]">Jadwal 5 Waktu Salat</h3>
                    <p class="text-[11px] text-[#535955]">Jadwal resmi hisab Kemenag RI</p>
                </div>
                <span class="material-symbols-outlined text-[#717975] text-[18px]">calendar_today</span>
            </div>

            <div class="divide-y divide-[#f0f0ed] mt-1 text-[#1c1b1f]">
                {{-- Subuh --}}
                <div class="flex items-center justify-between py-2.5 px-1">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#535955] text-[18px]">wb_twilight</span>
                        <span class="text-[13px] font-medium text-[#1c1b1f]">Subuh</span>
                    </div>
                    <span class="font-serif text-[14px] font-semibold text-[#0f382c]">04:42 WIB</span>
                </div>

                {{-- Dzuhur --}}
                <div class="flex items-center justify-between py-2.5 px-1">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#535955] text-[18px]">light_mode</span>
                        <span class="text-[13px] font-medium text-[#1c1b1f]">Dzuhur</span>
                    </div>
                    <span class="font-serif text-[14px] font-semibold text-[#0f382c]">12:05 WIB</span>
                </div>

                {{-- Ashar (Aktif / Sedang Berlangsung) --}}
                <div class="flex items-center justify-between py-2.5 px-2.5 -mx-1 rounded-xl bg-[#f4f4f1] border-l-4 border-[#c59b27] border-y border-r border-[#e5e5e0]">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#c59b27] text-[18px]">sunny</span>
                        <div class="flex items-center gap-1.5">
                            <span class="text-[13px] font-bold text-[#0f382c]">Ashar</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] bg-[#c59b27]/15 text-[#735c00] font-bold">
                                Aktif
                            </span>
                        </div>
                    </div>
                    <span class="font-serif text-[14px] font-bold text-[#0f382c]">15:18 WIB</span>
                </div>

                {{-- Maghrib --}}
                <div class="flex items-center justify-between py-2.5 px-1">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#535955] text-[18px]">nights_stay</span>
                        <span class="text-[13px] font-medium text-[#1c1b1f]">Maghrib</span>
                    </div>
                    <span class="font-serif text-[14px] font-semibold text-[#0f382c]">18:09 WIB</span>
                </div>

                {{-- Isya --}}
                <div class="flex items-center justify-between py-2.5 px-1">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-[#535955] text-[18px]">dark_mode</span>
                        <span class="text-[13px] font-medium text-[#1c1b1f]">Isya</span>
                    </div>
                    <span class="font-serif text-[14px] font-semibold text-[#0f382c]">19:18 WIB</span>
                </div>
            </div>
        </section>

    </div>

</x-layouts.app>
