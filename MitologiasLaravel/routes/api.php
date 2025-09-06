<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MitologiasController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//ruta para mostrar todas las mitologias
Route::get('/mitologias', [MitologiasController::class, 'index']);
//ruta para crear mitologia
Route::post('/mitologias', [MitologiasController::class, 'store']);
//ruta para mostrar mitologia por id
Route::get('/mitologias/{id}', [MitologiasController::class, 'show']);
