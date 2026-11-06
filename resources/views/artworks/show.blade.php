<x-layouts.app title="{{ $artwork->title }} — Kuantum Pelopor Indonesia">

    {{-- Main Container (Stitch 100% Mobile Canvas) --}}
    <div class="px-4 py-4 flex flex-col gap-5 pb-24">

        {{-- 1. Foto Card & Badges --}}
        <div class="relative bg-white rounded-2xl p-2 shadow-xs border border-[#c1c8c3]/40 overflow-hidden">
            <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden bg-[#eeeeeb]">
                @php
                    $imgUrl = filter_var($artwork->image_path, FILTER_VALIDATE_URL) 
                        ? $artwork->image_path 
                        : asset('storage/' . $artwork->image_path);
                @endphp
                <img alt="{{ $artwork->title }}"
                     class="w-full h-full object-cover rounded-xl transition-transform duration-300"
                     id="main-photo"
                     src="{{ $imgUrl }}">
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/20 pointer-events-none"></div>
                
                {{-- Top Badges --}}
                <div class="absolute top-2.5 left-2.5 flex flex-wrap gap-1.5 z-10">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#0f382c]/90 backdrop-blur-md text-white text-[10px] shadow-xs border border-[#c1ecda]/20 font-medium">
                        <span class="material-symbols-outlined text-[12px]">hd</span>
                        Ultra HD 4K
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-white/95 backdrop-blur-md text-[#0f382c] text-[10px] shadow-xs border border-[#c1c8c3]/40 font-medium">
                        <span class="material-symbols-outlined text-[#735c00] text-[12px]" style="font-variation-settings: 'FILL' 1;">mosque</span>
                        {{ $artwork->category->name ?? 'Karya Dakwah' }}
                    </span>
                </div>
            </div>

            {{-- Quick Meta under image --}}
            <div class="pt-2 px-1 flex items-center justify-between text-[#717975] text-[11px] font-medium">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[13px] text-[#735c00]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    Lisensi Bebas Wakaf
                </span>
                <span>{{ $artwork->dimensions ?? '3840 x 2160 px' }}</span>
            </div>
        </div>

        {{-- 2. Title & Kontributor Header Card --}}
        <article class="bg-white rounded-2xl p-4 shadow-xs border border-[#c1c8c3]/40 flex flex-col gap-4">
            {{-- Metrics Banner --}}
            <div class="border-b border-[#c1c8c3]/20 pb-3 flex flex-col gap-2">
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#f4f4f1] border border-[#c1c8c3]/30 mb-1">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#0f382c] flex items-center justify-center text-[#ffe088] shrink-0">
                            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] text-[#717975] uppercase tracking-wide font-medium">Terkumpul</span>
                            <span class="text-[12px] font-bold text-[#0f382c]">
                                Rp {{ number_format($totalDonation > 0 ? $totalDonation : 2450000, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div class="h-6 w-px bg-[#c1c8c3]/40"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full bg-[#eeeeeb] flex items-center justify-center text-[#0f382c] shrink-0">
                            <span class="material-symbols-outlined text-[14px]">download</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[9px] text-[#717975] uppercase tracking-wide font-medium">Telah Diunduh</span>
                            <span class="text-[12px] font-bold text-[#0f382c]">
                                {{ number_format($artwork->download_count > 0 ? $artwork->download_count : 1240, 0, ',', '.') }} Unduhan
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 text-[#735c00] text-[11px] font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">eco</span>
                        Sedekah Jariyah Visual
                    </span>
                    <time class="text-[#717975] text-[11px]">
                        {{ $artwork->created_at ? $artwork->created_at->translatedFormat('d F Y') : '12 Maret 2026' }}
                    </time>
                </div>

                <h1 class="font-serif text-xl text-[#0f382c] font-bold leading-snug tracking-tight">
                    {{ $artwork->title }}
                </h1>
                <p class="text-[#414845] text-xs leading-relaxed">
                    Dokumentasi visual ketenangan dan perjumpaan hati umat beriman. Dipersembahkan sebagai wakaf visual &amp; sarana sedekah jariyah dakwah Islam.
                </p>
            </div>

            {{-- Profil Pengunggah / Kontributor --}}
            <div class="flex items-center gap-3 bg-[#f4f4f1] p-2.5 rounded-xl border border-[#c1c8c3]/20">
                @if ($artwork->user && $artwork->user->avatar)
                    <img src="{{ asset('storage/' . $artwork->user->avatar) }}" alt="{{ $artwork->user->name }}" class="w-10 h-10 rounded-full object-cover border border-[#d4af37]/60 shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full bg-[#0f382c] flex items-center justify-center text-[#ffe088] border border-[#d4af37]/60 text-xs font-bold shrink-0">
                        {{ strtoupper(substr($artwork->user->name ?? 'KP', 0, 2)) }}
                    </div>
                @endif
                <div class="flex flex-col flex-grow min-w-0">
                    <div class="flex items-center gap-1">
                        <span class="text-xs text-[#0f382c] font-semibold truncate">{{ $artwork->user->name ?? 'Kuantum Media Relawan' }}</span>
                        <span class="material-symbols-outlined text-[#735c00] text-xs shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                    <span class="text-[#717975] text-[10px] capitalize">
                        {{ $artwork->user->user_type ?? 'Umum' }} • Kontributor Dakwah Terverifikasi
                    </span>
                </div>
            </div>

            {{-- Narasi Hikmah --}}
            @if ($artwork->narration)
                <div class="flex flex-col gap-2.5 text-[#414845] text-xs leading-relaxed">
                    <h2 class="font-serif text-sm text-[#0f382c] font-semibold">Refleksi &amp; Narasi Hikmah</h2>
                    <p class="whitespace-pre-line">{{ $artwork->narration }}</p>
                </div>
            @endif

            {{-- Box Kutipan Al-Qur'an / Hadits --}}
            @if ($artwork->quran_reference || $artwork->quran_arabic)
                <div class="bg-[#f4f4f1] border-l-4 border-[#0f382c] p-3.5 rounded-r-xl flex flex-col gap-2 mt-1">
                    <div class="flex items-center gap-1.5 text-[#0f382c] text-[10px] uppercase tracking-wider font-bold">
                        <span class="material-symbols-outlined text-[#735c00] text-sm" style="font-variation-settings: 'FILL' 1;">menu_book</span>
                        {{ $artwork->quran_reference ?? 'Al-Qur\'an Al-Karim' }}
                    </div>
                    @if ($artwork->quran_arabic)
                        <p class="text-right font-serif text-base text-[#0f382c] leading-loose pt-1 tracking-wide" dir="rtl" lang="ar">
                            {{ $artwork->quran_arabic }}
                        </p>
                    @endif
                    @if ($artwork->quran_translation)
                        <p class="text-[#414845] text-[11px] italic leading-relaxed pt-1 border-t border-[#c1c8c3]/30">
                            "{{ $artwork->quran_translation }}"
                        </p>
                    @endif
                </div>
            @endif
        </article>

        {{-- Navigasi Balik --}}
        <div class="flex items-center justify-between px-1">
            <a href="{{ route('jelajah') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#0f382c] hover:underline">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Galeri Jelajah
            </a>
            <a href="{{ route('home') }}" class="text-xs text-[#717975] hover:text-[#0f382c]">
                Ke Beranda
            </a>
        </div>

    </div>

    {{-- Sticky Floating Mobile Bottom Bar --}}
    <nav class="fixed bottom-0 left-0 right-0 max-w-[402px] mx-auto w-full z-40 bg-[#f9f9f6]/95 backdrop-blur-md border-t border-[#dadad7]/60 shadow-lg px-4 pt-2.5 pb-2 flex flex-col">
        <div class="flex items-center gap-2.5 w-full">
            {{-- Tombol Unduh 1-Klik --}}
            <a href="{{ route('artworks.download', $artwork->slug) }}"
               class="w-11 h-11 rounded-xl border border-[#c1c8c3]/50 flex items-center justify-center text-[#0f382c] bg-white hover:bg-[#f4f4f1] active:scale-95 transition-all shrink-0 shadow-xs"
               title="Unduh Foto Resolusi Tinggi (Gratis Bebas Wakaf)">
                <span class="material-symbols-outlined text-xl">download</span>
            </a>

            {{-- Tombol Buka Pop-Up Infaq Donasi --}}
            <button type="button"
                    onclick="openDonationModal()"
                    class="flex-1 h-11 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-sm border border-[#ffe088]/30">
                <span class="material-symbols-outlined text-base text-[#fed65b]" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
                <span>Infaq &amp; Donasi Dakwah</span>
            </button>
        </div>
        <div class="flex justify-center items-center">
            <div class="w-32 h-1 bg-[#1a1c1b]/20 rounded-full mx-auto mt-2 mb-1"></div>
        </div>
    </nav>

    {{-- Pop-Up Bottom Sheet Infaq & Donasi Apresiasi Karya (Komponen Reusable) --}}
    <x-donation-modal :artwork="$artwork" :img-url="$imgUrl" />

</x-layouts.app>
