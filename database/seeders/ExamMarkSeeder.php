<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\ExamMark;

class ExamMarkSeeder extends Seeder
{
    public function run(): void
    {
        // 遍历所有学生
        $students = Student::with('course.subjects')->get();

        foreach ($students as $student) {
            // 如果学生没有课程或者课程没有科目，就跳过
            if (!$student->course || $student->course->subjects->isEmpty()) {
                continue;
            }

            foreach ($student->course->subjects as $subject) {
                ExamMark::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'subject_id' => $subject->id
                    ],
                    [
                        'marks' => rand(50, 100) // 随机生成50-100分
                    ]
                );
            }
        }
    }
}
