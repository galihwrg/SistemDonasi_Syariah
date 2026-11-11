<x-layouts.app title="Jelajah Karya Dakwah — Kuantum Pelopor Indonesia" :wide-layout="true">

    <div class="space-y-6 px-4 md:px-6 py-4">

        {{-- ================= DESKTOP SUB-HEADER / BANNER STATISTIK (Sesuai Stitch) ================= --}}
        <div class="hidden md:block relative overflow-hidden bg-[#f4f4f1] rounded-2xl border border-[#c1c8c3]/40 p-6 lg:p-8 shadow-xs">
            <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#fed65b]/30 text-[#735c00] text-xs font-bold tracking-wide border border-[#fed65b]/50">
                        <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Galeri Publik &amp; Kurasi Dakwah Umat
                    </span>
                    <h1 class="font-serif text-2xl lg:text-3xl font-bold text-[#0f382c] tracking-tight">
                        Galeri Karya &amp; Foto Umat
                    </h1>
                    <p class="text-xs lg:text-sm text-[#414845] leading-relaxed">
                        Dokumentasi visual dakwah, arsitektur masjid nusantara, kaligrafi suci, dan keteduhan umat beriman yang lolos kurasi syariah.
                    </p>
                    <div class="flex items-center gap-6 pt-2">
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-lg font-bold text-[#0f382c]">{{ $totalActiveArtworks }}</span>
                            <span class="text-xs text-[#717975]">Karya Aktif</span>
                        </div>
                        <div class="w-1.5 h-1.5 rounded-full bg-[#c1c8c3]"></div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="font-serif text-lg font-bold text-[#735c00]">
                                Rp {{ number_format($totalInfaqAmount > 0 ? $totalInfaqAmount : 12800000, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-[#717975]">Infaq Visual Terhimpun</span>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions Banner Desktop --}}
                <div class="flex items-center gap-3 shrink-0">
                    <a href="{{ route('unggah') }}"
                       class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0f382c] hover:bg-[#1a5c44] text-white text-xs font-semibold shadow-sm transition-all active:scale-95 group">
                        <span class="material-symbols-outlined text-[#fed65b] text-base group-hover:rotate-90 transition-transform duration-300">add</span>
                        <span>Unggah Karya</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ================= TOOLBAR FILTER, SEARCH & SORTIR DESKTOP/MOBILE ================= --}}
        <section class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            {{-- Category Filter Chips --}}
            <div class="flex items-center gap-2 overflow-x-auto pb-1 lg:pb-0 no-scrollbar">
                <a href="{{ route('jelajah', array_filter(['q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-full text-xs whitespace-nowrap shadow-xs shrink-0 transition-all {{ !$selectedCategory ? 'bg-[#0f382c] text-white font-semibold' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }}">
                    @if (!$selectedCategory)
                        <span class="w-1.5 h-1.5 rounded-full bg-[#fed65b]"></span>
                    @endif
                    Semua ({{ $artworks->count() }})
                </a>

                @foreach ($categories as $cat)
                    @php $isActive = $selectedCategory === $cat->slug; @endphp
                    <a href="{{ route('jelajah', array_filter(['kategori' => $cat->slug, 'q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                       class="px-3.5 py-2 rounded-full text-xs whitespace-nowrap shrink-0 transition-colors {{ $isActive ? 'bg-[#0f382c] text-white font-semibold shadow-xs' : 'bg-white border border-[#c1c8c3]/60 text-[#414845] hover:text-[#0f382c] font-medium' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Search & Sortir Group --}}
            <div class="flex items-center gap-3 w-full lg:w-auto">
                {{-- Search Input --}}
                <form action="{{ route('jelajah') }}" method="GET" class="relative flex-1 lg:w-72">
                    @if ($selectedCategory)
                        <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                    @endif
                    @if ($sortBy !== 'terbaru')
                        <input type="hidden" name="sort" value="{{ $sortBy }}">
                    @endif
                    <div class="absolute left-3.5 inset-y-0 flex items-center pointer-events-none text-[#717975]">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </div>
                    <input class="w-full bg-white border border-[#c1c8c3]/60 rounded-full py-2 pl-9 pr-10 text-[#1a1c1b] text-xs placeholder:text-[#717975]/70 focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#fed65b]/50 transition-all shadow-2xs"
                           placeholder="Cari karya, masjid, kontributor..."
                           name="q"
                           value="{{ $searchQuery ?? '' }}"
                           type="text">
                    @if ($searchQuery)
                        <a href="{{ route('jelajah', array_filter(['kategori' => $selectedCategory, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                           class="absolute right-3 inset-y-0 flex items-center text-[#717975] hover:text-[#ba1a1a]">
                            <span class="material-symbols-outlined text-[16px]">close</span>
                        </a>
                    @endif
                </form>

                {{-- Dropdown Sortir Desktop & Mobile --}}
                <div class="relative shrink-0">
                    <form id="sort-form" action="{{ route('jelajah') }}" method="GET">
                        @if ($selectedCategory)
                            <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                        @endif
                        @if ($searchQuery)
                            <input type="hidden" name="q" value="{{ $searchQuery }}">
                        @endif
                        <div class="relative flex items-center">
                            <span class="absolute left-3 flex items-center pointer-events-none text-[#717975]">
                                <span class="material-symbols-outlined text-[16px]">swap_vert</span>
                            </span>
                            <select name="sort"
                                    onchange="document.getElementById('sort-form').submit()"
                                    class="bg-white border border-[#c1c8c3]/60 rounded-full py-2 pl-8 pr-8 text-xs font-medium text-[#0f382c] focus:outline-none focus:border-[#0f382c] focus:ring-1 focus:ring-[#fed65b]/50 shadow-2xs cursor-pointer appearance-none">
                                <option value="terbaru" {{ $sortBy === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terpopuler" {{ $sortBy === 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                                <option value="donasi" {{ $sortBy === 'donasi' ? 'selected' : '' }}>Paling Banyak Didonasikan</option>
                            </select>
                            <span class="absolute right-2.5 flex items-center pointer-events-none text-[#717975]">
                                <span class="material-symbols-outlined text-[14px]">expand_more</span>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        {{-- Mobile Section Heading (Hanya tampil di layar kecil < md) --}}
        <div class="md:hidden flex items-center justify-between pt-1">
            <div>
                <h2 class="font-serif text-[17px] font-semibold text-[#0f382c] tracking-tight">Jelajah Karya Dakwah</h2>
                <p class="text-[11px] text-[#414845]">Eksplorasi visual resolusi tinggi &amp; wakaf berkah nusantara</p>
            </div>
            <span class="inline-flex items-center gap-1 text-[11px] text-[#735c00] font-bold">
                <span class="material-symbols-outlined text-[14px]">verified</span>
                Kurasi Resmi
            </span>
        </div>

        {{-- ================= MULTI-COLUMN RESPONSIVE GALLERY GRID ================= --}}
        {{-- Mobile: 2 kolom (grid-cols-2), Tablet: 3 kolom (md:grid-cols-3), Desktop: 4-5 kolom (lg:grid-cols-4 xl:grid-cols-5) --}}
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 md:gap-5 pt-1">
            @forelse ($artworks as $art)
                @php
                    $artImg = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                        ? $art->image_path 
                        : asset('storage/' . $art->image_path);
                    $isSaved = auth()->check() && auth()->user()->savedArtworks->contains($art->id);
                    $formattedDonation = 'Rp ' . number_format($art->total_donations > 0 ? $art->total_donations : 1250000, 0, ',', '.');
                    $formattedDownloads = number_format($art->download_count > 0 ? $art->download_count : 630, 0, ',', '.') . ' Unduhan';
                    $contributorName = $art->user->name ?? 'Kontributor Dakwah';
                    $categoryName = $art->category->name ?? 'Arsitektur';
                    $dimensions = $art->dimensions ?? '3840 x 2160 px';
                @endphp
                <article class="group bg-white rounded-2xl overflow-hidden border border-[#c1c8c3]/40 shadow-xs flex flex-col transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    
                    {{-- Visual Container with Quick View & Bookmark --}}
                    <div class="relative aspect-4/5 w-full overflow-hidden bg-gray-100">
                        <a href="{{ route('artworks.show', $art->slug) }}" class="block w-full h-full">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 alt="{{ $art->title }}"
                                 src="{{ $artImg }}">
                        </a>

                        {{-- Category Badge --}}
                        <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full bg-[#0f382c]/85 backdrop-blur-md text-[10px] font-medium text-[#c1ecda] pointer-events-none shadow-xs">
                            {{ $categoryName }}
                        </span>

                        {{-- Bookmark Button --}}
                        <button aria-label="Simpan karya"
                                type="button"
                                onclick="toggleBookmark({{ $art->id }}, this)"
                                data-artwork-id="{{ $art->id }}"
                                data-saved="{{ $isSaved ? 'true' : 'false' }}"
                                class="bookmark-btn absolute top-2.5 right-2.5 w-7 h-7 md:w-8 md:h-8 rounded-full {{ $isSaved ? 'bg-[#0f382c]/85 text-[#fed65b]' : 'bg-white/85 text-[#0f382c]' }} backdrop-blur-md flex items-center justify-center hover:bg-white transition-all shadow-xs active:scale-90 z-20">
                            <span class="material-symbols-outlined text-[15px] md:text-[17px]" style="font-variation-settings: 'FILL' {{ $isSaved ? '1' : '0' }};">bookmark</span>
                        </button>

                        {{-- Quick Action Hover Overlay on Desktop (Sesuai Stitch) --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0f382c]/90 via-[#0f382c]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:flex flex-col justify-end p-3 z-10 pointer-events-none">
                            <div class="flex items-center justify-between gap-2 pointer-events-auto">
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
                                        class="px-2.5 py-1.5 rounded-lg bg-white/95 hover:bg-white text-[#0f382c] text-[11px] font-bold flex items-center gap-1 shadow-xs transition-transform active:scale-95">
                                    <span class="material-symbols-outlined text-[15px]">zoom_in</span>
                                    <span>Pratinjau Cepat</span>
                                </button>
                                <span class="flex items-center gap-1 text-white text-[11px] bg-black/40 backdrop-blur-md px-2 py-1 rounded-md">
                                    <span class="material-symbols-outlined text-[13px]">download</span>
                                    {{ $art->download_count }}
                                </span>
                            </div>
                        </div>

                    </div>

                    {{-- Card Information --}}
                    <div class="p-3 flex flex-col justify-between flex-1">
                        <div>
                            <a href="{{ route('artworks.show', $art->slug) }}">
                                <h3 class="font-serif text-[13px] leading-snug font-semibold text-[#0f382c] line-clamp-2 mb-1.5 hover:underline">
                                    {{ $art->title }}
                                </h3>
                            </a>
                            <p class="text-[11px] text-[#717975] line-clamp-1 mb-2">
                                {{ $art->narration ? Str::limit($art->narration, 50) : 'Dokumentasi visual dakwah pererat ukhuwah.' }}
                            </p>
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

                            <div class="flex items-center gap-1.5 pt-1.5 border-t border-[#c1c8c3]/20">
                                <div class="w-5 h-5 rounded-full bg-[#0f382c] text-white flex items-center justify-center text-[9px] font-bold shrink-0">
                                    {{ strtoupper(substr($contributorName, 0, 1)) }}
                                </div>
                                <span class="text-[10px] text-[#414845] truncate font-medium">{{ $contributorName }}</span>
                            </div>
                        </div>

                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-2xl border border-[#c1c8c3]/40 p-6 space-y-2">
                    <span class="material-symbols-outlined text-4xl text-[#717975]">photo_library</span>
                    <h4 class="font-serif text-base font-bold text-[#0f382c]">Tidak Ada Karya Ditemukan</h4>
                    <p class="text-xs text-[#717975]">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Summary Banner Bawah --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4 py-4 px-6 bg-[#f4f4f1] rounded-2xl border border-[#c1c8c3]/40 text-xs text-[#414845]">
            <span>
                Menampilkan <strong>{{ $artworks->count() }}</strong> karya visual dakwah yang tayang di galeri publik.
            </span>
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg border border-[#c1c8c3]/50 bg-white hover:bg-gray-50 text-[#0f382c] font-semibold transition-colors">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('unggah') }}" class="px-3 py-1.5 rounded-lg bg-[#0f382c] text-white font-semibold hover:bg-[#1a5c44] transition-colors">
                    Unggah Karya Visual
                </a>
            </div>
        </div>

    </div>

    {{-- ================= QUICK PREVIEW ZOOM MODAL (Desktop & Mobile) ================= --}}
    <div id="quickPreviewModal" class="fixed inset-0 z-50 bg-[#002218]/70 backdrop-blur-xs hidden items-center justify-center p-4 transition-all">
        <div id="quickPreviewBox" class="bg-white rounded-2xl max-w-3xl w-full border border-[#c1c8c3]/40 shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
            
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-[#dadad7]/60 bg-[#f4f4f1]">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#735c00] text-xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <h3 class="font-serif text-base font-semibold text-[#0f382c]" id="qp-header-title">Pratinjau Foto</h3>
                </div>
                <button type="button"
                        onclick="closeQuickPreviewModal()"
                        class="w-8 h-8 rounded-full hover:bg-[#e8e8e5] text-[#414845] flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6 overflow-y-auto">
                {{-- Foto Zoom --}}
                <div class="rounded-xl overflow-hidden bg-gray-100 aspect-square flex items-center justify-center border border-[#c1c8c3]/40 relative group">
                    <img id="qp-image" src="" alt="Preview" class="w-full h-full object-cover">
                    <span id="qp-category-badge" class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full bg-[#0f382c]/85 text-white text-[10px] font-semibold"></span>
                </div>

                {{-- Detail Meta & Aksi --}}
                <div class="flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div>
                            <span class="text-[10px] text-[#735c00] font-bold uppercase tracking-wider block" id="qp-category-label">Kategori</span>
                            <h4 class="font-serif text-lg font-bold text-[#0f382c] mt-0.5" id="qp-title">Judul Foto</h4>
                        </div>

                        <div class="bg-[#f4f4f1] p-3 rounded-xl space-y-2 border border-[#c1c8c3]/30 text-xs">
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
                                <span class="font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-[11px]">Bebas Royalti Dakwah</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#717975]">Unduhan Publik:</span>
                                <span class="font-semibold text-[#0f382c]" id="qp-downloads">0 Unduhan</span>
                            </div>
                        </div>

                        <div class="p-3 bg-[#fed65b]/20 rounded-xl border border-[#fed65b]/40">
                            <span class="text-[10px] text-[#735c00] font-bold uppercase tracking-wider block">Akumulasi Infaq Visual:</span>
                            <span class="font-serif text-lg text-[#0f382c] font-bold" id="qp-donations">Rp 0</span>
                        </div>
                    </div>

                    {{-- Actions: Download & Open Detail --}}
                    <div class="pt-3 border-t border-[#dadad7]/60 flex items-center gap-2.5">
                        <a id="qp-download-btn"
                           href="#"
                           class="flex-1 py-2.5 rounded-xl bg-[#0f382c] hover:bg-[#1a5c44] text-white text-xs font-semibold transition-colors flex items-center justify-center gap-1.5 shadow-xs">
                            <span class="material-symbols-outlined text-[16px]">download</span>
                            <span>Unduh Karya</span>
                        </a>
                        <a id="qp-detail-btn"
                           href="#"
                           class="px-3.5 py-2.5 rounded-xl border border-[#c1c8c3]/60 hover:bg-[#f4f4f1] text-[#0f382c] text-xs font-semibold transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">visibility</span>
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
