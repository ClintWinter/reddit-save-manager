<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function saves()
    {
        return $this->hasMany(Save::class);
    }
}
