<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        style="background: url('{{ asset('images/brand/login-bg.jpg') }}') no-repeat center center fixed; background-size: cover;">

        <!-- Language Switcher for Guest Pages -->
        <div class="fixed top-5 right-5 z-50">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="bg-white/50 backdrop-blur-md px-4 py-2 rounded-full border border-white/30 shadow-sm flex items-center gap-2 text-sm font-semibold text-gray-700 hover:bg-white/80 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5h12M9 3v2m1.048 9.5a18.062 18.062 0 01-1.427-4.503m1.427 4.503l.952 2.5m-3.411-4.503l.921-.497a17.96 17.96 0 001.49-4.5H3m14 1h3M18 13c1.333 0 2.667-.667 4-2m0 0l-1-1m1 1l-1 1" />
                    </svg>
                    <span>{{ strtoupper(app()->getLocale()) }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-32 rounded-xl bg-white/90 backdrop-blur-lg shadow-xl border border-white/20 overflow-hidden">
                    <form method="POST" action="{{ route('locale.update') }}">
                        @csrf
                        <button name="locale" value="en"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-orange-50 transition-colors flex items-center justify-between {{ app()->getLocale() == 'en' ? 'text-orange-600 font-bold' : 'text-gray-700' }}">
                            English
                        </button>
                        <button name="locale" value="ar"
                            class="w-full text-left px-4 py-2 text-sm hover:bg-orange-50 transition-colors flex items-center justify-between {{ app()->getLocale() == 'ar' ? 'text-orange-600 font-bold' : 'text-gray-700' }}">
                            العربية
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="text-center mb-4">
            <a href="/"
                class="text-4xl font-bold text-orange-500 transition-all hover:scale-110 inline-block drop-shadow-lg">
                <strong style="color: #333 text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">Kashmos</strong> <br>
                <span class="text-2xl" style="color: #555;">k-bizns</span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/80 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-[2rem] border border-white/20">
            {{ $slot }}
        </div>
    </div>
</body>

</html>