<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Kuantum Pelopor Indonesia — Visual Dakwah & Infaq Syariah' }}</title>

    <!-- Google Fonts: Noto Serif, Plus Jakarta Sans, Amiri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Noto+Serif:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Google Material Symbols Outlined -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

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
                        arabic: ['Amiri', 'serif'],
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
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F0F0EA;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }
        .font-serif {
            font-family: 'Noto Serif', serif;
        }
        .font-arabic {
            font-family: 'Amiri', serif;
            direction: rtl;
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
        /* Hide scrollbars for chips */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        /* Mobile scrollbar styling */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-track {
            background: #F0F0EA;
        }
        ::-webkit-scrollbar-thumb {
            background: #2E7D5E;
            border-radius: 4px;
        }
    </style>
</head>
<body class="min-h-screen bg-[#F0F0EA] flex justify-center text-[#1A1A1A]">

    {{-- Background desktop ambient decoration --}}
    <div class="fixed inset-0 pointer-events-none hidden lg:block overflow-hidden" aria-hidden="true">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full opacity-10 bg-[#0F382C] blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full opacity-10 bg-[#D4AF37] blur-3xl"></div>
    </div>

    {{-- Mobile Container (402px / max-w-md centered) --}}
    <div class="w-full max-w-md min-h-screen bg-[#F9F9F6] shadow-2xl relative flex flex-col border-x border-[#E5E7EB]/60">

        {{-- Top Header --}}
        <x-header :title="$title ?? null" />

        {{-- Main Page Content --}}
        <main class="flex-1 pb-24">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        {{-- Bottom Navigation Bar (5 Menu) --}}
        <x-bottom-navbar />

    </div>

</body>
</html>
