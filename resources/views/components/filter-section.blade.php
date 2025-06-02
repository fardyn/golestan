<div class="bg-white shadow rounded-lg p-6 mb-6" x-data="{ showFilters: false }">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Filters</h2>
        <button @click="showFilters = !showFilters" class="text-gray-500 hover:text-gray-700">
            <span x-text="showFilters ? \"Hide Filters\" : \"Show Filters\""></span>
        </button>
    </div>
    
    <div x-show="showFilters" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {{ $slot }}
    </div>
</div>