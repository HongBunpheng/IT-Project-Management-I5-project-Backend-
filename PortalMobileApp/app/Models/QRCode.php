<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $fillable = [
        'code',
        'timetable_id',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
}

