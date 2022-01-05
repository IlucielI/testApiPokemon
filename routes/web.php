<?php

use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes(['verify' => true]);

Route::get('/', 'App\Http\Controllers\PokemonController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/pokemon/{name}', 'App\Http\Controllers\PokemonController@show');
    Route::post('/pokemon', 'App\Http\Controllers\PokemonController@store');
    Route::get('/mypokemon', 'App\Http\Controllers\PokemonController@myPokemon');
    Route::delete('/mypokemon/{id}', 'App\Http\Controllers\PokemonController@destroy');
    Route::patch('/mypokemon', 'App\Http\Controllers\PokemonController@update');
});
Route::post('/mypokemonDetailAjax', 'App\Http\Controllers\PokemonController@myPokemonDetailAjax');
Route::get('/bayar/{id}', [PokemonController::class,'bayar']);
Route::post('/notification/handling', [PokemonController::class,'notification']);
Route::get('/finish', [MidtransController::class,'finish']);
Route::get('/unfinish', [MidtransController::class,'unfinish']);
Route::get('/error', [MidtransController::class,'error']);
// Route::get('/signin', 'App\Http\Controllers\AuthController@signin')->name('login')->middleware('guest');
// Route::get('/signup', 'App\Http\Controllers\AuthController@signup')->middleware('guest');
// Route::post('/signup', 'App\Http\Controllers\AuthController@signupStore');
// Route::post('/signin', 'App\Http\Controllers\AuthController@authenticate');
// Route::post('/signout', 'App\Http\Controllers\AuthController@signout');
