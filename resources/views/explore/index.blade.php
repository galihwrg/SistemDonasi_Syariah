<x-layouts.app title="Jelajah Karya Dakwah — Kuantum Pelopor Indonesia">

    <div class="space-y-4">

        {{-- 1. Search Bar --}}
        <section class="px-4 pt-3">
            <div class="relative flex items-center">
                <div class="absolute left-3.5 flex items-center pointer-events-none text-[#717975]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input class="w-full bg-white border border-[#c1c8c3]/60 rounded-2xl py-3 pl-11 pr-12 text-[#1a1c1b] text-[13px] placeholder:text-[#717975]/70 focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#fed65b]/40 transition-all shadow-xs"
                       placeholder="Cari karya dakwah, surah, masjid, kaligrafi..."
                       type="text">
                <button aria-label="Filter"
                        class="absolute right-2.5 w-8 h-8 rounded-xl bg-[#f4f4f1] flex items-center justify-center text-[#0f382c] hover:bg-[#e8e8e5] active:scale-90 transition-all"
                        type="button">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                </button>
            </div>
        </section>

        {{-- 2. Horizontal Category Filter Strip --}}
        <section class="mb-2">
            <div class="flex items-center gap-2 overflow-x-auto px-4 py-1 no-scrollbar">
                {{-- Active Filter Chip --}}
                <button class="flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#0f382c] text-white text-[12px] font-semibold whitespace-nowrap shadow-xs shrink-0"
                        type="button">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                    Semua
                </button>

                {{-- Inactive Category Chips --}}
                <button class="px-3.5 py-2 rounded-full bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors"
                        type="button">
                    Masjid &amp; Arsitektur
                </button>
                <button class="px-3.5 py-2 rounded-full bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors"
                        type="button">
                    Alam &amp; Tadabbur
                </button>
                <button class="px-3.5 py-2 rounded-full bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors"
                        type="button">
                    Kegiatan Umat
                </button>
                <button class="px-3.5 py-2 rounded-full bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors"
                        type="button">
                    Kaligrafi
                </button>
                <button class="px-3.5 py-2 rounded-full bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors"
                        type="button">
                    Ramadhan
                </button>
            </div>
        </section>

        {{-- 3. Bagian "Jelajah Karya Dakwah" Grid --}}
        <section class="px-4 pb-8">
            {{-- Section Header --}}
            <div class="flex items-center justify-between mb-3.5">
                <div>
                    <h1 class="font-serif text-[17px] font-semibold text-[#0f382c] tracking-tight">Jelajah Karya Dakwah</h1>
                    <p class="text-[11px] text-[#414845]">Eksplorasi visual resolusi tinggi &amp; wakaf berkah nusantara</p>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] text-[#735c00] font-bold">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                    Kurasi Resmi
                </span>
            </div>

            {{-- 2-Column Responsive Card Grid (Exact Stitch Specifications) --}}
            <div class="grid grid-cols-2 gap-3">

                {{-- Card 1: Pelataran Masjid --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Kebersamaan Subuh & Ukhuwah di Pelataran Masjid"
                             src="https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda]">
                            Kegiatan Umat
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Kebersamaan Subuh &amp; Ukhuwah di Pelataran Masjid
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 1.450.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                890
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                F
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Fajar Ramadhan</span>
                        </div>
                    </div>
                </article>

                {{-- Card 2: Pilar Masjid Nabawi --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Simetri dan Keagungan Lengkung Pilar Masjid Nabawi"
                             src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#735c00]/85 backdrop-blur-md text-[9.5px] font-medium text-[#ffe088]">
                            Arsitektur
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Simetri dan Keagungan Lengkung Pilar Masjid Nabawi
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 2.120.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                1.4k
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                A
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Ali Syafi'i</span>
                        </div>
                    </div>
                </article>

                {{-- Card 3: Lembah Bromo Tadabbur --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Kabut Pagi & Tadabbur Ciptaan di Lembah Bromo"
                             src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda]">
                            Alam &amp; Tadabbur
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Kabut Pagi &amp; Tadabbur Ciptaan di Lembah Bromo
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 980.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                620
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                D
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Dimas Pratama</span>
                        </div>
                    </div>
                </article>

                {{-- Card 4: Kaligrafi Thuluth --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Lafaz Basmalah Kaligrafi Thuluth Tradisional"
                             src="https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#735c00]/85 backdrop-blur-md text-[9.5px] font-medium text-[#ffe088]">
                            Kaligrafi
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Lafaz Basmalah Kaligrafi Thuluth Tradisional
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 3.400.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                2.3k
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                U
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Ust. Azhar</span>
                        </div>
                    </div>
                </article>

                {{-- Card 5: Lentera Ramadhan --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Lentera Berkah & Manisnya Waktu Berbuka"
                             src="https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda]">
                            Ramadhan
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Lentera Berkah &amp; Manisnya Waktu Berbuka
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 1.150.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                745
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                S
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Siti Nurhaliza</span>
                        </div>
                    </div>
                </article>

                {{-- Card 6: Halaqah Pemuda Pelopor --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Semangat Pemuda Pelopor dalam Halaqah Ilmu"
                             src="https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=600&q=80">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda]">
                            Kegiatan Umat
                        </span>
                        <button aria-label="Simpan karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                type="button">
                            <span class="material-symbols-outlined text-[15px]">bookmark</span>
                        </button>
                    </div>
                    <div class="p-2.5 flex flex-col justify-between flex-1">
                        <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Semangat Pemuda Pelopor dalam Halaqah Ilmu
                        </h3>
                        <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                            <div class="flex flex-col">
                                <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                    Rp 850.000
                                </span>
                                <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                            </div>
                            <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                512
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                H
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Hasan Basri</span>
                        </div>
                    </div>
                </article>

            </div>

            {{-- 4. Tombol Muat Lebih Banyak --}}
            <div class="mt-6 mb-2 flex justify-center">
                <button type="button"
                        class="w-full py-3 px-4 rounded-2xl bg-[#f4f4f1] hover:bg-[#e8e8e5] border border-[#c1c8c3]/50 text-[#0f382c] text-[13px] font-semibold flex items-center justify-center gap-2 transition-all active:scale-98 shadow-2xs">
                    <span class="material-symbols-outlined text-[18px]">autorenew</span>
                    <span>Muat Lebih Banyak Karya</span>
                </button>
            </div>

            {{-- Mini Footer End Note --}}
            <div class="pt-4 pb-2 text-center">
                <p class="text-[11px] text-[#717975]">
                    © 2026 Kuantum Pelopor Indonesia. Menyemai Berkah Visual &amp; Infaq Dakwah.
                </p>
            </div>
        </section>

    </div>

</x-layouts.app>
