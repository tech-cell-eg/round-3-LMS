<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'student@example.com',
                'username' => 'doe_john',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Elsayed',
                'email' => 'student2@example.com',
                'username' => 'medo_elsayed',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Hossam',
                'email' => 'student3@example.com',
                'username' => 'ahmed_hossam',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
            [
                'first_name' => 'Medo',
                'last_name' => 'Essam',
                'email' => 'student4@example.com',
                'username' => 'medo_essam',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Salama',
                'email' => 'student5@example.com',
                'username' => 'ahmed_salama',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
            [
                'first_name' => 'Hassan',
                'last_name' => 'Shehata',
                'email' => 'student6@example.com',
                'username' => 'hassan_shehata',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
        ];

        foreach ($students as $studentData) {
            // Create or get the student
            $student = User::firstOrCreate(
                ['email' => $studentData['email']],
                [
                    'first_name' => $studentData['first_name'],
                    'last_name' => $studentData['last_name'],
                    'username' => $studentData['username'],
                    'password' => $studentData['password'],
                    'role' => $studentData['role'],
                ]
            );

            // Create avatar image for the student
            Image::updateOrCreate(
                [
                    'imageable_type' => User::class,
                    'imageable_id' => $student->id,
                ],
                [
                    'path' => $studentData['image_path'] ?? 'students/default-user.jpg',
                ]
            );
        }
    }
}
