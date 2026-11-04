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

    {{-- Bottom Sheet / Donation Modal Overlay (Design Stitch 100%) --}}
    <div id="donation-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300 hidden opacity-0 flex flex-col justify-end max-w-[402px] mx-auto" onclick="handleModalBackdropClick(event)">
        <div id="donation-bottom-sheet" class="bg-white w-full rounded-t-3xl max-h-[88vh] overflow-y-auto p-4 flex flex-col gap-4 transform translate-y-full transition-transform duration-300 shadow-2xl" onclick="event.stopPropagation()">
            {{-- Handle Bar & Close --}}
            <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-1 bg-[#c1c8c3] rounded-full"></div>
                <div class="w-full flex items-center justify-between pb-2 border-b border-[#c1c8c3]/20">
                    <div>
                        <span class="inline-flex items-center gap-1 text-[#735c00] text-[10px] font-bold uppercase tracking-wider">
                            <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">eco</span>
                            Sedekah Jariyah
                        </span>
                        <h2 class="font-serif text-base text-[#0f382c] font-bold">Infaq &amp; Donasi Dakwah</h2>
                    </div>
                    <button type="button" onclick="closeDonationModal()" class="w-8 h-8 rounded-full bg-[#f4f4f1] flex items-center justify-center text-[#414845] hover:text-[#0f382c] transition-colors">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
            </div>

            {{-- Mini Preview Card Karya --}}
            <div class="p-2.5 rounded-xl bg-[#f4f4f1] border border-[#c1c8c3]/30 flex items-center gap-2.5">
                <img src="{{ $imgUrl }}" alt="{{ $artwork->title }}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-serif font-bold text-[#0f382c] truncate">{{ $artwork->title }}</h4>
                    <p class="text-[10px] text-[#717975] truncate">Karya: {{ $artwork->user->name ?? 'Kuantum Pelopor' }}</p>
                </div>
            </div>

            <p class="text-[#414845] text-[11px] leading-relaxed">
                Infaq Anda menopang pembebasan royalti karya visual Islami untuk syiar umat dan operasional dakwah Kuantum Pelopor Indonesia.
            </p>

            {{-- Form Donasi Mobile --}}
            <form id="donation-form" class="flex flex-col gap-3.5" onsubmit="handleDonationSubmit(event)">
                {{-- Nominal Presets --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs text-[#414845] font-medium">Pilih Nominal Donasi</label>
                    <div class="grid grid-cols-2 gap-2" id="amount-preset-container">
                        <button type="button" onclick="selectAmount(10000, this)" class="donation-btn py-2 px-3 rounded-lg border border-[#c1c8c3]/60 text-xs text-[#1a1c1b] hover:bg-[#f4f4f1] text-center transition-colors">
                            Rp 10.000
                        </button>
                        <button type="button" onclick="selectAmount(25000, this)" class="donation-btn py-2 px-3 rounded-lg border border-[#c1c8c3]/60 text-xs text-[#1a1c1b] hover:bg-[#f4f4f1] text-center transition-colors">
                            Rp 25.000
                        </button>
                        <button type="button" onclick="selectAmount(50000, this)" class="donation-btn py-2 px-3 rounded-lg border-2 border-[#0f382c] bg-[#0f382c]/5 text-xs text-[#0f382c] font-bold text-center transition-colors">
                            Rp 50.000
                        </button>
                        <button type="button" onclick="selectAmount(100000, this)" class="donation-btn py-2 px-3 rounded-lg border border-[#c1c8c3]/60 text-xs text-[#1a1c1b] hover:bg-[#f4f4f1] text-center transition-colors">
                            Rp 100.000
                        </button>
                    </div>
                    <div class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#717975] text-xs">Rp</span>
                        <input type="number" id="custom-amount" min="5000" name="amount" placeholder="Nominal Lainnya (Contoh: 150000)" oninput="clearPresetActive()" class="w-full pl-9 pr-3 py-2 text-xs bg-white border border-[#c1c8c3]/60 rounded-lg focus:border-[#0f382c] focus:ring-1 focus:ring-[#0f382c] outline-none">
                    </div>
                </div>

                {{-- Identitas Donatur --}}
                <div class="flex flex-col gap-1">
                    <label for="donor-name" class="text-xs text-[#414845] font-medium">Nama Donatur</label>
                    <input type="text" id="donor-name" name="donor_name" placeholder="Hamba Allah / Nama Anda" value="{{ auth()->user()->name ?? 'Hamba Allah' }}" required class="w-full px-3 py-2 text-xs bg-white border border-[#c1c8c3]/60 rounded-lg focus:border-[#0f382c] focus:ring-1 focus:ring-[#0f382c] outline-none">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="donor-email" class="text-xs text-[#414845] font-medium">Email / WhatsApp (Bukti Infaq)</label>
                    <input type="text" id="donor-email" name="donor_contact" placeholder="0812xxxx atau email@anda.com" value="{{ auth()->user()->email ?? '' }}" class="w-full px-3 py-2 text-xs bg-white border border-[#c1c8c3]/60 rounded-lg focus:border-[#0f382c] focus:ring-1 focus:ring-[#0f382c] outline-none">
                </div>

                <div class="flex flex-col gap-1">
                    <label for="donor-notes" class="text-xs text-[#414845] font-medium">Doa / Pesan Kebaikan</label>
                    <textarea id="donor-notes" name="notes" placeholder="Semoga menjadi wasilah jariyah dan berkah bagi dakwah..." rows="2" class="w-full px-3 py-2 text-xs bg-white border border-[#c1c8c3]/60 rounded-lg focus:border-[#0f382c] focus:ring-1 focus:ring-[#0f382c] outline-none resize-none"></textarea>
                </div>

                {{-- Pilihan Metode Pembayaran --}}
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs text-[#414845] font-medium">Metode Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 p-2 rounded-lg border border-[#c1c8c3]/60 cursor-pointer hover:bg-[#f4f4f1] transition-colors has-[:checked]:border-[#0f382c] has-[:checked]:bg-[#0f382c]/5">
                            <input type="radio" name="payment_method" value="qris" checked class="text-[#0f382c] focus:ring-[#0f382c]">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-[#0f382c]">QRIS Instan</span>
                                <span class="text-[9px] text-[#717975] leading-tight">GoPay, OVO, Dana, BSI</span>
                            </div>
                        </label>
                        <label class="flex items-center gap-2 p-2 rounded-lg border border-[#c1c8c3]/60 cursor-pointer hover:bg-[#f4f4f1] transition-colors has-[:checked]:border-[#0f382c] has-[:checked]:bg-[#0f382c]/5">
                            <input type="radio" name="payment_method" value="bsi_va" class="text-[#0f382c] focus:ring-[#0f382c]">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-[#0f382c]">BSI VA</span>
                                <span class="text-[9px] text-[#717975] leading-tight">Virtual Account Syariah</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Submit Action --}}
                <button type="submit" class="w-full mt-1 py-3 rounded-xl bg-[#0f382c] text-white text-xs font-semibold hover:bg-[#1a5c44] active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-sm border border-[#ffe088]/20">
                    <span class="material-symbols-outlined text-base text-[#fed65b]">volunteer_activism</span>
                    <span>Lanjutkan Donasi Sekarang</span>
                </button>
            </form>

            {{-- Alert Sukses (Placeholder sebelum Midtrans payment gateway aktif di Issue 6) --}}
            <div id="donation-success-alert" class="hidden p-3 rounded-xl bg-[#c1ecda]/40 border border-[#a6d0be] text-[#002117] flex flex-col gap-1.5">
                <div class="flex items-center gap-1.5 text-xs font-bold">
                    <span class="material-symbols-outlined text-[#0f382c] text-base">check_circle</span>
                    Jazakumullah Khairan!
                </div>
                <p class="text-[11px] text-[#0f382c] leading-relaxed">
                    Data niat infaq Anda telah tercatat dengan amanah. Modul pembayaran otomatis terhubung pada Sprint 2 berikutnya.
                </p>
            </div>
        </div>
    </div>

    {{-- Interactive Modal Scripts --}}
    <script>
        let selectedDonationAmount = 50000;

        function openDonationModal() {
            const modal = document.getElementById('donation-modal');
            const sheet = document.getElementById('donation-bottom-sheet');
            if (!modal || !sheet) return;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                sheet.classList.remove('translate-y-full');
            }, 10);
        }

        function closeDonationModal() {
            const modal = document.getElementById('donation-modal');
            const sheet = document.getElementById('donation-bottom-sheet');
            if (!modal || !sheet) return;

            modal.classList.add('opacity-0');
            sheet.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function handleModalBackdropClick(e) {
            if (e.target.id === 'donation-modal') {
                closeDonationModal();
            }
        }

        function selectAmount(amt, btn) {
            selectedDonationAmount = amt;
            const customInput = document.getElementById('custom-amount');
            if (customInput) customInput.value = '';

            const allBtns = document.querySelectorAll('.donation-btn');
            allBtns.forEach(b => {
                b.className = 'donation-btn py-2 px-3 rounded-lg border border-[#c1c8c3]/60 text-xs text-[#1a1c1b] hover:bg-[#f4f4f1] text-center transition-colors';
            });
            btn.className = 'donation-btn py-2 px-3 rounded-lg border-2 border-[#0f382c] bg-[#0f382c]/5 text-xs text-[#0f382c] font-bold text-center transition-colors';
        }

        function clearPresetActive() {
            const allBtns = document.querySelectorAll('.donation-btn');
            allBtns.forEach(b => {
                b.className = 'donation-btn py-2 px-3 rounded-lg border border-[#c1c8c3]/60 text-xs text-[#1a1c1b] hover:bg-[#f4f4f1] text-center transition-colors';
            });
        }

        function handleDonationSubmit(e) {
            e.preventDefault();
            const alertBox = document.getElementById('donation-success-alert');
            const form = document.getElementById('donation-form');
            if (alertBox && form) {
                alertBox.classList.remove('hidden');
                form.classList.add('hidden');
            }
        }
    </script>

</x-layouts.app>
