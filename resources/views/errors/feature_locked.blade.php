<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h2 class="text-2xl font-bold text-orange-600 mb-4">Feature Locked</h2>
                <p class="text-gray-600 mb-6">The feature <strong>{{ $feature }}</strong> is not available in your
                    current plan. Please upgrade your subscription to unlock it.</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ url()->previous() }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Go Back
                    </a>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        View Upgrade Options
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>