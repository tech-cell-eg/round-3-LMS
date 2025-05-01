<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class EnrollmentsSeeder extends Seeder
{
    public function run(): void
    {
        $enrollments = [
            ['user_id' => 6, 'course_id' => 1, 'coupon_id' => 3, 'discount_percentage' => 20, 'discount_code' => 'SUMMER20'],
            ['user_id' => 7, 'course_id' => 1, 'coupon_id' => 3, 'discount_percentage' => 20, 'discount_code' => 'SUMMER20'],
            ['user_id' => 8, 'course_id' => 1, 'coupon_id' => 3, 'discount_percentage' => 20, 'discount_code' => 'SUMMER20'],
            ['user_id' => 9, 'course_id' => 1, 'coupon_id' => 3, 'discount_percentage' => 20, 'discount_code' => 'SUMMER20'],
            ['user_id' => 10, 'course_id' => 1, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 11, 'course_id' => 1, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 6, 'course_id' => 2, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 7, 'course_id' => 2, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 8, 'course_id' => 2, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 9, 'course_id' => 2, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 10, 'course_id' => 2, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 6, 'course_id' => 3, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 7, 'course_id' => 3, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 8, 'course_id' => 3, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 9, 'course_id' => 3, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 6, 'course_id' => 4, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 7, 'course_id' => 4, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 8, 'course_id' => 4, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 6, 'course_id' => 5, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
            ['user_id' => 7, 'course_id' => 5, 'coupon_id' => null, 'discount_percentage' => null, 'discount_code' => null],
        ];

        foreach ($enrollments as $enrollment) {
            $course = Course::find($enrollment['course_id']);
            $coursePrice = $course->price;

            // Handle discount percentage (null check and typo correction)
            $discountPercentage = $enrollment['discount_percentage'] ?? $enrollment['discount_percentage'] ?? 0;

            // Calculate total price correctly (percentage of course price)
            $totalPrice = $coursePrice - ($coursePrice * ($discountPercentage / 100));

            $enrollmentRecord = Enrollment::firstOrCreate(
                [
                    'user_id' => $enrollment['user_id'],
                    'course_id' => $enrollment['course_id'],
                ],
                [
                    'coupon_id' => $enrollment['coupon_id'] ?? null,
                    'discount_percentage' => $discountPercentage,
                    'discount_code' => $enrollment['discount_code'] ?? $enrollment['discount_code'] ?? null,
                    'total_price' => $totalPrice,
                ]
            );

            if ($course) {
                Instructor::where('user_id', $course->instructor_id)
                    ->increment('total_students');
            }
        }
    }
}
