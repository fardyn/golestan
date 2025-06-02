@extends("layouts.app")

@section("content")
<div x-data="studentFilter()">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Students</h1>

    <x-filter-section>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Student ID</label>
                <input type="text" x-model="filters.student_id" @input="filter"
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
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" x-model="filters.email" @input="filter"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="students-table-body">
                    @foreach($students as $student)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->student_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student->is_active ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                {{ $student->is_active ? "Active" : "Inactive" }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
function studentFilter() {
    return {
        filters: {
            student_id: new URLSearchParams(window.location.search).get("student_id") || "",
            first_name: new URLSearchParams(window.location.search).get("first_name") || "",
            last_name: new URLSearchParams(window.location.search).get("last_name") || "",
            email: new URLSearchParams(window.location.search).get("email") || ""
        },
        filter: debounce(function() {
            updateQueryParams(this.filters);
            fetch(`/students?${new URLSearchParams(this.filters)}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    document.getElementById("students-table-body").innerHTML = 
                        doc.getElementById("students-table-body").innerHTML;
                });
        }, 300)
    }
}
</script>
@endpush