<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function instructor()
    {
        return $this->belongsTo(Instructor::class,'instructor_id');
    }
    public function students()
    {
        return $this->belongsToMany(User::class,'course_user');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function syllabi()
    {
        return $this->hasMany(Syllabi::class,'course_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function favorites()
    {
        return $this->hasMany(Favourite::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }
    public function lessonProgress()
    {
        return $this->hasManyThrough(
            LessonProgress::class,
            Syllabi::class,
            'course_id',
            'lesson_id',
            'id',
            'id'
        );
    }
    public function scopeTopCourses($query, $limit = 3)
{
    return $query->with(['category', 'instructor', 'syllabi.lessons', 'reviews', 'enrollments', 'image'])
        ->withCount('enrollments')
        ->orderBy('enrollments_count', 'desc')
        ->take($limit);
}

}
