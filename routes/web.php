<?php

// https://sistemaspnp.com/cedula/

use App\Http\Controllers\ProjectSupervisorController;
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
        Route::get('/', [\App\Http\Controllers\OperatorController::class, 'index']);
        Route::post('/items', [\App\Http\Controllers\OperatorController::class, 'getItems']);
        Route::post('/', [\App\Http\Controllers\OperatorController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\OperatorController::class, 'update']);
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

        Route::get('/items/operators', [\App\Http\Controllers\ProjectController::class, 'getOperators']);
        Route::get('/items/vehicles', [\App\Http\Controllers\ProjectController::class, 'getVehicles']);

        Route::get('/assigned-vehicles/{projectId}', [\App\Http\Controllers\ProjectController::class, 'getItemsAssignedVehicles']);
        Route::post('/assign-vehicle', [\App\Http\Controllers\ProjectController::class, 'assignVehicle']);

        Route::get('/items/companies', [\App\Http\Controllers\ProjectController::class, 'getCompanies']);
        Route::get('/items/responsible-by-company/{companyId}', [\App\Http\Controllers\ProjectController::class, 'getResponsibleByCompany']);
        Route::post('/assign-responsible-company', [\App\Http\Controllers\ProjectController::class, 'assignResponsibleCompany']);
        Route::get('/project-manager/{projectId}', [\App\Http\Controllers\ProjectController::class, 'getProjectManager']);
        Route::post('/assign-project-supervisor', [\App\Http\Controllers\ProjectController::class, 'assignProjectSupervisor']);
        Route::get('/project-supervisor/{projectId}', [\App\Http\Controllers\ProjectController::class, 'getProjectSupervisor']);
        // Route::get('/items/supervisory-operators', [\App\Http\Controllers\ProjectController::class, 'getSupervisoryOperators']);

        //supervisors
        Route::get('/items/supervisors', [\App\Http\Controllers\ProjectController::class, 'getSupervisors']);
        //assign/supervisor
        Route::post('/assign/supervisor', [ProjectSupervisorController::class, 'assignSupervisor']);
        //unassign/supervisor
        Route::post('/unassign/supervisor', [ProjectSupervisorController::class, 'unassignSupervisor']);
        //get/supervisor
        Route::get('/supervisor/{projectId}', [ProjectSupervisorController::class, 'getSupervisorByProject']);
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
