<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled("student_id")) {
            $query->where("student_id", "like", "%%", $request->student_id);
        }

        if ($request->filled("first_name")) {
            $query->where("first_name", "like", "%%", $request->first_name);
        }

        if ($request->filled("last_name")) {
            $query->where("last_name", "like", "%%", $request->last_name);
        }

        if ($request->filled("email")) {
            $query->where("email", "like", "%%", $request->email);
        }

        $students = $query->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($students);
        }

        return view("students.index", ["students" => $students]);
    }
}