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
            $query->where("teacher_id", "like", "%" . $request->teacher_id . "%");
        }

        if ($request->filled("first_name")) {
            $query->where("first_name", "like", "%" . $request->first_name . "%");
        }

        if ($request->filled("last_name")) {
            $query->where("last_name", "like", "%" . $request->last_name . "%");
        }

        if ($request->filled("department")) {
            $query->where("department", "like", "%" . $request->department . "%");
        }

        if ($request->filled("title")) {
            $query->where("title", $request->title);
        }

        $perPage = $request->input("per_page", 10);
        $departments = Teacher::distinct()->pluck("department");
        $titles = Teacher::distinct()->pluck("title");
        $teachers = $query->paginate($perPage)->withQueryString();

        // Prepare search data for interactive search
        $searchData = [
            'teacher_id' => Teacher::select('teacher_id as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'first_name' => Teacher::select('first_name as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'last_name' => Teacher::select('last_name as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'department' => Teacher::select('department as text')
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
            return response()->json($teachers);
        }

        return view("teachers.index", [
            "teachers" => $teachers,
            "departments" => $departments,
            "titles" => $titles,
            "perPage" => $perPage,
            "searchData" => $searchData
        ]);
    }
}
