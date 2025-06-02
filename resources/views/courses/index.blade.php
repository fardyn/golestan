@extends("layouts.app")

@section("content")
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">Courses</h1>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Filter Courses</h2>
            <button type="button" onclick="resetFilters()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset Filters
            </button>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('courses.index') }}" method="GET" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label for="code_search" class="block text-sm font-medium text-gray-700">Search Course Code</label>
                        <div class="search-container">
                            <input type="text"
                                id="code_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search course codes..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'code', 'code_results')"
                                onkeydown="handleKeyNavigation(event, 'code_results')"
                                onfocus="showResults('code_results')"
                                onblur="hideResults('code_results')" />
                            <div id="code_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="code" id="code" value="{{ request('code') }}" />
                    </div>
                    <div class="space-y-4">
                        <label for="name_search" class="block text-sm font-medium text-gray-700">Search Course Name</label>
                        <div class="search-container">
                            <input type="text"
                                id="name_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search course names..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'name', 'name_results')"
                                onkeydown="handleKeyNavigation(event, 'name_results')"
                                onfocus="showResults('name_results')"
                                onblur="hideResults('name_results')" />
                            <div id="name_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="name" id="name" value="{{ request('name') }}" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label for="department_search" class="block text-sm font-medium text-gray-700">Search Department</label>
                        <div class="search-container">
                            <input type="text"
                                id="department_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search departments..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'department', 'department_results')"
                                onkeydown="handleKeyNavigation(event, 'department_results')"
                                onfocus="showResults('department_results')"
                                onblur="hideResults('department_results')" />
                            <div id="department_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="department" id="department" value="{{ request('department') }}" />
                    </div>
                    <div class="space-y-4">
                        <label for="credits" class="block text-sm font-medium text-gray-700">Credits</label>
                        <select name="credits" id="credits" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- All Credits --</option>
                            @foreach(range(1, 6) as $credit)
                            <option value="{{ $credit }}" {{ request('credits') == $credit ? 'selected' : '' }}>{{ $credit }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-4 bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Code</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courses as $course)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->code }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->department }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->credits }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 px-6 py-4 border-t border-gray-200">
        {{ $courses->links() }}
    </div>
</div>
@endsection

@push("scripts")
<script>
    // Store the original options data
    const searchData = @json($searchData);

    // Initialize selected values from request
    document.addEventListener('DOMContentLoaded', function() {
        const types = ['code', 'name', 'department'];
        types.forEach(type => {
            const value = document.getElementById(type).value;
            if (value) {
                document.getElementById(`${type}_search`).value = value;
            }
        });
    });

    function handleSearch(input, hiddenId, resultsId) {
        const searchText = input.value.toLowerCase();
        const type = hiddenId;
        const resultsDiv = document.getElementById(resultsId);
        const data = searchData[type];

        if (!searchText) {
            resultsDiv.innerHTML = '';
            resultsDiv.classList.remove('active');
            return;
        }

        // Filter and sort results
        const matches = data.filter(item => {
            const searchTerms = searchText.split(' ');
            return searchTerms.every(term =>
                item.search.includes(term) ||
                item.text.toLowerCase().startsWith(term)
            );
        }).sort((a, b) => {
            // Prioritize matches that start with the search text
            const aStartsWith = a.text.toLowerCase().startsWith(searchText);
            const bStartsWith = b.text.toLowerCase().startsWith(searchText);
            if (aStartsWith && !bStartsWith) return -1;
            if (!aStartsWith && bStartsWith) return 1;
            return a.text.localeCompare(b.text);
        });

        // Display results
        resultsDiv.innerHTML = matches.map((item, index) => {
            const text = highlightMatch(item.text, searchText);
            return `
                <div class="search-result-item ${index === 0 ? 'selected' : ''}" 
                     data-text="${item.text}"
                     onclick="selectItem(this, '${hiddenId}', '${resultsId}')">
                    ${text}
                </div>
            `;
        }).join('');

        resultsDiv.classList.add('active');
    }

    function highlightMatch(text, search) {
        const searchTerms = search.split(' ');
        let result = text;
        searchTerms.forEach(term => {
            const regex = new RegExp(`(${term})`, 'gi');
            result = result.replace(regex, '<span class="highlight">$1</span>');
        });
        return result;
    }

    function selectItem(element, hiddenId, resultsId) {
        const text = element.dataset.text;
        document.getElementById(hiddenId).value = text;
        document.getElementById(hiddenId + '_search').value = text;
        document.getElementById(resultsId).classList.remove('active');
    }

    function handleKeyNavigation(event, resultsId) {
        const resultsDiv = document.getElementById(resultsId);
        const items = resultsDiv.getElementsByClassName('search-result-item');
        const selected = resultsDiv.querySelector('.selected');
        let index = Array.from(items).indexOf(selected);

        switch (event.key) {
            case 'ArrowDown':
                event.preventDefault();
                if (index < items.length - 1) index++;
                break;
            case 'ArrowUp':
                event.preventDefault();
                if (index > 0) index--;
                break;
            case 'Enter':
                event.preventDefault();
                if (selected) {
                    selectItem(selected, resultsId.replace('_results', ''), resultsId);
                }
                return;
            case 'Escape':
                resultsDiv.classList.remove('active');
                return;
            default:
                return;
        }

        if (selected) selected.classList.remove('selected');
        if (items[index]) {
            items[index].classList.add('selected');
            items[index].scrollIntoView({
                block: 'nearest'
            });
        }
    }

    function showResults(resultsId) {
        const input = document.getElementById(resultsId.replace('_results', '_search'));
        if (input.value) {
            document.getElementById(resultsId).classList.add('active');
        }
    }

    function hideResults(resultsId) {
        setTimeout(() => {
            document.getElementById(resultsId).classList.remove('active');
        }, 200);
    }

    function resetFilters() {
        document.querySelector('form').reset();
        ['code', 'name', 'department'].forEach(type => {
            document.getElementById(`${type}_search`).value = '';
            document.getElementById(type).value = '';
        });
        document.querySelector('form').submit();
    }
</script>
@endpush

<style>
    .search-container {
        position: relative;
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }

    .search-results.active {
        display: block;
    }

    .search-result-item {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        border-bottom: 1px solid #f3f4f6;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item:hover,
    .search-result-item.selected {
        background-color: #f3f4f6;
    }

    .search-result-item .highlight {
        background-color: #fef3c7;
        padding: 0 2px;
        border-radius: 2px;
    }
</style>