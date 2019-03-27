<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('artigo','ArtigoController@index');
Route::get('artigo/{id}','ArtigoController@show');
Route::post('artigo','ArtigoController@store');
Route::put('artigo','ArtigoController@store');
Route::delete('artigo/{id}','ArtigoController@destroy');
