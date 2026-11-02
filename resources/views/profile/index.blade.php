<x-layouts.app title="Profil Saya — Kuantum Pelopor Indonesia">

    <div class="px-4 py-4 space-y-4">

        {{-- Profile Header Card --}}
        <div class="bg-white rounded-3xl p-5 border border-[#E5E7EB] shadow-2xs">
            <div class="flex items-center gap-3.5">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         alt="{{ $user->name }}"
                         class="w-14 h-14 rounded-full object-cover ring-2 ring-[#0F382C]">
                @else
                    <div class="w-14 h-14 rounded-full bg-[#0F382C] text-white flex items-center justify-center font-bold text-lg ring-2 ring-[#D4AF37]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-1">
                    <h2 class="text-sm font-bold text-[#0F382C] font-serif">
                        {{ $user->name }}
                    </h2>
                    <p class="text-[11px] text-[#6B7280]">
                        {{ $user->email }}
                    </p>
                    <div class="mt-1 flex items-center gap-1.5">
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold {{ $user->is_verified ? 'bg-[#E8F5E9] text-[#16A34A]' : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->is_verified ? 'Terverifikasi' : 'Belum Diverifikasi' }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-[#E8F5E9] text-[#0F382C] uppercase">
                            {{ $user->user_type }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Logout form --}}
            <div class="mt-4 pt-3 border-t border-[#F0F0EA] flex justify-end">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-xs font-semibold text-red-600 hover:text-red-700 transition-colors">
                        Keluar dari Akun →
                    </button>
                </form>
            </div>
        </div>

        {{-- Notice / Issue #4 Preview --}}
        <div class="p-4 rounded-2xl bg-[#E8F5E9] border border-[#A5D6A7]/60 text-[#0F382C] text-xs space-y-1">
            <p class="font-bold">✨ Halaman Profil &amp; Rekening Bank</p>
            <p class="text-[11px] text-[#1A5C44]">
                Fitur lengkap verifikasi KTM/KTP dan manajemen rekening penyaluran donasi akan dikerjakan pada Issue #4.
            </p>
        </div>

    </div>

</x-layouts.app>
