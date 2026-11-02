<x-layouts.app title="Jelajah Galeri Visual — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Top Section Heading (Consistent with Stitch Editorial style) --}}
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#f4f4f1] border border-[#dadad7] text-[10px] font-medium text-[#735c00] mb-1">
                <span class="material-symbols-outlined text-[13px] text-[#735c00]" style="font-variation-settings: 'FILL' 1;">stars</span>
                <span>Kurasi Visual Dakwah Syariah</span>
            </div>
            <h1 class="text-xl font-bold font-serif text-[#0f382c]">
                Jelajah Karya Dakwah
            </h1>
            <p class="text-[11px] text-[#414845] mt-0.5">
                Koleksi fotografi resolusi tinggi berlisensi wakaf berkah
            </p>
        </div>

        {{-- Search Input (Matching Home Stitch pattern) --}}
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-[#717975] pointer-events-none">
                search
            </span>
            <input type="text"
                   placeholder="Cari masjid, arsitektur, kaligrafi, alam..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl text-[12px] bg-white border border-[#dadad7] placeholder-[#717975]/70 text-[#1a1c1b] outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#0f382c] transition-all shadow-xs">
        </div>

        {{-- Category Chips (Scrollable, Stitch Colors) --}}
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 no-scrollbar -mx-4 px-4 text-xs select-none">
            <button class="px-3.5 py-1.5 rounded-full text-[11px] font-semibold bg-[#0f382c] text-white shrink-0 shadow-xs">
                Semua
            </button>
            <button class="px-3.5 py-1.5 rounded-full text-[11px] font-medium bg-white text-[#414845] border border-[#dadad7] shrink-0 hover:bg-[#f4f4f1]">
                Arsitektur Masjid
            </button>
            <button class="px-3.5 py-1.5 rounded-full text-[11px] font-medium bg-white text-[#414845] border border-[#dadad7] shrink-0 hover:bg-[#f4f4f1]">
                Kaligrafi &amp; Mushaf
            </button>
            <button class="px-3.5 py-1.5 rounded-full text-[11px] font-medium bg-white text-[#414845] border border-[#dadad7] shrink-0 hover:bg-[#f4f4f1]">
                Alam &amp; Ayat Kauniyah
            </button>
            <button class="px-3.5 py-1.5 rounded-full text-[11px] font-medium bg-white text-[#414845] border border-[#dadad7] shrink-0 hover:bg-[#f4f4f1]">
                Sosial &amp; Umat
            </button>
        </div>

        {{-- Visual Grid Cards (Aligned with Home Stitch visual cards) --}}
        <div class="grid grid-cols-2 gap-3 pt-1">
            {{-- Card 1 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-[#dadad7] shadow-xs flex flex-col group cursor-pointer hover:shadow-md transition-shadow">
                <div class="relative aspect-4/5 bg-[#eeeeeb] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=400&q=80"
                         alt="Masjid Nabawi Madinah"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-semibold bg-[#0f382c]/85 text-white backdrop-blur-xs">
                        Arsitektur
                    </span>
                    <button class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 hover:bg-white text-[#0f382c] flex items-center justify-center transition-colors shadow-xs" title="Simpan ke Koleksi">
                        <span class="material-symbols-outlined text-[15px]">bookmark</span>
                    </button>
                </div>
                <div class="p-2.5 space-y-1">
                    <h3 class="text-[12px] font-semibold text-[#0f382c] line-clamp-1 font-serif leading-snug">
                        Kubah Hijau &amp; Pilar Nabawi
                    </h3>
                    <p class="text-[10px] text-[#717975] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">person</span>
                        Ahmad Al-Ghifari
                    </p>
                    <div class="flex items-center justify-between pt-1 border-t border-[#f4f4f1]">
                        <span class="text-[9px] font-medium text-[#735c00] bg-[#ffe088]/40 px-1.5 py-0.5 rounded">
                            Wakaf Terbuka
                        </span>
                        <span class="text-[10px] text-[#414845] font-semibold">
                            Rp 50rb
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-[#dadad7] shadow-xs flex flex-col group cursor-pointer hover:shadow-md transition-shadow">
                <div class="relative aspect-4/5 bg-[#eeeeeb] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=400&q=80"
                         alt="Mushaf Kuno Al-Qur'an"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-semibold bg-[#0f382c]/85 text-white backdrop-blur-xs">
                        Kaligrafi
                    </span>
                    <button class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 hover:bg-white text-[#0f382c] flex items-center justify-center transition-colors shadow-xs" title="Simpan ke Koleksi">
                        <span class="material-symbols-outlined text-[15px]">bookmark</span>
                    </button>
                </div>
                <div class="p-2.5 space-y-1">
                    <h3 class="text-[12px] font-semibold text-[#0f382c] line-clamp-1 font-serif leading-snug">
                        Mushaf Tilawah Nusantara
                    </h3>
                    <p class="text-[10px] text-[#717975] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">person</span>
                        Fathurrahman
                    </p>
                    <div class="flex items-center justify-between pt-1 border-t border-[#f4f4f1]">
                        <span class="text-[9px] font-medium text-[#735c00] bg-[#ffe088]/40 px-1.5 py-0.5 rounded">
                            Wakaf Terbuka
                        </span>
                        <span class="text-[10px] text-[#414845] font-semibold">
                            Rp 100rb
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-[#dadad7] shadow-xs flex flex-col group cursor-pointer hover:shadow-md transition-shadow">
                <div class="relative aspect-4/5 bg-[#eeeeeb] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&w=400&q=80"
                         alt="Cahaya Alam Subuh"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-semibold bg-[#0f382c]/85 text-white backdrop-blur-xs">
                        Alam
                    </span>
                    <button class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 hover:bg-white text-[#0f382c] flex items-center justify-center transition-colors shadow-xs" title="Simpan ke Koleksi">
                        <span class="material-symbols-outlined text-[15px]">bookmark</span>
                    </button>
                </div>
                <div class="p-2.5 space-y-1">
                    <h3 class="text-[12px] font-semibold text-[#0f382c] line-clamp-1 font-serif leading-snug">
                        Tadabbur Fajar Gunung Salak
                    </h3>
                    <p class="text-[10px] text-[#717975] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">person</span>
                        Irfan Hakim
                    </p>
                    <div class="flex items-center justify-between pt-1 border-t border-[#f4f4f1]">
                        <span class="text-[9px] font-medium text-[#735c00] bg-[#ffe088]/40 px-1.5 py-0.5 rounded">
                            Wakaf Terbuka
                        </span>
                        <span class="text-[10px] text-[#414845] font-semibold">
                            Rp 75rb
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 4 --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-[#dadad7] shadow-xs flex flex-col group cursor-pointer hover:shadow-md transition-shadow">
                <div class="relative aspect-4/5 bg-[#eeeeeb] overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?auto=format&fit=crop&w=400&q=80"
                         alt="Kajian Umat Masjid"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-semibold bg-[#0f382c]/85 text-white backdrop-blur-xs">
                        Umat
                    </span>
                    <button class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 hover:bg-white text-[#0f382c] flex items-center justify-center transition-colors shadow-xs" title="Simpan ke Koleksi">
                        <span class="material-symbols-outlined text-[15px]">bookmark</span>
                    </button>
                </div>
                <div class="p-2.5 space-y-1">
                    <h3 class="text-[12px] font-semibold text-[#0f382c] line-clamp-1 font-serif leading-snug">
                        Halaqah Al-Qur'an Santri
                    </h3>
                    <p class="text-[10px] text-[#717975] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">person</span>
                        Zulkifli
                    </p>
                    <div class="flex items-center justify-between pt-1 border-t border-[#f4f4f1]">
                        <span class="text-[9px] font-medium text-[#735c00] bg-[#ffe088]/40 px-1.5 py-0.5 rounded">
                            Wakaf Terbuka
                        </span>
                        <span class="text-[10px] text-[#414845] font-semibold">
                            Rp 25rb
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-layouts.app>
