<?php

namespace App\Http\Controllers;

use Auth;
use App\Save;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->tokenExpired())
            $user->refreshToken();

        $user
            ->newSaves()
            ->each(function($save) use ($user) {
                $user->newSave($save);
            });

        // if (empty(request('query'))) {
        //     return $user->saves()->with(['subreddit', 'tags', 'type'])->latest()->paginate(request('count', 15));
        // }

        $tmp = request('query', '');
        $query = "%{$tmp}%";

        return $user
                ->saves()
                ->with(['subreddit', 'tags', 'type'])
                ->where('title', 'like', $query)
                ->orWhere('body', 'like', $query)
                ->latest()
                ->paginate(request('count', 15));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
