<x-app-layout>
    <x-slot name="header">
        {{ __('About Our Creator') }}
    </x-slot>

    <link href="https://fonts.cdnfonts.com/css/eagle-horizon" rel="stylesheet">

    <div class="space-y-12">
        <!-- Header Section with Logo and Name -->
        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 border-b border-orange-100 pb-12">
            <div class="relative group">
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-orange-400 to-amber-600 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200">
                </div>
                <img src="{{ asset('storage/' . $companyInfo->logo) }}" alt="{{ $companyInfo->name }}"
                    class="relative w-48 h-48 rounded-full shadow-2xl border-4 border-white object-cover">
            </div>

            <div class="flex-1 text-center md:text-left">
                <h1 class="text-5xl font-extrabold text-[#ff8100] mb-2"
                    style="font-family: 'Eagle Horizon-Personal use', sans-serif;">{{ $companyInfo->name }}</h1>
                <p class="text-xl text-orange-800 font-medium mb-4">{!! $companyInfo->industrial !!}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full bg-orange-100 text-orange-800 text-sm font-semibold border border-orange-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Founder: {{ $companyInfo->founder }}
                    </span>
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full bg-amber-100 text-amber-800 text-sm font-semibold border border-amber-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Est. 2015
                    </span>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left Column: About -->
            <div class="lg:col-span-2 space-y-6">
                <div>
                    <h3 class="text-2xl font-bold text-[#3e2e21] mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Company Overview
                    </h3>
                    <div class="prose prose-orange max-w-none text-[#5a4637] leading-relaxed text-lg italic">
                        {!! $companyInfo->description !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-orange-50 shadow-sm">
                        <h4 class="font-bold text-orange-900 mb-2">Our Mission</h4>
                        <p class="text-[#6b5645]">Bridging the gap between technology and business growth through
                            strategic IT evolution.</p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-orange-50 shadow-sm">
                        <h4 class="font-bold text-orange-900 mb-2">Our Strategy</h4>
                        <p class="text-[#6b5645]">A business-first approach that identifies leverages for competitive
                            advantage.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Contact Details -->
            <div class="space-y-8">
                <div class="bg-[#fdf8f3] rounded-[2.5rem] p-8 border border-orange-100 shadow-inner">
                    <h3 class="text-2xl font-bold text-[#3e2e21] mb-6">Contact Details</h3>

                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="bg-orange-600 p-2 rounded-xl text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-orange-800 opacity-60">Email
                                    Address</p>
                                <a href="mailto:{{ $companyInfo->email }}"
                                    class="text-lg font-semibold text-[#3e2e21] hover:text-orange-600 transition-colors">{{ $companyInfo->email }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-orange-600 p-2 rounded-xl text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-orange-800 opacity-60">Phone
                                    Number</p>
                                <a href="tel:{{ $companyInfo->phone }}"
                                    class="text-lg font-semibold text-[#3e2e21] hover:text-orange-600 transition-colors">{{ $companyInfo->phone }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-orange-600 p-2 rounded-xl text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-orange-800 opacity-60">
                                    Location</p>
                                <p class="text-lg font-semibold text-[#3e2e21] leading-tight">
                                    {{ $companyInfo->address }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>

                @if($companyInfo->commercial_reg || $companyInfo->tax_card)
                    <div class="bg-white rounded-[2.5rem] p-8 border border-orange-50 shadow-sm space-y-4">
                        <h4 class="text-lg font-bold text-[#3e2e21]">Official Registration</h4>
                        @if($companyInfo->commercial_reg)
                            <div class="flex justify-between items-center py-2 border-b border-orange-50">
                                <span class="text-sm text-[#8a7261]">Comm. Reg.</span>
                                <span class="font-mono font-bold text-[#3e2e21]">{{ $companyInfo->commercial_reg }}</span>
                            </div>
                        @endif
                        @if($companyInfo->tax_card)
                            <div class="flex justify-between items-center py-2 border-b border-orange-50">
                                <span class="text-sm text-[#8a7261]">Tax Card</span>
                                <span class="font-mono font-bold text-[#3e2e21]">{{ $companyInfo->tax_card }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex justify-center gap-6 py-4">
                    @if($companyInfo->website)
                        <a href="{{ $companyInfo->website }}" target="_blank"
                            class="text-orange-900 hover:text-orange-600 transition-all"><svg class="w-8 h-8" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg></a>
                    @endif
                    @if($companyInfo->facebook)
                        <a href="{{ $companyInfo->facebook }}" target="_blank"
                            class="text-orange-900 hover:text-orange-600 transition-all font-bold text-2xl">f</a>
                    @endif
                    @if($companyInfo->youtube)
                        <a href="{{ $companyInfo->youtube }}" target="_blank"
                            class="text-orange-900 hover:text-orange-600 transition-all font-bold text-2xl">Y</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>