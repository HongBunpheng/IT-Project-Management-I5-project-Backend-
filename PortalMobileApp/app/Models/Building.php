<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = ['name', 'address', 'code'];

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }
}
