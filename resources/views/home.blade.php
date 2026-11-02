<x-layouts.app title="Kuantum Pelopor Indonesia — Galeri Visual Islami">

    <div class="space-y-4">

        {{-- Session Flash Message --}}
        @if (session('success'))
            <div class="mx-4 mt-3 p-3.5 rounded-2xl text-xs font-medium flex items-center justify-between"
                 style="background: #ECFDF5; color: #16A34A; border: 1px solid #86EFAC;">
                <span>{{ session('success') }}</span>
                <span class="text-sm">✓</span>
            </div>
        @endif

        {{-- 3. Hero Card Donasi & Syiar Dakwah --}}
        <section class="p-4">
            <div class="relative rounded-3xl overflow-hidden bg-[#0f382c] text-white p-6 shadow-md border border-[#00392b]">
                {{-- Subtle Decorative Background Pattern Scrim --}}
                <div class="absolute -right-8 -bottom-8 w-44 h-44 rounded-full bg-[#3f6658]/30 blur-2xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-36 h-36 rounded-full bg-[#fed65b]/10 blur-xl pointer-events-none"></div>

                {{-- Waqf Badge --}}
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md border border-white/20 mb-3.5">
                    <span class="material-symbols-outlined text-[14px] text-[#ffe088]">volunteer_activism</span>
                    <span class="text-[10px] tracking-normal text-[#c1ecda] font-medium">Wadah Wakaf &amp; Donasi Islami</span>
                </div>

                {{-- Main Hero Title & Tagline --}}
                <h2 class="font-serif text-[22px] font-bold text-white leading-tight mb-2 tracking-tight">
                    Kuantum Pelopor Indonesia
                </h2>
                <p class="text-[13px] text-[#99d2bd] leading-relaxed mb-5">
                    Alirkan pahala jariyah melalui donasi dakwah visual. Bersama hadirkan karya fotografi dan konten Islami bermakna untuk umat.
                </p>

                {{-- Action CTA Cluster --}}
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-3.5 flex flex-col gap-2.5">
                    <div class="flex items-center gap-1.5 text-[#ffe088]">
                        <span class="material-symbols-outlined text-[17px]">account_balance_wallet</span>
                        <span class="text-[10.5px] font-medium tracking-normal text-[#c1ecda]">Total Donasi Terkumpul</span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <span class="font-serif text-[22px] font-bold text-white tracking-tight">Rp 28.450.000</span>
                        <span class="text-[11px] text-[#99d2bd]">640 Muhsinin Terlibat</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-[10.5px] text-[#99d2bd] pt-0.5">
                        <span class="material-symbols-outlined text-[14px] text-[#ffe088]">verified</span>
                        <span class="text-[10.5px] font-medium tracking-normal text-[#c1ecda]">Transparansi Penyaluran Syariah</span>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <button type="button"
                                onclick="const m=document.getElementById('profile-dialog'); if(m){ m.classList.remove('hidden'); m.classList.add('flex'); }"
                                class="flex-1 py-2 px-3 rounded-xl bg-[#fed65b] hover:bg-[#ffe088] text-[#0f382c] text-[12px] font-bold flex items-center justify-center gap-1.5 shadow-sm active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[16px]">volunteer_activism</span>
                            <span>Salurkan Donasi</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Thumb-Friendly Search Bar --}}
        <section class="px-4 mb-3">
            <div class="relative flex items-center">
                <div class="absolute left-3.5 flex items-center pointer-events-none text-[#717975]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input class="w-full bg-white border border-[#c1c8c3]/60 rounded-2xl py-3 pl-11 pr-12 text-[#1a1c1b] text-[13px] placeholder:text-[#717975]/70 focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#fed65b]/40 transition-all shadow-xs"
                       placeholder="Cari karya dakwah, program sedekah, masjid, atau kaligrafi..."
                       type="text">
                <button aria-label="Filter"
                        class="absolute right-2.5 w-8 h-8 rounded-xl bg-[#f4f4f1] flex items-center justify-center text-[#0f382c] hover:bg-[#e8e8e5] active:scale-90 transition-all"
                        type="button">
                    <span class="material-symbols-outlined text-[18px]">tune</span>
                </button>
            </div>
        </section>

        {{-- 5. Horizontal Category Filter Strip --}}
        <section class="mb-4">
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

        {{-- 6. Bagian "Koleksi Visual Pilihan" --}}
        <section class="px-4">
            {{-- Section Header --}}
            <div class="flex items-center justify-between mb-3.5">
                <div>
                    <h3 class="font-serif text-[17px] font-semibold text-[#0f382c] tracking-tight">Koleksi Visual Pilihan</h3>
                    <p class="text-[11px] text-[#414845]">Kurasi fotografi &amp; karya dakwah berkualitas tinggi</p>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] text-[#735c00] font-bold">
                    <span class="material-symbols-outlined text-[14px]">verified</span>
                    Kurasi Resmi
                </span>
            </div>

            {{-- 2-Column Responsive Card Grid --}}
            <div class="grid grid-cols-2 gap-3">

                {{-- Card 1: Pelataran Masjid --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Pelataran Masjid"
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
                        <h4 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Kebersamaan Subuh &amp; Ukhuwah di Pelataran Masjid
                        </h4>
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
                             alt="Pilar Masjid Nabawi"
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
                        <h4 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Simetri dan Keagungan Lengkung Pilar Masjid Nabawi
                        </h4>
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
                             alt="Tadabbur Alam"
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
                        <h4 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Keheningan Kabut Fajar di Lembah Bromo
                        </h4>
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
                                720
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                            <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                R
                            </div>
                            <span class="text-[10px] text-[#414845] truncate">Rahmat Hidayat</span>
                        </div>
                    </div>
                </article>

                {{-- Card 4: Semangat Pemuda Pelopor --}}
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                    <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             alt="Halaqah Pemuda"
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
                        <h4 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5">
                            Semangat Pemuda Pelopor dalam Halaqah Ilmu
                        </h4>
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

            {{-- 7. Tombol "Muat Lebih Banyak Karya" --}}
            <div class="mt-6 mb-2 flex justify-center">
                <a href="{{ route('jelajah') }}"
                   class="w-full py-3 px-4 rounded-2xl bg-[#f4f4f1] hover:bg-[#e8e8e5] border border-[#c1c8c3]/50 text-[#0f382c] text-[13px] font-semibold flex items-center justify-center gap-2 transition-all active:scale-98 shadow-2xs">
                    <span class="material-symbols-outlined text-[18px]">autorenew</span>
                    <span>Muat Lebih Banyak Karya</span>
                </a>
            </div>

            {{-- Mini Footer End Note --}}
            <div class="pt-4 pb-2 text-center">
                <p class="text-[11px] text-[#717975]">
                    © 2026 Kuantum Pelopor Indonesia. Menyemai Berkah Visual &amp; Infaq Dakwah.
                </p>
            </div>
        </section>

    </div>

    {{-- Dialog Modal Profil Pengurus & Rekening BSI (Dari Stitch Design) --}}
    <div id="profile-dialog"
         class="hidden fixed inset-0 z-50 bg-[#121614]/70 backdrop-blur-sm items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="w-full max-w-[402px] bg-white rounded-t-3xl sm:rounded-3xl p-5 shadow-2xl border border-[#c1c8c3]/30 flex flex-col gap-4 animate-in fade-in slide-in-from-bottom duration-200">
            <div class="flex items-center justify-between pb-2 border-b border-[#c1c8c3]/20">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#0f382c] text-[20px]">verified_user</span>
                    <h3 class="font-serif text-[16px] font-semibold text-[#0f382c]">Profil Pengurus &amp; Rekening</h3>
                </div>
                <button type="button"
                        onclick="const m=document.getElementById('profile-dialog'); if(m){ m.classList.add('hidden'); m.classList.remove('flex'); }"
                        class="w-8 h-8 rounded-full bg-[#f4f4f1] hover:bg-[#e8e8e5] text-[#414845] flex items-center justify-center transition-colors active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <div class="flex items-center gap-3.5 bg-[#f4f4f1] p-3 rounded-2xl border border-[#c1c8c3]/30">
                <div class="w-12 h-12 rounded-full bg-[#0f382c] text-white flex items-center justify-center font-bold text-lg border-2 border-[#0f382c] shadow-xs">
                    KP
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1">
                        <h4 class="font-serif text-[14px] font-bold text-[#0f382c] truncate">Kuantum Pelopor Indonesia</h4>
                        <span class="material-symbols-outlined text-[15px] text-[#735c00]">verified</span>
                    </div>
                    <p class="text-[10.5px] text-[#735c00] font-semibold">Pelopor Dakwah Visual</p>
                    <p class="text-[11px] text-[#414845] flex items-center gap-1 mt-0.5 truncate">
                        <span class="material-symbols-outlined text-[13px] text-[#717975]">location_on</span>
                        Ciomas, Kab. Bogor, Jawa Barat
                    </p>
                </div>
            </div>

            <div class="bg-[#0f382c] text-white rounded-2xl p-3.5 flex flex-col gap-2 border border-[#00392b] shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-[10.5px] text-[#ffe088] font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">account_balance</span>
                        Bank Syariah Indonesia (BSI)
                    </span>
                    <span class="text-[10px] text-[#c1ecda] bg-white/15 px-2 py-0.5 rounded-full font-medium">Wakaf &amp; Donasi</span>
                </div>
                <div class="flex items-center justify-between bg-white/10 p-2.5 rounded-xl border border-white/20">
                    <div class="flex flex-col">
                        <span class="font-serif text-[16px] font-bold tracking-wider text-white select-all" id="bsi-rekening">7182-9384-1029</span>
                        <span class="text-[10.5px] text-[#99d2bd]">a.n. Yayasan Kuantum Pelopor</span>
                    </div>
                    <button type="button"
                            onclick="navigator.clipboard ? navigator.clipboard.writeText('718293841029') : null; const t=document.getElementById('copy-feedback'); if(t){ t.innerText='Tersalin!'; setTimeout(()=>t.innerText='Salin', 2000); }"
                            class="px-3 py-1.5 rounded-lg bg-[#fed65b] hover:bg-[#ffe088] text-[#0f382c] text-[11px] font-bold flex items-center gap-1 active:scale-95 transition-all shadow-xs">
                        <span class="material-symbols-outlined text-[14px]">content_copy</span>
                        <span id="copy-feedback">Salin</span>
                    </button>
                </div>
            </div>

            <div class="flex items-center gap-2 pt-1">
                <button type="button"
                        onclick="const m=document.getElementById('profile-dialog'); if(m){ m.classList.add('hidden'); m.classList.remove('flex'); }"
                        class="w-full py-2.5 rounded-xl bg-[#f4f4f1] hover:bg-[#e8e8e5] text-[#0f382c] text-[13px] font-semibold border border-[#c1c8c3]/40 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</x-layouts.app>
