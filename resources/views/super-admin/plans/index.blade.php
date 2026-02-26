<x-app-layout>
    <x-slot name="header">
        Subscription Plans
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Subscription Plans</h1>
            <a href="{{ route('super-admin.plans.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Create Plan</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plans as $plan)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col">
                    <div class="mb-4">
                        <h2 class="text-xl font-bold">{{ $plan->name }}</h2>
                        <p class="text-2xl font-bold text-blue-600 mt-2">${{ $plan->price }} <span
                                class="text-sm text-slate-400 font-normal">/ {{ $plan->interval }}</span></p>
                    </div>

                    <div class="flex-grow">
                        <h3 class="text-sm font-semibold text-slate-500 uppercase mb-2">Limits</h3>
                        <ul class="text-sm space-y-1 mb-4">
                            @foreach($plan->limits as $key => $value)
                                <li><span class="font-medium capitalize">{{ str_replace('_', ' ', $key) }}:</span> {{ $value }}
                                </li>
                            @endforeach
                        </ul>

                        @if($plan->features)
                            <h3 class="text-sm font-semibold text-slate-500 uppercase mb-2">Features</h3>
                            <ul class="text-sm space-y-1">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between">
                        <a href="{{ route('super-admin.plans.edit', $plan) }}"
                            class="text-blue-600 hover:text-blue-800 font-medium">Edit Plan</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>