<?php
use Illuminate\Support\Facades\Request;

Auth::routes();

Route::get('/', function () {
    if (Auth::check()) 
        return redirect('/home');

    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/saves', 'SaveController@index');

Route::post('/tags', function(Request $request) {
    request()->validate([
        'tag' => 'required'
    ]);

    $tag = App\Tag::firstOrCreate([
        'name' => request('tag')
    ]);

    $tag->saves()->attach(request('save_id'));
    
    return $tag;
});

Route::get('/filters', function() {
    return Auth::user()->getFilters();
})->middleware('auth');

Route::get('/user', function() { return Auth::user(); })->middleware('auth');

Route::get('/reddit/redirect', 'Auth\LoginController@redirectToProvider')->name('reddit.redirect');
Route::get('/reddit/callback', 'Auth\LoginController@handleProviderCallback');