<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    public function index(Request $request)
    {
        $query = Offering::with(["course", "teacher", "student"]);

        if ($request->filled("course_id")) {
            $query->where("course_id", $request->course_id);
        }

        if ($request->filled("teacher_id")) {
            $query->where("teacher_id", $request->teacher_id);
        }

        if ($request->filled("student_id")) {
            $query->where("student_id", $request->student_id);
        }

        if ($request->filled("semester")) {
            $query->where("semester", $request->semester);
        }

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        if ($request->filled("grade")) {
            $query->where("grade", $request->grade);
        }

        if ($request->filled("section")) {
            $query->where("section", $request->section);
        }

        $perPage = $request->input("per_page", 10);

        // Get unique teachers if requested
        $uniqueTeachers = null;
        if ($request->filled('show_unique_teachers')) {
            // Start with the same base query to maintain filters
            $uniqueTeachersQuery = clone $query;

            // Get the course from the first offering to ensure we're showing teachers for the right course
            $firstOffering = $uniqueTeachersQuery->first();
            if ($firstOffering) {
                $uniqueTeachers = Offering::with(['course', 'teacher'])
                    ->where('course_id', $firstOffering->course_id)
                    ->when($request->filled('semester'), function ($q) use ($request) {
                        $q->where('semester', $request->semester);
                    })
                    ->select('teacher_id', 'course_id', 'semester')
                    ->distinct()
                    ->get()
                    ->map(function ($offering) {
                        return [
                            'teacher_id' => $offering->teacher->teacher_id,
                            'first_name' => $offering->teacher->first_name,
                            'last_name' => $offering->teacher->last_name,
                            'department' => $offering->teacher->department,
                            'title' => $offering->teacher->title,
                            'course_code' => $offering->course->code,
                            'course_name' => $offering->course->name,
                            'semester' => $offering->semester
                        ];
                    });
            }
        }

        // Prepare search data
        $searchData = [
            'course' => Course::select('id', 'code', 'name')->get()->map(function ($course) {
                return [
                    'id' => $course->id,
                    'text' => $course->code . ' - ' . $course->name,
                    'search' => strtolower($course->code . ' ' . $course->name)
                ];
            }),
            'teacher' => Teacher::select('id', 'teacher_id', 'first_name', 'last_name')->get()->map(function ($teacher) {
                return [
                    'id' => $teacher->id,
                    'text' => $teacher->teacher_id . ' - ' . $teacher->first_name . ' ' . $teacher->last_name,
                    'search' => strtolower($teacher->teacher_id . ' ' . $teacher->first_name . ' ' . $teacher->last_name)
                ];
            }),
            'student' => Student::select('id', 'student_id', 'first_name', 'last_name')->get()->map(function ($student) {
                return [
                    'id' => $student->id,
                    'text' => $student->student_id . ' - ' . $student->first_name . ' ' . $student->last_name,
                    'search' => strtolower($student->student_id . ' ' . $student->first_name . ' ' . $student->last_name)
                ];
            })
        ];

        $offerings = $query->paginate($perPage)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($offerings);
        }

        return view("offerings.index", [
            "offerings" => $offerings,
            "searchData" => $searchData,
            "perPage" => $perPage,
            "uniqueTeachers" => $uniqueTeachers,
            "showUniqueTeachers" => $request->filled('show_unique_teachers')
        ]);
    }
}
