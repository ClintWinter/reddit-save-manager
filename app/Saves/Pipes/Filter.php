<?php

namespace App\Saves\Pipes;

use Closure;

class Filter {

    public function handle(array $data, Closure $next)
    {
        [$request, $saves] = $data;

        return $next([$request, $saves]);
    }
}
