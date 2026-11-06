<x-layouts.app title="Jelajah Karya Dakwah — Kuantum Pelopor Indonesia">

    <div class="space-y-4">

        {{-- 1. Search Bar --}}
        <section class="px-4 pt-3">
            <form action="{{ route('jelajah') }}" method="GET" class="relative flex items-center">
                @if ($selectedCategory)
                    <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                @endif
                <div class="absolute left-3.5 flex items-center pointer-events-none text-[#717975]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input class="w-full bg-white border border-[#c1c8c3]/60 rounded-2xl py-3 pl-11 pr-12 text-[#1a1c1b] text-[13px] placeholder:text-[#717975]/70 focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#fed65b]/40 transition-all shadow-xs"
                       placeholder="Cari karya dakwah, surah, masjid, kaligrafi..."
                       name="q"
                       value="{{ $searchQuery ?? '' }}"
                       type="text">
                <button aria-label="Cari"
                        type="submit"
                        class="absolute right-2.5 w-8 h-8 rounded-xl bg-[#f4f4f1] flex items-center justify-center text-[#0f382c] hover:bg-[#e8e8e5] active:scale-90 transition-all">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                </button>
            </form>
        </section>

        {{-- 2. Horizontal Category Filter Strip --}}
        <section class="mb-2">
            <div class="flex items-center gap-2 overflow-x-auto px-4 py-1 no-scrollbar">
                {{-- Active / Inactive Semua --}}
                <a href="{{ route('jelajah', array_filter(['q' => $searchQuery])) }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-full text-[12px] whitespace-nowrap shadow-xs shrink-0 {{ !$selectedCategory ? 'bg-[#0f382c] text-white font-semibold' : 'bg-white border border-[#c1c8c3]/50 text-[#414845] font-medium' }}">
                    @if (!$selectedCategory)
                        <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                    @endif
                    Semua
                </a>

                {{-- Dynamic Category Chips --}}
                @forelse ($categories as $cat)
                    @php $isActive = $selectedCategory === $cat->slug; @endphp
                    <a href="{{ route('jelajah', array_filter(['kategori' => $cat->slug, 'q' => $searchQuery])) }}"
                       class="px-3.5 py-2 rounded-full text-[12px] whitespace-nowrap shrink-0 transition-colors {{ $isActive ? 'bg-[#0f382c] text-white font-semibold shadow-xs' : 'bg-white border border-[#c1c8c3]/50 text-[#414845] hover:text-[#0f382c] font-medium' }}">
                        {{ $cat->name }}
                    </a>
                @empty
                @endforelse
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
                @forelse ($artworks as $art)
                    @php
                        $artImg = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                            ? $art->image_path 
                            : asset('storage/' . $art->image_path);
                    @endphp
                    <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                        <div class="relative h-44 w-full overflow-hidden bg-gray-100">
                            <a href="{{ route('artworks.show', $art->slug) }}" class="block w-full h-full">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                     alt="{{ $art->title }}"
                                     src="{{ $artImg }}">
                            </a>
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda] pointer-events-none">
                                {{ $art->category->name ?? 'Dakwah' }}
                            </span>
                            <button aria-label="Simpan karya"
                                    class="absolute top-2 right-2 w-7 h-7 rounded-full bg-white/80 backdrop-blur-md text-[#0f382c] flex items-center justify-center hover:bg-white transition-all shadow-xs"
                                    type="button">
                                <span class="material-symbols-outlined text-[15px]">bookmark</span>
                            </button>
                        </div>
                        <div class="p-2.5 flex flex-col justify-between flex-1">
                            <a href="{{ route('artworks.show', $art->slug) }}">
                                <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5 hover:underline">
                                    {{ $art->title }}
                                </h3>
                            </a>
                            <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                                <div class="flex flex-col">
                                    <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                        <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                        Rp {{ number_format($art->total_donations > 0 ? $art->total_donations : 1250000, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                                </div>
                                <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                    <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                    {{ $art->download_count }}
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                                <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold">
                                    {{ strtoupper(substr($art->user->name ?? 'K', 0, 1)) }}
                                </div>
                                <span class="text-[10px] text-[#414845] truncate">{{ $art->user->name ?? 'Kontributor' }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-2 text-center py-8 text-[#717975] text-xs">
                        Tidak ada karya yang sesuai dengan filter pencarian.
                    </div>
                @endforelse
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
