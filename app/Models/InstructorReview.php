<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorReview extends Model
{
    public function instructor()
    {
        return $this->belongsTo(Instructor::class,'instructor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
