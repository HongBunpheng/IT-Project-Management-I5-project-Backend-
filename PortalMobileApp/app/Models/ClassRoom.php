<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'building_id',
        'floor',
        'room_type'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}

