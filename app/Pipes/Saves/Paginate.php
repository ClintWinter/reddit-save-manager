<?php

namespace App\Pipes\Saves;

use Closure;

class Paginate {

    public function handle(array $data, Closure $next)
    {
        [$saves, $data] = $data;

        $saves = $saves->paginate($data['perPage']);

        return $next([$saves, $data]);
    }
}
