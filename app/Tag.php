<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function saves() 
    {
        return $this->belongsToMany(Save::class)->withTimestamps();
    }
}
