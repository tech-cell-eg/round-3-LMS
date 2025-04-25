<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Syllabi;
use App\Models\Syllabus;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $instructor = User::firstOrCreate(
            ['email' => 'instructor@example.com'],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'username' => 'DoeJohn',
                'password' => bcrypt('password'),
                'role' => 'instructor',
            ]
        );

        $courses = [
            [
                'title' => 'Introduction to Laravel',
                'category_id' => 1,
                'instructor_id' => $instructor->id,
                'price' => 99.99,
                'duration' => 360,
                'level' => 'intermediate',
                'description' => 'Learn Laravel from scratch with this comprehensive course.',
                'video_url' => 'https://example.com/courses/laravel-preview.mp4',
                'sale' => 79.99,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'Getting Started',
                        'description' => 'Introduction to Laravel framework',
                        'duration' => 60,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Installation',
                                'video_url' => 'https://example.com/lessons/laravel-installation.mp4',
                                'duration' => 15,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                            [
                                'title' => 'Configuration',
                                'video_url' => 'https://example.com/lessons/laravel-configuration.mp4',
                                'duration' => 20,
                                'is_preview' => false,
                                'order' => 2,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Basic Concepts',
                        'description' => 'Learn the fundamental concepts of Laravel',
                        'duration' => 120,
                        'order' => 2,
                        'lessons' => [
                            [
                                'title' => 'Routing',
                                'video_url' => 'https://example.com/lessons/laravel-routing.mp4',
                                'duration' => 25,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                            [
                                'title' => 'Controllers',
                                'video_url' => 'https://example.com/lessons/laravel-controllers.mp4',
                                'duration' => 30,
                                'is_preview' => false,
                                'order' => 2,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'sample/laravel-course.jpg',
            ],
            [
                'title' => 'Advanced PHP Techniques',
                'category_id' => 2,
                'instructor_id' => $instructor->id,
                'price' => 129.99,
                'duration' => 480,
                'level' => 'advanced',
                'description' => 'Master advanced PHP concepts and patterns.',
                'video_url' => 'https://example.com/courses/php-preview.mp4',
                'sale' => 0,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'Design Patterns',
                        'description' => 'Learn common PHP design patterns',
                        'duration' => 180,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Singleton Pattern',
                                'video_url' => 'https://example.com/lessons/php-singleton.mp4',
                                'duration' => 30,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'sample/php-course.jpg',
            ],
        ];

        foreach ($courses as $courseData) {
            $syllabi = $courseData['syllabi'];
            unset($courseData['syllabi']);
            unset($courseData['image_path']);

            $course = Course::create($courseData);

            Image::create([
                'imageable_type' => Course::class,
                'imageable_id' => $course->id,
                'path' => $courseData['image_path'] ?? 'sample/default-course.jpg',
            ]);

            foreach ($syllabi as $syllabusData) {
                $lessons = $syllabusData['lessons'] ?? [];
                unset($syllabusData['lessons']);

                $syllabus = Syllabi::create(array_merge($syllabusData, [
                    'course_id' => $course->id,
                ]));

                foreach ($lessons as $lessonData) {
                    Lesson::create(array_merge($lessonData, [
                        'syllabus_id' => $syllabus->id,
                    ]));
                }
            }
        }

    }
}
