<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'credit',
        'department_id',
        'year_level',
        'semester_id',
    ];

    // 🔗 Relations
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }
}
