<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function saves() 
    {
        return $this->hasMany(Save::class);
    }
}
