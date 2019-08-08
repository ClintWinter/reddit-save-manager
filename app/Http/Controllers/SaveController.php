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
        $search = "%{$tmp}%";

        return $user
                ->saves()
                ->with(['subreddit', 'tags', 'type'])
                // search
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', $search)
                        ->orWhere('body', 'like', $search);
                })
                // filters
                ->when(request('subreddit', false), function($query, $subreddit) {
                    $query->whereHas('subreddit', function($q) use ($subreddit) {
                        $q->where('name', $subreddit);
                    });
                })
                ->when(request('tag', false), function($query, $tag) {
                    $query->whereHas('tags', function($q) use ($tag) {
                        $q->where('name', $tag);
                    });
                })
                ->when(request('type', false), function($query, $type) {
                    $query->whereHas('type', function($q) use ($type) {
                        $q->where('type', $type);
                    });
                })
                // ->where(function ($query) {
                //     if (request('subreddit', '')) {
                //         $query->where('subreddit.name', request('subreddit'));
                //     }
                //     if (request('tag', '')) {
                //         $query->where('tag.name', request('tag'));
                //     }
                //     if (request('type', '')) {
                //         $query->where('type.type', request('type'));
                //     }
                // })
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
