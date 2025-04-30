<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Syllabi;
use App\Models\Syllabus;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $instructors = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'username' => 'john_doe',
                'bio' => 'Senior Laravel developer with 8 years of experience',
                'title' => 'Web Development Expert',
                'field' => 'Web Development'
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Smith',
                'email' => 'sarah.smith@example.com',
                'username' => 'sarah_smith',
                'bio' => 'Data science specialist with Python expertise',
                'title' => 'Data Science Instructor',
                'field' => 'Data Science'
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael.johnson@example.com',
                'username' => 'michael_j',
                'bio' => 'UI/UX designer focused on user experience',
                'title' => 'UX Design Lead',
                'field' => 'UI/UX Design'
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Williams',
                'email' => 'emily.williams@example.com',
                'username' => 'emily_w',
                'bio' => 'Digital marketing strategist and SEO expert',
                'title' => 'Marketing Specialist',
                'field' => 'Digital Marketing'
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'username' => 'david_b',
                'bio' => 'Cybersecurity consultant and ethical hacker',
                'title' => 'Security Consultant',
                'field' => 'Cyber Security'
            ]
        ];

        foreach ($instructors as $instructorData) {
            // Create user
            $user = User::create([
                'first_name' => $instructorData['first_name'],
                'last_name' => $instructorData['last_name'],
                'email' => $instructorData['email'],
                'username' => $instructorData['username'],
                'password' => bcrypt('password'),
                'role' => 'instructor'
            ]);

            // Assign Image to user
            Image::create([
                'imageable_type' => User::class,
                'imageable_id' => $user->id,
                'path' => 'instructors/default-user.jpg',
            ]);

            // Create instructor profile
            $user->instructor()->create([
                'bio' => $instructorData['bio'],
                'title' => $instructorData['title'],
                'field' => $instructorData['field']
            ]);
        }

        $courses = [
            [
                'title' => 'Introduction to Laravel',
                'category_id' => 1,
                'instructor_id' => 1,
                'price' => 99.99,
                'duration' => 60,
                'level' => 'intermediate',
                'description' => 'Learn Laravel from scratch with this comprehensive course.',
                'video_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                'sale' => 79.99,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'Getting Started',
                        'description' => 'Introduction to Laravel framework',
                        'duration' => 30,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Installation',
                                'type' => 'text',
                                'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic.',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 20,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                            [
                                'title' => 'Configuration',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 10,
                                'is_preview' => true,
                                'order' => 2,
                            ],
                        ],
                    ],
                    [
                        'title' => 'Basic Concepts',
                        'description' => 'Learn the fundamental concepts of Laravel',
                        'duration' => 30,
                        'order' => 2,
                        'lessons' => [
                            [
                                'title' => 'Routing',
                                'type' => 'video',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 15,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                            [
                                'title' => 'Controllers',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 15,
                                'is_preview' => true,
                                'order' => 2,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'courses/default-course.jpg',
            ],
            [
                'title' => 'Advanced PHP Techniques',
                'category_id' => 2,
                'instructor_id' => 2,
                'price' => 129.99,
                'duration' => 30,
                'level' => 'advanced',
                'description' => 'Master advanced PHP concepts and patterns.',
                'video_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                'sale' => 0,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'Design Patterns',
                        'description' => 'Learn common PHP design patterns',
                        'duration' => 30,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Singleton Pattern',
                                'type' => 'video',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 30,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'courses/default-course.jpg',
            ],
            [
                'title' => 'JavaScript for Beginners',
                'category_id' => 3,
                'instructor_id' => 3,
                'price' => 89.99,
                'duration' => 40,
                'level' => 'beginner',
                'description' => 'A complete guide to JavaScript programming.',
                'video_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                'sale' => 69.99,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'JavaScript Basics',
                        'description' => 'Introduction to JavaScript programming language',
                        'duration' => 40,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Variables and Data Types',
                                'type' => 'video',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 10,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                            [
                                'title' => 'Functions',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 30,
                                'is_preview' => true,
                                'order' => 2,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'courses/default-course.jpg',
            ],
            [
                'title' => 'Data Science with Python',
                'category_id' => 4,
                'instructor_id' => 4,
                'price' => 149.99,
                'duration' => 35,
                'level' => 'intermediate',
                'description' => 'Learn data analysis and visualization using Python.',
                'video_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                'sale' => 0,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'Data Analysis',
                        'description' => 'Learn data analysis techniques using Python',
                        'duration' => 35,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Pandas Library',
                                'type' => 'text',
                                'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic. Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem. Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam, a commodi hic.',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 35,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'courses/default-course.jpg',
            ],
            [
                'title' => 'Digital Marketing Masterclass',
                'category_id' => 5,
                'instructor_id' => 5,
                'price' => 199.99,
                'duration' => 40,
                'level' => 'beginner',
                'description' => 'Comprehensive course on digital marketing strategies.',
                'video_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                'sale' => 0,
                'language' => 'English',
                'certificate' => true,
                'status' => true,
                'syllabi' => [
                    [
                        'title' => 'SEO Basics',
                        'description' => 'Learn the fundamentals of SEO',
                        'duration' => 40,
                        'order' => 1,
                        'lessons' => [
                            [
                                'title' => 'Keyword Research',
                                'type' => 'text',
                                'text' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi culpa corrupti maxime quidem.
                                            Sunt quis blanditiis tempore ipsum sed quia itaque nisi non temporibus, eveniet cupiditate totam,
                                            a commodi hic.',
                                'lesson_url' => 'https://www.youtube.com/watch?v=PEo0KmuuzSc',
                                'duration' => 40,
                                'is_preview' => true,
                                'order' => 1,
                            ],
                        ],
                    ],
                ],
                'image_path' => 'courses/default-course.jpg',
            ],
        ];

        foreach ($courses as $courseData) {
            $syllabi = $courseData['syllabi'];
            unset($courseData['syllabi']);
            unset($courseData['image_path']);

            $course = Course::create($courseData);
            // Increment instructor's total courses
            $instructor = Instructor::find($courseData['instructor_id']);
            if ($instructor) {
                $instructor->increment('total_courses');
            }

            Image::create([
                'imageable_type' => Course::class,
                'imageable_id' => $course->id,
                'path' => $courseData['image_path'] ?? 'courses/default-course.jpg',
            ]);

            foreach ($syllabi as $syllabusData) {
                $lessons = $syllabusData['lessons'] ?? [];
                unset($syllabusData['lessons']);

                $syllabus = Syllabi::create(array_merge($syllabusData, [
                    'course_id' => $course->id,
                ]));

                foreach ($lessons as $lessonData) {
                    Lesson::create(array_merge($lessonData, [
                        'syllabi_id' => $syllabus->id,
                    ]));
                }
            }
        }
    }
}
