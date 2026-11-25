<x-layouts.guest title="Masuk Akun — Kuantum Pelopor Indonesia">

    <div class="w-full max-w-sm mx-auto">

        {{-- Navigasi Kembali ke Beranda --}}
        <div class="mb-4">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-[#E5E7EB] text-xs font-semibold text-[#0F382C] hover:bg-[#F3F4F6] transition-all shadow-2xs active:scale-95">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        {{-- Brand Badge --}}
        <div class="flex flex-col items-center mb-8">
            <div class="flex items-center gap-2 mb-4 px-3 py-1.5 rounded-full text-xs font-medium"
                 style="background: #E8F5E9; color: #1A5C44; border: 1px solid #A5D6A7;">
                <span>★</span>
                <span>Portal Dakwah Terverifikasi</span>
            </div>

            {{-- Logo KPi --}}
            <div class="mb-3">
                <x-application-logo class="h-16 w-auto object-contain rounded-2xl shadow-md" />
            </div>

            <h1 class="text-2xl font-bold" style="font-family: 'Noto Serif', serif; color: #0F382C;">
                Masuk Akun
            </h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Selamat datang kembali di Kuantum Pelopor Indonesia</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #E5E7EB;">

            {{-- Session Error Flash --}}
            @if (session('error'))
                <div class="mb-4 p-3 rounded-lg text-sm" style="background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA;">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tab Switcher --}}
            <div class="flex gap-1 p-1 rounded-xl mb-6" style="background: #F3F4F6;" role="tablist">
                <button type="button" id="tab-umum" role="tab" aria-selected="true" aria-controls="panel-umum"
                        onclick="switchTab('umum')"
                        class="tab-btn flex-1 py-2 px-3 rounded-lg text-sm font-medium transition-all duration-200">
                    Umum
                </button>
                <button type="button" id="tab-mahasiswa" role="tab" aria-selected="false" aria-controls="panel-mahasiswa"
                        onclick="switchTab('mahasiswa')"
                        class="tab-btn flex-1 py-2 px-3 rounded-lg text-sm font-medium transition-all duration-200">
                    Mahasiswa / Akademisi
                </button>
            </div>

            {{-- Tab Panel: Umum --}}
            <div id="panel-umum" role="tabpanel" aria-labelledby="tab-umum">
                <form method="POST" action="{{ route('login.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="user_type" value="umum">

                    <div class="space-y-4">

                        {{-- Credential --}}
                        <div>
                            <label for="credential-umum" class="block text-sm font-medium mb-1.5" style="color: #374151;">
                                Email atau Nama Pengguna
                            </label>
                            <input
                                type="text"
                                id="credential-umum"
                                name="credential"
                                value="{{ old('credential') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                style="border: 1.5px solid {{ $errors->has('credential') ? '#DC2626' : '#E5E7EB' }}; background: {{ $errors->has('credential') ? '#FEF2F2' : '#FAFAFA' }};"
                                onfocus="this.style.borderColor='#0F382C'"
                                onblur="this.style.borderColor='{{ $errors->has('credential') ? '#DC2626' : '#E5E7EB' }}'"
                            >
                            @error('credential')
                                <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="password-umum" class="block text-sm font-medium" style="color: #374151;">
                                    Kata Sandi
                                </label>
                                <a href="#" class="text-xs" style="color: #1A5C44;">Lupa kata sandi?</a>
                            </div>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password-umum"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all pr-12"
                                    style="border: 1.5px solid #E5E7EB; background: #FAFAFA;"
                                    onfocus="this.style.borderColor='#0F382C'"
                                    onblur="this.style.borderColor='#E5E7EB'"
                                >
                                <button type="button" onclick="togglePassword('password-umum', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1"
                                        style="color: #9CA3AF;" aria-label="Lihat kata sandi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="remember" name="remember" value="1"
                                   class="w-4 h-4 rounded" style="accent-color: #0F382C;">
                            <label for="remember" class="text-sm" style="color: #6B7280;">
                                Ingat saya selama 30 hari
                            </label>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all hover:opacity-90 active:scale-95 shadow-sm mt-2"
                                style="background: #0F382C;">
                            Masuk Akun
                        </button>

                    </div>
                </form>
            </div>

            {{-- Tab Panel: Mahasiswa --}}
            <div id="panel-mahasiswa" role="tabpanel" aria-labelledby="tab-mahasiswa" class="hidden">
                <form method="POST" action="{{ route('login.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="user_type" value="mahasiswa">

                    <div class="space-y-4">

                        {{-- Perguruan Tinggi (display only) --}}
                        <div>
                            <label class="block text-sm font-medium mb-1.5" style="color: #374151;">
                                Perguruan Tinggi
                            </label>
                            <div class="w-full px-4 py-3 rounded-xl text-sm" style="border: 1.5px solid #E5E7EB; background: #F3F4F6; color: #6B7280;">
                                Terisi otomatis saat daftar
                            </div>
                        </div>

                        {{-- NIM / Email Kampus --}}
                        <div>
                            <label for="credential-mhs" class="block text-sm font-medium mb-1.5" style="color: #374151;">
                                NIM / NIDN / Email Kampus
                            </label>
                            <input
                                type="text"
                                id="credential-mhs"
                                name="credential"
                                value="{{ old('credential') }}"
                                placeholder="065121001 atau nama@unpak.ac.id"
                                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                                style="border: 1.5px solid #E5E7EB; background: #FAFAFA;"
                                onfocus="this.style.borderColor='#0F382C'"
                                onblur="this.style.borderColor='#E5E7EB'"
                            >
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password-mhs" class="block text-sm font-medium mb-1.5" style="color: #374151;">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <input
                                    type="password"
                                    id="password-mhs"
                                    name="password"
                                    placeholder="Kata sandi akun"
                                    class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all pr-12"
                                    style="border: 1.5px solid #E5E7EB; background: #FAFAFA;"
                                    onfocus="this.style.borderColor='#0F382C'"
                                    onblur="this.style.borderColor='#E5E7EB'"
                                >
                                <button type="button" onclick="togglePassword('password-mhs', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1"
                                        style="color: #9CA3AF;" aria-label="Lihat kata sandi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                                class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all hover:opacity-90 active:scale-95 shadow-sm mt-2"
                                style="background: #0F382C;">
                            Masuk Portal Akademik
                        </button>

                    </div>
                </form>
            </div>

        </div>

        {{-- Footer link --}}
        <p class="text-center text-sm mt-6" style="color: #6B7280;">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold" style="color: #0F382C;">
                Daftar Sekarang
            </a>
        </p>

    </div>

    {{-- Tab Script --}}
    <script>
        const activeTabStyle  = { background: '#0F382C', color: '#FFFFFF', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' };
        const inactiveTabStyle = { background: 'transparent', color: '#6B7280', boxShadow: 'none' };

        function applyStyle(el, styles) {
            Object.assign(el.style, styles);
        }

        function switchTab(type) {
            const tabs   = ['umum', 'mahasiswa'];
            const panels = { umum: document.getElementById('panel-umum'), mahasiswa: document.getElementById('panel-mahasiswa') };
            const btns   = { umum: document.getElementById('tab-umum'),   mahasiswa: document.getElementById('tab-mahasiswa') };

            tabs.forEach(t => {
                if (t === type) {
                    panels[t].classList.remove('hidden');
                    applyStyle(btns[t], activeTabStyle);
                    btns[t].setAttribute('aria-selected', 'true');
                } else {
                    panels[t].classList.add('hidden');
                    applyStyle(btns[t], inactiveTabStyle);
                    btns[t].setAttribute('aria-selected', 'false');
                }
            });
        }

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Init active tab
        switchTab('{{ old('user_type', 'umum') }}');
    </script>

</x-layouts.guest>
