<?php

namespace App\Saves\Pipes;

use Closure;

class Search {

    public function handle(array $data, Closure $next)
    {
        [$saves, $data] = $data;

        if (array_key_exists('search', $data) && ! empty($data['search'])) {
            $search = "%{$data['search']}%";

            $saves = $saves->where(function ($query) use ($search) {
                $query->where('title', 'like', $search)
                    ->orWhere('body', 'like', $search);
            });
        }

        return $next([$saves, $data]);
    }
}
