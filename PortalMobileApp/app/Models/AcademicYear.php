<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'year_level',
        'year_name',
        'start_date',
        'end_date',
        'is_current',
    ];

    // 🔗 Relations
    public function semesters()
    {
        return $this->hasMany(Semester::class, 'acad_year_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
