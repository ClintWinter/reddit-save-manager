<?php

namespace App\Saves\Pipes;

use Closure;

class Order {

    public function handle(array $data, Closure $next)
    {
        [$request, $saves] = $data;

        $saves = $saves->orderBy('created_at');

        return $next([$request, $saves]);
    }
}
