<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MitologiasController;
use App\Http\Controllers\userController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//ruta para mostrar todas las mitologias
Route::get('/mitologias', [MitologiasController::class, 'index']);
//ruta para crear mitologia
Route::post('/mitologias', [MitologiasController::class, 'store']);
//ruta para mostrar mitologia por id
Route::get('/mitologias/{id}', [MitologiasController::class, 'show']);
//ruta para actualizar mitologia por id
Route::put('/mitologias/{id}', [MitologiasController::class, 'update']);
//ruta para actualizar parcialmente la mitologia por id
Route::patch('/mitologias/{id}', [MitologiasController::class, 'updatePartial']);
//ruta para eliminar mitologia por id
Route::delete('/mitologias/{id}', [MitologiasController::class, 'destroy']);

Route::get('/users', [userController::class, 'index']);
//ruta para crear  user
Route::post('/users', [userController::class, 'store']);
//Ruta para mostrar user por id
Route::get('/users/{id}', [userController::class, 'show']);
//Ruta modificar parcialmente usuario (no correo)
Route::patch('/users/{id}', [userController::class, 'updatePartial']);
//ruta eliminar usuario
Route::delete('/users/{id}', [userController::class, 'destroy']);

//ruta para asociar un usuario a una mitologia (guardar mitologia)
Route::post('/mitologias/{IdMitologia}/users/{IdUsuario}', [MitologiasController::class, 'attachUser']);
//ruta para desasociar un usuario de una mitologia (quitar mitologia guardada)
Route::delete('/mitologias/{IdMitologia}/users/{IdUsuario}', [MitologiasController::class, 'detachUser']);
//ruta para obtener todas las mitologias guardadas por un usuario
Route::get('/mitologias/{IdMitologia}/users', [MitologiasController::class, 'showAttached']);
