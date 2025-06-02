@extends("layouts.app")

@section("content")
<div x-data="teacherFilter()">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Teachers</h1>

    <x-filter-section>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Teacher ID</label>
                <input type="text" x-model="filters.teacher_id" @input="filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" x-model="filters.first_name" @input="filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" x-model="filters.last_name" @input="filter"
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
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <select x-model="filters.title" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Titles</option>
                    @foreach($titles as $title)
                        <option value="{{ $title }}">{{ $title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </x-filter-section>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="teachers-table-body">
                    @foreach($teachers as $teacher)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->teacher_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->department }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $teacher->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $teacher->is_active ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                {{ $teacher->is_active ? "Active" : "Inactive" }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
function teacherFilter() {
    return {
        filters: {
            teacher_id: new URLSearchParams(window.location.search).get("teacher_id") || "",
            first_name: new URLSearchParams(window.location.search).get("first_name") || "",
            last_name: new URLSearchParams(window.location.search).get("last_name") || "",
            department: new URLSearchParams(window.location.search).get("department") || "",
            title: new URLSearchParams(window.location.search).get("title") || ""
        },
        filter: debounce(function() {
            updateQueryParams(this.filters);
            fetch(`/teachers?${new URLSearchParams(this.filters)}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    document.getElementById("teachers-table-body").innerHTML = 
                        doc.getElementById("teachers-table-body").innerHTML;
                });
        }, 300)
    }
}
</script>
@endpush