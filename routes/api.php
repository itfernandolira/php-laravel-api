<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//localhost/api - cai sempre nas rotas api.php
//esta é exatamente igual à de web e por isso devolve o mesmo content-type
/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', function () {
    //return application/json
    return ['Chegamos aqui'=>'SIM'];
    //ver content-type response
});

//os métodos create e edit não são implementados em api
//Route::resource('Cliente','App\Http\Controllers\ClienteController');

Route::prefix('v1')->middleware('jwt.auth')->group(function() {
    Route::post('me','AuthController@me');
    Route::apiResource('cliente','ClienteController');
    Route::apiResource('carro','CarroController');
    Route::apiResource('aluguer','AluguerController');
    Route::apiResource('marca','MarcaController');
    Route::apiResource('modelo','ModeloController');
});


Route::post('login','AuthController@login');
Route::post('logout','AuthController@logout');
Route::post('refresh','AuthController@refresh');




