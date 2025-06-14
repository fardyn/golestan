<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    private $departments = [
        'Computer Science',
        'Mathematics',
        'Physics',
        'Chemistry',
        'Biology',
        'Engineering',
        'Business',
        'Economics',
        'Psychology',
        'History',
        'Literature',
        'Philosophy'
    ];

    private $coursePrefixes = [
        'CS' => 'Computer Science',
        'MATH' => 'Mathematics',
        'PHYS' => 'Physics',
        'CHEM' => 'Chemistry',
        'BIO' => 'Biology',
        'ENG' => 'Engineering',
        'BUS' => 'Business',
        'ECON' => 'Economics',
        'PSY' => 'Psychology',
        'HIST' => 'History',
        'LIT' => 'Literature',
        'PHIL' => 'Philosophy'
    ];

    public function definition(): array
    {
        $prefix = $this->faker->randomElement(array_keys($this->coursePrefixes));
        $number = $this->faker->numberBetween(100, 499);
        $department = $this->coursePrefixes[$prefix];

        return [
            'code' => $prefix . $number,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'credits' => $this->faker->randomElement([1, 2, 3, 4]),
            'department' => $department,
            'is_active' => true
        ];
    }
}
