<x-app-layout>
    <x-slot name="header">
        {{ __('messages.edit_company') ?? 'Edit Company' }}
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h3
                style="font-size: 1.5rem; font-weight: 350; color: var(--title-color); border-bottom: 2px dotted var(--nav-border); padding-bottom: 0.4rem;">
                {{ __('messages.edit_company') ?? 'Edit Company' }} - {{ $company->name }}
            </h3>
            <a href="{{ route('super-admin.companies.index') }}"
                title="{{ __('messages.back_to_list') ?? 'Back to list' }}"
                style="color: var(--btn-text); font-size: 1.6rem; transition: transform 0.2s;"
                onmouseover="this.style.transform='scale(1.2)';" onmouseout="this.style.transform='scale(1)';"
                class="flex items-center">⬅️</a>
        </div>

        <div
            style="background: var(--content-bg); border-radius: 1.5rem; padding: 2rem; border: 1px solid var(--content-border); box-shadow: var(--card-shadow);">
            <form action="{{ route('super-admin.companies.update', $company) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="name"
                        style="color: var(--text-color); font-weight: 600; display: block; margin-bottom: 0.5rem;">
                        {{ __('messages.company_name') ?? 'Company Name' }} <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}" required
                        style="width: 100%; padding: 0.75rem 1rem; border-radius: 1rem; border: 1px solid var(--nav-border); background: var(--nav-bg); color: var(--text-color); outline: none; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--accent-border)'"
                        onblur="this.style.borderColor='var(--nav-border)'">
                    @error('name')
                        <p style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4" style="border-top: 1px solid var(--content-border);">
                    <a href="{{ route('super-admin.companies.index') }}"
                        style="padding: 0.75rem 1.5rem; border-radius: 1rem; border: 1px solid var(--btn-border); background: transparent; color: var(--text-color); font-weight: 600; text-decoration: none; transition: all 0.2s;"
                        onmouseover="this.style.background='var(--nav-bg)';"
                        onmouseout="this.style.background='transparent';">
                        {{ __('messages.cancel') ?? 'Cancel' }}
                    </a>
                    <button type="submit"
                        style="padding: 0.75rem 1.5rem; border-radius: 1rem; border: 1px solid var(--accent-border); background: var(--accent-bg); color: var(--accent-text); font-weight: 600; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        {{ __('messages.save_changes') ?? 'Save Changes' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>