<x-layouts.app title="Verifikasi Akun & Rekening — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="rounded-xl p-3 bg-[#c1ecda]/40 border border-[#a6d0be] text-[#002117] text-[12px] flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] text-[#0f382c]">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-xl p-3 bg-red-50 border border-red-200 text-red-700 text-[12px] flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl p-3 bg-red-50 border border-red-200 text-red-700 text-[11px] space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">close</span>
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        @if ($user->is_verified)
            {{-- ============================================================ --}}
            {{-- STATE 2: AKUN TERVERIFIKASI & REKENING AKTIF (STITCH 100%)  --}}
            {{-- ============================================================ --}}

            {{-- 1. Ringkasan Profil Minimalis Terverifikasi --}}
            <div class="bg-white rounded-xl p-3 border border-[#c1c8c3]/30 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-[#d4af37]/60">
                    @else
                        <div class="w-10 h-10 rounded-full bg-[#0f382c] text-[#fed65b] font-bold text-sm flex items-center justify-center border border-[#d4af37]/60">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-1.5">
                            <h2 class="text-[14px] font-semibold text-[#0f382c] leading-tight">{{ $user->name }}</h2>
                        </div>
                        <p class="text-[11px] text-[#0f382c] font-medium capitalize">{{ $user->user_type }} Terverifikasi</p>
                        <p class="text-[10px] text-[#414845]">{{ $user->campus_name ?? $user->university ?? 'Civitas Dakwah Indonesia' }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#c1ecda] text-[#002117] text-[11px] font-semibold border border-[#a6d0be]">
                    <span class="material-symbols-outlined text-[13px]">check_circle</span>
                    Terverifikasi
                </span>
            </div>

            {{-- 2. Banner Status Berhasil & Amanah --}}
            <div class="rounded-xl p-3 bg-[#f4f4f1] border border-[#a6d0be] flex items-start gap-2.5 shadow-xs">
                <div class="w-7 h-7 rounded-full bg-[#c1ecda] flex items-center justify-center shrink-0 mt-0.5 text-[#002117]">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                </div>
                <div>
                    <h3 class="text-[12px] font-semibold text-[#0f382c] leading-tight">Akun &amp; Identitas Terverifikasi</h3>
                    <p class="text-[11px] leading-relaxed text-[#414845] mt-0.5">
                        Identitas Anda telah diverifikasi oleh tim Kuantum Pelopor Indonesia. Rekening donasi dakwah aktif dan siap menerima penyaluran dana.
                    </p>
                </div>
            </div>

            {{-- 3. Rekening Bank BSI Aktif --}}
            <div class="bg-white rounded-xl p-4 border border-[#c1c8c3]/30 shadow-xs space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-[#c1c8c3]/20">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-[#e8e8e5] flex items-center justify-center text-[#0f382c]">
                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        </div>
                        <div>
                            <h4 class="text-[12px] font-semibold text-[#1a1c1b] leading-tight">Rekening Penyaluran Aktif</h4>
                            <p class="text-[10px] text-[#717975]">Pencairan donasi dakwah otomatis</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-[#c1ecda] text-[#002117] border border-[#a6d0be]">
                        <span class="material-symbols-outlined text-[11px]">check</span> Aktif
                    </span>
                </div>

                @php
                    $activeAccount = $primaryAccount ?? $user->bankAccounts->first();
                @endphp

                <div class="bg-[#f4f4f1] rounded-xl p-3 border border-[#c1c8c3]/30 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-semibold uppercase tracking-wider text-[#414845]">
                            {{ $activeAccount->bank_name ?? 'Bank Syariah Indonesia (BSI)' }}
                        </span>
                        <span class="material-symbols-outlined text-[16px] text-[#0f382c]">lock</span>
                    </div>
                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-[#c1c8c3]/30">
                        <div>
                            <span class="text-[17px] font-semibold tracking-wide text-[#0f382c] block font-serif" id="rek-display">
                                {{ $activeAccount->account_number ?? '7123-4567-8901' }}
                            </span>
                            <span class="text-[11px] text-[#414845] block">
                                a.n. {{ $activeAccount->account_holder_name ?? $user->name }}
                            </span>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $activeAccount->account_number ?? '712345678901' }}'); alert('Nomor rekening berhasil disalin!');" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-[#e8e8e5] text-[#0f382c] text-[11px] font-semibold hover:bg-[#dadad7] transition-colors active:scale-95" type="button">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span>
                            Salin
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <button onclick="document.getElementById('modal-bank').classList.remove('hidden')" class="text-[12px] font-semibold text-[#0f382c] hover:text-[#1a5c44] inline-flex items-center gap-1" type="button">
                        <span class="material-symbols-outlined text-[15px]">edit</span>
                        Ubah Rekening
                    </button>
                    <button onclick="document.getElementById('modal-bank').classList.remove('hidden')" class="text-[12px] font-medium text-[#414845] hover:text-[#0f382c] inline-flex items-center gap-1" type="button">
                        <span class="material-symbols-outlined text-[15px]">add_circle</span>
                        Tambah Rekening Lain
                    </button>
                </div>
            </div>

            {{-- 4. Ringkasan Donasi Terkumpul / Saldo Masuk --}}
            <div class="bg-white rounded-xl p-4 border border-[#c1c8c3]/30 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-[11px] text-[#414845] block">Total Donasi Terkumpul</span>
                        <span class="text-[20px] font-semibold text-[#0f382c] block mt-0.5 font-serif">
                            Rp {{ number_format($totalDonation > 0 ? $totalDonation : 450000, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-[#ffe088]/50 flex items-center justify-center text-[#735c00] border border-[#e9c349]/40">
                        <span class="material-symbols-outlined text-[18px]">savings</span>
                    </div>
                </div>

                {{-- Link Akses ke Postingan Saya --}}
                <div class="pt-2 border-t border-[#c1c8c3]/20 flex items-center justify-between">
                    <a href="{{ route('artworks.my') }}"
                       class="text-xs font-semibold text-[#0f382c] hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] text-[#735c00]">photo_library</span>
                        <span>Kelola Postingan Saya</span>
                    </a>
                    <span class="text-[10px] text-[#717975]">Per karya &amp; status</span>
                </div>
            </div>

        @else
            {{-- ============================================================ --}}
            {{-- STATE 1: VERIFIKASI AKUN BELUM TERVERIFIKASI (STITCH 100%)  --}}
            {{-- ============================================================ --}}

            {{-- 1. Ringkasan Profil Minimalis --}}
            <div class="bg-white rounded-xl p-3 border border-[#c1c8c3]/30 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-[#d4af37]/60">
                    @else
                        <div class="w-10 h-10 rounded-full bg-[#0f382c] text-[#fed65b] font-bold text-sm flex items-center justify-center border border-[#d4af37]/60">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <h2 class="text-[14px] font-semibold text-[#0f382c] leading-tight">{{ $user->name }}</h2>
                        <p class="text-[11px] text-[#414845]">{{ $user->email }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-[#ffe088]/50 text-[#574500] text-[11px] font-semibold border border-[#e9c349]/40">
                    <span class="material-symbols-outlined text-[13px]">hourglass_top</span>
                    {{ $latestVerification && $latestVerification->status === 'pending' ? 'Menunggu Review' : 'Belum Verifikasi' }}
                </span>
            </div>

            {{-- 2. Info Kunci Rekening Sederhana --}}
            <div class="rounded-xl p-3 bg-gradient-to-br from-[#f4f4f1] to-[#fef8e7] border border-[#e9c349]/40 flex items-start gap-2.5">
                <span class="material-symbols-outlined text-amber-900 text-[18px] shrink-0 mt-0.5">lock</span>
                <p class="text-[12px] leading-relaxed text-[#1a1c1b]">
                    Verifikasi identitas diperlukan untuk membuka fitur nomor rekening &amp; pencairan donasi dakwah.
                </p>
            </div>

            {{-- 3. Form Pilihan Kategori & Unggah Minimalis --}}
            <form method="POST" action="{{ route('profile.verify') }}" enctype="multipart/form-data" class="bg-white rounded-xl p-4 border border-[#c1c8c3]/30 shadow-xs space-y-3.5">
                @csrf
                <input type="hidden" name="id_type" id="hidden_id_type" value="{{ $user->user_type === 'mahasiswa' ? 'ktm' : 'ktp' }}">

                {{-- Tab Pilihan Sederhana --}}
                <div class="grid grid-cols-2 p-1 bg-[#f4f4f1] rounded-lg gap-1 border border-[#c1c8c3]/30">
                    <button type="button" id="tab-v-mhs" onclick="setVerifTab('mahasiswa')" class="py-1.5 px-3 rounded-md text-[12px] transition-all shadow-xs {{ $user->user_type === 'mahasiswa' ? 'bg-[#0f382c] text-white font-semibold' : 'text-[#414845] hover:text-[#0f382c] font-medium' }} text-center">
                        Mahasiswa
                    </button>
                    <button type="button" id="tab-v-umum" onclick="setVerifTab('umum')" class="py-1.5 px-3 rounded-md text-[12px] transition-all {{ $user->user_type === 'umum' ? 'bg-[#0f382c] text-white font-semibold' : 'text-[#414845] hover:text-[#0f382c] font-medium' }} text-center">
                        Umum
                    </button>
                </div>

                {{-- Form Fields Sederhana --}}
                <div class="space-y-3">
                    <div id="campus_field_wrapper" class="{{ $user->user_type === 'mahasiswa' ? 'block' : 'hidden' }}">
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1">Perguruan Tinggi / Kampus</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-[#717975]">account_balance</span>
                            <input class="w-full pl-9 pr-3 py-2 text-[13px] rounded-lg border border-[#c1c8c3]/50 focus:border-[#0f382c] focus:ring-2 focus:ring-[#d4af37]/30 bg-white text-[#1a1c1b] transition-all placeholder:text-[#717975]/70" name="campus_name" placeholder="Nama Perguruan Tinggi / Ma'had" type="text" value="{{ old('campus_name', $user->campus_name ?? '') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1" id="id_number_label">
                            {{ $user->user_type === 'mahasiswa' ? 'NIM / Nomor Induk Mahasiswa' : 'NIK e-KTP' }}
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-2.5 text-[18px] text-[#717975]">badge</span>
                            <input class="w-full pl-9 pr-3 py-2 text-[13px] rounded-lg border border-[#c1c8c3]/50 focus:border-[#0f382c] focus:ring-2 focus:ring-[#d4af37]/30 bg-white text-[#1a1c1b] transition-all placeholder:text-[#717975]/70" name="id_number" placeholder="Masukkan NIM atau NIK e-KTP" type="text" value="{{ old('id_number', $user->nim_nik ?? '') }}" required>
                        </div>
                    </div>

                    {{-- Area Upload Minimalis --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1">Unggah Foto KTM / KTP</label>
                        <label for="doc-upload" class="border-2 border-dashed border-[#c1c8c3] hover:border-[#0f382c] rounded-xl py-5 px-3 text-center bg-[#f9f9f6] cursor-pointer transition-colors group flex flex-col items-center justify-center gap-1">
                            <input type="file" id="doc-upload" name="document" accept="image/*" class="hidden" onchange="previewFile(this)">
                            <div class="w-9 h-9 rounded-full bg-[#e8e8e5] flex items-center justify-center text-[#0f382c] group-hover:scale-105 transition-transform">
                                <span class="material-symbols-outlined text-[20px]">add_a_photo</span>
                            </div>
                            <p class="text-[12px] text-[#0f382c] font-semibold mt-1" id="upload-label-text">
                                Sentuh untuk Mengunggah KTM / KTP
                            </p>
                            <p class="text-[11px] text-[#414845]" id="upload-sub-text">
                                Format JPG/PNG maks 5MB (Jelas &amp; terbaca)
                            </p>
                        </label>
                    </div>
                </div>

                {{-- Preview Status Rekening Terkunci --}}
                <div class="bg-[#f4f4f1] rounded-xl p-3 border border-[#c1c8c3]/20 flex items-center justify-between opacity-80">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center border border-[#c1c8c3]/30 text-[#0f382c]">
                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        </div>
                        <div>
                            <p class="text-[12px] font-semibold text-[#1a1c1b] leading-tight">Rekening Bank</p>
                            <p class="text-[11px] text-[#717975]">Terbuka otomatis pasca verifikasi</p>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-[#e8e8e5] text-[#414845] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[12px]">lock</span> Terkunci
                    </span>
                </div>

                {{-- Tombol Aksi Utama --}}
                <div class="pt-1 space-y-2">
                    <button class="w-full py-3 px-4 rounded-xl bg-[#0f382c] text-white text-[14px] font-semibold shadow-md hover:bg-[#1a5c44] active:scale-[0.98] transition-all flex items-center justify-center gap-2 border border-[#d4af37]/30" type="submit">
                        <span class="material-symbols-outlined text-[18px] text-[#fed65b]">verified_user</span>
                        Kirim Verifikasi
                    </button>
                </div>
            </form>

            {{-- Akses Cepat Postingan Saya bagi User Belum Verifikasi --}}
            <div class="bg-white rounded-xl p-3 border border-[#c1c8c3]/30 shadow-xs flex items-center justify-between">
                <a href="{{ route('artworks.my') }}"
                   class="text-xs font-semibold text-[#0f382c] hover:underline flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px] text-[#735c00]">photo_library</span>
                    <span>Lihat &amp; Kelola Postingan Saya</span>
                </a>
                <span class="material-symbols-outlined text-sm text-[#717975]">chevron_right</span>
            </div>
        @endif

        {{-- Logout Section Sederhana & Aman --}}
        <div class="pt-2 border-t border-[#c1c8c3]/30 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-[12px] font-medium text-[#414845] hover:text-[#0f382c] flex items-center gap-1">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Kembali ke Beranda
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-[12px] font-semibold text-red-600 hover:text-red-700 flex items-center gap-1 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">logout</span>
                    Keluar Akun
                </button>
            </form>
        </div>

    </div>

    {{-- Modal Tambah / Ubah Rekening Bank (Bagi Akun Terverifikasi) --}}
    @if ($user->is_verified)
        <div id="modal-bank" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
            <div class="w-full max-w-sm bg-white rounded-3xl p-5 border border-[#dadad7] shadow-2xl relative space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#dadad7]/50">
                    <h3 class="text-sm font-bold text-[#0f382c] font-serif flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        Rekening Bank Syariah
                    </h3>
                    <button type="button" onclick="document.getElementById('modal-bank').classList.add('hidden')" class="w-7 h-7 rounded-full bg-[#f4f4f1] text-[#414845] hover:text-[#0f382c] flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px]">close</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('profile.bank.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1">Nama Bank Syariah</label>
                        <select name="bank_name" class="w-full px-3 py-2 text-xs rounded-xl border border-[#dadad7] outline-none focus:border-[#0f382c]" required>
                            <option value="Bank Syariah Indonesia (BSI)">Bank Syariah Indonesia (BSI)</option>
                            <option value="Bank Muamalat">Bank Muamalat</option>
                            <option value="BCA Syariah">BCA Syariah</option>
                            <option value="Mega Syariah">Mega Syariah</option>
                            <option value="Bank Jabar Banten Syariah (BJBS)">BJB Syariah</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1">Nomor Rekening</label>
                        <input type="text" name="account_number" placeholder="Contoh: 7123456789" class="w-full px-3 py-2 text-xs rounded-xl border border-[#dadad7] outline-none focus:border-[#0f382c]" required>
                    </div>

                    <div>
                        <label class="block text-[11px] font-semibold text-[#414845] mb-1">Nama Pemilik Rekening</label>
                        <input type="text" name="account_holder_name" value="{{ $user->name }}" placeholder="Nama sesuai buku tabungan" class="w-full px-3 py-2 text-xs rounded-xl border border-[#dadad7] outline-none focus:border-[#0f382c]" required>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <button type="button" onclick="document.getElementById('modal-bank').classList.add('hidden')" class="flex-1 py-2.5 rounded-xl border border-[#dadad7] text-xs font-semibold text-[#414845]">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-2.5 rounded-xl bg-[#0f382c] text-white text-xs font-semibold shadow-sm hover:bg-[#1a5c44]">
                            Simpan Rekening
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        function setVerifTab(type) {
            const mhsBtn = document.getElementById('tab-v-mhs');
            const umumBtn = document.getElementById('tab-v-umum');
            const hiddenType = document.getElementById('hidden_id_type');
            const campusWrapper = document.getElementById('campus_field_wrapper');
            const idLabel = document.getElementById('id_number_label');

            if (!mhsBtn || !umumBtn) return;

            if (type === 'mahasiswa') {
                mhsBtn.className = "py-1.5 px-3 rounded-md text-[12px] transition-all shadow-xs bg-[#0f382c] text-white font-semibold text-center";
                umumBtn.className = "py-1.5 px-3 rounded-md text-[12px] transition-all text-[#414845] hover:text-[#0f382c] font-medium text-center";
                if (hiddenType) hiddenType.value = 'ktm';
                if (campusWrapper) campusWrapper.classList.remove('hidden');
                if (idLabel) idLabel.textContent = 'NIM / Nomor Induk Mahasiswa';
            } else {
                umumBtn.className = "py-1.5 px-3 rounded-md text-[12px] transition-all shadow-xs bg-[#0f382c] text-white font-semibold text-center";
                mhsBtn.className = "py-1.5 px-3 rounded-md text-[12px] transition-all text-[#414845] hover:text-[#0f382c] font-medium text-center";
                if (hiddenType) hiddenType.value = 'ktp';
                if (campusWrapper) campusWrapper.classList.add('hidden');
                if (idLabel) idLabel.textContent = 'NIK e-KTP';
            }
        }

        function previewFile(input) {
            if (input.files && input.files[0]) {
                const label = document.getElementById('upload-label-text');
                const sub = document.getElementById('upload-sub-text');
                if (label) label.textContent = '✓ ' + input.files[0].name;
                if (sub) sub.textContent = 'Siap dikirim untuk verifikasi';
            }
        }
    </script>

</x-layouts.app>
