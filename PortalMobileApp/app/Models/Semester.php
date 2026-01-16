<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'acad_year_id',
        'semester_num',
        'start_date',
        'end_date',
        'is_current',
    ];

    // 🔗 Relations
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'acad_year_id');
    }
}
