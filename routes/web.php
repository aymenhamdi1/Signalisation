<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\role\RoleController;
use App\Http\Controllers\Backend\user\UserController;
use App\Http\Controllers\Backend\admin\AdminController;
use App\Http\Controllers\frontend\home\IndexController;
use App\Http\Controllers\Backend\permission\PermissionController;
use App\Http\Controllers\Backend\traduction\TraductionController;
use App\Http\Controllers\Backend\permission_par_role\PermissionByRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Backend\gestion\Carte\CarteController;
use App\Http\Controllers\Backend\gestion\signalisation\SignalisationController;
use App\Http\Controllers\Backend\gestion\dashboard\DashboardController;


    Route::controller(IndexController::class)->group(function () {
        Route::get('/','Index')->name('index');
    });

    Route::get('/carte/projets/geojson', [CarteController::class, 'geojsonAllProjets'])->name('carte.projets.geojson');
Route::get('/carte/projet/{id}/geojson', [CarteController::class, 'geojsonProjet'])->name('carte.projet.geojson');




// Dans routes/web.php
Route::get('/geoserver-proxy', function() {
    $url = 'http://192.168.80.128:8080/geoserver/DBR/ows?'.http_build_query([
        'service' => 'WFS',
        'version' => '1.0.0',
        'request' => 'GetFeature',
        'typeName' => 'DBR:R_projets',
        'outputFormat' => 'application/json'
    ]);

    return response()->json(file_get_contents($url));
});

// Proxy pour GeoServer (contourne CORS)
Route::get('/geoserver-proxy', function (Request $request) {
    $url = 'http://192.168.80.128:8080/geoserver/DBR/ows?' . http_build_query($request->all());

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return response()->json(['error' => $error], 500);
    }

    return response($response, $httpCode)
        ->header('Content-Type', 'application/json')
        ->header('Access-Control-Allow-Origin', '*');
});


    require __DIR__.'/auth.php';

    Route::middleware(['auth', 'Admin'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin/dashboard','Index')->middleware(['auth', 'verified'])->name('dashboard');
            Route::get('/admin/logout','AdminLogout')->name('admin.logout');
            Route::get('/admin/profile', 'IndexProfile')->name('admin.profile');
            Route::get('/admin/edit/profile', 'EditProfile')->name('edit.profile');
            Route::post('/admin/store/profile', 'storeProfile')->name('store.profile');
            Route::get('/admin/change/password', 'ChangePassword')->name('change.password');
            Route::post('/admin/update/password', 'UpdatePassword')->name('update.password');
        });
    });


    ///Permission All Route
    Route::controller(PermissionController::class)->group(function(){
        Route::get('/all/permission','AllPermission')->name('all.permission')->middleware('permission:permission.menu');
        Route::get('/add/permission','AddPermission')->name('add.permission')->middleware('permission:permission.add');
        Route::post('/store/permission','StorePermission')->name('permission.store')->middleware('permission:permission.store');
        Route::get('/edit/permission/{group_name}','EditPermission')->name('edit.permission')->middleware('permission:permission.edit');
        Route::post('/update/permission/{group_name}','UpdatePermission')->name('permission.update')->middleware('permission:permission.update');
        Route::get('/delete/permission/{group_name}','DeletePermission')->name('delete.permission')->middleware('permission:permission.delete');

     });

     ///Roles All Route
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/roles','AllRoles')->name('all.roles')->middleware('permission:roles.menu');
        Route::get('/add/roles','AddRoles')->name('add.roles')->middleware('permission:roles.add');
        Route::post('/store/roles','StoreRoles')->name('roles.store')->middleware('permission:roles.store');
        Route::get('/edit/roles/{id}','EditRoles')->name('edit.roles')->middleware('permission:roles.edit');
        Route::post('/update/roles/{id}','UpdateRoles')->name('roles.update')->middleware('permission:roles.update');
        Route::get('/delete/roles/{id}','DeleteRoles')->name('delete.roles')->middleware('permission:roles.delete');

   });

   ///Add Roles in Permission All Route
    Route::controller(PermissionByRoleController::class)->group(function(){

        Route::get('/add/roles/permission','AddRolesPermission')->name('add.roles.permission')->middleware('permission:roles.permission.add');
        Route::post('/role/permission/store','StoreRolesPermission')->name('role.permission.store')->middleware('permission:roles.permission.store');
        Route::get('/all/roles/permission','AllRolesPermission')->name('all.roles.permission')->middleware('permission:roles.permission.menu');
        Route::get('/admin/edit/roles/{id}','AdminEditRoles')->name('permission.edit.roles')->middleware('permission:roles.permission.edit');
        Route::post('/role/permission/update/{id}','RolePermissionUpdate')->name('role.permission.update')->middleware('permission:roles.permission.update');
        Route::get('/admin/delete/roles/{id}','AdminDeleteRoles')->name('permission.delete.roles')->middleware('permission:roles.permission.delete');

   });

   ///Roles All Route
   Route::controller(TraductionController::class)->group(function(){
    Route::get('/all/traduction','AllTraduction')->name('all.traduction')->middleware('permission:traduction.menu');
    Route::get('/add/traduction','AddTraduction')->name('add.traduction')->middleware('permission:traduction.add');
    Route::post('/store/traduction','StoreTraduction')->name('traduction.store')->middleware('permission:traduction.store');
    Route::get('/edit/traduction/{key}','EditTraduction')->name('edit.traduction')->middleware('permission:traduction.edit');
    Route::post('/update/traduction/{key}','UpdateTraduction')->name('traduction.update')->middleware('permission:traduction.update');
    Route::get('/delete/traduction/{key}','DeleteTraduction')->name('delete.traduction')->middleware('permission:traduction.delete');

    Route::get('/extract-translations','extractTranslationsFromBladeFiles')->name('extract.translations')->middleware('permission:traduction.trans');
    Route::post('/traductions/delete-multiple','deleteMultipleTraductions')->name('delete.multiple.traductions')->middleware('permission:traduction.mdelete');



    });

    //==========****--- Gestion des Utilisateurs ---****=========//

    Route::controller(UserController::class)->group(function () {
        Route::get('/all/user','allUsers')->name('all.user')->middleware('permission:user.menu');
        Route::get('/add/user','addUser')->name('add.user')->middleware('permission:user.add');
        Route::post('/store/user','storeUser')->name('user.store')->middleware('permission:user.store');
        Route::get('/edit/user/{id}','editUser')->name('edit.user')->middleware('permission:user.edit');
        Route::post('/update/user/{id}','updateUser')->name('update.user')->middleware('permission:user.update');
        Route::get('/delete/user/{id}','deleteUser')->name('delete.user')->middleware('permission:user.delete');
        Route::get('/restore/user/{id}','restoreUser')->name('restore.user')->middleware('permission:user.restore');
        Route::get('/force_delete/user/{id}','forceDeleteUser')->name('forcedelete.user')->middleware('permission:user.fdelete');
        Route::post('/changestatus/user', 'changeStatus')->name('changestatus.user')->middleware('permission:user.status');
        Route::get('/getlastactive/user', 'getLastActiveUser')->name('getlastactive.user')->middleware('permission:user.activite');

    });



Route::get('all/dashboard', [DashboardController::class, 'index'])
    ->name('all.dashboard')
    ->middleware('auth');

Route::middleware(['auth'])->prefix('signalisation')->name('signalisation.')->group(function () {

    // ═══════ PANNEAUX ═══════
    Route::get('/',        [SignalisationController::class, 'index'])->name('index');
    Route::post('/',       [SignalisationController::class, 'store'])->name('store');
    Route::get('/{id}',    [SignalisationController::class, 'show'])->name('show');
    Route::put('/{id}',    [SignalisationController::class, 'update'])->name('update');
    Route::delete('/{id}', [SignalisationController::class, 'destroy'])->name('destroy');

    // ═══════ OBSERVATIONS ═══════
    Route::post('/{id}/observation',      [SignalisationController::class, 'storeObservation'])->name('observation.store');
    Route::put('/observation/{idObs}',    [SignalisationController::class, 'updateObservation'])->name('observation.update');
    Route::delete('/observation/{idObs}', [SignalisationController::class, 'destroyObservation'])->name('observation.destroy');

    // ═══════ PHOTOS ═══════
    Route::delete('/photos/{idPhoto}', [SignalisationController::class, 'destroyPhoto'])->name('photo.destroy');
});



Route::middleware(['auth'])
    ->prefix('carte')
    ->name('carte.')
    ->group(function () {
        Route::get('/',                 [CarteController::class, 'index'])->name('index');
        Route::post('/panneau',         [CarteController::class, 'store'])->name('panneau.store');
        Route::put('/panneau/{id}',     [CarteController::class, 'update'])->name('panneau.update');
    });



