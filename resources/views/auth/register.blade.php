<x-layouts.guest title="Daftar Akun — Kuantum Pelopor Indonesia">

    <div class="w-full max-w-sm mx-auto">

        {{-- Brand Badge --}}
        <div class="flex flex-col items-center mb-6">
            <div class="flex items-center gap-2 mb-4 px-3 py-1.5 rounded-full text-xs font-medium"
                 style="background: #E8F5E9; color: #1A5C44; border: 1px solid #A5D6A7;">
                <span>★</span>
                <span>Portal Dakwah Terverifikasi</span>
            </div>

            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-3 shadow-md"
                 style="background: #0F382C;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.966 8.966 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>

            <h1 class="text-2xl font-bold" style="font-family: 'Noto Serif', serif; color: #0F382C;">
                Buat Akun
            </h1>
            <p class="text-sm mt-1" style="color: #6B7280;">Bergabung dan bagikan karya Islami Anda</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-sm p-6" style="border: 1px solid #E5E7EB;">

            {{-- Tab Switcher --}}
            <div class="flex gap-1 p-1 rounded-xl mb-5" style="background: #F3F4F6;" role="tablist">
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
                <form method="POST" action="{{ route('register.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="user_type" value="umum">
                    @include('auth._register-fields', ['userType' => 'umum'])
                </form>
            </div>

            {{-- Tab Panel: Mahasiswa --}}
            <div id="panel-mahasiswa" role="tabpanel" aria-labelledby="tab-mahasiswa" class="hidden">
                <form method="POST" action="{{ route('register.store') }}" novalidate>
                    @csrf
                    <input type="hidden" name="user_type" value="mahasiswa">
                    @include('auth._register-fields', ['userType' => 'mahasiswa'])
                </form>
            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-3 mt-5 mb-4">
                <div class="flex-1 h-px" style="background: #E5E7EB;"></div>
                <span class="text-xs" style="color: #9CA3AF;">atau</span>
                <div class="flex-1 h-px" style="background: #E5E7EB;"></div>
            </div>

            {{-- Google OAuth (placeholder) --}}
            <button type="button"
                    class="w-full flex items-center justify-center gap-3 py-3 rounded-xl text-sm font-medium transition-all hover:bg-gray-50 active:scale-95"
                    style="border: 1.5px solid #E5E7EB; color: #374151; background: white;">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Daftar dengan Google
            </button>

        </div>

        {{-- Footer link --}}
        <p class="text-center text-sm mt-6" style="color: #6B7280;">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-semibold" style="color: #0F382C;">
                Masuk Sekarang
            </a>
        </p>

    </div>

    <script>
        const activeTabStyle   = { background: '#0F382C', color: '#FFFFFF', boxShadow: '0 1px 3px rgba(0,0,0,0.1)' };
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

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        // Init tab from old input or default
        switchTab('{{ old('user_type', 'umum') }}');
    </script>

</x-layouts.guest>
