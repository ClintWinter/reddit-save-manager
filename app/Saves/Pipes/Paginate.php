<?php

namespace App\Saves\Pipes;

use Closure;

class Paginate {

    public function handle(array $data, Closure $next)
    {
        [$request, $saves] = $data;

        $saves = $saves->paginate(session('perPage', 15));

        return $next([$request, $saves]);
    }
}
