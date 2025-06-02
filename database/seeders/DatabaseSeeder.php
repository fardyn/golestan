<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Offering;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 teachers
        $teachers = Teacher::factory()->count(10)->create();

        // Create 20 courses
        $courses = Course::factory()->count(20)->create();

        // Create 50 students
        $students = Student::factory()->count(50)->create();

        // Create random offerings
        // Each student takes 3-6 courses
        foreach ($students as $student) {
            $numCourses = rand(3, 6);
            $randomCourses = $courses->random($numCourses);

            foreach ($randomCourses as $course) {
                Offering::factory()->create([
                    "course_id" => $course->id,
                    "teacher_id" => $teachers->random()->id,
                    "student_id" => $student->id
                ]);
            }
        }
    }
}