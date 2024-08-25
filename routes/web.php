<?php

// https://sistemaspnp.com/cedula/

use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProjectManagerController;
use App\Http\Controllers\ProjectSupervisorController;
use App\Http\Controllers\ProjectVehicleController;
use App\Http\Controllers\TimeSheetController;
use App\Http\Controllers\VehiclesOperatorController;
use App\Models\ProjectSupervisor;
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
    Route::post('/sign-out', [\App\Http\Controllers\Auth\AuthController::class, 'signOut']);
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

    Route::group(['prefix' => 'areas'], function () {
        Route::post('/items/{companyId}', [\App\Http\Controllers\Configuration\AreaController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\Configuration\AreaController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Configuration\AreaController::class, 'update']);
    });

    Route::group(['prefix' => 'workers'], function () {
        Route::post('/items/{companyId}', [\App\Http\Controllers\Configuration\WorkerController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\Configuration\WorkerController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Configuration\WorkerController::class, 'update']);
    });

    Route::group(['prefix' => 'branches'], function () {
        Route::get('/', [\App\Http\Controllers\BranchController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\BranchController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\BranchController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\BranchController::class, 'update']);
    });

    Route::group(['prefix' => 'operators'], function () {
        Route::get('/', [OperatorController::class, 'index']);
        Route::post('/items', [OperatorController::class, 'getItems']);
        Route::post('/', [OperatorController::class, 'store']);
        Route::put('/{id}', [OperatorController::class, 'update']);
    });

    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('/', [\App\Http\Controllers\SupplierController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\SupplierController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\SupplierController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\SupplierController::class, 'update']);
        Route::get('/{id}/vehicles', [\App\Http\Controllers\VehicleController::class, 'index']);
    });

    Route::group(['prefix' => 'vehicles'], function () {
        Route::post('/items/{supplierId}', [\App\Http\Controllers\VehicleController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\VehicleController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\VehicleController::class, 'update']);
    });

    Route::group(['prefix' => 'supervisors'], function () {
        Route::get('/', [\App\Http\Controllers\SupervisorController::class, 'index']);
        Route::post('/items/', [\App\Http\Controllers\SupervisorController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\SupervisorController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\SupervisorController::class, 'update']);
    });

    Route::group(['prefix' => 'administrators'], function () {
        Route::get('/', [\App\Http\Controllers\AdministratorController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\AdministratorController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\AdministratorController::class, 'store']);
    });


    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', [\App\Http\Controllers\ProjectController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\ProjectController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\ProjectController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\ProjectController::class, 'update']);
        Route::get('/{id}', [\App\Http\Controllers\ProjectController::class, 'show']);


        //project supervisors
        Route::get('/items/supervisors', [ProjectSupervisorController::class, 'getSupervisors']);
        //assign/supervisor
        Route::post('/assign/supervisor', [ProjectSupervisorController::class, 'assignSupervisor']);
        //unassign/supervisor
        Route::post('/unassign/supervisor', [ProjectSupervisorController::class, 'unassignSupervisor']);
        //get/supervisor
        Route::get('/supervisor/{projectId}', [ProjectSupervisorController::class, 'getSupervisorByProject']);

        //project manager
        Route::get('/items/company-managers/{companyId}', [ProjectManagerController::class, 'getCompanyManagers']);
        //projects/assign/manager
        Route::post('/assign/manager', [ProjectManagerController::class, 'assignManager']);
        //projects/unassign/manager
        Route::post('/unassign/manager', [ProjectManagerController::class, 'unassignManager']);
        //getProjectManagers
        Route::get('/managers/{projectId}', [ProjectManagerController::class, 'getManagers']);

        //project vehicles
        //projects/vehicles/supplier
        Route::get('/vehicles/supplier/{supplierId}', [ProjectVehicleController::class, 'getVehiclesBySupplier']);

        Route::get('/items/vehicles/{projectId}', [ProjectVehicleController::class, 'items']);
        //projects/vehicles/assign
        Route::post('/assign/vehicle', [ProjectVehicleController::class, 'assignVehicle']);
        //projects/vehicles/unassign
        Route::post('/unassign/vehicle', [ProjectVehicleController::class, 'unassignVehicle']);

        //projects vehicles operator
        Route::get('/free/operators', [OperatorController::class, 'getOperators']);

        //assignOperator
        Route::post('/assign/operator', [VehiclesOperatorController::class, 'assignOperator']);
        //unassignOperator
        Route::post('/unassign/operator', [VehiclesOperatorController::class, 'unassignOperator']);

        //time-sheets
        Route::get('/time-sheets/{projectId}', [TimeSheetController::class, 'index']);
        //store
        Route::post('/time-sheets', [TimeSheetController::class, 'store']);

        //vehiclesForTimeSheet
        Route::get('/vehicles-for-time-sheet/{projectId}/{date}', [TimeSheetController::class, 'timeSheetByDay']);
    });
});


//rutas para security
Route::group(['prefix' => ''], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [\App\Http\Controllers\Security\UserController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\Security\UserController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\Security\UserController::class, 'store']);

        //getProfilesByType
        Route::get('/{type}/profiles', [\App\Http\Controllers\Security\UserController::class, 'getProfilesByType']);

        //assign-branch
        Route::post('/assign-branch', [\App\Http\Controllers\Security\UserController::class, 'assignBranch']);
        //disable-branch
        Route::post('/disable-branch', [\App\Http\Controllers\Security\UserController::class, 'disableBranch']);

        //search-project
        Route::get('/search-projects/{search}/{id}', [\App\Http\Controllers\Security\UserController::class, 'searchProject']);

        //assign-project
        Route::post('/assign-project', [\App\Http\Controllers\Security\UserController::class, 'assignProject']);

        //disable-project
        Route::post('/disable-project', [\App\Http\Controllers\Security\UserController::class, 'disableProject']);
    });


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


Route::group(['prefix' => 'service'], function () {
    Route::get('/locations/{search}', [\App\Http\Controllers\ServiceController::class, 'searchLocation']);
    Route::get('/reniec/{dni}', [\App\Http\Controllers\ServiceController::class, 'searchReniec']);
    Route::get('/sunat/{ruc}', [\App\Http\Controllers\ServiceController::class, 'searchSunat']);
});
