<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for instructor reviews
        $reviews = [
            ['user_id' => 6,'instructor_id' => 1,'rating' => 5,'comment' => 'Great instructor!','created_at' => now()],
            ['user_id' => 7,'instructor_id' => 1,'rating' => 5,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 8,'instructor_id' => 1,'rating' => 4,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 9,'instructor_id' => 1,'rating' => 3,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 10,'instructor_id' => 2,'rating' => 5,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 6,'instructor_id' => 2,'rating' => 3,'comment' => 'Good, but could improve.','created_at' => now()],
            ['user_id' => 7,'instructor_id' => 2,'rating' => 2,'comment' => 'Not satisfied with the course.','created_at' => now()],
            ['user_id' => 8,'instructor_id' => 3,'rating' => 5,'comment' => 'Excellent teaching style!','created_at' => now()],
            ['user_id' => 9,'instructor_id' => 3,'rating' => 4,'comment' => 'Very engaging lectures.','created_at' => now()],
            ['user_id' => 10,'instructor_id' => 4,'rating' => 5,'comment' => 'Great instructor!','created_at' => now()],
            ['user_id' => 6,'instructor_id' => 4,'rating' => 4,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 7,'instructor_id' => 5,'rating' => 3,'comment' => 'Good, but could improve.','created_at' => now()],
            ['user_id' => 8,'instructor_id' => 5,'rating' => 2,'comment' => 'Not satisfied with the course.','created_at' => now()],
        ];

        foreach ($reviews as $review) {
            \DB::table('instructor_reviews')->insert($review);

            // Update the instructor's average rating
            $instructor = \DB::table('instructors')->where('id', $review['instructor_id'])->first();
            if ($instructor) {
                $totalReviews = \DB::table('instructor_reviews')->where('instructor_id', $review['instructor_id'])->count();

                \DB::table('instructors')->where('id', $review['instructor_id'])->update([
                    'total_reviews' => $totalReviews,
                ]);
            }
        }
    }
}
