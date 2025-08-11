<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'student_id', 'dob', 'phone', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
