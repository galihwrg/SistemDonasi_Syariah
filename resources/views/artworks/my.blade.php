<x-layouts.app title="Postingan Saya — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-5">

        {{-- Top Navigation & Header --}}
        <div class="flex items-center justify-between pb-2 border-b border-[#dadad7]/50">
            <div class="flex items-center gap-3">
                <a href="{{ route('profile') }}"
                   class="w-9 h-9 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#1a1c1b] hover:bg-[#e2e3e0] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div>
                    <h1 class="font-serif text-[18px] text-[#0f382c] tracking-tight font-bold">
                        Postingan Saya
                    </h1>
                    <p class="text-[11px] text-[#414845]">Kelola karya visual &amp; pantau perolehan infaq</p>
                </div>
            </div>

            <a href="{{ route('unggah') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] active:scale-95 transition-all shadow-xs">
                <span class="material-symbols-outlined text-sm text-[#fed65b]">add</span>
                <span>Unggah</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="rounded-xl p-3 bg-[#c1ecda]/40 border border-[#a6d0be] text-[#002117] text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-base text-[#0f382c]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ================= 1. REKAPITULASI STATISTIK KONTRIBUTOR ================= --}}
        <div class="grid grid-cols-2 gap-3">
            {{-- Total Saldo Infaq Terkumpul --}}
            <div class="col-span-2 bg-gradient-to-br from-[#0f382c] to-[#1a5c44] rounded-2xl p-4 text-white shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-[11px] text-[#c1ecda] uppercase tracking-wider font-semibold block">Total Infaq Apresiasi Terkumpul</span>
                    <span class="font-serif text-2xl font-bold text-[#fed65b] block mt-1">
                        Rp {{ number_format($totalSaldoInfaq, 0, ',', '.') }}
                    </span>
                    <p class="text-[10px] text-white/80 mt-1 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px] text-[#fed65b]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Pencairan disalurkan berkala ke rekening terverifikasi
                    </p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-[#fed65b] shrink-0 border border-white/10">
                    <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
                </div>
            </div>

            {{-- Stat Box 1: Total Unduhan --}}
            <div class="bg-white rounded-2xl p-3.5 border border-[#c1c8c3]/40 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-[#717975] uppercase tracking-wider font-medium block">Telah Diunduh</span>
                    <span class="font-serif text-lg font-bold text-[#0f382c] block mt-0.5">
                        {{ number_format($totalDownloads, 0, ',', '.') }}
                    </span>
                    <span class="text-[9.5px] text-[#414845]">Pemanfaatan Dakwah</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-[#eeeeeb] flex items-center justify-center text-[#0f382c]">
                    <span class="material-symbols-outlined text-xl">download</span>
                </div>
            </div>

            {{-- Stat Box 2: Total Karya --}}
            <div class="bg-white rounded-2xl p-3.5 border border-[#c1c8c3]/40 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-[#717975] uppercase tracking-wider font-medium block">Karya Tayang</span>
                    <span class="font-serif text-lg font-bold text-[#0f382c] block mt-0.5">
                        {{ $totalApproved }} <span class="text-xs font-normal text-[#717975]">/ {{ $totalUploaded }}</span>
                    </span>
                    <span class="text-[9.5px] text-[#414845]">{{ $totalPending }} antrean kurasi</span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-[#c1ecda]/50 flex items-center justify-center text-[#0f382c]">
                    <span class="material-symbols-outlined text-xl">photo_library</span>
                </div>
            </div>
        </div>

        {{-- ================= 2. DAFTAR POSTINGAN KARYA ================= --}}
        <div class="space-y-3 pt-2">
            <div class="flex items-center justify-between">
                <h2 class="font-serif text-sm font-bold text-[#0f382c]">
                    Daftar Karya Anda ({{ $artworks->count() }})
                </h2>
                <div class="flex items-center gap-1.5 text-[10px] text-[#717975]">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Tayang</span>
                    <span class="w-2 h-2 rounded-full bg-amber-500 ml-1"></span>
                    <span>Review</span>
                    <span class="w-2 h-2 rounded-full bg-red-500 ml-1"></span>
                    <span>Ditolak</span>
                </div>
            </div>

            @forelse ($artworks as $art)
                @php
                    $imgUrl = filter_var($art->image_path, FILTER_VALIDATE_URL) 
                        ? $art->image_path 
                        : asset('storage/' . $art->image_path);
                    $donationAmount = $art->total_donations ?? 0;
                @endphp
                <div class="bg-white rounded-2xl p-3 border border-[#c1c8c3]/40 shadow-xs flex gap-3 transition-all hover:shadow-sm">
                    {{-- Thumbnail & Status Badge --}}
                    <div class="relative w-24 h-24 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ $imgUrl }}" alt="{{ $art->title }}" class="w-full h-full object-cover">
                        
                        {{-- Status Pill on Image --}}
                        @if ($art->status === 'approved')
                            <span class="absolute top-1.5 left-1.5 px-2 py-0.5 rounded-md bg-emerald-600/90 text-white text-[9px] font-bold backdrop-blur-xs flex items-center gap-0.5 shadow-2xs">
                                <span class="material-symbols-outlined text-[11px]">verified</span>
                                Tayang
                            </span>
                        @elseif ($art->status === 'pending')
                            <span class="absolute top-1.5 left-1.5 px-2 py-0.5 rounded-md bg-amber-500/90 text-white text-[9px] font-bold backdrop-blur-xs flex items-center gap-0.5 shadow-2xs">
                                <span class="material-symbols-outlined text-[11px]">hourglass_top</span>
                                Review
                            </span>
                        @else
                            <span class="absolute top-1.5 left-1.5 px-2 py-0.5 rounded-md bg-red-600/90 text-white text-[9px] font-bold backdrop-blur-xs flex items-center gap-0.5 shadow-2xs">
                                <span class="material-symbols-outlined text-[11px]">cancel</span>
                                Ditolak
                            </span>
                        @endif
                    </div>

                    {{-- Content & Tracking Saldo --}}
                    <div class="flex-1 flex flex-col justify-between min-w-0">
                        <div>
                            <div class="flex items-start justify-between gap-1">
                                <h3 class="font-serif text-xs font-semibold text-[#0f382c] line-clamp-1">
                                    {{ $art->title }}
                                </h3>
                                
                                {{-- Dropdown or Delete Button --}}
                                <form action="{{ route('artworks.destroy', $art->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus karya visual ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-[#717975] hover:text-red-600 transition-colors p-0.5"
                                            title="Hapus karya">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </form>
                            </div>

                            <p class="text-[10px] text-[#717975] mt-0.5">
                                {{ $art->category->name ?? 'Dakwah' }} • {{ $art->created_at->translatedFormat('d M Y') }}
                            </p>

                            @if ($art->status === 'rejected' && $art->rejection_reason)
                                <div class="mt-1 p-1.5 rounded-lg bg-red-50 border border-red-200 text-red-700 text-[10px] leading-tight">
                                    <strong>Alasan:</strong> {{ $art->rejection_reason }}
                                </div>
                            @endif
                        </div>

                        {{-- Metrik Saldo Donasi & Unduhan --}}
                        <div class="pt-2 mt-1 border-t border-[#c1c8c3]/20 flex items-center justify-between text-xs">
                            <div class="flex flex-col">
                                <span class="text-[9px] text-[#717975] uppercase">Infaq Masuk</span>
                                <span class="font-bold text-[#0f382c] text-[12px] flex items-center gap-0.5">
                                    <span class="material-symbols-outlined text-[13px] text-[#735c00]">volunteer_activism</span>
                                    Rp {{ number_format($donationAmount, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="flex items-center gap-0.5 text-[#717975] text-[11px]" title="Total Unduhan">
                                    <span class="material-symbols-outlined text-[13px]">download</span>
                                    {{ $art->download_count }}
                                </span>

                                @if ($art->status === 'approved')
                                    <a href="{{ route('artworks.show', $art->slug) }}"
                                       class="px-2 py-1 rounded-lg bg-[#f4f4f1] text-[#0f382c] hover:bg-[#e8e8e5] text-[10px] font-semibold flex items-center gap-0.5 transition-colors">
                                        <span>Lihat</span>
                                        <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 border border-[#c1c8c3]/40 shadow-xs text-center flex flex-col items-center justify-center space-y-3">
                    <div class="w-14 h-14 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#0f382c]">
                        <span class="material-symbols-outlined text-3xl">photo_library</span>
                    </div>
                    <div class="space-y-1">
                        <h3 class="font-serif text-sm font-bold text-[#0f382c]">Belum Ada Karya yang Diunggah</h3>
                        <p class="text-xs text-[#717975] max-w-xs">
                            Mulai kontribusi dakwah visual Anda. Bagikan karya foto berkualitas untuk sedekah jariyah dan terima infaq apresiasi.
                        </p>
                    </div>
                    <a href="{{ route('unggah') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] transition-all shadow-xs">
                        <span class="material-symbols-outlined text-sm text-[#fed65b]">add</span>
                        <span>Mulai Unggah Karya</span>
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</x-layouts.app>
