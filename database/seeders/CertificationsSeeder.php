<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $certifications = [
            [
                'user_id' => 6,
                'course_id' => 1,
                'duration' => '60',
                'issued_date' => now(),
            ],
        ];
        foreach ($certifications as $certification) {
            \App\Models\Certification::create($certification);
        }
    }
}
