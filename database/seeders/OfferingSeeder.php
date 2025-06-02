<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Offering;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class OfferingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();
        $teachers = Teacher::all();
        $semesters = ['Fall 2024', 'Spring 2024', 'Summer 2024', 'Fall 2023', 'Spring 2023'];
        $sections = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

        // For each student, create 4-6 course enrollments per semester
        foreach ($students as $student) {
            foreach ($semesters as $semester) {
                // Determine how many courses this student takes this semester (4-6)
                $numCourses = rand(4, 6);

                // Get random courses for this semester
                $semesterCourses = $courses->random($numCourses);

                foreach ($semesterCourses as $course) {
                    // Find a teacher from the same department
                    $courseTeacher = $teachers->where('department', $course->department)->random();

                    // Create the offering
                    Offering::create([
                        'course_id' => $course->id,
                        'teacher_id' => $courseTeacher->id,
                        'student_id' => $student->id,
                        'semester' => $semester,
                        'section' => $sections[array_rand($sections)],
                        'status' => $this->getRandomStatus($semester),
                        'grade' => $this->getRandomGrade($semester)
                    ]);
                }
            }
        }
    }

    private function getRandomStatus(string $semester): string
    {
        // For current and future semesters, more likely to be active
        if (in_array($semester, ['Fall 2024', 'Spring 2024', 'Summer 2024'])) {
            return $this->getWeightedRandom(['active' => 80, 'dropped' => 20]);
        }

        // For past semesters, more likely to be completed
        return $this->getWeightedRandom(['completed' => 90, 'dropped' => 10]);
    }

    private function getRandomGrade(?string $semester): ?float
    {
        if (!$semester || in_array($semester, ['Fall 2024', 'Spring 2024', 'Summer 2024'])) {
            return null; // No grades for current/future semesters
        }

        // Generate grades with a normal distribution
        $grade = $this->generateNormalDistribution(75, 10);
        return round(max(0, min(100, $grade)), 2);
    }

    private function getWeightedRandom(array $weights): string
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);
        $current = 0;

        foreach ($weights as $key => $weight) {
            $current += $weight;
            if ($rand <= $current) {
                return $key;
            }
        }

        return array_key_first($weights);
    }

    private function generateNormalDistribution(float $mean, float $stdDev): float
    {
        // Box-Muller transform to generate normal distribution
        $u1 = mt_rand() / mt_getrandmax();
        $u2 = mt_rand() / mt_getrandmax();
        $z = sqrt(-2 * log($u1)) * cos(2 * pi() * $u2);
        return $z * $stdDev + $mean;
    }
}
