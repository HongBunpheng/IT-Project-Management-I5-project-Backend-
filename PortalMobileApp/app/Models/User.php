<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'user_name',
        'email',
        'password',
        'gender',
        'role',
        'group_id',
        'department_id',
        'profile_picture',
        'date_of_birth',
        'phone_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }

    // Relationships (based on your ERD)
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }

    // public function leaveRequests()
    // {
    //     return $this->hasMany(LeaveRequest::class);
    // }

    // public function personalTimeslots()
    // {
    //     return $this->hasMany(PersonalTimeslot::class);
    // }
}
