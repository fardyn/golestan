<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Offering;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferingFactory extends Factory
{
    protected $model = Offering::class;

    public function definition(): array
    {
        $semesters = [
            "Fall 2023",
            "Spring 2024",
            "Fall 2024",
            "Spring 2025"
        ];

        $statuses = ["enrolled", "completed", "dropped"];
        $status = $this->faker->randomElement($statuses);

        // Only generate grades for completed courses
        $grade = $status === "completed" ? $this->faker->randomFloat(2, 60, 100) : null;

        return [
            "course_id" => Course::factory(),
            "teacher_id" => Teacher::factory(),
            "student_id" => Student::factory(),
            "semester" => $this->faker->randomElement($semesters),
            "section" => $this->faker->randomElement(["A", "B", "C", "D"]),
            "status" => $status,
            "grade" => $grade
        ];
    }
}