<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-4">Subscription Expired</h2>
                <p class="text-gray-600 mb-6">Your trial or subscription has expired. Please contact support or renew
                    your plan to continue.</p>
                <div class="flex justify-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Logout
                        </button>
                    </form>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Renew Subscription
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>