<?php

namespace App\Pipes\Saves;

use Closure;

class Filter {

    public function handle(array $data, Closure $next)
    {
        [$saves, $data] = $data;

        $filters = $data['filters'];

        $saves = $saves->when($filters['type'], function ($query) use ($filters) {
                $query->where('type_id', $filters['type']);
            })
            ->when($filters['subreddit'], function ($query) use ($filters) {
                $query->where('subreddit_id', $filters['subreddit']);
            });

        return $next([$saves, $data]);
    }
}
