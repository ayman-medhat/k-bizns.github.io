<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Email Address</label>
            <input id="email"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="name@company.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block font-semibold text-sm text-gray-700">Password</label>
            </div>
            <input id="password"
                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl transition-all outline-none"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded-lg border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500 w-5 h-5 transition-all"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-600 hover:text-orange-700 font-semibold transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);"
                class="w-full flex items-center justify-center px-6 py-4 border border-transparent rounded-xl font-bold text-base text-white hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5">
                {{ __('Secure Login') }}
            </button>
        </div>


    </form>
</x-guest-layout>