<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Course Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                        <a href="{{ route("courses.index") }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">Courses</a>
                        <a href="{{ route("teachers.index") }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">Teachers</a>
                        <a href="{{ route("students.index") }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">Students</a>
                        <a href="{{ route("offerings.index") }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">Offerings</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield("content")
    </main>

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
    @stack("scripts")
</body>
</html>