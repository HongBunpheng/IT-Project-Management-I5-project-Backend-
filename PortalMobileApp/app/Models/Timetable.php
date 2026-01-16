<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'group_id',
        'class_id',
        'semester_id',
        'day_of_week',
        'title',
        'start_time',
        'end_time',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    
}
