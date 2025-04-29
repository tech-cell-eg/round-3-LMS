<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample data for instructor reviews
        $reviews = [
            ['user_id' => 6,'course_id' => 1,'rating' => 5,'comment' => 'Great instructor!','created_at' => now()],
            ['user_id' => 7,'course_id' => 2,'rating' => 4,'comment' => 'Very knowledgeable.','created_at' => now()],
            ['user_id' => 8,'course_id' => 3,'rating' => 3,'comment' => 'Good course, but could be better.','created_at' => now()],
            ['user_id' => 9,'course_id' => 4,'rating' => 5,'comment' => 'Excellent content!','created_at' => now()],
            ['user_id' => 10,'course_id' => 5,'rating' => 2,'comment' => 'Not what I expected.','created_at' => now()],
        ];

        Review::insert($reviews);
    }
}
