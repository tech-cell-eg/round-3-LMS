<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Instructor extends Model
{
    use Notifiable;

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

    public function areas()
    {
        return $this->hasMany(InstructorArea::class);
    }
}
