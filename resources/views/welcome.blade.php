<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kashmos | IT Services & Business Development</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/eagle-horizon" rel="stylesheet">

    <!-- Scripts / Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kashmos: {
                            prime: '#1a103d', // Deep Majestic Purple
                            accent: '#facc15', // Vibrant Gold
                            muted: '#a855f7', // Soft Purple
                            dark: '#0f172a',  // Slate Dark
                        }
                    },
                    fontFamily: {
                        sans: ['Figtree', 'sans-serif'],
                        display: ['Eagle Horizon', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #facc15 0%, #fb923c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-pattern {
            background-color: #0f172a;
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.05) 1px, transparent 0);
            background-size: 32px 32px;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body
    class="bg-kashmos-dark text-slate-200 antialiased font-sans selection:bg-kashmos-accent selection:text-kashmos-prime">

    <!-- Navigation -->
    <nav x-data="{ open: false, atTop: true }" @scroll.window="atTop = (window.pageYOffset > 20 ? false : true)"
        :class="atTop ? 'bg-transparent py-6' : 'glass py-4 shadow-2xl'"
        class="fixed w-full z-50 transition-all duration-300 px-6 lg:px-12 flex justify-between items-center">

        <a href="#" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
            <img src="{{ asset('images/kashmos-logo.png') }}"
                class="h-10 w-10 border-2 border-kashmos-accent rounded-full p-0.5" alt="Kashmos Logo">
            <span class="text-2xl font-display text-white tracking-widest uppercase">Kashmos</span>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center gap-8">
            <a href="#about" class="hover:text-kashmos-accent transition-colors">{{ __('messages.about_us') }}</a>
            <a href="#services" class="hover:text-kashmos-accent transition-colors">{{ __('messages.services') }}</a>
            <a href="#contact" class="hover:text-kashmos-accent transition-colors">{{ __('messages.contact') }}</a>

            @if (Route::has('login'))
                <div class="flex items-center gap-4 ml-6 pl-6 border-l border-white/10">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-6 py-2 bg-kashmos-accent text-kashmos-prime font-bold rounded-full hover:scale-105 transition-transform">{{ __('messages.dashboard') }}</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-6 py-2 bg-transparent border border-kashmos-accent text-kashmos-accent font-bold rounded-full hover:bg-kashmos-accent hover:text-kashmos-prime transition-all">{{ __('messages.login') }}</a>
                    @endauth
                </div>
            @endif
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="open = !open" class="lg:hidden text-white">
            <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
            <svg x-show="open" x-cloak class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Mobile Menu -->
        <div x-show="open" x-cloak x-transition
            class="absolute top-full left-0 w-full glass p-8 flex flex-col gap-6 lg:hidden border-t border-white/10 shadow-3xl">
            <a @click="open = false" href="#about" class="text-xl">About</a>
            <a @click="open = false" href="#services" class="text-xl">Services</a>
            <a @click="open = false" href="#contact" class="text-xl">Contact</a>
            <hr class="border-white/10">
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="w-full py-3 bg-kashmos-accent text-kashmos-prime text-center font-bold rounded-xl">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full py-3 bg-kashmos-accent text-kashmos-prime text-center font-bold rounded-xl">Log In</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center pt-20 overflow-hidden hero-pattern">
        <!-- Background Accents -->
        <div
            class="absolute top-0 right-0 w-[600px] h-[600px] bg-kashmos-muted/10 blur-[120px] rounded-full -mr-40 -mt-40">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-kashmos-accent/5 blur-[100px] rounded-full -ml-20 -mb-20">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-12 items-center relative z-10">
            <div>
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 glass rounded-full text-sm font-medium text-kashmos-accent mb-6">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-kashmos-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-kashmos-accent"></span>
                    </span>
                    IT Excellence Since 2015
                </div>
                <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-[1.1] mb-6">
                    {{ __('messages.hero_title_1') }} <span
                        class="gradient-text">{{ __('messages.hero_title_2') }}</span>
                </h1>
                <p class="text-xl text-slate-400 mb-10 leading-relaxed max-w-xl">
                    {{ __('messages.hero_description') }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#services"
                        class="px-8 py-4 bg-kashmos-accent text-kashmos-prime font-bold rounded-2xl hover:shadow-[0_0_30px_rgba(250,204,21,0.3)] hover:-translate-y-1 transition-all duration-300">Explore
                        Services</a>
                    <a href="#contact"
                        class="px-8 py-4 glass text-white font-bold rounded-2xl hover:bg-white/5 transition-all">Get in
                        Touch</a>
                </div>
            </div>

            <div class="hidden lg:block relative">
                <div class="float relative z-10">
                    <div class="glass p-8 rounded-[2.5rem] shadow-4xl relative overflow-hidden group">
                        <!-- Abstract Dashboard Representation -->
                        <div class="flex gap-4 mb-6">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-kashmos-accent to-orange-400">
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="h-4 w-1/2 bg-white/10 rounded-full"></div>
                                <div class="h-3 w-1/3 bg-white/5 rounded-full"></div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="h-24 glass rounded-2xl border-white/5 flex items-center justify-center">
                                <span class="text-white/20 font-display text-4xl tracking-widest">KASHMOS</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="h-16 glass rounded-2xl border-white/5"></div>
                                <div class="h-16 glass rounded-2xl border-white/10"></div>
                            </div>
                            <div class="h-32 glass rounded-2xl border-white/5 bg-kashmos-accent/5"></div>
                        </div>
                        <!-- Decorative glow -->
                        <div
                            class="absolute -bottom-10 -right-10 w-40 h-40 bg-kashmos-accent/20 blur-[60px] rounded-full">
                        </div>
                    </div>
                </div>
                <!-- Extra tech elements -->
                <div class="absolute -top-10 -right-4 w-24 h-24 glass rounded-3xl -rotate-12 border-kashmos-accent/20">
                </div>
                <div class="absolute -bottom-6 -left-8 w-16 h-16 glass rounded-full border-white/10"></div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-8">
                    <div>
                        <h2 class="text-kashmos-accent font-bold tracking-widest uppercase mb-4">{{ __('messages.about_kashmos') }}</h2>
                        <h3 class="text-4xl lg:text-5xl font-bold text-white leading-tight">{{ __('messages.about_title') }}</h3>
                    </div>
                    <p class="text-lg text-slate-400">
                        {{ __('messages.about_description') }}
                    </p>
                    <div class="grid grid-cols-2 gap-8">
                        <div class="p-6 glass rounded-3xl border-kashmos-accent/10">
                            <div class="text-3xl font-bold text-kashmos-accent mb-2">9+</div>
                            <div class="text-slate-400 text-sm">{{ __('messages.years_excellence') }}</div>
                        </div>
                        <div class="p-6 glass rounded-3xl border-kashmos-accent/10">
                            <div class="text-3xl font-bold text-kashmos-accent mb-2">100%</div>
                            <div class="text-slate-400 text-sm">{{ __('messages.client_roi') }}</div>
                        </div>
                    </div>
                </div>

                <div class="glass p-8 lg:p-12 rounded-[3rem] border-white/5 relative">
                    <div
                        class="absolute -top-6 -right-6 px-6 py-3 bg-kashmos-accent text-kashmos-prime font-black rounded-2xl shadow-xl">
                        {{ __('messages.our_mission') }}</div>
                    <p class="text-2xl font-medium text-white italic leading-relaxed mb-8">
                        "{{ __('messages.mission_quote') }}"
                    </p>
                    <hr class="border-white/10 mb-8">
                    <div class="space-y-4">
                        <h4 class="text-kashmos-accent font-bold">Our Philosophy</h4>
                        <p class="text-slate-400">Technology must drive performance, not just operate systems. We are
                            not just service providers. We are long-term technology partners.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-24 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-kashmos-accent font-bold tracking-widest uppercase mb-4">{{ __('messages.what_we_do') }}</h2>
                <h3 class="text-4xl lg:text-5xl font-bold text-white mb-6">{{ __('messages.services_title') }}</h3>
                <p class="text-slate-400 text-lg">{{ __('messages.services_description') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Service 1 -->
                <div
                    class="group p-8 glass rounded-[2.5rem] hover:bg-white/[0.05] transition-all duration-500 border-white/5 hover:border-kashmos-accent/20">
                    <div
                        class="w-14 h-14 bg-kashmos-accent/10 rounded-2xl flex items-center justify-center text-kashmos-accent mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Custom Applications</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Scalable, secure systems like CRM, ERP, and
                        automation platforms tailored to you.</p>
                    <ul class="space-y-2 text-xs text-slate-500 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-kashmos-accent"></span> CRM & ERP
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-kashmos-accent"></span> Workflow Automation
                        </li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div
                    class="group p-8 glass rounded-[2.5rem] hover:bg-white/[0.05] transition-all duration-500 border-white/5 hover:border-blue-400/20">
                    <div
                        class="w-14 h-14 bg-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Network Infrastructure</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">Enterprise-grade LAN/WAN solutions,
                        structured cabling, and secure VPNs.</p>
                    <ul class="space-y-2 text-xs text-slate-500 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-blue-400"></span> LAN / WAN Design
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-blue-400"></span> Firewall & Security
                        </li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div
                    class="group p-8 glass rounded-[2.5rem] hover:bg-white/[0.05] transition-all duration-500 border-white/5 hover:border-emerald-400/20">
                    <div
                        class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Managed IT Support</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">On-site and remote support, server
                        management, and disaster recovery.</p>
                    <ul class="space-y-2 text-xs text-slate-500 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-emerald-400"></span> 24/7 Monitoring
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-emerald-400"></span> Cloud Maintenance
                        </li>
                    </ul>
                </div>

                <!-- Service 4 -->
                <div
                    class="group p-8 glass rounded-[2.5rem] hover:bg-white/[0.05] transition-all duration-500 border-white/5 hover:border-orange-400/20">
                    <div
                        class="w-14 h-14 bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-400 mb-8 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-4">Hardware & Security</h4>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">authorized hardware reseller and surveillance
                        systems integrator.</p>
                    <ul class="space-y-2 text-xs text-slate-500 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-orange-400"></span> CCTV & IP Systems
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1 h-1 rounded-full bg-orange-400"></span> Biometric Access
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Framework & Why Us Section -->
    <section class="py-24 bg-kashmos-prime/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid lg:grid-cols-2 gap-20 items-center">
            <div>
                <h2 class="text-kashmos-accent font-bold tracking-widest uppercase mb-4 text-center lg:text-left">
                    Strategic Framework</h2>
                <h3 class="text-4xl font-bold text-white mb-8 text-center lg:text-left">Our systematic engineering
                    approach</h3>
                <div class="space-y-4">
                    <template
                        x-for="(step, index) in ['Assess Business Model', 'Identify Technology Gaps', 'Design Scalable Architecture', 'Implement & Integrate', 'Monitor & Optimize']">
                        <div class="flex items-center gap-6 p-4 glass rounded-2xl hover:bg-white/5 transition-colors">
                            <span x-text="index + 1"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-kashmos-accent text-kashmos-prime font-bold shrink-0"></span>
                            <span x-text="step" class="text-lg font-medium text-white"></span>
                        </div>
                    </template>
                </div>
            </div>

            <div class="space-y-12">
                <div class="glass p-10 rounded-[3rem] border-white/5 shadow-inner">
                    <h3 class="text-3xl font-bold text-white mb-4">Why Choose Kashmos?</h3>
                    <p class="text-slate-400 mb-8 leading-relaxed">Technology is not a cost center — it is a growth
                        accelerator. We bridge the gap with a business-first strategy.</p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <h4 class="font-bold text-kashmos-accent">Business-First</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">Process analysis before technical
                                proposing.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-bold text-kashmos-accent">Strategic IT</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">Aligning IT roadmaps with growth strategy.
                            </p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-bold text-kashmos-accent">End-to-End</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">From procurement to long-term support.</p>
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-bold text-kashmos-accent">Partnership</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">Focus on sustainable performance.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <template
                        x-for="industry in ['Construction', 'Real Estate', 'Retail', 'SMEs', 'Startups', 'Education']">
                        <span class="px-5 py-2 glass rounded-full text-xs font-bold text-white border-white/5"
                            x-text="industry"></span>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Founder Message -->
    <section class="py-24 relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="mb-12 inline-block">
                <div
                    class="w-24 h-24 rounded-full border-4 border-kashmos-accent/30 p-1 mx-auto overflow-hidden bg-slate-800">
                    <!-- Placeholder for Founder Photo -->
                    <div
                        class="w-full h-full rounded-full flex items-center justify-center text-kashmos-accent bg-slate-900 border border-white/10 uppercase font-black text-2xl">
                        AM</div>
                </div>
                <div class="mt-4">
                    <h4 class="text-white text-xl font-bold">Eng. Ayman Medhat</h4>
                    <p class="text-kashmos-accent text-sm font-bold uppercase tracking-widest">Founder – Kashmos</p>
                </div>
            </div>

            <blockquote class="text-2xl lg:text-3xl font-medium text-white italic leading-snug">
                “At Kashmos, we believe that technology should be a strategic asset, not an operational burden. Our
                mission is to empower companies to scale efficiently, operate securely, and compete confidently in a
                rapidly evolving market.”
            </blockquote>
        </div>
    </section>

    <!-- Contact & Footer -->
    <footer id="contact" class="bg-black py-24 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid lg:grid-cols-3 gap-16 mb-20">
            <div class="col-span-1 space-y-6">
                <a href="#" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="{{ asset('images/kashmos-logo.png') }}"
                        class="h-10 w-10 border-2 border-kashmos-accent rounded-full p-0.5" alt="Kashmos Logo">
                    <span class="text-2xl font-display text-white tracking-widest uppercase">Kashmos</span>
                </a>
                <p class="text-slate-500 leading-relaxed">IT & Business Development Services. Design scalable,
                    revenue-driven technology ecosystems.</p>
                <div class="flex gap-4">
                    <!-- Social placeholders -->
                    <div
                        class="w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:text-kashmos-accent transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.444 2.5a5.5 5.5 0 0 0-5.5 5.5v13.5h5.5v-13.5zM6.556 21.5a5.5 5.5 0 0 1-5.5-5.5h11a5.5 5.5 0 0 1-5.5 5.5z">
                            </path>
                        </svg>
                    </div>
                    <div
                        class="w-10 h-10 glass rounded-full flex items-center justify-center text-white hover:text-kashmos-accent transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.477 2 2 6.477 2 12c0 4.418 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.463-1.11-1.463-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.087.636-1.337-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.026.799-.222 1.656-.333 2.506-.337.849.004 1.706.115 2.506.337 1.909-1.295 2.747-1.026 2.747-1.026.546 1.377.203 2.394.101 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.578.688.48C19.137 20.164 22 16.418 22 12c0-5.523-4.477-10-10-10z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="col-span-1 space-y-8">
                <h4
                    class="text-white font-bold uppercase tracking-widest border-b border-kashmos-accent/30 pb-2 inline-block">
                    Location</h4>
                <div class="space-y-4">
                    <div class="flex gap-4 text-slate-400">
                        <svg class="w-6 h-6 text-kashmos-accent shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>390 ElNakeel 1, October's Gardens, Giza, Egypt</span>
                    </div>
                </div>
            </div>

            <div class="col-span-1 space-y-8">
                <h4
                    class="text-white font-bold uppercase tracking-widest border-b border-kashmos-accent/30 pb-2 inline-block">
                    Contact Info</h4>
                <div class="space-y-4">
                    <div class="flex gap-4 text-slate-400 items-center">
                        <svg class="w-6 h-6 text-kashmos-accent shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                        <span>+20 101 287 2168</span>
                    </div>
                    <div class="flex gap-4 text-slate-400 items-center">
                        <svg class="w-6 h-6 text-kashmos-accent shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>kashmos@outlook.com</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 border-t border-white/5 pt-8 text-center text-slate-600 text-sm">
            <p>© {{ date('Y') }} Kashmos. All rights reserved. <span class="mx-2 text-white/5">|</span> Built with <span
                    class="text-kashmos-accent">♥</span> for IT Excellence.</p>
        </div>
    </footer>

</body>

</html>