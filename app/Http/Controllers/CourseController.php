<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled("code")) {
            $query->where("code", "like", "%%", $request->code);
        }

        if ($request->filled("name")) {
            $query->where("name", "like", "%%", $request->name);
        }

        if ($request->filled("department")) {
            $query->where("department", $request->department);
        }

        if ($request->filled("credits")) {
            $query->where("credits", $request->credits);
        }

        $departments = Course::distinct()->pluck("department");
        $courses = $query->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($courses);
        }

        return view("courses.index", ["courses" => $courses, "departments" => $departments]);
    }
}