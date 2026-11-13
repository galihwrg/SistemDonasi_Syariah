<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panel Admin Kurasi — Kuantum Pelopor Indonesia' }}</title>

    <!-- Google Fonts: Noto Serif & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Google Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN fallback) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            emerald: '#0F382C',
                            'emerald-dark': '#0a261e',
                            'emerald-light': '#1b5644',
                            surface: '#F9F9F6',
                            border: '#E8E8E4',
                            gold: '#EAB308',
                            goldBadge: '#FEF08A'
                        }
                    },
                    fontFamily: {
                        serif: ['Noto Serif', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            background-color: #F9F9F6;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1F2937;
        }
        .font-serif-heading {
            font-family: 'Noto Serif', serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-[#0F382C] selection:text-white">

    <!-- Top Admin Navigation Bar (Stitch 100%) -->
    <header class="bg-white border-b border-[#E8E8E4] sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Left: Brand Logo & Identity --}}
                <div class="flex items-center space-x-3.5">
                    <div class="w-11 h-11 bg-[#0F382C] text-white rounded-xl flex items-center justify-center shadow-xs shrink-0">
                        <span class="material-symbols-outlined text-[24px] text-[#FED65B]">photo_library</span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-serif-heading font-bold text-[#0F382C] text-base tracking-tight">Kuantum Pelopor Indonesia</span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-[#FEF3C7] text-[#92400E] tracking-wider">
                                ADMIN
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium">Panel Kurasi &amp; Galeri Publik</p>
                    </div>
                </div>

                {{-- Center: Navigation Tabs --}}
                <nav class="hidden md:flex space-x-8 h-full items-end pb-[1px]">
                    {{-- Tab 1: Moderasi Foto (Aktif) --}}
                    <a href="{{ route('admin.curation.index') }}"
                       class="inline-flex items-center px-2 py-4 border-b-2 {{ request()->routeIs('admin.curation*') ? 'border-[#0F382C] text-[#0F382C] font-bold' : 'border-transparent text-gray-600 hover:text-[#0F382C]' }} text-sm gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">photo_library</span>
                        <span>Daftar Foto (Moderasi)</span>
                    </a>

                    {{-- Tab 2: Konfirmasi Akun (Sprint 3 Issue 11) --}}
                    <a href="#"
                       class="inline-flex items-center px-2 py-4 border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-[#0F382C] gap-2 transition-colors relative opacity-70">
                        <span class="material-symbols-outlined text-[18px]">verified_user</span>
                        <span>Konfirmasi Akun</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </a>

                    {{-- Tab 3: Lihat Galeri --}}
                    <a href="{{ route('jelajah') }}"
                       target="_blank"
                       class="inline-flex items-center px-2 py-4 border-b-2 border-transparent text-sm font-medium text-gray-600 hover:text-[#0F382C] gap-1.5 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                        <span>Lihat Galeri</span>
                        <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                    </a>
                </nav>

                {{-- Right: Admin Profile & Logout --}}
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2.5">
                        <div class="relative shrink-0">
                            <div class="w-9 h-9 rounded-full bg-[#0F382C] text-[#FED65B] flex items-center justify-center font-bold text-xs shadow-xs">
                                {{ strtoupper(substr(auth()->user()->name ?? 'AP', 0, 2)) }}
                            </div>
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="hidden lg:block text-left">
                            <p class="text-xs font-semibold text-gray-800 leading-tight">{{ auth()->user()->name ?? 'Admin Pelopor' }}</p>
                            <p class="text-[11px] text-[#166534] font-medium flex items-center gap-1">Super Administrator • Online</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-gray-500 hover:text-red-700 hover:bg-red-50 rounded-lg text-xs font-medium border border-transparent hover:border-red-200 transition-colors"
                                title="Keluar">
                            <span class="material-symbols-outlined text-[16px]">logout</span>
                            <span class="hidden sm:inline">Keluar</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    {{-- Main Content Layout --}}
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-7">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-[#E8E8E4] py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <h4 class="font-serif-heading font-bold text-[#0F382C] text-sm tracking-tight">Kuantum Pelopor Indonesia</h4>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                        Portal Kurasi Dakwah
                    </span>
                </div>
                <p class="text-xs text-gray-500">
                    © 2026 Kuantum Pelopor Indonesia. Media visual pencerah dan perekat ukhuwah.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-gray-500 font-medium">
                <a class="hover:text-[#0F382C] transition-colors" href="{{ route('home') }}">Beranda Utama</a>
                <a class="hover:text-[#0F382C] transition-colors" href="{{ route('jelajah') }}">Galeri Jelajah</a>
                <span class="text-gray-300">•</span>
                <span class="text-gray-400">Pedoman Etika &amp; Kurasi Dakwah Syariah</span>
            </div>
        </div>
    </footer>

</body>
</html>
