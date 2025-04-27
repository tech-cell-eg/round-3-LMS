<?php

namespace Database\Seeders;

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

        foreach ($students as $student) {
            User::firstOrCreate(
                ['email' => $student['email']],
                $student
            );
        }
    }
}
