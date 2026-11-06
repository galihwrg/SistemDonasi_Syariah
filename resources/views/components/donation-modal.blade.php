@props(['artwork', 'imgUrl' => null])

@php
    $imageUrl = $imgUrl ?? (filter_var($artwork->image_path, FILTER_VALIDATE_URL) 
        ? $artwork->image_path 
        : asset('storage/' . $artwork->image_path));
@endphp

<!-- Bottom Sheet / Donation Modal Overlay (Stitch 100% 402px) -->
<div id="donation-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300 hidden opacity-0 flex flex-col justify-end max-w-[402px] mx-auto" onclick="handleModalBackdropClick(event)">
    <div id="donation-bottom-sheet" class="w-full bg-[#f9f9f6] rounded-t-[28px] border-t border-[#dadad7]/60 shadow-2xl flex flex-col max-h-[92vh] overflow-hidden transform translate-y-full transition-transform duration-300" onclick="event.stopPropagation()">
        
        <!-- Drag Handle -->
        <div class="w-full flex justify-center pt-3 pb-1">
            <div class="w-10 h-1.5 rounded-full bg-[#dadad7]"></div>
        </div>

        <!-- Header Modal -->
        <div class="px-5 pt-2 pb-3.5 flex items-center justify-between border-b border-[#dadad7]/40">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-[#0f382c]/10 flex items-center justify-center text-[#0f382c]">
                    <span class="material-symbols-outlined text-[18px]">volunteer_activism</span>
                </div>
                <div>
                    <h2 class="font-serif font-bold text-lg text-[#0f382c] tracking-tight leading-tight">Infaq &amp; Donasi Dakwah</h2>
                    <p class="text-[10px] text-[#5c6460]">Sedekah jariyah apresiasi karya visual umat</p>
                </div>
            </div>
            <button type="button" onclick="closeDonationModal()" class="w-8 h-8 rounded-full bg-[#dadad7]/50 hover:bg-[#dadad7] text-[#1b221f] flex items-center justify-center transition-colors" aria-label="Tutup Pop-up">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="px-5 py-4 overflow-y-auto space-y-4">

            <!-- Target Karya Info Card -->
            <div class="bg-white rounded-xl p-3 border border-[#dadad7]/80 flex items-center gap-3 shadow-xs">
                <div class="w-12 h-12 rounded-lg bg-[#0f382c]/10 overflow-hidden flex-shrink-0 relative">
                    <img alt="{{ $artwork->title }}" class="w-full h-full object-cover" src="{{ $imageUrl }}">
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[9px] uppercase tracking-wider font-semibold text-[#8c733e] block">Wakaf Visual &amp; Sedekah Jariyah</span>
                    <p class="text-xs font-serif font-bold text-[#1b221f] truncate leading-snug">{{ $artwork->title }}</p>
                    <p class="text-[10px] text-[#5c6460] truncate">Karya: {{ $artwork->user->name ?? 'Kuantum Media Relawan' }}</p>
                </div>
            </div>

            <!-- Form Donasi -->
            <form id="donation-form" method="POST" action="{{ route('donations.store') }}" class="flex flex-col gap-3.5" onsubmit="handleDonationSubmit(event)">
                @csrf
                <input type="hidden" name="artwork_id" value="{{ $artwork->id }}">

                <!-- Pilih Nominal Donasi (6 Grid Presets: 10k, 25k, 50k, 100k, 250k, 500k) -->
                <div>
                    <label class="block text-xs font-semibold text-[#1b221f] mb-2 flex items-center justify-between">
                        <span>Pilih Nominal Infaq</span>
                        <span class="text-[10px] font-normal text-[#8c733e]">Ikhlas &amp; Berkah</span>
                    </label>
                    <div class="grid grid-cols-3 gap-2" id="amount-preset-container">
                        <button type="button" onclick="selectAmount(10000, this)" class="donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center">
                            Rp 10.000
                        </button>
                        <button type="button" onclick="selectAmount(25000, this)" class="donation-btn py-2.5 px-2 rounded-xl border-2 border-[#0f382c] bg-[#0f382c]/10 text-xs font-bold text-[#0f382c] transition-all text-center shadow-xs">
                            Rp 25.000
                        </button>
                        <button type="button" onclick="selectAmount(50000, this)" class="donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center">
                            Rp 50.000
                        </button>
                        <button type="button" onclick="selectAmount(100000, this)" class="donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center">
                            Rp 100.000
                        </button>
                        <button type="button" onclick="selectAmount(250000, this)" class="donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center">
                            Rp 250.000
                        </button>
                        <button type="button" onclick="selectAmount(500000, this)" class="donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center">
                            Rp 500.000
                        </button>
                    </div>
                </div>

                <!-- Input Nominal Lainnya -->
                <div>
                    <label class="block text-xs font-medium text-[#1b221f] mb-1.5">Atau Masukkan Nominal Lain (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-[#5c6460]">Rp</span>
                        <input type="number" id="custom-amount" min="5000" name="amount" placeholder="Minimal 5.000" value="25000" oninput="onCustomAmountChange(this)" class="w-full h-11 pl-10 pr-3.5 text-xs font-semibold rounded-xl border border-[#dadad7] bg-white focus:outline-none focus:ring-1 focus:ring-[#0f382c] focus:border-[#0f382c]" required>
                    </div>
                </div>

                <!-- Data Donatur -->
                <div class="space-y-2.5 pt-1">
                    <div>
                        <label class="block text-xs font-medium text-[#1b221f] mb-1.5">Nama Donatur</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-[#5c6460]">person</span>
                            <input type="text" name="donor_name" value="{{ auth()->user()->name ?? 'Hamba Allah' }}" placeholder="Nama Lengkap Anda" class="w-full h-11 pl-9 pr-3.5 text-xs rounded-xl border border-[#dadad7] bg-white focus:outline-none focus:ring-1 focus:ring-[#0f382c] focus:border-[#0f382c]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[#1b221f] mb-1.5">Email atau WhatsApp (Opsional Bukti Doa)</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-[#5c6460]">mail</span>
                            <input type="text" name="donor_contact" value="{{ auth()->user()->email ?? '' }}" placeholder="email@domain.com atau 0812..." class="w-full h-11 pl-9 pr-3.5 text-xs rounded-xl border border-[#dadad7] bg-white focus:outline-none focus:ring-1 focus:ring-[#0f382c] focus:border-[#0f382c]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-[#1b221f] mb-1.5">Doa / Pesan untuk Kreator &amp; Dakwah</label>
                        <textarea name="prayer_message" rows="2" placeholder="Tuliskan doa kebaikan atau kalimat penyemangat..." class="w-full p-2.5 text-xs rounded-xl border border-[#dadad7] bg-white focus:outline-none focus:ring-1 focus:ring-[#0f382c] focus:border-[#0f382c] resize-none">Semoga menjadi amal jariyah dan dakwah visual Kuantum Pelopor berkah selalu.</textarea>
                    </div>
                </div>

                <!-- Metode Pembayaran Syariah -->
                <div>
                    <label class="block text-xs font-semibold text-[#1b221f] mb-2 flex items-center justify-between">
                        <span>Metode Pembayaran</span>
                        <span class="text-[10px] text-[#0f382c] font-medium flex items-center gap-0.5">
                            <span class="material-symbols-outlined text-[13px]">verified_user</span> Otomatis &amp; Terverifikasi
                        </span>
                    </label>
                    <div class="space-y-1.5">
                        <!-- QRIS -->
                        <label class="payment-option flex items-center justify-between p-2.5 rounded-xl border-2 border-[#0f382c] bg-white cursor-pointer shadow-xs">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 border border-emerald-100 flex items-center justify-center text-[#0f382c]">
                                    <span class="material-symbols-outlined text-[18px]">qr_code_2</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <p class="text-xs font-bold text-[#1b221f]">QRIS (Semua Pembayaran)</p>
                                        <span class="text-[9px] bg-[#0f382c] text-white px-1.5 py-0.2 rounded font-medium">Instan</span>
                                    </div>
                                    <p class="text-[10px] text-[#5c6460]">GoPay, OVO, Dana, ShopeePay, BCA, Mandiri</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="qris" checked class="text-[#0f382c] focus:ring-[#0f382c] w-4 h-4 accent-[#0f382c]" onchange="updatePaymentStyle()">
                        </label>

                        <!-- Virtual Account BSI -->
                        <label class="payment-option flex items-center justify-between p-2.5 rounded-xl border border-[#dadad7] bg-white cursor-pointer hover:border-[#0f382c]/60">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-teal-50 border border-teal-100 flex items-center justify-center text-teal-800">
                                    <span class="material-symbols-outlined text-[18px]">account_balance</span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-[#1b221f]">Bank Syariah Indonesia (BSI)</p>
                                    <p class="text-[10px] text-[#5c6460]">Virtual Account Bebas Biaya Admin</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="bsi_va" class="text-[#0f382c] focus:ring-[#0f382c] w-4 h-4 accent-[#0f382c]" onchange="updatePaymentStyle()">
                        </label>

                        <!-- Transfer Bank BCA/Mandiri -->
                        <label class="payment-option flex items-center justify-between p-2.5 rounded-xl border border-[#dadad7] bg-white cursor-pointer hover:border-[#0f382c]/60">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-stone-100 border border-stone-200 flex items-center justify-center text-[#5c6460]">
                                    <span class="material-symbols-outlined text-[18px]">credit_card</span>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-[#1b221f]">Transfer Antar Bank / VA Lainnya</p>
                                    <p class="text-[10px] text-[#5c6460]">BCA, BRI, Mandiri, BNI</p>
                                </div>
                            </div>
                            <input type="radio" name="payment_method" value="bank_transfer" class="text-[#0f382c] focus:ring-[#0f382c] w-4 h-4 accent-[#0f382c]" onchange="updatePaymentStyle()">
                        </label>
                    </div>
                </div>

                <!-- Footer Action Bottom Modal -->
                <div class="pt-2 flex flex-col gap-2">
                    <div class="flex items-center justify-between px-1 text-xs">
                        <span class="text-[#5c6460]">Total Donasi Dakwah</span>
                        <span id="display-total-amount" class="font-bold text-[#0f382c] text-sm font-serif">Rp 25.000</span>
                    </div>
                    <button type="submit" id="btn-submit-donation" class="w-full h-11 bg-[#0f382c] hover:bg-[#0a271f] text-white rounded-xl text-xs font-semibold flex items-center justify-center gap-2 shadow-md transition-colors active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">volunteer_activism</span>
                        <span>Lanjutkan Pembayaran Infaq</span>
                    </button>
                    <p class="text-[9px] text-center text-[#5c6460] pt-0.5">
                        Koneksi terenkripsi &amp; 100% donasi disalurkan untuk dakwah visual
                    </p>
                </div>
            </form>

            <!-- Alert Sukses Pasca Submit -->
            <div id="donation-success-alert" class="hidden p-4 rounded-xl bg-[#c1ecda]/40 border border-[#a6d0be] text-[#002117] flex flex-col gap-2">
                <div class="flex items-center gap-2 text-xs font-bold">
                    <span class="material-symbols-outlined text-[#0f382c] text-lg">check_circle</span>
                    <span>Jazakumullah Khairan!</span>
                </div>
                <p id="donation-success-message" class="text-[11px] text-[#0f382c] leading-relaxed">
                    Data niat infaq Anda telah tercatat dengan amanah. Modul pembayaran otomatis terhubung pada Sprint 4.
                </p>
                <div class="pt-2 flex justify-end">
                    <button type="button" onclick="closeDonationModal()" class="px-3 py-1.5 rounded-lg bg-[#0f382c] text-white text-xs font-semibold">
                        Selesai
                    </button>
                </div>
            </div>

        </div>

        <!-- iOS Home Indicator -->
        <div class="w-full flex justify-center pt-1.5 pb-2">
            <div class="w-32 h-1 rounded-full bg-[#dadad7]"></div>
        </div>

    </div>
</div>

<script>
    let currentDonationAmount = 25000;

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
            // reset alert state
            const alertBox = document.getElementById('donation-success-alert');
            const form = document.getElementById('donation-form');
            if (alertBox && form) {
                alertBox.classList.add('hidden');
                form.classList.remove('hidden');
            }
        }, 300);
    }

    function handleModalBackdropClick(e) {
        if (e.target.id === 'donation-modal') {
            closeDonationModal();
        }
    }

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function selectAmount(amt, btn) {
        currentDonationAmount = amt;
        const customInput = document.getElementById('custom-amount');
        const totalDisplay = document.getElementById('display-total-amount');

        if (customInput) customInput.value = amt;
        if (totalDisplay) totalDisplay.innerText = formatRupiah(amt);

        const allBtns = document.querySelectorAll('.donation-btn');
        allBtns.forEach(b => {
            b.className = 'donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center';
        });

        btn.className = 'donation-btn py-2.5 px-2 rounded-xl border-2 border-[#0f382c] bg-[#0f382c]/10 text-xs font-bold text-[#0f382c] transition-all text-center shadow-xs';
    }

    function onCustomAmountChange(input) {
        const amt = parseInt(input.value) || 0;
        currentDonationAmount = amt;
        const totalDisplay = document.getElementById('display-total-amount');
        if (totalDisplay) totalDisplay.innerText = formatRupiah(amt);

        // Reset preset highlight
        const allBtns = document.querySelectorAll('.donation-btn');
        allBtns.forEach(b => {
            b.className = 'donation-btn py-2.5 px-2 rounded-xl border border-[#dadad7] bg-white text-xs font-semibold text-[#1b221f] hover:border-[#0f382c] hover:bg-[#0f382c]/5 transition-all text-center';
        });
    }

    function updatePaymentStyle() {
        const options = document.querySelectorAll('.payment-option');
        options.forEach(opt => {
            const radio = opt.querySelector('input[type="radio"]');
            if (radio && radio.checked) {
                opt.className = 'payment-option flex items-center justify-between p-2.5 rounded-xl border-2 border-[#0f382c] bg-white cursor-pointer shadow-xs';
            } else {
                opt.className = 'payment-option flex items-center justify-between p-2.5 rounded-xl border border-[#dadad7] bg-white cursor-pointer hover:border-[#0f382c]/60';
            }
        });
    }

    async function handleDonationSubmit(e) {
        e.preventDefault();
        const form = document.getElementById('donation-form');
        const submitBtn = document.getElementById('btn-submit-donation');
        const alertBox = document.getElementById('donation-success-alert');
        const alertMsg = document.getElementById('donation-success-message');

        const formData = new FormData(form);

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerText = 'Memproses...';
        }

        try {
            const response = await fetch("{{ route('donations.store') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                form.classList.add('hidden');
                if (alertBox) {
                    alertBox.classList.remove('hidden');
                    if (alertMsg) {
                        alertMsg.innerText = data.message + ' (Order ID: ' + data.donation.midtrans_order_id + ')';
                    }
                }
            } else {
                alert('Terjadi kesalahan saat memproses donasi.');
            }
        } catch (err) {
            // Jika fallback ke normal post
            form.submit();
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Lanjutkan Pembayaran Infaq';
            }
        }
    }
</script>
