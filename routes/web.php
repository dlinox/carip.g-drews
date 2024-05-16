<?php

use Illuminate\Support\Facades\Route;


// de / redirige a /auth
Route::get('/', function () {
    return redirect('/auth');
});

//grupo de rutas para el auth 
Route::group(['prefix'=>'auth'],function(){
    Route::get('/',[\App\Http\Controllers\Auth\AuthController::class,'index']);
});

//ruta para el dashboard
Route::get('/dashboard',[\App\Http\Controllers\Dashboard\DashboardController::class,'index']);

//rutas para recepcion
Route::group(['prefix'=>'recepcion'],function(){
    Route::get('/',[\App\Http\Controllers\Reception\ReceptionController::class,'index']);
    Route::get('/registro',[\App\Http\Controllers\Reception\ReceptionController::class,'checkIn']);
    Route::get('/salida',[\App\Http\Controllers\Reception\ReceptionController::class,'checkOut']);
});

//rutas para configuracion
Route::group(['prefix'=>'configuracion'],function(){
    Route::get('/empresa',[\App\Http\Controllers\Configuration\CompanyController::class,'index']);
    Route::get('/categorias',[\App\Http\Controllers\Configuration\CategoryController::class,'index']);
    Route::get('/cajas',[\App\Http\Controllers\Configuration\CashRegisterController::class,'index']);
    Route::get('/habitaciones',[\App\Http\Controllers\Configuration\RoomController::class,'index']);
    Route::get('/pisos',[\App\Http\Controllers\Configuration\FloorController::class,'index']);
    Route::get('/series',[\App\Http\Controllers\Configuration\SerialController::class,'index']);
});


//rutas para security
Route::group(['prefix'=>'seguridad'],function(){
    Route::get('/usuarios',[\App\Http\Controllers\Security\UserController::class,'index']);
    Route::get('/roles',[\App\Http\Controllers\Security\RoleController::class,'index']);
    Route::get('/permisos',[\App\Http\Controllers\Security\PermissionController::class,'index']);
    Route::get('/modulos',[\App\Http\Controllers\Security\ModuleController::class,'index']);
});