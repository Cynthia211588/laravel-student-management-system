<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // 先确保有一些默认科目
        $subjects = [
            'Mathematics', 'English', 'Science', 'History', 'Computer Science'
        ];

        foreach ($subjects as $name) {
            Subject::firstOrCreate(['name' => $name]);
        }

        // 创建课程
        $courses = [
            ['course_id' => 'CS0001', 'name' => 'Software Engineering'],
            ['course_id' => 'CS0002', 'name' => 'Data Science'],
            ['course_id' => 'CS0003', 'name' => 'Network Security']
        ];

        foreach ($courses as $data) {
            $course = Course::create($data);

            // 随机关联 2-3 个科目
            $randomSubjects = Subject::inRandomOrder()->take(rand(2, 3))->pluck('id')->toArray();
            $course->subjects()->sync($randomSubjects);
        }
    }
}
