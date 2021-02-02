<?php

namespace App\Saves\Pipes;

use Closure;

class Search {

    public function handle(array $data, Closure $next)
    {
        [$request, $saves] = $data;

        if ($request->has('query')) {
            $search = sprintf('%%s%', $request->query('query'));

            $saves = $saves->where(function ($query) use ($search) {
                $query->where('title', 'like', $search)
                    ->orWhere('body', 'like', $search);
            });
        }

        return $next([$request, $saves]);
    }
}
