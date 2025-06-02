@extends("layouts.app")

@section("content")
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-gray-900 mb-4">Offerings</h1>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Filter Offerings</h2>
            <button type="button" onclick="resetFilters()" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset Filters
            </button>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form action="{{ route('offerings.index') }}" method="GET" class="space-y-6">
                <!-- Course and Teacher Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label for="course_search" class="block text-sm font-medium text-gray-700">Search Course</label>
                        <div class="search-container">
                            <input type="text"
                                id="course_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search courses..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'course_id', 'course_results')"
                                onkeydown="handleKeyNavigation(event, 'course_results')"
                                onfocus="showResults('course_results')"
                                onblur="hideResults('course_results')" />
                            <div id="course_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="course_id" id="course_id" value="{{ request('course_id') }}" />
                    </div>
                    <div class="space-y-4">
                        <label for="teacher_search" class="block text-sm font-medium text-gray-700">Search Teacher</label>
                        <div class="search-container">
                            <input type="text"
                                id="teacher_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search teachers..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'teacher_id', 'teacher_results')"
                                onkeydown="handleKeyNavigation(event, 'teacher_results')"
                                onfocus="showResults('teacher_results')"
                                onblur="hideResults('teacher_results')" />
                            <div id="teacher_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="teacher_id" id="teacher_id" value="{{ request('teacher_id') }}" />
                    </div>
                </div>

                <!-- Student and Semester Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label for="student_search" class="block text-sm font-medium text-gray-700">Search Student</label>
                        <div class="search-container">
                            <input type="text"
                                id="student_search"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="Type to search students..."
                                autocomplete="off"
                                onkeyup="handleSearch(this, 'student_id', 'student_results')"
                                onkeydown="handleKeyNavigation(event, 'student_results')"
                                onfocus="showResults('student_results')"
                                onblur="hideResults('student_results')" />
                            <div id="student_results" class="search-results"></div>
                        </div>
                        <input type="hidden" name="student_id" id="student_id" value="{{ request('student_id') }}" />
                    </div>
                    <div class="space-y-4">
                        <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                        <select name="semester" id="semester" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Select Semester --</option>
                            <optgroup label="2024">
                                <option value="2024-1" {{ request('semester') == '2024-1' ? 'selected' : '' }}>Spring 2024</option>
                                <option value="2024-2" {{ request('semester') == '2024-2' ? 'selected' : '' }}>Fall 2024</option>
                            </optgroup>
                            <optgroup label="2023">
                                <option value="2023-1" {{ request('semester') == '2023-1' ? 'selected' : '' }}>Spring 2023</option>
                                <option value="2023-2" {{ request('semester') == '2023-2' ? 'selected' : '' }}>Fall 2023</option>
                            </optgroup>
                            <optgroup label="2022">
                                <option value="2022-1" {{ request('semester') == '2022-1' ? 'selected' : '' }}>Spring 2022</option>
                                <option value="2022-2" {{ request('semester') == '2022-2' ? 'selected' : '' }}>Fall 2022</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- Status, Section, and Grade Range Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- All Statuses --</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                        </select>
                    </div>
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700">Section</label>
                        <select name="section" id="section" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- All Sections --</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('section') == $i ? 'selected' : '' }}>Section {{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700">Grade</label>
                        <select name="grade" id="grade" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- All Grades --</option>
                            <option value="A" {{ request('grade') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ request('grade') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ request('grade') == 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ request('grade') == 'D' ? 'selected' : '' }}>D</option>
                            <option value="F" {{ request('grade') == 'F' ? 'selected' : '' }}>F</option>
                            <option value="W" {{ request('grade') == 'W' ? 'selected' : '' }}>W (Withdrawn)</option>
                            <option value="I" {{ request('grade') == 'I' ? 'selected' : '' }}>I (Incomplete)</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($offerings as $offering)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->course->code }} - {{ $offering->course->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->teacher->teacher_id }} - {{ $offering->teacher->first_name }} {{ $offering->teacher->last_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->student->student_id }} - {{ $offering->student->first_name }} {{ $offering->student->last_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->semester }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->section }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $offering->status === 'completed' ? 'bg-green-100 text-green-800' : ( $offering->status === 'dropped' ? 'bg-red-100 text-red-800' : '' ) }}">
                            {{ ucfirst($offering->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->grade ?? "-" }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 px-6 py-4 border-t border-gray-200">
        {{ $offerings->links() }}
    </div>
</div>
@endsection

@push("scripts")
<script>
    // Store the original options data
    const searchData = @json($searchData);

    // Initialize selected values from request
    document.addEventListener('DOMContentLoaded', function() {
        const types = ['course', 'teacher', 'student'];
        types.forEach(type => {
            const id = document.getElementById(`${type}_id`).value;
            if (id) {
                const item = searchData[type].find(item => item.id == id);
                if (item) {
                    document.getElementById(`${type}_search`).value = item.text;
                }
            }
        });
    });

    function handleSearch(input, hiddenId, resultsId) {
        const searchText = input.value.toLowerCase();
        const type = hiddenId.split('_')[0];
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
                     data-id="${item.id}"
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
        const id = element.dataset.id;
        const text = element.dataset.text;
        document.getElementById(hiddenId).value = id;
        document.getElementById(hiddenId.split('_')[0] + '_search').value = text;
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
                    selectItem(selected, resultsId.replace('_results', '_id'), resultsId);
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
        // Small delay to allow click events to fire
        setTimeout(() => {
            document.getElementById(resultsId).classList.remove('active');
        }, 200);
    }

    function resetFilters() {
        // Reset all form inputs
        document.querySelector('form').reset();
        // Clear search inputs and hidden fields
        ['course', 'teacher', 'student'].forEach(type => {
            document.getElementById(`${type}_search`).value = '';
            document.getElementById(`${type}_id`).value = '';
        });
        // Submit the form to refresh the results
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