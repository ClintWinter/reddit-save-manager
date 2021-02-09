<?php

namespace App\Saves\Pipes;

use Closure;

class Paginate {

    public function handle(array $data, Closure $next)
    {
        [$saves, $data] = $data;

        $saves = $saves->paginate($data['perPage']);

        return $next([$saves, $data]);
    }
}
