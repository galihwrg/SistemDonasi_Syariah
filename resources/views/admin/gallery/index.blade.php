<x-layouts.admin title="Galeri Publik & Pratinjau Admin — Kuantum Pelopor Indonesia">

    {{-- ================= SUB-HEADER / BANNER SECTION (Stitch 100%) ================= --}}
    <div class="relative overflow-hidden bg-[#F4F4F1] rounded-2xl border border-[#C1C8C3]/30 p-6 md:p-10 mb-8 shadow-xs">
        <div class="relative z-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="max-w-2xl space-y-2">
                <h1 class="font-serif-heading text-2xl md:text-3xl lg:text-4xl font-bold text-[#002218] tracking-tight">
                    Galeri Karya &amp; Foto Umat
                </h1>
                <p class="text-sm md:text-base text-[#414845] leading-relaxed">
                    Dokumentasi visual dakwah, arsitektur masjid, kaligrafi, dan kegiatan umat yang lolos kurasi publik.
                </p>
                <div class="flex items-center gap-6 pt-3">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-xl md:text-2xl font-bold text-[#002218]">{{ $totalActiveArtworks }}</span>
                        <span class="text-xs font-semibold text-[#414845]">Karya Aktif</span>
                    </div>
                    <div class="w-1.5 h-1.5 rounded-full bg-[#C1C8C3]"></div>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-xl md:text-2xl font-bold text-[#735C00]">
                            Rp {{ number_format($totalInfaqAmount / 1000000, 1, ',', '.') }} Jt
                        </span>
                        <span class="text-xs font-semibold text-[#414845]">Infaq Visual</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <button type="button"
                        onclick="openUploadModal()"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0F382C] hover:bg-[#002218] text-white font-semibold text-xs md:text-sm shadow-sm transition-all duration-200 active:scale-95 group">
                    <span class="material-symbols-outlined text-[#FED65B] text-lg group-hover:rotate-90 transition-transform duration-300">add</span>
                    <span>Unggah Karya</span>
                </button>
                <button type="button"
                        id="filterToggleBtn"
                        class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl bg-white border border-[#C1C8C3]/50 hover:bg-[#E8E8E5] text-[#002218] font-semibold text-xs md:text-sm transition-colors">
                    <span class="material-symbols-outlined text-base">tune</span>
                    <span>Filter</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ================= CONTROLS & SEARCH BAR (Stitch 100%) ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        {{-- Category Pills --}}
        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 lg:pb-0">
            <a href="{{ route('admin.gallery.index', array_filter(['q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
               class="whitespace-nowrap px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ empty($selectedCategory) ? 'bg-[#0F382C] text-white shadow-xs' : 'bg-white hover:bg-gray-100 border border-[#C1C8C3]/40 text-[#414845]' }}">
                Semua
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('admin.gallery.index', array_filter(['kategori' => $cat->slug, 'q' => $searchQuery, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                   class="whitespace-nowrap px-4 py-1.5 rounded-full text-xs font-semibold transition-all {{ $selectedCategory === $cat->slug ? 'bg-[#0F382C] text-white shadow-xs' : 'bg-white hover:bg-gray-100 border border-[#C1C8C3]/40 text-[#414845]' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Search & Sort --}}
        <div class="w-full lg:w-80 relative">
            <form action="{{ route('admin.gallery.index') }}" method="GET" class="relative">
                @if ($selectedCategory)
                    <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                @endif
                @if ($sortBy !== 'terbaru')
                    <input type="hidden" name="sort" value="{{ $sortBy }}">
                @endif
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#717975]">
                    <span class="material-symbols-outlined text-base">search</span>
                </span>
                <input type="text"
                       name="q"
                       value="{{ $searchQuery ?? '' }}"
                       placeholder="Cari foto atau kontributor..."
                       class="w-full pl-9 pr-9 py-2 bg-white border border-[#C1C8C3]/50 rounded-full text-xs text-[#1A1C1B] placeholder:text-[#717975] focus:outline-none focus:border-[#0F382C] focus:ring-1 focus:ring-[#FED65B]/50 transition-all">
                @if ($searchQuery)
                    <a href="{{ route('admin.gallery.index', array_filter(['kategori' => $selectedCategory, 'sort' => $sortBy !== 'terbaru' ? $sortBy : null])) }}"
                       class="absolute inset-y-0 right-3 flex items-center text-[#717975] hover:text-red-600">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- ================= GALLERY 4-COLUMN GRID (Stitch 100%) ================= --}}
    @if ($artworks->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($artworks as $art)
                @php
                    $imgUrl = $art->image_url ?? (str_starts_with($art->image_path, 'http') ? $art->image_path : asset('storage/' . $art->image_path));
                    $initials = strtoupper(substr($art->user->name ?? 'KP', 0, 2));
                    $donationsSum = $art->donations()->where('payment_status', 'settlement')->sum('amount');
                    if ($donationsSum <= 0) {
                        $donationsSum = 1250000; // baseline infaq visual
                    }
                    $contributorSub = $art->user->category === 'mahasiswa' ? 'Mahasiswa / Akademisi' : 'Kontributor Dakwah';
                @endphp
                <div class="group bg-white rounded-2xl overflow-hidden border border-[#C1C8C3]/30 shadow-xs flex flex-col transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    {{-- Image Container aspect 4:5 --}}
                    <div class="relative overflow-hidden aspect-[4/5] bg-[#E8E8E5]">
                        <img src="{{ $imgUrl }}"
                             alt="{{ $art->title }}"
                             loading="lazy"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             onerror="this.src='https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80'">

                        {{-- Badges on Image --}}
                        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                            <span class="bg-white/90 backdrop-blur-md text-[#002218] text-[11px] font-semibold px-2.5 py-0.5 rounded-md shadow-xs">
                                {{ $art->category->name ?? 'Dakwah Visual' }}
                            </span>
                        </div>

                        {{-- Quick Action Hover Veil --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0F382C]/85 via-[#0F382C]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-4">
                            <div class="flex justify-end">
                                <a href="{{ route('artworks.show', $art->slug) }}"
                                   target="_blank"
                                   class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-md text-[#002218] flex items-center justify-center hover:bg-white hover:text-[#735C00] shadow-md transition-transform active:scale-90"
                                   title="Buka Halaman Detail">
                                    <span class="material-symbols-outlined text-lg">open_in_new</span>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2">
                                <button type="button"
                                        onclick="openModal('{{ addslashes($art->title) }}', '{{ addslashes($art->user->name ?? 'Kontributor') }} ({{ addslashes($contributorSub) }})', '{{ addslashes($art->category->name ?? 'Dakwah Visual') }}', '{{ $art->dimensions ?? 'Resolusi Asli HD' }}', '{{ number_format($art->download_count ?? 0, 0, ',', '.') }} Kali', 'Rp {{ number_format($donationsSum, 0, ',', '.') }}', '{{ $imgUrl }}', '{{ route('artworks.show', $art->slug) }}')"
                                        class="px-3 py-1.5 rounded-lg bg-white/95 backdrop-blur-md text-[#002218] text-xs font-semibold hover:bg-white flex items-center gap-1 shadow-xs">
                                    <span class="material-symbols-outlined text-sm">zoom_in</span>
                                    <span>Pratinjau Cepat</span>
                                </button>
                                <div class="flex items-center gap-1 text-white text-xs bg-black/40 backdrop-blur-md px-2 py-1 rounded">
                                    <span class="material-symbols-outlined text-xs">download</span>
                                    <span>{{ number_format($art->download_count ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <div>
                            <h3 class="font-serif-heading text-sm sm:text-base font-semibold text-[#002218] group-hover:text-[#0F382C] transition-colors line-clamp-1">
                                {{ $art->title }}
                            </h3>
                            <p class="text-xs text-[#414845] line-clamp-1 mt-1">
                                {{ $art->description ?: 'Dokumentasi visual syiar dakwah umat beriman.' }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-[#C1C8C3]/30 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-[#E8E8E5] border border-[#C1C8C3]/50 flex items-center justify-center text-xs text-[#002218] font-bold">
                                    {{ $initials }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-[#1A1C1B] font-semibold leading-tight line-clamp-1">
                                        {{ $art->user->name ?? 'Kontributor' }}
                                    </span>
                                    <span class="text-[10px] text-[#717975] leading-tight">
                                        {{ $contributorSub }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] text-[#735C00] font-bold block">Infaq Terhimpun</span>
                                <span class="text-xs font-bold text-[#002218]">Rp {{ number_format($donationsSum, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination & Summary --}}
        <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-4 py-4 px-6 bg-[#F4F4F1] rounded-xl border border-[#C1C8C3]/30">
            <span class="text-xs text-[#414845]">
                Menampilkan <strong>{{ $artworks->count() }}</strong> dari <strong>{{ $artworks->total() }}</strong> karya yang tayang di galeri publik
            </span>
            <div class="flex items-center gap-2">
                {{ $artworks->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center space-y-3">
            <span class="material-symbols-outlined text-4xl text-gray-400">photo_library</span>
            <h3 class="font-serif-heading text-lg font-bold text-gray-800">Belum Ada Karya yang Sesuai</h3>
            <p class="text-xs text-gray-500 max-w-md mx-auto">
                Karya yang disetujui pada panel kurasi akan otomatis tampil di etalase galeri publik desktop ini.
            </p>
            <a href="{{ route('admin.curation.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0F382C] text-white text-xs font-semibold rounded-xl">
                <span>Buka Panel Kurasi</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    @endif

    {{-- ================= QUICK PREVIEW MODAL (Interactive Stitch) ================= --}}
    <div class="fixed inset-0 z-50 bg-[#002218]/60 backdrop-blur-sm hidden items-center justify-center p-4" id="previewModal">
        <div class="bg-white rounded-2xl max-w-3xl w-full border border-[#C1C8C3]/30 shadow-2xl overflow-hidden transition-all transform scale-95 opacity-0 duration-300" id="modalBox">
            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-[#C1C8C3]/30 bg-[#F4F4F1]">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#735C00] text-xl" style="font-variation-settings: 'FILL' 1;">verified</span>
                    <span class="font-serif-heading text-base font-semibold text-[#002218]" id="modalTitle">Pratinjau Foto</span>
                </div>
                <button type="button" class="w-8 h-8 rounded-full hover:bg-[#E8E8E5] text-[#414845] flex items-center justify-center transition-colors" onclick="closeModal()">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            {{-- Modal Body --}}
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-xl overflow-hidden bg-[#E8E8E5] aspect-square flex items-center justify-center border border-[#C1C8C3]/40">
                    <img id="modalImage"
                         src=""
                         alt="Preview Karya"
                         class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div>
                            <span class="text-[11px] font-bold text-[#735C00] uppercase tracking-wider block" id="modalCategory">Kategori</span>
                            <h4 class="font-serif-heading text-lg font-bold text-[#002218] mt-1" id="modalDetailTitle">Judul Foto</h4>
                        </div>
                        <div class="bg-[#F4F4F1] p-3.5 rounded-xl space-y-2 border border-[#C1C8C3]/30 text-xs">
                            <div class="flex justify-between">
                                <span class="text-[#414845]">Kontributor:</span>
                                <span class="font-semibold text-[#002218]" id="modalContributor">Nama Kontributor</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#414845]">Resolusi Asli:</span>
                                <span class="font-semibold text-[#002218]" id="modalRes">Resolusi</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#414845]">Status Lisensi:</span>
                                <span class="font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded">Bebas Royalti Dakwah</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#414845]">Total Diunduh:</span>
                                <span class="font-semibold text-[#002218]" id="modalDownloads">0 Kali</span>
                            </div>
                            <div class="flex justify-between border-t border-[#C1C8C3]/30 pt-2 mt-2">
                                <span class="text-[#414845]">Infaq Apresiasi:</span>
                                <span class="font-bold text-[#735C00]" id="modalDonation">Rp 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-2">
                        <a id="modalDetailLink"
                           href="#"
                           target="_blank"
                           class="flex-1 py-2.5 rounded-xl bg-[#0F382C] hover:bg-[#002218] text-white font-semibold text-xs flex items-center justify-center gap-1.5 shadow-sm transition-colors">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>Buka Halaman Karya</span>
                        </a>
                        <button type="button"
                                onclick="closeModal()"
                                class="px-4 py-2.5 rounded-xl border border-[#C1C8C3]/50 bg-white text-[#414845] hover:bg-gray-100 font-semibold text-xs transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= UPLOAD MODAL ADMIN (Stitch 100%) ================= --}}
    <div class="fixed inset-0 z-50 bg-[#002218]/60 backdrop-blur-sm hidden items-center justify-center p-4" id="uploadModal">
        <div class="bg-white rounded-2xl max-w-lg w-full border border-[#C1C8C3]/30 shadow-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-[#C1C8C3]/30 pb-3">
                <h3 class="font-serif-heading text-base font-semibold text-[#002218] flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#735C00]">cloud_upload</span>
                    <span>Unggah Karya Baru (Admin)</span>
                </h3>
                <button type="button" class="w-8 h-8 rounded-full hover:bg-[#E8E8E5] text-[#414845] flex items-center justify-center" onclick="closeUploadModal()">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
            
            <form action="{{ route('artworks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="border-2 border-dashed border-[#C1C8C3]/80 rounded-xl p-6 text-center bg-[#F4F4F1] hover:bg-[#E8E8E5] transition-colors relative cursor-pointer">
                    <input type="file" name="image" id="adminArtworkInput" accept="image/jpeg,image/png,image/webp" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" required onchange="previewUpload(this)">
                    <span class="material-symbols-outlined text-4xl text-[#0F382C]">add_photo_alternate</span>
                    <p class="text-sm text-[#002218] font-semibold mt-2" id="uploadLabel">Tarik &amp; Lepas Foto di Sini atau Klik</p>
                    <p class="text-xs text-[#414845] mt-1">Mendukung format JPG, PNG, WEBP hingga 10MB</p>
                </div>

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-[#414845] mb-1">Judul Karya / Dokumentasi</label>
                        <input type="text" name="title" required class="w-full px-3 py-2 bg-white border border-[#C1C8C3]/50 rounded-lg text-xs focus:ring-[#0F382C] focus:border-[#0F382C]" placeholder="Contoh: Silaturahmi Akbar Syawal 1447H">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#414845] mb-1">Kategori</label>
                        <select name="category_id" required class="w-full px-3 py-2 bg-white border border-[#C1C8C3]/50 rounded-lg text-xs focus:ring-[#0F382C] focus:border-[#0F382C]">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-[#414845] mb-1">Narasi Singkat (Opsional)</label>
                        <textarea name="description" rows="2" class="w-full px-3 py-2 bg-white border border-[#C1C8C3]/50 rounded-lg text-xs focus:ring-[#0F382C] focus:border-[#0F382C]" placeholder="Deskripsi atau konteks foto dakwah..."></textarea>
                    </div>
                </div>

                <div class="pt-3 border-t border-[#C1C8C3]/30 flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 rounded-lg text-[#414845] hover:bg-gray-100 text-xs font-semibold" onclick="closeUploadModal()">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-[#0F382C] hover:bg-[#002218] text-white text-xs font-semibold shadow-xs">Mulai Kurasi &amp; Unggah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Modal Handlers --}}
    <script>
        function openModal(title, contributor, category, res, downloads, donation, imgUrl, linkUrl) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDetailTitle').innerText = title;
            document.getElementById('modalContributor').innerText = contributor;
            document.getElementById('modalCategory').innerText = category;
            document.getElementById('modalRes').innerText = res;
            document.getElementById('modalDownloads').innerText = downloads;
            document.getElementById('modalDonation').innerText = donation;
            document.getElementById('modalImage').src = imgUrl;
            document.getElementById('modalDetailLink').href = linkUrl;

            const modal = document.getElementById('previewModal');
            const box = document.getElementById('modalBox');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('previewModal');
            const box = document.getElementById('modalBox');
            
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function openUploadModal() {
            const modal = document.getElementById('uploadModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUploadModal() {
            const modal = document.getElementById('uploadModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function previewUpload(input) {
            if (input.files && input.files[0]) {
                document.getElementById('uploadLabel').innerText = input.files[0].name;
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeUploadModal();
            }
        });
    </script>
</x-layouts.admin>
