<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    private $majors = [
        'Computer Science',
        'Mathematics',
        'Physics',
        'Chemistry',
        'Biology',
        'Engineering',
        'Business Administration',
        'Economics',
        'Psychology',
        'History',
        'English Literature',
        'Philosophy',
        'Political Science',
        'Sociology',
        'Art History',
        'Music',
        'Environmental Science',
        'Nursing',
        'Education',
        'Communications'
    ];

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $year = $this->faker->numberBetween(1, 4);
        $major = $this->faker->randomElement($this->majors);

        return [
            'student_id' => 'S' . $this->faker->unique()->numberBetween(10000, 99999),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower($firstName . '.' . $lastName . '@student.university.edu'),
            'phone' => $this->faker->phoneNumber(),
            'major' => $major,
            'year' => $year,
            'date_of_birth' => $this->faker->dateTimeBetween('-22 years', '-18 years'),
            'is_active' => $this->faker->boolean(95) // 95% chance of being active
        ];
    }
}
