<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Kuantum Pelopor Indonesia' }}</title>

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

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F9F9F6;
            color: #1A1A1A;
            -webkit-font-smoothing: antialiased;
        }
        .font-serif {
            font-family: 'Noto Serif', serif;
        }
    </style>
</head>
<body class="min-h-screen" style="background-color: #F9F9F6;">

    <!-- Background decorative -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-5"
             style="background: #0F382C;"></div>
        <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full opacity-5"
             style="background: #D4AF37;"></div>
    </div>

    <main class="relative z-10 flex flex-col items-center justify-center min-h-screen px-4 py-8">
        {{ $slot }}
    </main>

</body>
</html>
