<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MitologiasController;
use App\Http\Controllers\userController;
use App\Http\Controllers\CivilizacionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');//protege la ruta para que solo usuarios autenticados puedan acceder

Route::post('/login', [userController::class, 'login']);


//ruta para mostrar todas las mitologias
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [userController::class, 'logout']);
});

Route::get('/mitologias', [MitologiasController::class, 'index']);
//ruta para mostrar mitologia por id
Route::get('/mitologias/{id}', [MitologiasController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    //protege las rutas para que solo usuarios autenticados puedan realizar estas acciones
    //ruta para crear mitologia
    Route::post('/mitologias', [MitologiasController::class, 'store']);
    //ruta para actualizar mitologia por id
    Route::put('/mitologias/{id}', [MitologiasController::class, 'update']);
    //ruta para actualizar parcialmente la mitologia por id
    Route::patch('/mitologias/{id}', [MitologiasController::class, 'updatePartial']);
    //ruta para eliminar mitologia por id
    Route::delete('/mitologias/{id}', [MitologiasController::class, 'destroy']);
});


Route::get('/users', [userController::class, 'index']);
//ruta para crear  user
Route::post('/users', [userController::class, 'store']);
//Ruta para mostrar user por id
Route::get('/users/{id}', [userController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    //Ruta modificar parcialmente usuario (no correo)
    Route::patch('/users/{id}', [userController::class, 'updatePartial']);
    //ruta eliminar usuario
    Route::delete('/users/{id}', [userController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    //ruta para asociar un usuario a una mitologia (guardar mitologia)
    Route::post('/mitologias/{IdMitologia}/users', [MitologiasController::class, 'attachUser']);
    //ruta para desasociar un usuario de una mitologia (quitar mitologia guardada)
    Route::delete('/mitologias/{IdMitologia}/users/{IdUsuario}', [MitologiasController::class, 'detachUser']);
    //ruta para obtener TODOS los usuarios que han guardado una mitologia ESPECIFICA
    Route::get('/mitologias/{IdMitologia}/users', [MitologiasController::class, 'showAttached']);
    //ruta para obtener todas las mitologias guardadas por un usuario especifico
    Route::get('/user/{IdUser}/mitologias', [userController::class, 'showAttached']);
});


//ruta para mostrar todas las civilizaciones con sus mitologias
Route::get('/civilizaciones', [CivilizacionController::class, 'index']);
//ruta para mostrar civilizacion por id
Route::get('/civilizaciones/{id}', [CivilizacionController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    //ruta para crear civilizacion
    Route::post('/civilizaciones', [CivilizacionController::class, 'store']);
    //ruta para modificar civilizacion
    Route::put('/civilizaciones/{id}', [CivilizacionController::class, 'update']);
    //ruta para eliminar civilizacion
    Route::delete('/civilizaciones/{id}', [CivilizacionController::class, 'destroy']);

});
