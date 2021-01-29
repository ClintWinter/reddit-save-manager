<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $saves = $user->saves()->orderBy('created_at')->paginate();

        return view('home', [
            'user' => $user,
            'saves' => $saves,
        ]);
    }
}
