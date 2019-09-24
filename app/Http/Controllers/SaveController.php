<?php

namespace App\Http\Controllers;

use Auth;
use App\Save;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Filters\SaveFilters;

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
    public function index(Request $request, SaveFilters $filters)
    {
        $user = Auth::user();

        $user->handleToken();

        return $user
            ->saves()
            ->filter($filters)
            ->orderByDesc('id')
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
    public function store(Request $request, \App\ImportNewSaves $importNewSaves)
    {
        $importNewSaves->handle();
        // Auth::user()->handleNewSaves();

        return 0;
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
    public function destroy(Save $save)
    {
        $user = Auth::user();

        $user->handleToken();

        $httpClient = new Client([]);
        $response = $httpClient->post('https://oauth.reddit.com/api/unsave', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $user->access_token,
                'User-Agent' => config('services.reddit.platform') . ':' . config('services.reddit.app_id') . ':' . config('services.reddit.version_string')
            ],
            'body' => 'id=' . $save->reddit_id,
            'form_params' => [
                'id' => $save->reddit_id
            ]
        ]);
    
        $save->user()->dissociate();
        $save->tags()->detach();
        $save->delete();

        return 0;
    }
}
