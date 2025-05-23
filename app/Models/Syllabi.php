<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syllabi extends Model
{
    protected $table = "syllabis";

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class,'syllabi_id');
    }
}
