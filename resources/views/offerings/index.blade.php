@extends("layouts.app")

@section("content")
<div x-data="offeringFilter()">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Course Offerings</h1>

    <x-filter-section>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Course</label>
                <select x-model="filters.course_id" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Teacher</label>
                <select x-model="filters.teacher_id" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->teacher_id }} - {{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Student</label>
                <select x-model="filters.student_id" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Students</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Semester</label>
                <select x-model="filters.semester" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Semesters</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester }}">{{ $semester }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select x-model="filters.status" @change="filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="enrolled">Enrolled</option>
                    <option value="completed">Completed</option>
                    <option value="dropped">Dropped</option>
                </select>
            </div>
        </div>
    </x-filter-section>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="offerings-table-body">
                    @foreach($offerings as $offering)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $offering->course->code }} - {{ $offering->course->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $offering->teacher->first_name }} {{ $offering->teacher->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $offering->student->first_name }} {{ $offering->student->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->semester }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $offering->section }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $offering->status === "enrolled" ? "bg-blue-100 text-blue-800" : 
                                   ($offering->status === "completed" ? "bg-green-100 text-green-800" : 
                                    "bg-red-100 text-red-800") }}">
                                {{ ucfirst($offering->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $offering->grade ? number_format($offering->grade, 2) : "-" }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $offerings->links() }}
        </div>
    </div>
</div>
@endsection

@push("scripts")
<script>
function offeringFilter() {
    return {
        filters: {
            course_id: new URLSearchParams(window.location.search).get("course_id") || "",
            teacher_id: new URLSearchParams(window.location.search).get("teacher_id") || "",
            student_id: new URLSearchParams(window.location.search).get("student_id") || "",
            semester: new URLSearchParams(window.location.search).get("semester") || "",
            status: new URLSearchParams(window.location.search).get("status") || ""
        },
        filter: debounce(function() {
            updateQueryParams(this.filters);
            fetch(`/offerings?${new URLSearchParams(this.filters)}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    document.getElementById("offerings-table-body").innerHTML = 
                        doc.getElementById("offerings-table-body").innerHTML;
                });
        }, 300)
    }
}
</script>
@endpush