<x-layouts.app title="Beranda — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-5">

        {{-- Session Flash Message --}}
        @if (session('success'))
            <div class="p-3.5 rounded-2xl text-xs font-medium flex items-center justify-between"
                 style="background: #ECFDF5; color: #16A34A; border: 1px solid #86EFAC;">
                <span>{{ session('success') }}</span>
                <span class="text-sm">✓</span>
            </div>
        @endif

        {{-- Hero Section: Banner Donasi Infaq Dakwah Terkumpul --}}
        <div class="rounded-3xl p-5 text-white shadow-lg relative overflow-hidden"
             style="background: linear-gradient(135deg, #0F382C 0%, #1A5C44 70%, #2E7D5E 100%);">
            {{-- Decorative pattern overlay --}}
            <div class="absolute -right-8 -bottom-8 w-40 h-40 rounded-full opacity-10 bg-[#D4AF37] pointer-events-none"></div>
            <div class="absolute top-2 right-4 text-xs font-semibold px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-xs border border-white/15 text-[#FED65B]">
                Infaq Produktif
            </div>

            <p class="text-[11px] font-medium tracking-wide uppercase text-white/70">
                Penyaluran Donasi Dakwah Umat
            </p>

            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-2xl font-bold font-serif tracking-tight text-white">
                    Rp 128.450.000
                </span>
                <span class="text-xs text-white/70">
                    / Rp 150 Jt
                </span>
            </div>

            {{-- Progress Bar --}}
            <div class="mt-3 w-full bg-white/20 rounded-full h-2 overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500"
                     style="width: 85.6%; background: linear-gradient(90deg, #D4AF37 0%, #FED65B 100%);"></div>
            </div>

            {{-- Statistics Row --}}
            <div class="mt-3.5 grid grid-cols-3 gap-2 pt-3 border-t border-white/15 text-center text-white/90">
                <div>
                    <span class="block text-xs font-bold text-white">1.420</span>
                    <span class="text-[10px] text-white/70">Muhsinin</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-[#FED65B]">85.6%</span>
                    <span class="text-[10px] text-white/70">Tersalur</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-white">14 Hari</span>
                    <span class="text-[10px] text-white/70">Tersisa</span>
                </div>
            </div>

            {{-- CTA Buttons --}}
            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('jelajah') }}"
                   class="flex-1 py-2.5 px-3 rounded-xl text-center text-xs font-bold transition-transform active:scale-95 shadow-sm"
                   style="background: #D4AF37; color: #0F382C;">
                    Salurkan Donasi
                </a>
                <a href="{{ route('jelajah') }}"
                   class="py-2.5 px-3.5 rounded-xl text-center text-xs font-semibold text-white/90 border border-white/30 hover:bg-white/10 transition-colors">
                    Rincian
                </a>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text"
                   placeholder="Cari karya dakwah, masjid, atau kaligrafi..."
                   class="w-full pl-10 pr-4 py-3 rounded-2xl text-xs bg-white border border-[#E5E7EB] placeholder-gray-400 text-gray-800 outline-none focus:border-[#0F382C] focus:ring-2 focus:ring-[#0F382C]/10 transition-all shadow-2xs">
        </div>

        {{-- Category Ribbon / Filter Chips --}}
        <div>
            <div class="flex items-center justify-between mb-2.5">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[#0F382C]">
                    Kategori Visual
                </h2>
                <a href="{{ route('jelajah') }}" class="text-[11px] font-semibold text-[#D4AF37] hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none -mx-4 px-4 text-xs">
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs shadow-2xs transition-all bg-[#0F382C] text-white">
                    Semua
                </a>
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs transition-all bg-white text-[#6B7280] border border-[#E5E7EB] hover:border-[#0F382C]">
                    🕌 Arsitektur
                </a>
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs transition-all bg-white text-[#6B7280] border border-[#E5E7EB] hover:border-[#0F382C]">
                    🌿 Alam &amp; Tadabbur
                </a>
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs transition-all bg-white text-[#6B7280] border border-[#E5E7EB] hover:border-[#0F382C]">
                    ✍️ Kaligrafi
                </a>
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs transition-all bg-white text-[#6B7280] border border-[#E5E7EB] hover:border-[#0F382C]">
                    👥 Kegiatan Umat
                </a>
                <a href="{{ route('jelajah') }}"
                   class="px-3.5 py-2 rounded-full whitespace-nowrap font-medium text-xs transition-all bg-white text-[#6B7280] border border-[#E5E7EB] hover:border-[#0F382C]">
                    🌙 Ramadhan
                </a>
            </div>
        </div>

        {{-- Visual Curations: 2 Column Grid Preview --}}
        <div>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-bold font-serif text-[#0F382C]">
                    Karya Pilihan Terkini
                </h2>
                <span class="text-[11px] text-[#6B7280]">
                    Lisensi Bebas Wakaf
                </span>
            </div>

            {{-- 2-Column Grid Demo Cards --}}
            <div class="grid grid-cols-2 gap-3">

                {{-- Sample Card 1 --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-2xs border border-[#E5E7EB] group transition-all hover:shadow-md flex flex-col">
                    <div class="relative aspect-4/5 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542816417-0983c9c9ad53?auto=format&fit=crop&w=600&q=80"
                             alt="Arsitektur Masjid"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#0F382C]/80 backdrop-blur-xs text-white">
                            Arsitektur
                        </span>
                        <button type="button" aria-label="Simpan Karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-xs text-[#0F382C] flex items-center justify-center hover:bg-white shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-2.5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#0F382C] line-clamp-1 font-serif">
                                Kemegahan Kubah Nabawi
                            </h3>
                            <p class="text-[10px] text-[#6B7280] line-clamp-1 mt-0.5">
                                Galih Wiragama
                            </p>
                        </div>
                        <div class="mt-2 pt-2 border-t border-[#F0F0EA] flex items-center justify-between text-[10px]">
                            <span class="text-[#D4AF37] font-semibold">4K Ultra HD</span>
                            <span class="text-[#6B7280]">Gratis</span>
                        </div>
                    </div>
                </div>

                {{-- Sample Card 2 --}}
                <div class="bg-white rounded-2xl overflow-hidden shadow-2xs border border-[#E5E7EB] group transition-all hover:shadow-md flex flex-col">
                    <div class="relative aspect-4/5 bg-gray-100 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=600&q=80"
                             alt="Tadabbur Alam"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#0F382C]/80 backdrop-blur-xs text-white">
                            Tadabbur
                        </span>
                        <button type="button" aria-label="Simpan Karya"
                                class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-xs text-[#0F382C] flex items-center justify-center hover:bg-white shadow-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-2.5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs font-bold text-[#0F382C] line-clamp-1 font-serif">
                                Fajar di Atas Bukit
                            </h3>
                            <p class="text-[10px] text-[#6B7280] line-clamp-1 mt-0.5">
                                Fajar Shadiq
                            </p>
                        </div>
                        <div class="mt-2 pt-2 border-t border-[#F0F0EA] flex items-center justify-between text-[10px]">
                            <span class="text-[#D4AF37] font-semibold">4K Ultra HD</span>
                            <span class="text-[#6B7280]">Gratis</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Load More CTA --}}
            <div class="mt-4 text-center">
                <a href="{{ route('jelajah') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-[#0F382C] bg-white border border-[#E5E7EB] hover:bg-[#F0F0EA] transition-colors shadow-2xs">
                    <span>Muat Lebih Banyak Karya</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
            </div>
        </div>

    </div>

</x-layouts.app>
