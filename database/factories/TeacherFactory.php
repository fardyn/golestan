<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

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

    private $titles = [
        'Professor',
        'Associate Professor',
        'Assistant Professor',
        'Lecturer',
        'Senior Lecturer',
        'Adjunct Professor'
    ];

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $department = $this->faker->randomElement($this->departments);

        return [
            'teacher_id' => 'T' . $this->faker->unique()->numberBetween(10000, 99999),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . '@university.edu'),
            'phone' => $this->faker->phoneNumber(),
            'department' => $department,
            'title' => $this->faker->randomElement($this->titles),
            'bio' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(90) // 90% chance of being active
        ];
    }
}
