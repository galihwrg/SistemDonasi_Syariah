<x-layouts.admin title="Kurasi & Antrean Foto Umat — Admin Kuantum Pelopor">

    {{-- Flash Notifications --}}
    @if (session('success'))
        <div class="rounded-xl p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600 text-lg" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    {{-- ================= 1. HEADER SECTION ================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-serif-heading text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                Kurasi &amp; Antrean Foto Umat
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Tinjau kiriman visual santri, mahasiswa, dan jamaah sebelum diterbitkan ke galeri publik Kuantum Pelopor.
            </p>
        </div>
        <div>
            <a href="{{ route('admin.curation.index') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-300 rounded-lg text-xs sm:text-sm font-medium text-gray-700 shadow-xs hover:bg-gray-50 active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[18px] text-gray-600">rotate_right</span>
                <span>Segarkan Antrean</span>
            </a>
        </div>
    </div>

    {{-- ================= 2. METRIC SUMMARY CARDS (Sesuai Stitch) ================= --}}
    <section aria-label="Ringkasan Status" class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        {{-- Card 1: Menunggu Review --}}
        <div class="bg-white rounded-xl border border-[#E8E8E4] p-5 shadow-xs flex justify-between items-start">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-gray-500 tracking-wide uppercase">Menunggu Review</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">{{ $metrics['pending'] }}</span>
                    <span class="text-xs text-gray-500 font-medium">foto baru</span>
                </div>
                <div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#FEF3C7] text-[#92400E]">
                        Perlu Tindakan
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#FEF9C3] flex items-center justify-center text-[#A16207]">
                <span class="material-symbols-outlined text-[24px]">hourglass_top</span>
            </div>
        </div>

        {{-- Card 2: Disetujui / Tayang --}}
        <div class="bg-white rounded-xl border border-[#E8E8E4] p-5 shadow-xs flex justify-between items-start">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-gray-500 tracking-wide uppercase">Disetujui / Tayang</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">{{ $metrics['approved'] }}</span>
                    <span class="text-xs text-gray-500 font-medium">karya tayang</span>
                </div>
                <div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#DCFCE7] text-[#166534]">
                        Galeri Aktif
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#DCFCE7] flex items-center justify-center text-[#15803D]">
                <span class="material-symbols-outlined text-[24px]" style="font-variation-settings: 'FILL' 1;">verified</span>
            </div>
        </div>

        {{-- Card 3: Ditolak --}}
        <div class="bg-white rounded-xl border border-[#E8E8E4] p-5 shadow-xs flex justify-between items-start">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-gray-500 tracking-wide uppercase">Ditolak</span>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">{{ $metrics['rejected'] }}</span>
                    <span class="text-xs text-gray-500 font-medium">foto</span>
                </div>
                <div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-[#FEE2E2] text-[#991B1B]">
                        Tidak Sesuai Etika
                    </span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-[#FEE2E2] flex items-center justify-center text-[#DC2626]">
                <span class="material-symbols-outlined text-[24px]">cancel</span>
            </div>
        </div>
    </section>

    {{-- ================= 3. FILTER & SEARCH TOOLBAR ================= --}}
    <section class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
        {{-- Filter Status Tabs --}}
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            @php
                $statuses = [
                    'all' => ['label' => 'Semua (' . $metrics['total'] . ')', 'val' => 'all'],
                    'pending' => ['label' => 'Menunggu Review (' . $metrics['pending'] . ')', 'val' => 'pending'],
                    'approved' => ['label' => 'Disetujui (' . $metrics['approved'] . ')', 'val' => 'approved'],
                    'rejected' => ['label' => 'Ditolak (' . $metrics['rejected'] . ')', 'val' => 'rejected'],
                ];
            @endphp
            @foreach ($statuses as $key => $st)
                @php
                    $isActive = ($statusFilter === $st['val']);
                @endphp
                <a href="{{ route('admin.curation.index', array_filter(['status' => $st['val'] !== 'all' ? $st['val'] : null, 'kategori' => $categoryFilter, 'q' => $searchQuery])) }}"
                   class="px-4 py-1.5 rounded-lg text-xs font-medium transition-colors {{ $isActive ? 'bg-[#0F382C] text-white shadow-xs' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    {{ $st['label'] }}
                </a>
            @endforeach
        </div>

        {{-- Search Input & Category Dropdown --}}
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.curation.index') }}" method="GET" class="relative flex-1 sm:w-64">
                @if ($statusFilter !== 'all')
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                @endif
                @if ($categoryFilter)
                    <input type="hidden" name="kategori" value="{{ $categoryFilter }}">
                @endif
                <span class="material-symbols-outlined text-gray-400 text-[18px] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                <input class="w-full pl-9 pr-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#0F382C] focus:border-[#0F382C]"
                       name="q"
                       value="{{ $searchQuery ?? '' }}"
                       placeholder="Cari judul atau pengunggah..."
                       type="text">
            </form>

            {{-- Category Filter Dropdown --}}
            <form id="category-filter-form" action="{{ route('admin.curation.index') }}" method="GET">
                @if ($statusFilter !== 'all')
                    <input type="hidden" name="status" value="{{ $statusFilter }}">
                @endif
                @if ($searchQuery)
                    <input type="hidden" name="q" value="{{ $searchQuery }}">
                @endif
                <select name="kategori"
                        onchange="document.getElementById('category-filter-form').submit()"
                        class="px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-medium text-gray-700 hover:bg-gray-50 cursor-pointer focus:outline-none focus:border-[#0F382C]">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $categoryFilter === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </section>

    {{-- ================= 4. DAFTAR ANTREAN MODERASI ================= --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between pb-1">
            <h2 class="text-base font-bold text-gray-900 tracking-tight">Daftar Antrean Moderasi</h2>
            <span class="text-xs text-gray-500 font-medium">Menampilkan {{ $artworks->count() }} karya</span>
        </div>

        <div class="space-y-3.5">
            @forelse ($artworks as $art)
                @php
                    $imgUrl = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                        ? $art->image_path 
                        : asset('storage/' . $art->image_path);
                    $uploaderName = $art->user->name ?? 'Kontributor Anonim';
                    $uploaderCampus = $art->user->campus_name ?? ($art->user->user_type === 'mahasiswa' ? 'Mahasiswa Terdaftar' : 'Masyarakat Umum');
                @endphp
                <article class="bg-white border border-[#E8E8E4] rounded-xl p-4 sm:p-5 shadow-xs hover:shadow-sm transition-shadow flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        {{-- Thumbnail Foto --}}
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-200">
                            <img alt="{{ $art->title }}" class="w-full h-full object-cover" src="{{ $imgUrl }}">
                        </div>

                        {{-- Metadata & Narasi --}}
                        <div class="space-y-1.5 max-w-xl">
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                @if ($art->status === 'approved')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-[#DCFCE7] text-[#166534]">
                                        <span class="material-symbols-outlined text-[13px] mr-1">check</span> Disetujui
                                    </span>
                                @elseif ($art->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-[#FEF3C7] text-[#92400E]">
                                        <span class="material-symbols-outlined text-[13px] mr-1">hourglass_top</span> Menunggu Review
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-[#FEE2E2] text-[#991B1B]">
                                        <span class="material-symbols-outlined text-[13px] mr-1">cancel</span> Ditolak
                                    </span>
                                @endif

                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-700">
                                    {{ $art->category->name ?? 'Dakwah' }}
                                </span>
                                <span class="text-gray-400 text-[11px]">
                                    • {{ $art->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="font-serif-heading text-base font-bold text-gray-900 leading-snug">
                                {{ $art->title }}
                            </h3>

                            <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">
                                {{ $art->narration ?? 'Dokumentasi visual dakwah pererat ukhuwah keumatan nusantara.' }}
                            </p>

                            @if ($art->status === 'rejected' && $art->rejection_reason)
                                <div class="p-2 rounded-lg bg-red-50 border border-red-200 text-red-700 text-[11px]">
                                    <strong>Alasan Penolakan:</strong> {{ $art->rejection_reason }}
                                </div>
                            @endif

                            <div class="flex items-center text-xs text-gray-500 pt-0.5">
                                <span class="material-symbols-outlined text-[14px] text-gray-400 mr-1">person</span>
                                <span class="font-medium text-gray-700">{{ $uploaderName }}</span>
                                <span class="mx-1.5 text-gray-300">|</span>
                                <span>{{ $uploaderCampus }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2 self-end md:self-center flex-shrink-0 pt-2 md:pt-0">
                        @if ($art->status === 'pending')
                            {{-- Form Setujui --}}
                            <form action="{{ route('admin.curation.approve', $art->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#0F382C] text-white rounded-lg text-xs font-medium hover:bg-[#0c2e24] shadow-xs active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-[14px] text-[#FED65B]">check</span>
                                    <span>Setujui</span>
                                </button>
                            </form>

                            {{-- Tombol Tolak (Buka Modal) --}}
                            <button type="button"
                                    onclick="openRejectModal({{ $art->id }}, '{{ addslashes($art->title) }}')"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-red-200 text-red-700 rounded-lg text-xs font-medium hover:bg-red-50 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[14px]">close</span>
                                <span>Tolak</span>
                            </button>
                        @elseif ($art->status === 'approved')
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-medium">
                                <span class="material-symbols-outlined text-[14px] text-emerald-600">public</span>
                                <span>Tayang di Galeri</span>
                            </span>

                            <form action="{{ route('admin.curation.reject', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda ingin mencabut persetujuan dan menolak karya ini?')">
                                @csrf
                                <input type="hidden" name="rejection_reason" value="Pencabutan persetujuan tayang oleh admin.">
                                <button type="submit" class="px-2.5 py-1.5 bg-white border border-gray-300 text-gray-600 rounded-lg text-xs hover:bg-gray-50">
                                    Batalkan
                                </button>
                            </form>
                        @else
                            {{-- Rejected: Boleh disetujui ulang jika revisi terpenuhi --}}
                            <form action="{{ route('admin.curation.approve', $art->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#0F382C] text-white rounded-lg text-xs font-medium hover:bg-[#0c2e24]">
                                    <span class="material-symbols-outlined text-[14px]">published_with_changes</span>
                                    <span>Setujui Kembali</span>
                                </button>
                            </form>
                        @endif

                        {{-- Tombol Buka Detail / Pratinjau Cepat --}}
                        <button type="button"
                                onclick="openDetailModal({
                                    id: {{ $art->id }},
                                    title: '{{ addslashes($art->title) }}',
                                    uploader: '{{ addslashes($uploaderName) }}',
                                    campus: '{{ addslashes($uploaderCampus) }}',
                                    category: '{{ addslashes($art->category->name ?? 'Dakwah') }}',
                                    dimensions: '{{ addslashes($art->dimensions ?? '3840 x 2160 px') }}',
                                    narration: '{{ addslashes($art->narration ?? '-') }}',
                                    quranRef: '{{ addslashes($art->quran_reference ?? '-') }}',
                                    quranArabic: '{{ addslashes($art->quran_arabic ?? '') }}',
                                    quranTrans: '{{ addslashes($art->quran_translation ?? '') }}',
                                    imageUrl: '{{ addslashes($imgUrl) }}',
                                    status: '{{ $art->status }}'
                                })"
                                class="p-1.5 text-gray-400 hover:text-[#0F382C] rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors"
                                title="Buka Detail Karya">
                            <span class="material-symbols-outlined text-[18px]">zoom_in</span>
                        </button>
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center space-y-2">
                    <span class="material-symbols-outlined text-4xl text-gray-400">task_alt</span>
                    <h3 class="font-serif-heading text-base font-bold text-gray-900">Tidak Ada Antrean Foto</h3>
                    <p class="text-xs text-gray-500">Semua kiriman visual telah dimoderasi dengan baik.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination Links --}}
        <div class="pt-4">
            {{ $artworks->links() }}
        </div>
    </section>

    {{-- ================= 5. MODAL DETAIL PRATINJAU KARYA ================= --}}
    <div id="detailModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-3xl w-full border border-gray-200 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-200 bg-[#F9F9F6]">
                <h3 class="font-serif-heading text-base font-semibold text-[#0F382C]" id="modal-detail-title">Detail Foto</h3>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center text-gray-600">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <div class="p-5 overflow-y-auto grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="rounded-xl overflow-hidden bg-gray-100 aspect-square border border-gray-200 flex items-center justify-center">
                    <img id="modal-detail-img" src="" alt="Pratinjau" class="w-full h-full object-cover">
                </div>

                <div class="space-y-3 text-xs leading-relaxed">
                    <div>
                        <span id="modal-detail-category" class="px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold uppercase text-[10px]"></span>
                        <h4 id="modal-detail-heading" class="font-serif-heading text-lg font-bold text-gray-900 mt-1"></h4>
                        <p id="modal-detail-uploader" class="text-gray-500 mt-0.5"></p>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 space-y-1">
                        <span class="font-semibold text-gray-700 block">Refleksi / Narasi Hikmah:</span>
                        <p id="modal-detail-narration" class="text-gray-600 whitespace-pre-line"></p>
                    </div>

                    <div id="modal-detail-quran-box" class="p-3 bg-[#FEF9C3]/40 rounded-xl border border-amber-200 space-y-1">
                        <span id="modal-detail-quran-ref" class="font-bold text-[#92400E] block text-[11px]"></span>
                        <p id="modal-detail-quran-arabic" class="font-serif text-right text-base text-gray-900" dir="rtl"></p>
                        <p id="modal-detail-quran-trans" class="text-gray-600 italic text-[11px]"></p>
                    </div>

                    <div class="text-[11px] text-gray-500 pt-1">
                        <span>Dimensi Resolusi Asli: </span><strong id="modal-detail-res" class="text-gray-800"></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= 6. MODAL ALASAN PENOLAKAN KARYA ================= --}}
    <div id="rejectModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full border border-gray-200 shadow-2xl p-5 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="font-serif-heading text-base font-bold text-red-700 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">error</span>
                    <span>Tolak Foto Karya Dakwah</span>
                </h3>
                <button type="button" onclick="closeRejectModal()" class="w-7 h-7 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <form id="reject-form" method="POST" action="">
                @csrf
                <div class="space-y-3">
                    <p class="text-xs text-gray-600">
                        Berikan alasan penolakan untuk karya: <strong id="reject-artwork-title" class="text-gray-900"></strong>
                    </p>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1" for="reason">Alasan Penolakan (Syariah/Kualitas/Etika):</label>
                        <textarea name="rejection_reason"
                                  id="reason"
                                  rows="3"
                                  required
                                  class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-900 focus:outline-none focus:border-[#0F382C] focus:bg-white resize-none"
                                  placeholder="Contoh: Resolusi foto terlalu rendah, mengandung unsur hak cipta tanpa izin, atau tidak sesuai panduan etika dakwah."></textarea>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-3.5 py-1.5 rounded-lg border border-gray-300 text-xs font-medium text-gray-600 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-xs">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Modal Interaktif --}}
    <script>
        function openDetailModal(data) {
            document.getElementById('modal-detail-title').innerText = data.title;
            document.getElementById('modal-detail-heading').innerText = data.title;
            document.getElementById('modal-detail-uploader').innerText = `${data.uploader} • ${data.campus}`;
            document.getElementById('modal-detail-category').innerText = data.category;
            document.getElementById('modal-detail-narration').innerText = data.narration;
            document.getElementById('modal-detail-res').innerText = data.dimensions;
            document.getElementById('modal-detail-img').src = data.imageUrl;

            const quranBox = document.getElementById('modal-detail-quran-box');
            if (data.quranRef !== '-' || data.quranArabic) {
                quranBox.classList.remove('hidden');
                document.getElementById('modal-detail-quran-ref').innerText = data.quranRef;
                document.getElementById('modal-detail-quran-arabic').innerText = data.quranArabic;
                document.getElementById('modal-detail-quran-trans').innerText = data.quranTrans ? `"${data.quranTrans}"` : '';
            } else {
                quranBox.classList.add('hidden');
            }

            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        }

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        function openRejectModal(id, title) {
            document.getElementById('reject-artwork-title').innerText = title;
            document.getElementById('reject-form').action = `/admin/kurasi/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeDetailModal();
                closeRejectModal();
            }
        });
    </script>

</x-layouts.admin>
