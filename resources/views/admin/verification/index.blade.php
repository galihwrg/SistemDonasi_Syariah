<x-layouts.admin title="Konfirmasi Akun & Verifikasi Identitas — Admin Kuantum Pelopor">

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

    {{-- ================= 1. HEADER SECTION (Sesuai Stitch) ================= --}}
    <section class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2 border-b border-gray-200">
        <div>
            <h1 class="font-serif-heading text-2xl sm:text-3xl text-[#0F382C] tracking-tight font-bold">
                Konfirmasi Akun
            </h1>
            <p class="text-xs sm:text-sm text-gray-600 max-w-2xl mt-1">
                Tinjau dan verifikasi data identitas kontributor/pengguna baru (Mahasiswa &amp; Umum) sebelum membuka akses rekening penyaluran donasi.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.verification.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-[#0F382C] text-xs sm:text-sm font-semibold shadow-xs transition-all active:scale-95"
               id="btn-refresh">
                <span class="material-symbols-outlined text-lg text-gray-600">rotate_right</span>
                <span>Segarkan Antrean</span>
            </a>
        </div>
    </section>

    {{-- ================= 2. METRIC SUMMARY CARDS (3 Kartu Sesuai Stitch) ================= --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Card 1: Menunggu Verifikasi --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs relative overflow-hidden flex items-center justify-between">
            <div class="space-y-1.5">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#FEF3C7] text-[#92400E] text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Perlu Tindakan
                    </span>
                </div>
                <p class="font-serif-heading text-3xl font-bold text-[#0F382C] leading-none">
                    {{ $metrics['pending'] }}
                </p>
                <p class="text-xs text-gray-500 font-medium">Menunggu Verifikasi</p>
            </div>
            <div class="w-14 h-14 rounded-full bg-[#FEF3C7] text-[#92400E] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">pending_actions</span>
            </div>
        </div>

        {{-- Card 2: Terverifikasi / Aktif --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex items-center justify-between">
            <div class="space-y-1.5">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#DCFCE7] text-[#166534] text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Terverifikasi / Aktif
                    </span>
                </div>
                <p class="font-serif-heading text-3xl font-bold text-[#0F382C] leading-none">
                    {{ $metrics['approved'] }}
                </p>
                <p class="text-xs text-gray-500 font-medium">Akun Aktif Berdakwah</p>
            </div>
            <div class="w-14 h-14 rounded-full bg-[#DCFCE7] text-[#15803D] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">verified</span>
            </div>
        </div>

        {{-- Card 3: Ditolak / Revisi --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex items-center justify-between">
            <div class="space-y-1.5">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#FEE2E2] text-red-700 text-[11px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>Revisi Dokumen
                    </span>
                </div>
                <p class="font-serif-heading text-3xl font-bold text-[#0F382C] leading-none">
                    {{ $metrics['rejected'] }}
                </p>
                <p class="text-xs text-gray-500 font-medium">Ditolak / Perlu Perbaikan</p>
            </div>
            <div class="w-14 h-14 rounded-full bg-[#FEE2E2] text-red-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-3xl">cancel</span>
            </div>
        </div>
    </section>

    {{-- ================= 3. FILTER & PENCARIAN (Sesuai Stitch) ================= --}}
    <section class="bg-[#F4F4F1] p-4 md:p-5 rounded-2xl border border-gray-200 space-y-4 shadow-2xs">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            
            {{-- Horizontal Filter Tabs --}}
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 lg:pb-0 no-scrollbar">
                @php
                    $tabs = [
                        'all' => 'Semua (' . $metrics['total'] . ')',
                        'pending' => 'Menunggu Verifikasi (' . $metrics['pending'] . ')',
                        'mahasiswa' => 'Mahasiswa (KTM)',
                        'umum' => 'Umum (KTP)',
                        'approved' => 'Terverifikasi',
                    ];
                @endphp
                @foreach ($tabs as $key => $label)
                    @php $isActive = ($statusFilter === $key); @endphp
                    <a href="{{ route('admin.verification.index', array_filter(['status' => $key !== 'all' ? $key : null, 'type' => $typeFilter, 'q' => $searchQuery])) }}"
                       class="px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap transition-colors {{ $isActive ? 'bg-[#0F382C] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Dropdown Type & Search Box --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                {{-- Dropdown Filter Tipe Akun --}}
                <form id="type-filter-form" action="{{ route('admin.verification.index') }}" method="GET" class="relative min-w-[170px]">
                    @if ($statusFilter !== 'all')
                        <input type="hidden" name="status" value="{{ $statusFilter }}">
                    @endif
                    @if ($searchQuery)
                        <input type="hidden" name="q" value="{{ $searchQuery }}">
                    @endif
                    <select name="type"
                            onchange="document.getElementById('type-filter-form').submit()"
                            class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2 text-xs font-medium text-gray-800 focus:outline-none focus:border-[#0F382C] shadow-2xs cursor-pointer">
                        <option value="">Semua Tipe Akun</option>
                        <option value="mahasiswa" {{ $typeFilter === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa (KTM)</option>
                        <option value="umum" {{ $typeFilter === 'umum' ? 'selected' : '' }}>Umum (KTP)</option>
                    </select>
                </form>

                {{-- Search Box --}}
                <form action="{{ route('admin.verification.index') }}" method="GET" class="relative min-w-[260px] lg:min-w-[320px]">
                    @if ($statusFilter !== 'all')
                        <input type="hidden" name="status" value="{{ $statusFilter }}">
                    @endif
                    @if ($typeFilter)
                        <input type="hidden" name="type" value="{{ $typeFilter }}">
                    @endif
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg pointer-events-none">search</span>
                    <input class="w-full bg-white border border-gray-300 rounded-xl pl-9 pr-4 py-2 text-xs text-gray-900 placeholder:text-gray-400 focus:outline-none focus:border-[#0F382C] shadow-2xs"
                           placeholder="Cari nama, email, kampus, atau NIM/NIK..."
                           name="q"
                           value="{{ $searchQuery ?? '' }}"
                           type="text">
                </form>
            </div>

        </div>
    </section>

    {{-- ================= 4. DAFTAR ANTREAN AKUN PENGGUNA ================= --}}
    <section class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h2 class="font-serif-heading text-lg font-bold text-[#0F382C] flex items-center gap-2">
                <span>Antrean Berkas Konfirmasi</span>
                <span class="text-xs bg-[#c1ecda] text-[#0F382C] px-2.5 py-0.5 rounded-full font-bold">
                    {{ $verifications->count() }} Antrean
                </span>
            </h2>
            <span class="text-xs text-gray-500">Diurutkan: Terbaru ke Terlama</span>
        </div>

        <div class="space-y-3.5">
            @forelse ($verifications as $verif)
                @php
                    $user = $verif->user;
                    $userName = $user->name ?? 'Pengguna';
                    $userInitials = strtoupper(substr($userName, 0, 2));
                    $isMahasiswa = ($verif->id_type === 'ktm');
                    $docUrl = filter_var($verif->document_path, FILTER_VALIDATE_URL) 
                        ? $verif->document_path 
                        : asset('storage/' . $verif->document_path);
                    $institution = $verif->campus_name ?? $user->campus_name ?? ($isMahasiswa ? 'Perguruan Tinggi' : 'Masyarakat Umum');
                @endphp
                <article class="bg-white rounded-2xl p-5 border border-gray-200 hover:border-[#0F382C]/40 transition-all shadow-xs flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5 group">
                    <div class="flex items-start gap-4">
                        {{-- Avatar Inisial --}}
                        <div class="w-12 h-12 rounded-xl {{ $isMahasiswa ? 'bg-[#0F382C] text-[#FED65B]' : 'bg-gray-100 text-[#0F382C]' }} flex items-center justify-center font-bold text-base shrink-0 shadow-xs">
                            {{ $userInitials }}
                        </div>

                        {{-- Data Kontributor & Identitas --}}
                        <div class="space-y-1.5 max-w-xl">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-serif-heading text-base font-bold text-gray-900 leading-snug">
                                    {{ $userName }}
                                </h3>

                                @if ($isMahasiswa)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#c1ecda]/60 text-[#0F382C] text-[11px] font-bold">
                                        <span class="material-symbols-outlined text-xs">school</span>
                                        Mahasiswa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#FED65B]/40 text-[#735C00] text-[11px] font-bold">
                                        <span class="material-symbols-outlined text-xs">person</span>
                                        Umum
                                    </span>
                                @endif

                                @if ($verif->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#DCFCE7] text-[#166534] text-[10px] font-semibold">
                                        <span class="material-symbols-outlined text-[12px]">verified</span> Terverifikasi
                                    </span>
                                @elseif ($verif->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#FEF3C7] text-[#92400E] text-[10px] font-semibold">
                                        <span class="material-symbols-outlined text-[12px]">hourglass_top</span> Menunggu
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-[#FEE2E2] text-[#991B1B] text-[10px] font-semibold">
                                        <span class="material-symbols-outlined text-[12px]">cancel</span> Ditolak
                                    </span>
                                @endif

                                <span class="text-xs text-gray-400">
                                    {{ $verif->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-gray-600">
                                <span class="flex items-center gap-1 text-[#0F382C] font-semibold">
                                    <span class="material-symbols-outlined text-[16px] text-gray-400">apartment</span>
                                    {{ $institution }}
                                </span>
                                <span class="flex items-center gap-1 font-mono text-[11px] bg-gray-100 px-2 py-0.5 rounded text-gray-800">
                                    {{ $isMahasiswa ? 'NIM: ' : 'NIK: ' }} {{ $verif->id_number }}
                                </span>
                                <span class="flex items-center gap-1 text-gray-500">
                                    <span class="material-symbols-outlined text-[16px] text-[#735C00]">attachment</span>
                                    Dokumen {{ strtoupper($verif->id_type) }} terlampir
                                </span>
                            </div>

                            @if ($verif->status === 'rejected' && $verif->admin_notes)
                                <div class="mt-1 p-2 rounded-lg bg-red-50 border border-red-200 text-red-700 text-xs">
                                    <strong>Catatan Evaluasi Admin:</strong> {{ $verif->admin_notes }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2.5 w-full lg:w-auto pt-3 lg:pt-0 border-t lg:border-t-0 border-gray-200 justify-end shrink-0">
                        {{-- Tombol Tinjau Berkas & Detail (Drawer Modal) --}}
                        <button type="button"
                                onclick="openVerificationModal({
                                    id: {{ $verif->id }},
                                    name: '{{ addslashes($userName) }}',
                                    email: '{{ addslashes($user->email ?? '-') }}',
                                    phone: '{{ addslashes($user->phone_number ?? '-') }}',
                                    type: '{{ $isMahasiswa ? 'Mahasiswa' : 'Umum' }}',
                                    idType: '{{ strtoupper($verif->id_type) }}',
                                    idNumber: '{{ addslashes($verif->id_number) }}',
                                    institution: '{{ addslashes($institution) }}',
                                    docUrl: '{{ addslashes($docUrl) }}',
                                    status: '{{ $verif->status }}',
                                    notes: '{{ addslashes($verif->admin_notes ?? '') }}',
                                    approveUrl: '{{ route('admin.verification.approve', $verif->id) }}',
                                    rejectUrl: '{{ route('admin.verification.reject', $verif->id) }}'
                                })"
                                class="px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-[#0F382C] text-xs font-semibold transition-colors flex items-center gap-1.5 border border-gray-300">
                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                            <span>Tinjau Berkas &amp; Detail</span>
                        </button>

                        @if ($verif->status === 'pending')
                            {{-- Setujui Cepat --}}
                            <form action="{{ route('admin.verification.approve', $verif->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 rounded-xl bg-[#0F382C] hover:bg-[#1a5c44] text-white text-xs font-semibold transition-all shadow-xs active:scale-95 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-base text-[#FED65B]">check</span>
                                    <span>Setujui</span>
                                </button>
                            </form>

                            {{-- Tolak Cepat --}}
                            <button type="button"
                                    onclick="openRejectModal({{ $verif->id }}, '{{ addslashes($userName) }}')"
                                    class="px-3 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition-colors text-xs font-semibold flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">close</span>
                                <span>Tolak</span>
                            </button>
                        @elseif ($verif->status === 'approved')
                            <span class="inline-flex items-center gap-1 px-3 py-2 bg-[#DCFCE7] text-[#166534] rounded-xl text-xs font-semibold">
                                <span class="material-symbols-outlined text-base">task_alt</span>
                                <span>Rekening Aktif</span>
                            </span>
                        @else
                            {{-- Status Ditolak: Boleh diverifikasi ulang --}}
                            <form action="{{ route('admin.verification.approve', $verif->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-3.5 py-2 rounded-xl bg-[#0F382C] text-white hover:bg-[#1a5c44] text-xs font-medium">
                                    <span>Verifikasi Ulang</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-2xl border border-gray-200 p-12 text-center space-y-2">
                    <span class="material-symbols-outlined text-4xl text-gray-400">verified_user</span>
                    <h3 class="font-serif-heading text-base font-bold text-gray-900">Tidak Ada Antrean Verifikasi</h3>
                    <p class="text-xs text-gray-500">Seluruh pengajuan verifikasi dokumen telah selesai diproses.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pt-4">
            {{ $verifications->links() }}
        </div>
    </section>

    {{-- ================= 5. MODAL DETAIL & PRATINJAU DOKUMEN (Sesuai Stitch) ================= --}}
    <div id="verification-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full border border-gray-200 shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            
            {{-- Modal Header --}}
            <div class="p-5 border-b border-gray-200 flex items-center justify-between bg-[#F9F9F6]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0F382C] text-[#FED65B] flex items-center justify-center font-bold text-sm" id="vm-avatar">
                        FS
                    </div>
                    <div>
                        <h3 class="font-serif-heading text-base font-bold text-[#0F382C]" id="vm-name">Nama Kontributor</h3>
                        <p class="text-xs text-gray-500" id="vm-subtitle">Mahasiswa • Universitas Gadjah Mada</p>
                    </div>
                </div>
                <button type="button" onclick="closeVerificationModal()" class="w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center text-gray-500">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-5 overflow-y-auto space-y-4">
                {{-- Data Ringkas Kontak --}}
                <div class="grid grid-cols-2 gap-3 p-3.5 bg-[#F4F4F1] rounded-2xl text-xs">
                    <div>
                        <span class="text-gray-500 block">Email Akun:</span>
                        <strong class="text-gray-900 block mt-0.5" id="vm-email">-</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Nomor WhatsApp:</span>
                        <strong class="text-gray-900 block mt-0.5" id="vm-phone">-</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Jenis &amp; Nomor Identitas:</span>
                        <strong class="text-[#0F382C] block mt-0.5 font-mono" id="vm-id-number">-</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Status Pengajuan:</span>
                        <span class="inline-block mt-0.5 font-bold uppercase text-[11px]" id="vm-status">-</span>
                    </div>
                </div>

                {{-- Dokumen KTM/KTP Preview --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-700 block">Berkas Dokumen Identitas:</label>
                    <div class="relative rounded-2xl border border-gray-300 overflow-hidden bg-gray-100 group aspect-4/3 flex items-center justify-center">
                        <img id="vm-doc-img" src="" alt="Dokumen Identitas" class="w-full h-full object-cover">
                        
                        <div class="absolute bottom-3 left-3 right-3 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl border border-gray-200 flex items-center justify-between text-xs">
                            <span class="font-semibold text-gray-800" id="vm-doc-label">Dokumen Identitas</span>
                            <a id="vm-doc-full" href="#" target="_blank" class="text-[#0F382C] hover:underline font-bold flex items-center gap-1">
                                <span>Buka Penuh</span>
                                <span class="material-symbols-outlined text-sm">open_in_new</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Catatan Validasi Kampus / Admin --}}
                <div class="p-3 bg-[#FEF3C7]/40 border border-[#FEF3C7] rounded-xl flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#92400E] text-2xl">fact_check</span>
                    <div class="text-xs text-gray-800">
                        <span class="font-bold text-[#0F382C]">Validasi Pangkalan Data:</span> Pastikan nama lengkap, foto, dan nomor identitas jelas terbaca sebelum menyetujui akses rekening donasi.
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="p-4 border-t border-gray-200 bg-[#F9F9F6] flex flex-col sm:flex-row items-center justify-between gap-3">
                <button type="button" onclick="closeVerificationModal()" class="w-full sm:w-auto px-4 py-2 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold">
                    Tutup Dialog
                </button>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="button" id="vm-btn-reject" class="w-full sm:w-auto px-3.5 py-2 rounded-xl text-red-600 hover:bg-red-50 border border-red-200 text-xs font-semibold flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-base">close</span>
                        <span>Tolak</span>
                    </button>
                    <form id="vm-approve-form" method="POST" action="" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-[#0F382C] hover:bg-[#1a5c44] text-white text-xs font-bold shadow-xs flex items-center justify-center gap-1.5">
                            <span class="material-symbols-outlined text-base text-[#FED65B]">task_alt</span>
                            <span>Setujui &amp; Aktifkan Akun</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= 6. MODAL ALASAN PENOLAKAN VERIFIKASI ================= --}}
    <div id="rejectModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full border border-gray-200 shadow-2xl p-5 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="font-serif-heading text-base font-bold text-red-700 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-lg">error</span>
                    <span>Tolak Pengajuan Verifikasi</span>
                </h3>
                <button type="button" onclick="closeRejectModal()" class="w-7 h-7 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-500">
                    <span class="material-symbols-outlined text-base">close</span>
                </button>
            </div>

            <form id="reject-form" method="POST" action="">
                @csrf
                <div class="space-y-3">
                    <p class="text-xs text-gray-600">
                        Pengguna: <strong id="reject-user-name" class="text-gray-900"></strong>
                    </p>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1" for="admin_notes">
                            Catatan Alasan Penolakan / Permintaan Revisi:
                        </label>
                        <textarea name="admin_notes"
                                  id="admin_notes"
                                  rows="3"
                                  required
                                  class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs text-gray-900 focus:outline-none focus:border-[#0F382C] focus:bg-white resize-none"
                                  placeholder="Contoh: Foto KTM buram tidak terbaca, masa berlaku kartu telah habis, atau nama di kartu tidak sesuai nama akun."></textarea>
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
        function openVerificationModal(data) {
            document.getElementById('vm-name').innerText = data.name;
            document.getElementById('vm-avatar').innerText = data.name.substring(0, 2).toUpperCase();
            document.getElementById('vm-subtitle').innerText = `${data.type} • ${data.institution}`;
            document.getElementById('vm-email').innerText = data.email;
            document.getElementById('vm-phone').innerText = data.phone;
            document.getElementById('vm-id-number').innerText = `${data.idType}: ${data.idNumber}`;
            document.getElementById('vm-status').innerText = data.status;
            document.getElementById('vm-doc-img').src = data.docUrl;
            document.getElementById('vm-doc-full').href = data.docUrl;
            document.getElementById('vm-approve-form').action = data.approveUrl;

            const btnReject = document.getElementById('vm-btn-reject');
            btnReject.onclick = function() {
                closeVerificationModal();
                openRejectModal(data.id, data.name);
            };

            document.getElementById('verification-modal').classList.remove('hidden');
            document.getElementById('verification-modal').classList.add('flex');
        }

        function closeVerificationModal() {
            document.getElementById('verification-modal').classList.add('hidden');
            document.getElementById('verification-modal').classList.remove('flex');
        }

        function openRejectModal(id, name) {
            document.getElementById('reject-user-name').innerText = name;
            document.getElementById('reject-form').action = `/admin/verifikasi/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
            document.getElementById('rejectModal').classList.add('flex');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('rejectModal').classList.remove('flex');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeVerificationModal();
                closeRejectModal();
            }
        });
    </script>

</x-layouts.admin>
