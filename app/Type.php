<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    public $timestamps = false;
    
    public function saves() 
    {
        return $this->hasMany(Save::class);
    }
}
