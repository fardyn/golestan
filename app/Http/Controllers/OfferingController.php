<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Offering;
use App\Models\Student;
use App\Models\Teacher;
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

        // Get data for filter dropdowns
        $courses = Course::all();
        $teachers = Teacher::all();
        $students = Student::all();
        $semesters = Offering::distinct()->pluck("semester");

        $offerings = $query->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($offerings);
        }

        return view("offerings.index", [
            "offerings" => $offerings,
            "courses" => $courses,
            "teachers" => $teachers,
            "students" => $students,
            "semesters" => $semesters
        ]);
    }
}