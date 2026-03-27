<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'email',
        'dob',
        'password',
        'phone',
        'address',
        'roles',
        'gender',
        'account_lock',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
            'roles' => 'integer',
            'gender' => 'integer',
            'account_lock' => 'integer',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_user');
    }

    public function isAdmin()
    {
        return $this->roles == 2;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function countAdmins()
    {
        return self::where('roles', 2)->count();
    }
}