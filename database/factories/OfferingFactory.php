<?php

namespace Database\Factories;

use App\Models\Offering;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferingFactory extends Factory
{
    protected $model = Offering::class;

    private $semesters = [
        'Fall 2024',
        'Spring 2024',
        'Summer 2024',
        'Fall 2023',
        'Spring 2023',
        'Summer 2023'
    ];

    private $sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
    private $statuses = ['active', 'completed', 'dropped'];

    public function definition(): array
    {
        $semester = $this->faker->randomElement($this->semesters);
        $status = $this->faker->randomElement($this->statuses);
        $grade = $status === 'completed' ? $this->faker->randomFloat(2, 60, 100) : null;

        return [
            'course_id' => Course::inRandomOrder()->first()->id,
            'teacher_id' => Teacher::inRandomOrder()->first()->id,
            'student_id' => Student::inRandomOrder()->first()->id,
            'semester' => $semester,
            'section' => $this->faker->randomElement($this->sections),
            'status' => $status,
            'grade' => $grade
        ];
    }
}
