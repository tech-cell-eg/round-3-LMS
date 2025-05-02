<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorArea extends Model
{
    protected $table = 'instructor_areas';

    protected $fillable = ['area'];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
