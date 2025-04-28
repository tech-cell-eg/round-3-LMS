<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Enrollment;

class EnrollmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = [
            ['user_id' => 6, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 7, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 8, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 9, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 10, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 11, 'course_id' => 1, 'enrollment_date' => now()],
            ['user_id' => 6, 'course_id' => 2, 'enrollment_date' => now()],
            ['user_id' => 7, 'course_id' => 2, 'enrollment_date' => now()],
            ['user_id' => 8, 'course_id' => 2, 'enrollment_date' => now()],
            ['user_id' => 9, 'course_id' => 2, 'enrollment_date' => now()],
            ['user_id' => 10, 'course_id' => 2, 'enrollment_date' => now()],
            ['user_id' => 6, 'course_id' => 3, 'enrollment_date' => now()],
            ['user_id' => 7, 'course_id' => 3, 'enrollment_date' => now()],
            ['user_id' => 8, 'course_id' => 3, 'enrollment_date' => now()],
            ['user_id' => 9, 'course_id' => 3, 'enrollment_date' => now()],
            ['user_id' => 6, 'course_id' => 4, 'enrollment_date' => now()],
            ['user_id' => 7, 'course_id' => 4, 'enrollment_date' => now()],
            ['user_id' => 8, 'course_id' => 4, 'enrollment_date' => now()],
            ['user_id' => 6, 'course_id' => 5, 'enrollment_date' => now()],
            ['user_id' => 7, 'course_id' => 5, 'enrollment_date' => now()],
        ];

        foreach ($enrollments as $enrollment) {
            // Create or find enrollment
            $enrollmentRecord = Enrollment::firstOrCreate(
                [
                    'user_id' => $enrollment['user_id'],
                    'course_id' => $enrollment['course_id'],
                ],
                [
                    'enrollment_date' => $enrollment['enrollment_date'],
                ]
            );

            // Always increment student's instructor, no matter if enrollment existed or not
            $course = Course::find($enrollment['course_id']);

            if ($course) {
                $instructor = Instructor::where('user_id', $course->instructor_id)->first();

                if ($instructor) {
                    $instructor->increment('total_students');
                }
            }
        }
    }
}
