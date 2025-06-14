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
            $query->where("code", "like", "%" . $request->code . "%");
        }

        if ($request->filled("name")) {
            $query->where("name", "like", "%" . $request->name . "%");
        }

        if ($request->filled("department")) {
            $query->where("department", "like", "%" . $request->department . "%");
        }

        if ($request->filled("credits")) {
            $query->where("credits", $request->credits);
        }

        $perPage = $request->input("per_page", 10);
        $departments = Course::distinct()->pluck("department");
        $courses = $query->paginate($perPage)->withQueryString();

        // Prepare search data for interactive search
        $searchData = [
            'code' => Course::select('code as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'name' => Course::select('name as text')
                ->distinct()
                ->get()
                ->map(function ($item) {
                    return [
                        'text' => $item->text,
                        'search' => strtolower($item->text)
                    ];
                }),
            'department' => Course::select('department as text')
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
            return response()->json($courses);
        }

        return view("courses.index", [
            "courses" => $courses,
            "departments" => $departments,
            "perPage" => $perPage,
            "searchData" => $searchData
        ]);
    }
}
