<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function instructor()
    {
        return $this->belongsTo(User::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function syllabi()
    {
        return $this->hasMany(Syllabi::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
