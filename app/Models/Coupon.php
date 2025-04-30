<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'coupon_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
