<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = ['Math', 'English', 'Science', 'History', 'Computer'];
        foreach ($subjects as $name) {
            Subject::create(['name' => $name]);
        }
    }
}
