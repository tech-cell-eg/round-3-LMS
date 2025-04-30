<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function instructor()
    {
        return $this->belongsTo(Instructor::class,'instructor_id');
    }
}
