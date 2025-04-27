<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function syllabi()
    {
        return $this->belongsTo(Syllabi::class, 'syllabus_id');
    }
    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }
}
