<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ['images' => []]);
})->name('welcome');

Route::post('/', function(Request $request) {
    // Send a request to Unsplash and get a list of ten urls to return back to the front there.
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => 'https://api.unsplash.com',
        // You can set any number of default request options.
        'timeout'  => 2.0,
        'headers' => [
            'Accept-Version' => 'v1',
            'Accept'     => 'application/json',
            'Authorization' => "Client-ID " . env("UNSPLASH_KEY")
        ]
    ]);

    $response = $client->request('GET', '/search/photos', ['query'=> ['query'=>$request->image_topic]]);
    $data = json_decode($response->getBody()->getContents(), true);
    // dd($data['results']);
    // On the FE, load the data into a script. Every ten seconds, change the background URL using jquery.
    return view('welcome', ['images' => $data['results']]);
});