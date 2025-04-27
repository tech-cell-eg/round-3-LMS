<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Programming', 'Web Development', 'Mobile Development', 'Game Development',
            'Design', 'UI/UX Design', 'Graphic Design', 'Photography',
            'Business', 'Marketing', 'SEO', 'Personal Development', 'Career Development',
            'Language Learning', 'English', 'Spanish', 'French',
            'Health & Fitness', 'Yoga', 'Meditation',
            'Music', 'Singing', 'Music Instruments',
            'Finance & Accounting', 'Data Science', 'Artificial Intelligence', 'Machine Learning',
            'Cyber Security', 'Networking', 'Cloud Computing',
            'Project Management', 'Leadership', 'Software Testing',
            'Blockchain', 'Cryptocurrency', 'Cooking', 'Lifestyle', 'Video Production',
        ];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
