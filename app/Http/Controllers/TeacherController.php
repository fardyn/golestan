<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled("teacher_id")) {
            $query->where("teacher_id", "like", "%%", $request->teacher_id);
        }

        if ($request->filled("first_name")) {
            $query->where("first_name", "like", "%%", $request->first_name);
        }

        if ($request->filled("last_name")) {
            $query->where("last_name", "like", "%%", $request->last_name);
        }

        if ($request->filled("department")) {
            $query->where("department", $request->department);
        }

        if ($request->filled("title")) {
            $query->where("title", $request->title);
        }

        $departments = Teacher::distinct()->pluck("department");
        $titles = Teacher::distinct()->pluck("title");
        $teachers = $query->paginate(10)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($teachers);
        }

        return view("teachers.index", [
            "teachers" => $teachers,
            "departments" => $departments,
            "titles" => $titles
        ]);
    }
}