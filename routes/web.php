<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\PokemonController@index');
Route::get('/pokemon/{name}', 'App\Http\Controllers\PokemonController@show');
Route::get('/mypokemon', 'App\Http\Controllers\PokemonController@myPokemon');
Route::post('/mypokemonDetailAjax', 'App\Http\Controllers\PokemonController@myPokemonDetailAjax');
Route::get('/mypokemon/{name}', 'App\Http\Controllers\PokemonController@myPokemonShow');
Route::delete('/mypokemon/{id}', 'App\Http\Controllers\PokemonController@destroy');
Route::post('/pokemon', 'App\Http\Controllers\PokemonController@store');
Route::patch('/mypokemon', 'App\Http\Controllers\PokemonController@update');
