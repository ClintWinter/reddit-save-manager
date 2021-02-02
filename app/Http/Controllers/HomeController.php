<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $saves = $user->saves()->with(['subreddit', 'tags', 'type']);

        if ($request->has('perPage')) {
            $request->session()->put('perPage', $request->query('perPage'));
        }

        $saves = (new Pipeline(app()))
            ->send([$request, $saves])
            ->through([
                \App\Saves\Pipes\Filter::class,
                \App\Saves\Pipes\Search::class,
                \App\Saves\Pipes\Order::class,
                \App\Saves\Pipes\Paginate::class,
            ])
            ->then(function ($data) {
                return $data[1];
            });

        return view('home', [
            'user' => $user,
            'perPage' => $request->session()->get('perPage', 15),
            'saves' => $saves,
        ]);
    }
}
