<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subreddit extends Model
{
    public function saves() 
    {
        return $this->hasMany(Save::class);
    }
}
