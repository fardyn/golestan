@extends("layouts.app")

@section("content")
<div x-data="courseFilter()">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Courses</h1>

    <x-filter-section>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Course Code</label>
                <input type="text" x-model="filters.code" @input="filter" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Course Name</label>
                <input type="text" x-model="filters.name" @input="filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Department</label>
                <select x-model="filters.department" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}">{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Credits</label>
                <select x-model="filters.credits" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Credits</option>
                    <option value="2">2 Credits</option>
                    <option value="3">3 Credits</option>
                    <option value="4">4 Credits</option>
                </select>
            </div>
        </div>
    </x-filter-section>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Credits</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="courses-table-body">
                    @foreach($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->credits }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $course->is_active ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                {{ $course->is_active ? "Active" : "Inactive" }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $courses->links() }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
function courseFilter() {
    return {
        filters: {
            code: new URLSearchParams(window.location.search).get("code") || "",
            name: new URLSearchParams(window.location.search).get("name") || "",
            department: new URLSearchParams(window.location.search).get("department") || "",
            credits: new URLSearchParams(window.location.search).get("credits") || ""
        },
        filter: debounce(function() {
            updateQueryParams(this.filters);
            fetch(`/courses?${new URLSearchParams(this.filters)}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    document.getElementById("courses-table-body").innerHTML = 
                        doc.getElementById("courses-table-body").innerHTML;
                });
        }, 300)
    }
}
</script>
@endpush