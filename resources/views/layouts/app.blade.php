<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Course Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/utils.js') }}" defer></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-gray-800">Golestan</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('courses.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('courses.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Courses
                        </a>
                        <a href="{{ route('teachers.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('teachers.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Teachers
                        </a>
                        <a href="{{ route('students.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('students.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Students
                        </a>
                        <a href="{{ route('offerings.index') }}"
                            class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('offerings.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Offerings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Signature Footer -->
    <footer class="bg-white border-t border-gray-200 mt-8">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center items-center space-x-2 text-sm text-gray-500">
                <span>Built with</span>
                <svg class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
                <span>by</span>
                <span class="font-semibold text-gray-700">Fardin Alizadeh</span>
                <span class="text-xs">© {{ date('Y') }}</span>
            </div>
        </div>
    </footer>

    <script>
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function updateQueryParams(params) {
            const url = new URL(window.location);
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    url.searchParams.set(key, params[key]);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.history.pushState({}, "", url);
        }
    </script>
    @stack('scripts')
</body>

</html>