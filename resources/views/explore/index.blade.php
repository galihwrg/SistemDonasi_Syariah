<x-layouts.app title="Jelajah Karya Dakwah — Kuantum Pelopor Indonesia">

    <div class="space-y-4 pb-6">

        {{-- ================= BANNER INFO & KURASI DAKWAH UMAT ================= --}}
        <section class="px-4 pt-3">
            <div class="relative overflow-hidden bg-gradient-to-br from-[#0f382c] via-[#144839] to-[#0a2920] text-white rounded-3xl p-5 shadow-md border border-[#00392b]">
                {{-- Decorative light glow --}}
                <div class="absolute -right-8 -bottom-8 w-36 h-36 rounded-full bg-[#3f6658]/30 blur-2xl pointer-events-none"></div>
                <div class="absolute -left-6 -top-6 w-28 h-28 rounded-full bg-[#fed65b]/10 blur-xl pointer-events-none"></div>

                <div class="relative z-10 space-y-3">
                    <div class="flex items-center justify-between gap-2">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-[#ffe088] text-[10px] font-bold tracking-wide">
                            <span class="material-symbols-outlined text-[13px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                            Galeri Publik &amp; Kurasi Dakwah Umat
                        </span>
                        <a href="{{ route('unggah') }}"
                           class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-[#fed65b] hover:bg-[#ffe088] text-[#0f382c] text-[11px] font-bold shadow-xs active:scale-95 transition-all shrink-0">
                            <span class="material-symbols-outlined text-[14px]">add</span>
                            <span>Unggah Karya</span>
                        </a>
                    </div>

                    <div>
                        <h1 class="font-serif text-[20px] font-bold text-white tracking-tight leading-tight">
                            Galeri Karya &amp; Foto Umat
                        </h1>
                        <p class="text-[12px] text-[#c1ecda] leading-relaxed mt-1">
                            Dokumentasi visual dakwah, arsitektur masjid nusantara, kaligrafi, dan karya umat beriman yang lolos kurasi syariah.
                        </p>
                    </div>

                    {{-- Metrics pill --}}
                    <div class="flex items-center gap-4 pt-2 border-t border-white/15 text-xs">
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-[15px] font-bold text-white">{{ $totalActiveArtworks }}</span>
                            <span class="text-[10px] text-[#99d2bd]">Karya Aktif</span>
                        </div>
                        <div class="w-1 h-1 rounded-full bg-white/40"></div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-[15px] font-bold text-[#ffe088]">
                                Rp {{ number_format($totalInfaqAmount, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] text-[#99d2bd]">Infaq Visual Terhimpun</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= SEARCH BAR ================= --}}
        <section class="px-4">
            <form action="{{ route('jelajah') }}" method="GET" class="relative flex items-center">
                @if ($selectedCategory)
                    <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                @endif
                @if ($sortBy !== 'terbaru')
                    <input type="hidden" name="sort" value="{{ $sortBy }}">
                @endif
                <div class="absolute left-3.5 flex items-center pointer-events-none text-[#717975]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </div>
                <input class="w-full bg-white border border-[#c1c8c3]/60 rounded-2xl py-3 pl-11 pr-11 text-[#1a1c1b] text-[13px] placeholder:text-[#717975]/70 focus:outline-none focus:border-[#0f382c] focus:ring-2 focus:ring-[#fed65b]/40 transition-all shadow-xs"
                       placeholder="Cari karya, masjid, kontributor..."
                       name="q"
                       value="{{ $searchQuery ?? '' }}"
                       type="text">
                @if ($searchQuery)
                    <a href="{{ route('jelajah', array_filter(['kategori' => $selectedCategory, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                       class="absolute right-3.5 inset-y-0 flex items-center text-[#717975] hover:text-[#ba1a1a]">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </form>
        </section>

        {{-- ================= CATEGORY FILTER CHIPS ================= --}}
        <section class="overflow-x-auto no-scrollbar px-4 flex items-center gap-2">
            <a href="{{ route('jelajah', array_filter(['q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
               class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs whitespace-nowrap shadow-xs shrink-0 transition-all {{ !$selectedCategory ? 'bg-[#0f382c] text-white font-semibold' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }}">
                @if (!$selectedCategory)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                @endif
                Semua ({{ $artworks->count() }})
            </a>
            @foreach ($categories as $cat)
                @php $isActive = $selectedCategory === $cat->slug; @endphp
                <a href="{{ route('jelajah', array_filter(['kategori' => $cat->slug, 'q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                   class="px-3.5 py-1.5 rounded-full text-xs whitespace-nowrap shrink-0 transition-colors {{ $isActive ? 'bg-[#0f382c] text-white font-semibold shadow-xs' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </section>

        {{-- ================= SECTION HEADER & SORTIR ================= --}}
        <section class="px-4 flex items-center justify-between pt-1">
            <div>
                <h2 class="font-serif text-[15px] font-bold text-[#0f382c] tracking-tight">Koleksi Visual Dakwah</h2>
                <span class="text-[11px] text-[#717975]">{{ $artworks->count() }} karya ditemukan</span>
            </div>

            {{-- Dropdown Sortir --}}
            <form id="sort-form" action="{{ route('jelajah') }}" method="GET">
                @if ($selectedCategory)
                    <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                @endif
                @if ($searchQuery)
                    <input type="hidden" name="q" value="{{ $searchQuery }}">
                @endif
                <div class="relative flex items-center">
                    <span class="absolute left-2.5 flex items-center pointer-events-none text-[#717975]">
                        <span class="material-symbols-outlined text-[15px]">swap_vert</span>
                    </span>
                    <select name="sort"
                            onchange="document.getElementById('sort-form').submit()"
                            class="bg-white border border-[#c1c8c3]/60 rounded-full py-1.5 pl-7 pr-7 text-[11px] font-medium text-[#0f382c] focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#fed65b]/50 shadow-2xs cursor-pointer appearance-none">
                        <option value="terbaru" {{ $sortBy === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terpopuler" {{ $sortBy === 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="donasi" {{ $sortBy === 'donasi' ? 'selected' : '' }}>Paling Banyak Didonasikan</option>
                    </select>
                    <span class="absolute right-2 flex items-center pointer-events-none text-[#717975]">
                        <span class="material-symbols-outlined text-[13px]">expand_more</span>
                    </span>
                </div>
            </form>
        </section>

        {{-- ================= 2-COLUMN ARTWORK GRID (SAMA DENGAN HOME) ================= --}}
        <section class="px-4">
            <div class="grid grid-cols-2 gap-3">
                @forelse ($artworks as $art)
                    @php
                        $artImg = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                            ? $art->image_path 
                            : asset('storage/' . $art->image_path);
                        $isSaved = auth()->check() && auth()->user()->savedArtworks->contains($art->id);
                        $formattedDonation = 'Rp ' . number_format($art->total_donations ?? 0, 0, ',', '.');
                        $formattedDownloads = number_format($art->download_count ?? 0, 0, ',', '.') . ' Unduhan';
                        $contributorName = $art->user->name ?? 'Kontributor Dakwah';
                        $categoryName = $art->category->name ?? 'Arsitektur';
                        $dimensions = $art->dimensions ?? '3840 x 2160 px';
                    @endphp
                    <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all hover:shadow-md">
                        
                        {{-- Visual Media Container --}}
                        <div class="relative h-48 w-full overflow-hidden bg-gray-100">
                            <a href="{{ route('artworks.show', $art->slug) }}" class="block w-full h-full">
                                <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                     alt="{{ $art->title }}"
                                     src="{{ $artImg }}">
                            </a>

                            {{-- Category Badge --}}
                            <span class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[9.5px] font-medium text-[#c1ecda] pointer-events-none shadow-xs">
                                {{ $categoryName }}
                            </span>

                            {{-- Bookmark Button --}}
                            <button aria-label="Simpan karya"
                                    type="button"
                                    onclick="toggleBookmark({{ $art->id }}, this)"
                                    data-artwork-id="{{ $art->id }}"
                                    data-saved="{{ $isSaved ? 'true' : 'false' }}"
                                    class="bookmark-btn absolute top-2 right-2 w-7 h-7 rounded-full {{ $isSaved ? 'bg-[#0f382c]/85 text-[#fed65b]' : 'bg-white/85 text-[#0f382c]' }} backdrop-blur-md flex items-center justify-center hover:bg-white transition-all shadow-xs active:scale-90 z-20">
                                <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' {{ $isSaved ? '1' : '0' }};">bookmark</span>
                            </button>

                            {{-- Pratinjau Cepat Trigger Button --}}
                            <button type="button"
                                    onclick="openQuickPreviewModal({
                                        title: '{{ addslashes($art->title) }}',
                                        contributor: '{{ addslashes($contributorName) }}',
                                        category: '{{ addslashes($categoryName) }}',
                                        dimensions: '{{ addslashes($dimensions) }}',
                                        downloads: '{{ addslashes($formattedDownloads) }}',
                                        donations: '{{ addslashes($formattedDonation) }}',
                                        imageUrl: '{{ addslashes($artImg) }}',
                                        detailUrl: '{{ route('artworks.show', $art->slug) }}',
                                        downloadUrl: '{{ route('artworks.download', $art->slug) }}'
                                    })"
                                    class="absolute bottom-2 right-2 px-2 py-1 rounded-lg bg-black/60 hover:bg-[#0f382c] text-white text-[10px] font-medium flex items-center gap-1 backdrop-blur-md transition-all active:scale-95 shadow-xs">
                                <span class="material-symbols-outlined text-[13px]">zoom_in</span>
                                <span>Pratinjau Cepat</span>
                            </button>
                        </div>

                        {{-- Card Meta Info --}}
                        <div class="p-2.5 flex flex-col justify-between flex-1">
                            <div>
                                <a href="{{ route('artworks.show', $art->slug) }}">
                                    <h3 class="font-serif text-[12px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5 hover:underline">
                                        {{ $art->title }}
                                    </h3>
                                </a>
                            </div>

                            <div>
                                <div class="flex items-end justify-between py-1 mb-1 border-t border-[#c1c8c3]/20 pt-1.5">
                                    <div class="flex flex-col">
                                        <span class="flex items-center gap-1 font-bold text-[11px] text-[#0f382c]">
                                            <span class="material-symbols-outlined text-[12px] text-[#735c00]">volunteer_activism</span>
                                            {{ $formattedDonation }}
                                        </span>
                                        <span class="text-[9px] font-medium text-[#717975] pl-4 leading-none">Donasi Terkumpul</span>
                                    </div>
                                    <span class="flex items-center gap-0.5 text-[#414845] font-medium text-[10px] pb-0.5">
                                        <span class="material-symbols-outlined text-[12px] text-[#717975]">download</span>
                                        {{ $art->download_count }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-1.5 pt-1 border-t border-[#c1c8c3]/20">
                                    <div class="w-4 h-4 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[8px] font-bold shrink-0">
                                        {{ strtoupper(substr($contributorName, 0, 1)) }}
                                    </div>
                                    <span class="text-[10px] text-[#414845] truncate font-medium">{{ $contributorName }}</span>
                                </div>
                            </div>

                        </div>
                    </article>
                @empty
                    <div class="col-span-2 text-center py-10 bg-white rounded-2xl border border-[#c1c8c3]/40 p-6 space-y-2">
                        <span class="material-symbols-outlined text-4xl text-[#717975]">photo_library</span>
                        <h4 class="font-serif text-sm font-bold text-[#0f382c]">Tidak Ada Karya Ditemukan</h4>
                        <p class="text-xs text-[#717975]">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- ================= SUMMARY BOTTOM ================= --}}
        <section class="px-4 pt-2">
            <div class="p-3.5 bg-[#f4f4f1] rounded-2xl border border-[#c1c8c3]/40 text-center text-xs text-[#414845] space-y-2">
                <p>Menampilkan <strong>{{ $artworks->count() }}</strong> karya visual dakwah yang tayang di galeri publik.</p>
                <div class="flex items-center justify-center gap-2 pt-1">
                    <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-xl border border-[#c1c8c3]/50 bg-white hover:bg-gray-50 text-[#0f382c] text-xs font-semibold transition-colors">
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('unggah') }}" class="px-3 py-1.5 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] transition-colors">
                        Unggah Karya Visual
                    </a>
                </div>
            </div>
        </section>

    </div>

    {{-- ================= QUICK PREVIEW ZOOM MODAL ================= --}}
    <div id="quickPreviewModal" class="fixed inset-0 z-50 bg-[#002218]/70 backdrop-blur-xs hidden items-center justify-center p-4 transition-all">
        <div id="quickPreviewBox" class="bg-white rounded-2xl max-w-sm sm:max-w-md w-full border border-[#c1c8c3]/40 shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-[#dadad7]/60 bg-[#f4f4f1]">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[#735c00] text-lg" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <h3 class="font-serif text-sm font-semibold text-[#0f382c]" id="qp-header-title">Pratinjau Foto</h3>
                </div>
                <button type="button"
                        onclick="closeQuickPreviewModal()"
                        class="w-7 h-7 rounded-full hover:bg-[#e8e8e5] text-[#414845] flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-4 space-y-3.5 overflow-y-auto">
                {{-- Foto Zoom --}}
                <div class="rounded-xl overflow-hidden bg-gray-100 aspect-4/3 w-full border border-[#c1c8c3]/40 relative">
                    <img id="qp-image" src="" alt="Preview" class="w-full h-full object-cover">
                    <span id="qp-category-badge" class="absolute top-2 left-2 px-2 py-0.5 rounded-full bg-[#0f382c]/85 text-white text-[9.5px] font-semibold"></span>
                </div>

                {{-- Detail Meta & Aksi --}}
                <div class="space-y-3">
                    <div>
                        <span class="text-[9.5px] text-[#735c00] font-bold uppercase tracking-wider block" id="qp-category-label">Kategori</span>
                        <h4 class="font-serif text-base font-bold text-[#0f382c] mt-0.5 leading-snug" id="qp-title">Judul Foto</h4>
                    </div>

                    <div class="bg-[#f4f4f1] p-3 rounded-xl space-y-1.5 border border-[#c1c8c3]/30 text-[11px]">
                        <div class="flex justify-between">
                            <span class="text-[#717975]">Kontributor:</span>
                            <span class="font-semibold text-[#0f382c]" id="qp-contributor">Nama Kontributor</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#717975]">Resolusi Asli:</span>
                            <span class="font-semibold text-[#0f382c]" id="qp-dimensions">3840 x 2160 px</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#717975]">Status Lisensi:</span>
                            <span class="font-semibold text-emerald-800 bg-emerald-50 px-1.5 py-0.5 rounded text-[10px]">Bebas Royalti Dakwah</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-[#717975]">Unduhan Publik:</span>
                            <span class="font-semibold text-[#0f382c]" id="qp-downloads">0 Unduhan</span>
                        </div>
                    </div>

                    <div class="p-2.5 bg-[#fed65b]/20 rounded-xl border border-[#fed65b]/40 flex items-center justify-between">
                        <span class="text-[10px] text-[#735c00] font-bold uppercase tracking-wider">Infaq Visual:</span>
                        <span class="font-serif text-base text-[#0f382c] font-bold" id="qp-donations">Rp 0</span>
                    </div>

                    {{-- Actions: Download & Open Detail --}}
                    <div class="pt-2 border-t border-[#dadad7]/60 flex items-center gap-2">
                        <a id="qp-download-btn"
                           href="#"
                           class="flex-1 py-2.5 rounded-xl bg-[#0f382c] hover:bg-[#1a5c44] text-white text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                            <span class="material-symbols-outlined text-[15px]">download</span>
                            <span>Unduh Karya</span>
                        </a>
                        <a id="qp-detail-btn"
                           href="#"
                           class="px-3.5 py-2.5 rounded-xl border border-[#c1c8c3]/60 hover:bg-[#f4f4f1] text-[#0f382c] text-xs font-semibold transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px]">visibility</span>
                            <span>Halaman Detail</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Pratinjau Cepat Modal --}}
    <script>
        function openQuickPreviewModal(data) {
            document.getElementById('qp-header-title').innerText = data.title;
            document.getElementById('qp-title').innerText = data.title;
            document.getElementById('qp-contributor').innerText = data.contributor;
            document.getElementById('qp-category-label').innerText = data.category;
            document.getElementById('qp-category-badge').innerText = data.category;
            document.getElementById('qp-dimensions').innerText = data.dimensions;
            document.getElementById('qp-downloads').innerText = data.downloads;
            document.getElementById('qp-donations').innerText = data.donations;
            document.getElementById('qp-image').src = data.imageUrl;
            document.getElementById('qp-download-btn').href = data.downloadUrl;
            document.getElementById('qp-detail-btn').href = data.detailUrl;

            const modal = document.getElementById('quickPreviewModal');
            const box = document.getElementById('quickPreviewBox');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeQuickPreviewModal() {
            const modal = document.getElementById('quickPreviewModal');
            const box = document.getElementById('quickPreviewBox');

            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeQuickPreviewModal();
            }
        });
    </script>

</x-layouts.app>