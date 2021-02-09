<?php

namespace App\Saves\Pipes;

use Closure;

class Order {

    public function handle(array $data, Closure $next)
    {
        [$saves, $data] = $data;

        $saves = $saves->orderBy('created_at');

        return $next([$saves, $data]);
    }
}
