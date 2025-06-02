<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OfferingController;

Route::get("/", function () {
    return redirect()->route("courses.index");
});

Route::resource("courses", CourseController::class);
Route::resource("teachers", TeacherController::class);
Route::resource("students", StudentController::class);
Route::resource("offerings", OfferingController::class);