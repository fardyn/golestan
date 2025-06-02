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

        $perPage = $request->input("per_page", 10);

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
            "perPage" => $perPage
        ]);
    }
}
