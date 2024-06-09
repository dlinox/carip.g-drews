<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

//Oauth para google
Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();


    return response()->json($user);
});


// de / redirige a /auth
Route::get('/', function () {
    return redirect('/auth');
});

//grupo de rutas para el auth 
Route::group(['prefix' => 'auth'], function () {
    Route::get('/', [\App\Http\Controllers\Auth\AuthController::class, 'index']);
    Route::post('/sign-in', [\App\Http\Controllers\Auth\AuthController::class, 'signIn']);
});

//ruta para el dashboard
Route::get('/dashboard', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');



//rutas para configuracion
Route::group(['prefix' => ''], function () {

    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [\App\Http\Controllers\Configuration\CompanyController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\Configuration\CompanyController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\Configuration\CompanyController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Configuration\CompanyController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Configuration\CompanyController::class, 'destroy']);

        Route::get('/{id}/areas', [\App\Http\Controllers\Configuration\AreaController::class, 'index']);
        Route::get('/{id}/workers', [\App\Http\Controllers\Configuration\WorkerController::class, 'index']);
    });

    Route::group(['prefix' => 'branches'], function () {
        Route::get('/', [\App\Http\Controllers\BranchController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\BranchController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\BranchController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\BranchController::class, 'update']);
    });


    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', [\App\Http\Controllers\ProjectController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\ProjectController::class, 'show']);;
    });

    Route::group(['prefix' => 'cars'], function () {
        Route::get('/', [\App\Http\Controllers\Configuration\CarController::class, 'index']);
    });
});


//rutas para security
Route::group(['prefix' => ''], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [\App\Http\Controllers\Security\UserController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\Security\UserController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\Security\UserController::class, 'store']);
    });

    // Route::get('/modulos', [\App\Http\Controllers\Security\ModuleController::class, 'index']);

    Route::group(['prefix' => 'roles'], function () {
        //vista para roles
        Route::get('/', [\App\Http\Controllers\Security\RoleController::class, 'index']);
        //listado de roles
        Route::post('/items', [\App\Http\Controllers\Security\RoleController::class, 'getItems']);
        //crear un nuevo role
        Route::post('/', [\App\Http\Controllers\Security\RoleController::class, 'store']);
        //actualizar un role
        Route::put('/{id}', [\App\Http\Controllers\Security\RoleController::class, 'update']);
        //eliminar un role
        Route::delete('/{id}', [\App\Http\Controllers\Security\RoleController::class, 'destroy']);
        //actualizar el status de un role
        Route::put('/{id}/status', [\App\Http\Controllers\Security\RoleController::class, 'updateStatus']);
        //asignar permisos a un role
        Route::post('/permissions', [\App\Http\Controllers\Security\RoleController::class, 'assignPermissions']);
    });
});
