<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }
    public function userLinks()
    {
        return $this->hasMany(UserLink::class);
    }
    public function instructorCourses()
    {
        return $this->hasMany(Course::class);
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
