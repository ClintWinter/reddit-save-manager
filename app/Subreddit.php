<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Subreddit extends Model
{
    protected $guarded = [];

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public static function usedByUser(User $user)
    {
        return self::query()->whereIn('id', function ($query) use ($user) {
            $query->select('subreddit_id')
                ->from('saves')
                ->where('saves.user_id', $user->id);
        })->get();
    }
}
