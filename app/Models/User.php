<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    
     public function setPasswordAttribute($value)
     {
         $this->attributes['password'] = Hash::make($value);
     }

     public function blogs() {
        return $this->hasMany(Blog::class, 'user_id','id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'user_id','id');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'user_id','id');
    }



    public function articles() {
        return $this->hasMany(Article::class, 'user_id','id');
    }

    
    protected $fillable = [
        'name',
        'email',
        'email_verified',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
