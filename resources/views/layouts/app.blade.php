<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>K-bizns | KASHMOS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/kashmos-logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/kashmos-logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/eagle-horizon" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        :root {
            --bg-color: #faf3e8;
            --text-color: #4a3b2f;
            --nav-bg: #eee1d1;
            --nav-border: #d6bfa7;
            --header-bg: #d9c9b4;
            --header-border: #c4aa8b;
            --header-text: #3e2e21;
            --content-bg: #fff9f0;
            --content-border: #e2d5c0;
            --accent-bg: #c9b39b;
            --accent-text: #2f2117;
            --accent-border: #b2967a;
            --nav-link-bg: transparent;
            --nav-link-color: #4c3827;
            --btn-bg: #f4e2d1;
            --btn-border: #dbbf9f;
            --btn-hover-bg: #dbbf9f;
            --btn-text: #4c3827;
            --table-header-bg: #e3cfb6;
            --table-header-color: #4a3b2f;
            --table-border: #d3b392;
            --row-hover-bg: #f7efe2;
            --row-border: #e2d5c0;
            --title-color: #5f4230;
            --card-shadow: 0 10px 18px -8px #d0b79c;
            --badge-bg: #f4e2d1;
            --badge-border: #dbbf9f;
        }

        [data-theme="majestic"] {
            --bg-color: #e5d5f5;
            --text-color: #2d1b3c;
            --nav-bg: #e7d5fc;
            --nav-border: #cbb2ea;
            --header-bg: #6d43a3;
            --header-border: #ccb2f0;
            --header-text: #ffffff;
            --content-bg: #faf3ff;
            --content-border: #dac0fc;
            --accent-bg: #d9befa;
            --accent-text: #1d0c31;
            --accent-border: #b28fdf;
            --nav-link-bg: transparent;
            --nav-link-color: #311f4a;
            --btn-bg: #d9befa;
            --btn-border: #b28fdf;
            --btn-hover-bg: #cbb2ea;
            --btn-text: #1d0c31;
            --table-header-bg: #6d43a3;
            --table-header-color: #ffffff;
            --table-border: #ccb2f0;
            --row-hover-bg: #e9d8ff;
            --row-border: #dac0fc;
            --title-color: #2b1048;
            --card-shadow: 0 10px 18px -8px rgba(110, 40, 160, 0.3);
            --badge-bg: #e1cefc;
            --badge-border: #a27ed2;
        }

        [data-theme="azure"] {
            --bg-color: #d9e9fa;
            --text-color: #1a2b3e;
            --nav-bg: #d7e7fa;
            --nav-border: #aac4df;
            --header-bg: #3777a8;
            --header-border: #9ac0db;
            --header-text: #ffffff;
            --content-bg: #f4fafd;
            --content-border: #c3dbfa;
            --accent-bg: #bed9ff;
            --accent-text: #001e3b;
            --accent-border: #7fa9d0;
            --nav-link-bg: transparent;
            --nav-link-color: #0f3b5c;
            --btn-bg: #bed9ff;
            --btn-border: #7fa9d0;
            --btn-hover-bg: #aac4df;
            --btn-text: #001e3b;
            --table-header-bg: #3777a8;
            --table-header-color: #ffffff;
            --table-border: #9ac0db;
            --row-hover-bg: #daeaff;
            --row-border: #c3dbfa;
            --title-color: #043458;
            --card-shadow: 0 10px 18px -8px rgba(26, 76, 128, 0.3);
            --badge-bg: #c4ddfc;
            --badge-border: #749ec9;
        }

        /* Mobile nav drawer */
        .mobile-menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            font-weight: 500;
            color: var(--nav-link-color);
            text-decoration: none;
            transition: background 0.2s;
        }

        .mobile-menu-link:hover {
            background: var(--accent-bg);
            color: var(--accent-text);
        }

        /* Responsive content box */
        .content-box {
            background-color: var(--content-bg);
            border-radius: 2.5rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid var(--content-border);
            padding: 2.5rem;
        }

        @media (max-width: 640px) {
            .content-box {
                border-radius: 1.5rem;
                padding: 1.25rem;
            }
        }
    </style>
</head>

<body class="font-sans antialiased" data-theme="{{ $currentTheme ?? 'royal' }}"
    style="background-color: var(--bg-color); color: var(--text-color); transition: all 0.3s ease;">

    <div class="min-h-screen flex flex-col">

        <!-- Navigation -->
        <nav x-data="{ open: false }"
            style="background-color: var(--nav-bg); border-bottom: 1px solid var(--nav-border); position: sticky; top: 0; z-index: 40; backdrop-filter: blur(8px);">

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">

                    <!-- Left: Logo + page title -->
                    <div class="flex items-center min-w-0">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 flex-shrink-0 whitespace-nowrap"
                            style="text-decoration: none;">
                            <img src="{{ asset('images/kashmos-logo.png') }}" alt="KASHMOS"
                                style="height: 36px; width: 36px; border-radius: 50%;">
                            <span class="font-bold text-xl hidden xs:inline sm:inline"
                                style="color: var(--nav-link-color); font-family: 'Eagle Horizon-Personal use', sans-serif;">K-bizns</span>
                        </a>

                        @isset($header)
                            <div class="h-6 w-px bg-[var(--nav-border)] mx-3 hidden md:block"></div>
                            <h1 class="font-semibold text-base truncate hidden md:block"
                                style="color: var(--nav-link-color);">
                                {{ $header }}
                            </h1>
                        @endisset

                        <!-- Desktop Nav Links -->
                        @php
                            $navStyle = "color: var(--nav-link-color); background: var(--nav-link-bg); padding: 0.4rem 0.85rem; border-radius: 40px; font-weight: 500; transition: all 0.2s; border: 1px solid transparent; white-space: nowrap; font-size: 0.875rem;";
                            $navHover = "this.style.background='var(--accent-bg)'; this.style.color='var(--accent-text)'; this.style.borderColor='var(--accent-border)';";
                            $navOut = "this.style.background='var(--nav-link-bg)'; this.style.color='var(--nav-link-color)'; this.style.borderColor='transparent';";
                        @endphp
                        <div class="hidden lg:flex items-center gap-1.5 ml-4">
                            <a href="{{ route('dashboard') }}" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.dashboard') }}
                            </a>
                            <a href="{{ route('clients.index') }}" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.companies') }}
                            </a>
                            <a href="{{ route('contacts.index') }}" style="{{ $navStyle }}"
                                onmouseover="{{ $navHover }}" onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.contacts') }}
                            </a>
                            <a href="{{ route('deals.index') }}" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.deals') }}
                            </a>
                            <a href="{{ route('deals.kanban') }}" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.kanban') }}
                            </a>
                            <a href="{{ route('users.index') }}" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                onmouseout="{{ $navOut }}" class="flex items-center">
                                {{ __('messages.users') }}
                            </a>
                            @can('manage company')
                                <a href="{{ route('super-admin.companies.index') }}" style="{{ $navStyle }}"
                                    onmouseover="{{ $navHover }}" onmouseout="{{ $navOut }}" class="flex items-center">
                                    Super Admin
                                </a>
                            @endcan
                        </div>
                    </div>

                    <!-- Right: Utilities + Hamburger -->
                    <div class="flex items-center gap-1.5">

                        <!-- Desktop utilities -->
                        <div class="hidden lg:flex items-center gap-1.5">
                            @auth
                                <a href="{{ route('company-settings.index') }}" style="{{ $navStyle }}"
                                    onmouseover="{{ $navHover }}" onmouseout="{{ $navOut }}" class="flex items-center">
                                    {{ __('messages.company_settings') }}
                                </a>
                                <a href="{{ route('company-info.show') }}" style="{{ $navStyle }}"
                                    onmouseover="{{ $navHover }}" onmouseout="{{ $navOut }}" class="flex items-center">
                                    {{ __('messages.about_us') }}
                                </a>

                                <!-- Language Switcher -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                        onmouseout="{{ $navOut }}" class="flex items-center gap-2">
                                        <span class="text-xs font-bold uppercase">{{ app()->getLocale() }}</span>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-40 rounded-2xl shadow-xl z-50 overflow-hidden"
                                        style="background-color: var(--content-bg); border: 1px solid var(--nav-border);">
                                        <form method="POST" action="{{ route('locale.update') }}">
                                            @csrf
                                            <button name="locale" value="en"
                                                class="w-full text-left px-4 py-3 text-sm hover:opacity-80 transition-opacity flex items-center justify-between"
                                                style="color: var(--text-color); border-bottom: 1px solid var(--nav-border);">
                                                <span>English</span>
                                                @if(app()->getLocale() == 'en') <span class="text-green-500">✓</span> @endif
                                            </button>
                                            <button name="locale" value="ar"
                                                class="w-full text-left px-4 py-3 text-sm hover:opacity-80 transition-opacity flex items-center justify-between"
                                                style="color: var(--text-color);">
                                                <span>العربية</span>
                                                @if(app()->getLocale() == 'ar') <span class="text-green-500">✓</span> @endif
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Theme Switcher -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                        onmouseout="{{ $navOut }}" class="flex items-center gap-2">
                                        <div
                                            style="width: 18px; height: 18px; border-radius: 50%; background: conic-gradient(red, yellow, lime, aqua, blue, magenta, red); border: 1px solid rgba(0,0,0,0.1);">
                                        </div>
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 rounded-2xl shadow-xl z-50 overflow-hidden"
                                        style="background-color: var(--content-bg); border: 1px solid var(--nav-border);">
                                        <form method="POST" action="{{ route('theme.update') }}">
                                            @csrf
                                            <button name="theme" value="royal"
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-gray-100 transition-colors"
                                                style="color: var(--text-color); border-bottom: 1px solid var(--nav-border);">Royal
                                                (Classic)</button>
                                            <button name="theme" value="majestic"
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-gray-100 transition-colors"
                                                style="color: var(--text-color); border-bottom: 1px solid var(--nav-border);">Majestic
                                                (Purple)</button>
                                            <button name="theme" value="azure"
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-gray-100 transition-colors"
                                                style="color: var(--text-color);">Azure (Blue)</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" style="{{ $navStyle }}" onmouseover="{{ $navHover }}"
                                        onmouseout="{{ $navOut }}" class="flex items-center" title="Logout">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth
                        </div>

                        <!-- Hamburger (mobile only) -->
                        <button @click="open = !open"
                            class="lg:hidden flex items-center justify-center w-10 h-10 rounded-xl transition-colors"
                            style="color: var(--nav-link-color); background: var(--btn-bg); border: 1px solid var(--btn-border);"
                            aria-label="Toggle menu">
                            <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="open" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="lg:hidden border-t" style="background-color: var(--nav-bg); border-color: var(--nav-border);">
                <div class="px-4 py-4 space-y-1">
                    @isset($header)
                        <div class="px-3 py-2 text-sm font-semibold opacity-60 uppercase tracking-wider"
                            style="color: var(--nav-link-color);">
                            {{ $header }}
                        </div>
                    @endisset

                    <a href="{{ route('dashboard') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">🏠</span> {{ __('messages.dashboard') }}
                    </a>
                    <a href="{{ route('clients.index') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">🏢</span> {{ __('messages.companies') }}
                    </a>
                    <a href="{{ route('contacts.index') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">👥</span> {{ __('messages.contacts') }}
                    </a>
                    <a href="{{ route('deals.index') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">💼</span> {{ __('messages.deals') }}
                    </a>
                    <a href="{{ route('deals.kanban') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">📊</span> {{ __('messages.kanban') }}
                    </a>
                    <a href="{{ route('users.index') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">👤</span> {{ __('messages.users') }}
                    </a>
                    @can('manage company')
                        <a href="{{ route('super-admin.companies.index') }}" class="mobile-menu-link" @click="open = false">
                            <span class="mr-3">⚙️</span> Super Admin
                        </a>
                    @endcan
                    <a href="{{ route('company-settings.index') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">🔧</span> {{ __('messages.company_settings') }}
                    </a>
                    <a href="{{ route('company-info.show') }}" class="mobile-menu-link" @click="open = false">
                        <span class="mr-3">ℹ️</span> {{ __('messages.about_us') }}
                    </a>

                    <div class="pt-3 mt-3 border-t flex items-center gap-2 flex-wrap"
                        style="border-color: var(--nav-border);">
                        <!-- Language -->
                        <form method="POST" action="{{ route('locale.update') }}" class="inline">
                            @csrf
                            <button name="locale" value="{{ app()->getLocale() == 'en' ? 'ar' : 'en' }}"
                                class="mobile-menu-link px-4 py-2 text-sm"
                                style="background: var(--btn-bg); border: 1px solid var(--btn-border); border-radius: 1rem;">
                                🌐 {{ app()->getLocale() == 'en' ? 'العربية' : 'English' }}
                            </button>
                        </form>
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="mobile-menu-link px-4 py-2 text-sm"
                                style="background: var(--btn-bg); border: 1px solid var(--btn-border); border-radius: 1rem;">
                                🚪 {{ __('messages.logout') ?? 'Logout' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-4 sm:py-8 flex-grow">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
                <div class="content-box">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer
            style="background-color: var(--nav-bg); color: var(--text-color); padding: 1rem 1.5rem; border-top: 2px solid var(--nav-border); backdrop-filter: blur(8px); position: sticky; bottom: 0; z-index: 40;">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
                <div style="font-size: 0.85rem; color: #543d2b; font-weight: 500;">
                    © 2015 - {{ date('Y') }} <span
                        style="font-family: 'Eagle Horizon-Personal use', sans-serif;">KASHMOS</span>
                </div>
                <div style="font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="opacity: 0.8;">{{ __('messages.powered_by') }}</span>
                    <a href="{{ route('company-info.show') }}"
                        style="display: flex; align-items: center; gap: 0.4rem; color: #2f241b; font-weight: 700; text-decoration: none; background: rgba(255,255,255,0.2); padding: 0.25rem 0.7rem; border-radius: 20px; transition: all 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.4)'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.transform='scale(1)';">
                        <img src="{{ asset('images/kashmos-logo.png') }}" alt="KASHMOS"
                            style="height: 18px; width: 18px; border-radius: 50%;">
                        <span style="font-family: 'Eagle Horizon-Personal use', sans-serif;">KASHMOS</span>
                    </a>
                </div>
            </div>
        </footer>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>