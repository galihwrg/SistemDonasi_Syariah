{{--
    Partial: Register Fields
    Variable: $userType ('umum' | 'mahasiswa')
--}}

<div class="space-y-4">

    {{-- Nama Lengkap --}}
    <div>
        <label for="name-{{ $userType }}" class="block text-sm font-medium mb-1.5" style="color: #374151;">
            Nama Lengkap
        </label>
        <input
            type="text"
            id="name-{{ $userType }}"
            name="name"
            value="{{ old('name') }}"
            placeholder="Nama lengkap sesuai identitas"
            autocomplete="name"
            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
            style="border: 1.5px solid {{ $errors->has('name') ? '#DC2626' : '#E5E7EB' }};
                   background: {{ $errors->has('name') ? '#FEF2F2' : '#FAFAFA' }};"
            onfocus="this.style.borderColor='#0F382C'"
            onblur="this.style.borderColor='{{ $errors->has('name') ? '#DC2626' : '#E5E7EB' }}'"
        >
        @error('name')
            <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Khusus Mahasiswa: Nama Kampus + NIM --}}
    @if ($userType === 'mahasiswa')
        <div>
            <label for="campus_name" class="block text-sm font-medium mb-1.5" style="color: #374151;">
                Perguruan Tinggi
            </label>
            <input
                type="text"
                id="campus_name"
                name="campus_name"
                value="{{ old('campus_name') }}"
                placeholder="Universitas Pakuan"
                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                style="border: 1.5px solid {{ $errors->has('campus_name') ? '#DC2626' : '#E5E7EB' }};
                       background: {{ $errors->has('campus_name') ? '#FEF2F2' : '#FAFAFA' }};"
                onfocus="this.style.borderColor='#0F382C'"
                onblur="this.style.borderColor='{{ $errors->has('campus_name') ? '#DC2626' : '#E5E7EB' }}'"
            >
            @error('campus_name')
                <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nim_nik" class="block text-sm font-medium mb-1.5" style="color: #374151;">
                NIM / NIDN
            </label>
            <input
                type="text"
                id="nim_nik"
                name="nim_nik"
                value="{{ old('nim_nik') }}"
                placeholder="065121001"
                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                style="border: 1.5px solid {{ $errors->has('nim_nik') ? '#DC2626' : '#E5E7EB' }};
                       background: {{ $errors->has('nim_nik') ? '#FEF2F2' : '#FAFAFA' }};"
                onfocus="this.style.borderColor='#0F382C'"
                onblur="this.style.borderColor='{{ $errors->has('nim_nik') ? '#DC2626' : '#E5E7EB' }}'"
            >
            @error('nim_nik')
                <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
            @enderror
        </div>
    @endif

    {{-- Email --}}
    <div>
        <label for="email-{{ $userType }}" class="block text-sm font-medium mb-1.5" style="color: #374151;">
            Email Aktif
        </label>
        <input
            type="email"
            id="email-{{ $userType }}"
            name="email"
            value="{{ old('email') }}"
            placeholder="{{ $userType === 'mahasiswa' ? 'nama@unpak.ac.id' : 'nama@email.com' }}"
            autocomplete="email"
            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
            style="border: 1.5px solid {{ $errors->has('email') ? '#DC2626' : '#E5E7EB' }};
                   background: {{ $errors->has('email') ? '#FEF2F2' : '#FAFAFA' }};"
            onfocus="this.style.borderColor='#0F382C'"
            onblur="this.style.borderColor='{{ $errors->has('email') ? '#DC2626' : '#E5E7EB' }}'"
        >
        @error('email')
            <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor WhatsApp --}}
    <div>
        <label for="phone-{{ $userType }}" class="block text-sm font-medium mb-1.5" style="color: #374151;">
            Nomor WhatsApp / HP
        </label>
        <div class="flex gap-2">
            <div class="flex items-center px-3 rounded-xl text-sm shrink-0"
                 style="border: 1.5px solid #E5E7EB; background: #F3F4F6; color: #6B7280;">
                🇮🇩 +62
            </div>
            <input
                type="tel"
                id="phone-{{ $userType }}"
                name="phone_number"
                value="{{ old('phone_number') }}"
                placeholder="812-xxxx-xxxx"
                autocomplete="tel"
                class="flex-1 px-4 py-3 rounded-xl text-sm outline-none transition-all"
                style="border: 1.5px solid {{ $errors->has('phone_number') ? '#DC2626' : '#E5E7EB' }};
                       background: {{ $errors->has('phone_number') ? '#FEF2F2' : '#FAFAFA' }};"
                onfocus="this.style.borderColor='#0F382C'"
                onblur="this.style.borderColor='{{ $errors->has('phone_number') ? '#DC2626' : '#E5E7EB' }}'"
            >
        </div>
        @error('phone_number')
            <p class="mt-1 text-xs" style="color: #DC2626;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Password --}}
    <div>
        <label for="password-{{ $userType }}" class="block text-sm font-medium mb-1.5" style="color: #374151;">
            Kata Sandi
        </label>
        <div class="relative">
            <input
                type="password"
                id="password-{{ $userType }}"
                name="password"
                placeholder="Minimal 8 karakter"
                autocomplete="new-password"
                class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all pr-12"
                style="border: 1.5px solid {{ $errors->has('password') ? '#DC2626' : '#E5E7EB' }};
                       background: {{ $errors->has('password') ? '#FEF2F2' : '#FAFAFA' }};"
                onfocus="this.style.borderColor='#0F382C'"
                onblur="this.style.borderColor='{{ $errors->has('password') ? '#DC2626' : '#E5E7EB' }}'"
            >
            <button type="button" onclick="togglePassword('password-{{ $userType }}')"
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

    {{-- Konfirmasi Password --}}
    <div>
        <label for="password_confirmation-{{ $userType }}" class="block text-sm font-medium mb-1.5" style="color: #374151;">
            Konfirmasi Kata Sandi
        </label>
        <input
            type="password"
            id="password_confirmation-{{ $userType }}"
            name="password_confirmation"
            placeholder="Ulangi kata sandi"
            autocomplete="new-password"
            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
            style="border: 1.5px solid #E5E7EB; background: #FAFAFA;"
            onfocus="this.style.borderColor='#0F382C'"
            onblur="this.style.borderColor='#E5E7EB'"
        >
    </div>

    {{-- TOS Checkbox --}}
    <div class="flex items-start gap-3 pt-1">
        <input
            type="checkbox"
            id="agree_tos-{{ $userType }}"
            name="agree_tos"
            value="1"
            class="mt-0.5 w-4 h-4 rounded shrink-0"
            style="accent-color: #0F382C;"
            {{ old('agree_tos') ? 'checked' : '' }}
        >
        <label for="agree_tos-{{ $userType }}" class="text-sm leading-relaxed" style="color: #6B7280;">
            Saya menyetujui
            <a href="#" class="font-medium underline" style="color: #0F382C;">Ketentuan Layanan</a>
            &amp;
            <a href="#" class="font-medium underline" style="color: #0F382C;">Kebijakan Privasi Dakwah</a>
            yang berlaku.
        </label>
    </div>
    @error('agree_tos')
        <p class="text-xs" style="color: #DC2626;">{{ $message }}</p>
    @enderror

    {{-- Submit --}}
    <button type="submit"
            class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all hover:opacity-90 active:scale-95 shadow-sm mt-1"
            style="background: #0F382C;">
        Daftar Sekarang
    </button>

</div>
