<x-layouts.guest title="Daftar Akun — Kuantum Pelopor Indonesia">

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
        <div class="flex flex-col items-center mb-6">
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
