<x-layouts.app title="Koleksi Saya — Kuantum Pelopor Indonesia">

    <div class="px-5 py-4 space-y-4">

        {{-- Header Section --}}
        <div>
            <h1 class="font-serif text-[18px] font-bold text-[#0f382c] tracking-tight">
                Koleksi Saya
            </h1>
            <p class="text-[11px] text-[#414845] mt-0.5">
                Karya visual dakwah yang Anda simpan &amp; apresiasi
            </p>
        </div>

        {{-- Filter Chips Horizontal --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar -mx-5 px-5">
            <button type="button"
                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#0f382c] text-white text-[12px] font-semibold whitespace-nowrap shadow-xs shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                Semua (12)
            </button>
            <button type="button"
                    class="px-3.5 py-1.5 rounded-full bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors">
                Foto Favorit (8)
            </button>
            <button type="button"
                    class="px-3.5 py-1.5 rounded-full bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] text-[12px] font-medium whitespace-nowrap shrink-0 transition-colors">
                Kaligrafi (4)
            </button>
        </div>

        {{-- 2-Column Responsive Saved Cards Grid --}}
        <div class="grid grid-cols-2 gap-3 pt-1">

            {{-- Card 1: Kubah Fajar Nabawi --}}
            <article class="bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs group flex flex-col hover:shadow-md transition-all">
                <div class="relative overflow-hidden aspect-4/5 bg-gray-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="Kubah Fajar Nabawi"
                         src="https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=600&q=80">
                    <button aria-label="Tersimpan"
                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[#fed65b] flex items-center justify-center shadow-xs">
                        <span class="material-symbols-outlined text-[15px] fill">bookmark</span>
                    </button>
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 text-[9px] font-medium text-white">
                        Arsitektur
                    </span>
                </div>
                <div class="p-2.5 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-serif text-[12px] font-semibold text-[#0f382c] truncate">
                            Kubah Fajar Nabawi
                        </h4>
                        <p class="text-[10px] text-[#717975] truncate mt-0.5">
                            Fajar Ramadhan
                        </p>
                    </div>
                </div>
            </article>

            {{-- Card 2: Kaligrafi Al-Ikhlas --}}
            <article class="bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs group flex flex-col hover:shadow-md transition-all">
                <div class="relative overflow-hidden aspect-4/5 bg-gray-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="Kaligrafi Al-Ikhlas"
                         src="https://images.unsplash.com/photo-1579783902614-a3fb3927b675?auto=format&fit=crop&w=600&q=80">
                    <button aria-label="Tersimpan"
                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[#fed65b] flex items-center justify-center shadow-xs">
                        <span class="material-symbols-outlined text-[15px] fill">bookmark</span>
                    </button>
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#735c00]/85 text-[9px] font-medium text-[#ffe088]">
                        Kaligrafi
                    </span>
                </div>
                <div class="p-2.5 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-serif text-[12px] font-semibold text-[#0f382c] truncate">
                            Kaligrafi Al-Ikhlas
                        </h4>
                        <p class="text-[10px] text-[#717975] truncate mt-0.5">
                            Master Khaththath
                        </p>
                    </div>
                </div>
            </article>

            {{-- Card 3: Halaqah Qur'an --}}
            <article class="bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs group flex flex-col hover:shadow-md transition-all">
                <div class="relative overflow-hidden aspect-4/5 bg-gray-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="Halaqah Qur'an"
                         src="https://images.unsplash.com/photo-1519817650390-64a93db51149?auto=format&fit=crop&w=600&q=80">
                    <button aria-label="Tersimpan"
                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[#fed65b] flex items-center justify-center shadow-xs">
                        <span class="material-symbols-outlined text-[15px] fill">bookmark</span>
                    </button>
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 text-[9px] font-medium text-white">
                        Kegiatan Umat
                    </span>
                </div>
                <div class="p-2.5 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-serif text-[12px] font-semibold text-[#0f382c] truncate">
                            Halaqah Qur'an
                        </h4>
                        <p class="text-[10px] text-[#717975] truncate mt-0.5">
                            Zahra Art Gallery
                        </p>
                    </div>
                </div>
            </article>

            {{-- Card 4: Senja di Menara Nabawi --}}
            <article class="bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs group flex flex-col hover:shadow-md transition-all">
                <div class="relative overflow-hidden aspect-4/5 bg-gray-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="Senja di Menara"
                         src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=600&q=80">
                    <button aria-label="Tersimpan"
                            class="absolute top-2 right-2 w-7 h-7 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[#fed65b] flex items-center justify-center shadow-xs">
                        <span class="material-symbols-outlined text-[15px] fill">bookmark</span>
                    </button>
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 text-[9px] font-medium text-white">
                        Arsitektur
                    </span>
                </div>
                <div class="p-2.5 flex-1 flex flex-col justify-between">
                    <div>
                        <h4 class="font-serif text-[12px] font-semibold text-[#0f382c] truncate">
                            Senja di Menara
                        </h4>
                        <p class="text-[10px] text-[#717975] truncate mt-0.5">
                            Irfan Harun
                        </p>
                    </div>
                </div>
            </article>

        </div>

        {{-- Footer Note --}}
        <div class="pt-4 pb-2 text-center">
            <p class="text-[11px] text-[#717975]">
                Semua tersimpan rapi dalam koleksi dakwah Anda
            </p>
        </div>

    </div>

</x-layouts.app>
