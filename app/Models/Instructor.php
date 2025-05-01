<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $fillable = [
        'title',
        'description',
        'experience',
    ];
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
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function areas()
    {
        return $this->hasMany(InstructorArea::class);
    }
}
