<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'department_id',
        'academic_year_id',
        'total_student'
    ];

    public function students()
    {
        return $this->hasMany(User::class, 'group_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
