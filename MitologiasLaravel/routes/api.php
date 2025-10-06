<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MitologiasController;
use App\Http\Controllers\userController;
use App\Http\Controllers\CivilizacionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');//protege la ruta para que solo usuarios autenticados puedan acceder

//------------rutas para el login------------------
Route::post('/login', [userController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [userController::class, 'logout']);
});

//--------------------------
//------------RUTAS PARA MITOLOGIAS controller (CRUD)---------------

Route::get('/mitologias', [MitologiasController::class, 'index']);
//ruta para mostrar mitologia por id
Route::get('/mitologias/{id}', [MitologiasController::class, 'show']);

Route::middleware('auth:sanctum', 'role:admin')->group(function () {
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

//--------------------------
//------------RUTAS PARA USER controller (CRUD user y rol usuario)---------------
Route::get('/users', [userController::class, 'index']);
//ruta para crear  user
Route::post('/users', [userController::class, 'store']);
//Ruta para mostrar user por id
Route::get('/users/{id}', [userController::class, 'show']);
//Ruta para mostrar todos los roles
Route::get('/roles', [userController::class, 'showRoles']);

Route::middleware('auth:sanctum')->group(function () { // solo usuarios autenticados
    //Ruta modificar parcialmente usuario (no correo)
    Route::patch('/users/{id}', [userController::class, 'updatePartial']);
    //ruta eliminar el propio usuario autenticado
    Route::delete('/users/me', [userController::class, 'destroyOwnUser']);
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Rutas que solo puede acceder un usuario con rol de admin
    //ruta para asignar rol a usuario por id (solo admin)
    Route::post('/users/{idUser}/promote', [userController::class, 'AssignRole']);
    //ruta eliminar usuario por id (solo admin)
    Route::delete('/users/{id}', [userController::class, 'destroyOtherUser']);
    //ruta para quitar rol a usuario por id (solo admin)
    Route::post('/users/{idUser}/remove', [userController::class, 'RemoveRol']);
});

//--------------------------
//------------RUTAS PARA ASOCIAR MITOLOGIAS A USUARIOS (GUARDAR MITOLOGIAS)---------------
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    //ruta para asociar un usuario a una mitologia (guardar mitologia)
    Route::post('/mitologias/{IdMitologia}/users', [MitologiasController::class, 'attachUser']);
    //ruta para desasociar un usuario de una mitologia (quitar mitologia guardada)
    Route::delete('/mitologias/{IdMitologia}/users/', [MitologiasController::class, 'detachUser']);
    //ruta para obtener TODOS los usuarios que han guardado una mitologia ESPECIFICA
    Route::get('/mitologias/{IdMitologia}/users', [MitologiasController::class, 'showAttached']);
    //ruta para obtener todas las mitologias guardadas por un usuario especifico
    Route::get('/user/mitologias', [userController::class, 'showAttached']);
});

//--------------------------
//------------RUTAS PARA CIVILIZACION controller (CRUD)---------------


//ruta para mostrar todas las civilizaciones con sus mitologias
Route::get('/civilizaciones', [CivilizacionController::class, 'index']);
//ruta para mostrar civilizacion por id
Route::get('/civilizaciones/{id}', [CivilizacionController::class, 'show']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    //ruta para crear civilizacion
    Route::post('/civilizaciones', [CivilizacionController::class, 'store']);
    //ruta para modificar civilizacion
    Route::put('/civilizaciones/{id}', [CivilizacionController::class, 'update']);
    //ruta para eliminar civilizacion
    Route::delete('/civilizaciones/{id}', [CivilizacionController::class, 'destroy']);

});
//--------------------------
