<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(InstructorReview::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}
