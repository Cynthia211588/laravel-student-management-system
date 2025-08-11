<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();
        $courses = Course::all();

        // 如果没有课程，先跳过
        if ($courses->count() == 0) {
            return;
        }

        // 添加 10 个学生
        for ($i = 1; $i <= 10; $i++) {
            $studentId = 'ST' . str_pad($i, 4, '0', STR_PAD_LEFT);

            Student::create([
                'student_id' => $studentId,
                'name' => $faker->name,
                'dob' => Carbon::now()->subYears(rand(18, 25))->format('Y-m-d'),
                'phone' => '01' . rand(10000000, 99999999),
                'course_id' => $courses->random()->id
            ]);
        }
    }
}
