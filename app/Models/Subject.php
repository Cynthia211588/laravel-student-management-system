<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function examMarks()
    {
        return $this->hasMany(ExamMark::class);
    }
}
