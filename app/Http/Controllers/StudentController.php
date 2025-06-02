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
            $query->where("student_id", "like", "%" . $request->student_id . "%");
        }

        if ($request->filled("first_name")) {
            $query->where("first_name", "like", "%" . $request->first_name . "%");
        }

        if ($request->filled("last_name")) {
            $query->where("last_name", "like", "%" . $request->last_name . "%");
        }

        if ($request->filled("email")) {
            $query->where("email", "like", "%" . $request->email . "%");
        }

        $students = $query->paginate($request->input('per_page', 10));

        // Prepare search data for interactive search
        $searchData = [
            'student_id' => Student::select('student_id as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'first_name' => Student::select('first_name as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'last_name' => Student::select('last_name as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'email' => Student::select('email as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                })
        ];

        if ($request->expectsJson()) {
            return response()->json($students);
        }

        return view("students.index", compact('students', 'searchData'));
    }
}
