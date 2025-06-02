<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Offering;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create courses
        $departments = ['Computer Science', 'Mathematics', 'Physics', 'Engineering', 'Business'];
        $coursePrefixes = [
            'CS' => ['Programming', 'Data Structures', 'Algorithms', 'Database', 'Web Development', 'Software Engineering', 'Artificial Intelligence', 'Computer Networks', 'Operating Systems', 'Compiler Design', 'Computer Graphics', 'Parallel Computing', 'Cryptography', 'Machine Learning', 'Human-Computer Interaction', 'Mobile App Development', 'Cloud Computing', 'Big Data Analytics', 'Information Security', 'Embedded Systems', 'Game Development', 'Natural Language Processing', 'Computer Vision', 'Distributed Systems', 'Bioinformatics', 'Quantum Computing'],
            'MATH' => ['Calculus', 'Linear Algebra', 'Statistics', 'Discrete Mathematics', 'Number Theory', 'Differential Equations', 'Numerical Analysis', 'Topology', 'Abstract Algebra', 'Real Analysis', 'Complex Analysis', 'Probability Theory', 'Combinatorics', 'Mathematical Logic', 'Set Theory', 'Graph Theory', 'Optimization', 'Mathematical Modeling', 'Game Theory', 'Dynamical Systems', 'Fourier Analysis', 'Partial Differential Equations', 'Mathematical Finance', 'Actuarial Science', 'Mathematical Biology'],
            'PHYS' => ['Mechanics', 'Electromagnetism', 'Quantum Physics', 'Thermodynamics', 'Optics', 'Modern Physics', 'Astrophysics', 'Nuclear Physics', 'Solid State Physics', 'Statistical Mechanics', 'Plasma Physics', 'Particle Physics', 'Biophysics', 'Geophysics', 'Acoustics', 'Medical Physics', 'Computational Physics', 'Fluid Dynamics', 'Classical Mechanics', 'Relativity'],
            'ENG' => ['Digital Systems', 'Circuit Theory', 'Control Systems', 'Robotics', 'Signal Processing', 'Microelectronics', 'Power Systems', 'Communications', 'Embedded Systems', 'VLSI Design', 'Instrumentation', 'Renewable Energy', 'Mechatronics', 'Automotive Engineering', 'Aerospace Engineering', 'Structural Analysis', 'Thermal Engineering', 'Manufacturing Processes', 'Materials Science', 'Project Management'],
            'BUS' => ['Management', 'Marketing', 'Finance', 'Accounting', 'Economics', 'Business Law', 'Entrepreneurship', 'Business Ethics', 'International Business', 'Operations Management', 'Human Resources', 'Organizational Behavior', 'Strategic Management', 'Supply Chain Management', 'E-Commerce', 'Business Analytics', 'Investment Analysis', 'Risk Management', 'Corporate Finance', 'Taxation']
        ];

        $courses = [];
        $courseCount = 0;
        foreach ($coursePrefixes as $prefix => $subjects) {
            foreach ($subjects as $index => $subject) {
                if ($courseCount >= 130) break 2;
                $courses[] = Course::create([
                    'code' => $prefix . ' ' . (100 + $index),
                    'name' => $subject,
                    'department' => $departments[array_search($prefix, array_keys($coursePrefixes))],
                    'credits' => rand(2, 4),
                    'is_active' => true
                ]);
                $courseCount++;
            }
        }

        // Create teachers
        $teacherFirstNames = ['Ali', 'Mohammad', 'Sara', 'Fatima', 'Hassan', 'Zahra', 'Reza', 'Maryam', 'Amir', 'Narges'];
        $teacherLastNames = ['Mohammadi', 'Ahmadi', 'Hosseini', 'Karimi', 'Rahimi', 'Nouri', 'Mousavi', 'Jafari', 'Kazemi', 'Mirzaei'];
        $titles = ['Professor', 'Associate Professor', 'Assistant Professor', 'Lecturer'];
        $teacherDepartments = $departments;
        for ($i = 0; $i < 100; $i++) {
            Teacher::create([
                'teacher_id' => 'TCH' . str_pad($i + 1, 5, '0', STR_PAD_LEFT),
                'first_name' => $teacherFirstNames[array_rand($teacherFirstNames)],
                'last_name' => $teacherLastNames[array_rand($teacherLastNames)],
                'email' => 'teacher' . ($i + 1) . '@university.edu',
                'department' => $teacherDepartments[array_rand($teacherDepartments)],
                'title' => $titles[array_rand($titles)],
                'is_active' => true
            ]);
        }

        // Create students
        $firstNames = ['Ali', 'Mohammad', 'Sara', 'Fatima', 'Hassan', 'Zahra', 'Reza', 'Maryam', 'Amir', 'Narges'];
        $lastNames = ['Mohammadi', 'Ahmadi', 'Hosseini', 'Karimi', 'Rahimi', 'Nouri', 'Mousavi', 'Jafari', 'Kazemi', 'Mirzaei'];
        $majors = ['Computer Science', 'Mathematics', 'Physics', 'Electrical Engineering', 'Business Administration'];
        $years = [1, 2, 3, 4];

        $students = new Collection();
        for ($i = 0; $i < 500; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $emailBase = Str::lower($firstName . '.' . $lastName . '@university.edu');
            $email = $emailBase;
            $suffix = 1;
            // Ensure unique email
            while ($students->contains(function ($student) use ($email) {
                return $student->email === $email;
            })) {
                $email = Str::lower($firstName . '.' . $lastName . $suffix . '@university.edu');
                $suffix++;
            }
            $students->push(Student::create([
                'student_id' => 'STU' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => '09' . rand(100000000, 999999999),
                'major' => $majors[array_rand($majors)],
                'year' => $years[array_rand($years)],
                'is_active' => true
            ]));
        }

        // Create offerings
        $semesters = ['2023-1', '2023-2', '2024-1'];
        $statuses = ['active', 'completed', 'dropped'];
        $grades = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'F'];
        $teachers = Teacher::all();

        // Create 3 offerings per course per semester
        foreach ($courses as $course) {
            foreach ($semesters as $semester) {
                // Create 3 sections for each course in each semester
                for ($section = 1; $section <= 3; $section++) {
                    $teacher = $teachers->random();

                    // Enroll 20-30 students in each offering
                    $enrolledStudents = $students->random(rand(20, 30));
                    foreach ($enrolledStudents as $student) {
                        $status = $semester === '2024-1' ? 'active' : ($semester === '2023-2' ? $statuses[array_rand($statuses)] : 'completed');

                        Offering::create([
                            'course_id' => $course->id,
                            'teacher_id' => $teacher->id,
                            'student_id' => $student->id,
                            'semester' => $semester,
                            'section' => $section,
                            'status' => $status,
                            'grade' => $status === 'completed' ? $grades[array_rand($grades)] : null
                        ]);
                    }
                }
            }
        }
    }
}
