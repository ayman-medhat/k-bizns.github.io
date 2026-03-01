<x-app-layout>
    <x-slot name="header">
        {{ __('messages.add_company') }}
    </x-slot>

    <div>
        <div class="mb-6">
            <a href="{{ route('super-admin.companies.index') }}"
                style="color: var(--accent-text); padding: 0.4rem 1.2rem; border-radius: 30px; background: var(--accent-bg); border: 1px solid var(--accent-border); font-size: 0.875rem; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.25rem;"
                onmouseover="this.style.transform='translateX(-5px)';"
                onmouseout="this.style.transform='translateX(0)';" class="hover:underline">
                <span>←</span> {{ __('messages.back_to_companies') }}
            </a>
            <h2 class="mt-4"
                style="font-size: 2rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.add_company') }}
            </h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass-card p-8"
            style="background: var(--content-bg); border: 1px solid var(--row-border); border-radius: 1.5rem; box-shadow: var(--card-shadow); max-width: 640px;">
            <form action="{{ route('super-admin.companies.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium mb-1.5" style="color: var(--text-color);">
                        {{ __('messages.name') }}
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        class="block w-full rounded-md shadow-sm"
                        style="background-color: var(--content-bg); color: var(--text-color); border-color: var(--row-border);">
                </div>

                <div>
                    <button type="submit"
                        style="background: var(--btn-bg); color: var(--btn-text); width: 100%; padding: 0.8rem; border-radius: 1rem; font-weight: 500; transition: all 0.2s;"
                        onmouseover="this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.transform='translateY(0)';" class="hover:shadow-lg">
                        {{ __('messages.add_company') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
