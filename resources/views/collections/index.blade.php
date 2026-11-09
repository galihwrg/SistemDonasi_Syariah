<x-layouts.app title="Koleksi Saya — Kuantum Pelopor Indonesia">

    <div class="px-5 py-4 space-y-4">

        {{-- Header Section (Stitch Specifications) --}}
        <div class="flex items-center justify-between">
            <div class="space-y-0.5">
                <h1 class="font-serif text-[22px] font-bold text-[#0f382c] tracking-tight">
                    Koleksi Saya
                </h1>
                <p class="text-[12px] text-[#414845]">
                    Karya visual tersimpan &amp; disukai
                </p>
            </div>
            <a href="{{ route('jelajah') }}"
               aria-label="Cari Karya Lain"
               class="w-9 h-9 rounded-full flex items-center justify-center text-[#0f382c] bg-[#f4f4f1] hover:bg-[#e8e8e5] transition-colors border border-[#c1c8c3]/40">
                <span class="material-symbols-outlined text-[20px]">search</span>
            </a>
        </div>

        {{-- Filter Chips Horizontal --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar -mx-5 px-5">
            <a href="{{ route('koleksi') }}"
               class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full {{ empty($selectedCategorySlug) ? 'bg-[#0f382c] text-white shadow-xs font-semibold' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }} text-[12px] whitespace-nowrap shrink-0 transition-all">
                @if (empty($selectedCategorySlug))
                    <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                @endif
                Semua ({{ $totalSaved }})
            </a>

            @foreach ($categories as $cat)
                @php
                    $isActive = ($selectedCategorySlug === $cat->slug);
                @endphp
                <a href="{{ route('koleksi', ['kategori' => $cat->slug]) }}"
                   class="px-3.5 py-1.5 rounded-full {{ $isActive ? 'bg-[#0f382c] text-white shadow-xs font-semibold' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }} text-[12px] whitespace-nowrap shrink-0 transition-colors">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Main Saved Artworks Grid / Empty State --}}
        @if ($savedArtworks->isNotEmpty())
            <div id="collections-grid" class="grid grid-cols-2 gap-3.5 pt-1 items-start">
                @foreach ($savedArtworks as $art)
                    @php
                        $artImg = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                            ? $art->image_path 
                            : asset('storage/' . $art->image_path);
                    @endphp
                    <article id="collection-card-{{ $art->id }}"
                             class="bg-white rounded-xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs group flex flex-col hover:shadow-md transition-all">
                        <div class="relative overflow-hidden aspect-[3/4] bg-[#eeeeeb]">
                            <a href="{{ route('artworks.show', $art->slug) }}" class="block w-full h-full">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                     alt="{{ $art->title }}"
                                     src="{{ $artImg }}">
                            </a>
                            
                            {{-- Bookmark Toggle Button (Active Filled Yellow-Gold) --}}
                            <button type="button"
                                    aria-label="Hapus dari koleksi"
                                    onclick="toggleBookmark({{ $art->id }}, this)"
                                    class="bookmark-btn absolute top-2 right-2 w-7 h-7 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[#fed65b] flex items-center justify-center shadow-xs active:scale-90 transition-all"
                                    data-saved="true"
                                    data-artwork-id="{{ $art->id }}">
                                <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">bookmark</span>
                            </button>

                            @if ($art->category)
                                <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/80 backdrop-blur-md text-[9px] font-medium text-[#c1ecda] pointer-events-none">
                                    {{ $art->category->name }}
                                </span>
                            @endif
                        </div>

                        <div class="p-2.5">
                            <a href="{{ route('artworks.show', $art->slug) }}">
                                <h4 class="font-serif text-[13px] font-semibold text-[#0f382c] truncate hover:underline">
                                    {{ $art->title }}
                                </h4>
                            </a>
                            <p class="text-[11px] text-[#717975] truncate mt-0.5">
                                {{ $art->user->name ?? 'Kontributor Dakwah' }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-4 pb-2 text-center">
                <p class="text-[11px] text-[#717975] flex items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-[13px] text-[#735c00]">verified</span>
                    Semua tersimpan rapi dalam arsip pribadi Anda
                </p>
            </div>
        @else
            {{-- Syariah-Friendly Empty State (Desain Ramah Dakwah) --}}
            <div class="bg-white rounded-2xl p-8 border border-[#c1c8c3]/40 shadow-xs text-center flex flex-col items-center justify-center space-y-4 my-4">
                <div class="w-16 h-16 rounded-full bg-[#0f382c]/10 text-[#0f382c] flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">bookmarks</span>
                </div>

                <div class="space-y-1.5 max-w-xs">
                    <h3 class="font-serif text-base font-bold text-[#0f382c]">
                        Belum Ada Karya Tersimpan
                    </h3>
                    <p class="text-xs text-[#717975] leading-relaxed">
                        Simpan karya visual dakwah, kaligrafi, dan dokumentasi masjid favorit Anda untuk diakses kembali kapan saja.
                    </p>
                </div>

                @guest
                    <div class="pt-2 flex flex-col w-full gap-2">
                        <a href="{{ route('login') }}"
                           class="w-full py-2.5 px-4 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] active:scale-95 transition-all shadow-xs">
                            Masuk untuk Melihat Koleksi
                        </a>
                        <p class="text-[10px] text-[#717975]">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-[#0f382c] font-semibold underline">Daftar sekarang</a>
                        </p>
                    </div>
                @else
                    <a href="{{ route('jelajah') }}"
                       class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] active:scale-95 transition-all shadow-xs">
                        <span class="material-symbols-outlined text-sm">explore</span>
                        Jelajahi Galeri Sekarang
                    </a>
                @endguest
            </div>
        @endif

    </div>

</x-layouts.app>
