<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['user_id' => 6,'lesson_id' => 1,'is_completed' => false,'completed_at' => null,'watch_duration' => 150],
            ['user_id' => 7,'lesson_id' => 1,'is_completed' => true,'completed_at' => now(),'watch_duration' => 360],
            ['user_id' => 8,'lesson_id' => 1,'is_completed' => false,'completed_at' => null,'watch_duration' => 150],
            ['user_id' => 9,'lesson_id' => 1,'is_completed' => true,'completed_at' => now(),'watch_duration' => 360],
            ['user_id' => 10,'lesson_id' => 1,'is_completed' => true,'completed_at' => now(),'watch_duration' => 360],
            ['user_id' => 11,'lesson_id' => 1,'is_completed' => true,'completed_at' => now(),'watch_duration' => 360],
            ['user_id' => 6,'lesson_id' => 2,'is_completed' => false,'completed_at' => null,'watch_duration' => 0],
            ['user_id' => 7,'lesson_id' => 2,'is_completed' => false,'completed_at' => null,'watch_duration' => 0],
            ['user_id' => 8,'lesson_id' => 2,'is_completed' => false,'completed_at' => null,'watch_duration' => 50],
            ['user_id' => 6,'lesson_id' => 3,'is_completed' => false,'completed_at' => null,'watch_duration' => 50],
        ];

        foreach ($data as $lessonProgress) {
            \App\Models\LessonProgress::create($lessonProgress);
        }
    }
}
