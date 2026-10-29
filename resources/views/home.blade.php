<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda — Kuantum Pelopor Indonesia</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN fallback) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            deep: '#0F382C',
                            medium: '#1A5C44',
                            light: '#2E7D5E',
                        },
                        gold: {
                            DEFAULT: '#D4AF37',
                            light: '#E8CC5A',
                        },
                        eggshell: {
                            DEFAULT: '#F9F9F6',
                            dark: '#F0F0EA',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Noto Serif', 'serif'],
                    }
                }
            }
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body style="background: #F9F9F6; font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="flex flex-col items-center justify-center min-h-screen px-4 text-center">
        {{-- Logo KPi --}}
        <div class="mb-4">
            <x-application-logo class="h-16 w-auto object-contain rounded-2xl shadow-md" />
        </div>

        @auth
            <h1 class="text-2xl font-bold mb-2" style="font-family: 'Noto Serif', serif; color: #0F382C;">
                Selamat Datang, {{ auth()->user()->name }}! 🎉
            </h1>
            <p class="text-sm mb-6" style="color: #6B7280;">
                Issue #2 berhasil: Autentikasi dual-tab bekerja dengan baik.
            </p>

            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-xl text-sm" style="background: #ECFDF5; color: #16A34A; border: 1px solid #86EFAC;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="text-xs px-4 py-3 rounded-xl mb-6" style="background: white; border: 1px solid #E5E7EB; color: #6B7280;">
                Role: <strong style="color: #0F382C;">{{ auth()->user()->role }}</strong> |
                Tipe: <strong style="color: #0F382C;">{{ auth()->user()->user_type }}</strong> |
                Verified: <strong style="color: {{ auth()->user()->is_verified ? '#16A34A' : '#DC2626' }}">
                    {{ auth()->user()->is_verified ? 'Ya' : 'Belum' }}
                </strong>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="px-6 py-3 rounded-xl text-sm font-medium transition-all hover:opacity-80 shadow-sm"
                        style="background: #0F382C; color: white;">
                    Keluar dari Akun
                </button>
            </form>
        @else
            <h1 class="text-2xl font-bold mb-2" style="font-family: 'Noto Serif', serif; color: #0F382C;">
                Kuantum Pelopor Indonesia
            </h1>
            <p class="text-sm mb-6" style="color: #6B7280;">
                Galeri Visual Islami &amp; Platform Donasi Infaq Syariah
            </p>

            <div class="flex gap-3">
                <a href="{{ route('login') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all shadow-sm"
                   style="background: #0F382C;">
                    Masuk Akun
                </a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all border"
                   style="border-color: #0F382C; color: #0F382C; background: white;">
                    Daftar Sekarang
                </a>
            </div>
        @endauth

        <p class="text-xs mt-6" style="color: #9CA3AF;">
            Halaman beranda akan dibangun di Issue #3 dan seterusnya.
        </p>
    </div>
</body>
</html>
