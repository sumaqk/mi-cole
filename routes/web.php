<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ExceptionController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\WaterController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\UgelController;

Route::get('/', function () {
    return redirect()->route('home.index');
})->name('home');

Route::get('index/home', [IndexController::class, 'actionIndex'])->name('home.index');

Route::get('index/home/about', function () {
    return view('home/about');
})->name('home.about');

Route::get('index/home/content', [IndexController::class, 'actionContent'])->name('home.content');

Route::get('index/home/content_detail/{id}', [IndexController::class, 'actioncontentDetail'])->name('home.content_detail');

Route::get('index/home/gallery', [IndexController::class, 'actionGallery'])->name('home.gallery');

Route::get('index/home/institution', [IndexController::class, 'actionInstitution'])->name('home.institution');

Route::get('/get-districts', [UserController::class, 'getDistrictsByProvince'])->name('getDistricts');

Route::get('water/insert', [WaterController::class, 'actionInsert'])->middleware('GenericMiddleware:water/insert');

Route::get('index/indexadmin/{year?}/{month?}', [IndexController::class, 'actionIndexAdmin'])->middleware('GenericMiddleware:index/indexadmin');
Route::post('index/indexadmin', [IndexController::class, 'actionIndexAdmin'])->middleware('GenericMiddleware:index/indexadmin');

Route::get('general/privacy', [GeneralController::class, 'actionPrivacy'])->middleware('GenericMiddleware:general/privacy');
Route::get('general/accesserror', [GeneralController::class, 'actionAccessError'])->middleware('GenericMiddleware:general/accesserror');
Route::get('general/backup', [GeneralController::class, 'actionBackup'])->middleware('GenericMiddleware:general/backup');
Route::post('general/search', [GeneralController::class, 'actionSearch'])->middleware('GenericMiddleware:general/search');

Route::post('user/login', [UserController::class, 'actionLogIn'])->middleware('GenericMiddleware:user/login');
Route::match(['get', 'post'], 'user/loginasadmin', [UserController::class, 'actionLogInAsAdmin'])->middleware('GenericMiddleware:user/loginasadmin');
Route::get('user/logout', [UserController::class, 'actionLogOut'])->middleware('GenericMiddleware:user/logout');
Route::match(['get', 'post'], 'user/recoverypassword', [UserController::class, 'actionRecoveryPassword'])->middleware('GenericMiddleware:user/recoverypassword');
Route::post('user/getrecoverycode', [UserController::class, 'actionGetRecoveryCode'])->middleware('GenericMiddleware:user/getrecoverycode');
Route::post('user/changeemail', [UserController::class, 'actionChangeEmail'])->middleware('GenericMiddleware:user/changeemail');
Route::post('user/getemailchangecode', [UserController::class, 'actionGetEmailChangeCode'])->middleware('GenericMiddleware:user/getemailchangecode');
Route::post('user/insert', [UserController::class, 'actionInsert'])->middleware('GenericMiddleware:user/insert');
Route::match(['get', 'post'], 'user/insertasadmin', [UserController::class, 'actionInsertAsAdmin'])->middleware('GenericMiddleware:user/insertasadmin');
Route::get('user/thanksregister/{confirmation?}', [UserController::class, 'actionThanksRegister'])->middleware('GenericMiddleware:user/thanksregister');
Route::get('user/registerconfirmation/{email}/{confirmCode?}', [UserController::class, 'actionRegisterConfirmation'])->middleware('GenericMiddleware:user/registerconfirmation');
Route::match(['get', 'post'], 'user/edit', [UserController::class, 'actionEdit'])->middleware('GenericMiddleware:user/edit');
Route::match(['get', 'post'], 'user/editasadmin/{idUser?}', [UserController::class, 'actionEditAsAdmin'])->middleware('GenericMiddleware:user/editasadmin');
Route::post('user/uploadavatar', [UserController::class, 'actionUploadAvatar'])->middleware('GenericMiddleware:user/uploadavatar');
Route::post('user/changepassword', [UserController::class, 'actionChangePassword'])->middleware('GenericMiddleware:user/changepassword');
Route::get('user/getall/{currentPage}', [UserController::class, 'actionGetAll'])->middleware('GenericMiddleware:user/getall');
Route::get('user/deleteinactive', [UserController::class, 'actionDeleteInactive'])->middleware('GenericMiddleware:user/deleteinactive');
Route::post('user/filterbyfirstnamesurnameemail', [UserController::class, 'actionFilterByFirstNameSurNameEmail'])->middleware('GenericMiddleware:user/filterbyfirstnamesurnameemail');

Route::get('usernotification/read/{idUserNotification}', [UserNotificationController::class, 'actionRead'])->middleware('GenericMiddleware:usernotification/read');
Route::post('usernotification/readall', [UserNotificationController::class, 'actionReadAll'])->middleware('GenericMiddleware:usernotification/readall');
Route::post('usernotification/seebyscroll', [UserNotificationController::class, 'actionSeeByScroll'])->middleware('GenericMiddleware:usernotification/seebyscroll');
Route::post('usernotification/verify', [UserNotificationController::class, 'actionVerify'])->middleware('GenericMiddleware:usernotification/verify');

Route::match(['get', 'post'], 'configuration/management', [ConfigurationController::class, 'actionManagement'])->middleware('GenericMiddleware:configuration/management');

Route::get('exception/getall', [ExceptionController::class, 'actionGetAll'])->middleware('GenericMiddleware:exception/getall');
Route::get('exception/changestatus/{idException}/{status}', [ExceptionController::class, 'actionChangeStatus'])->middleware('GenericMiddleware:exception/changestatus');

Route::match(['get', 'post'], 'water/insert', [WaterController::class, 'actionInsert'])->middleware('GenericMiddleware:water/insert');
Route::get('water/getall', [WaterController::class, 'actionGetAll'])->middleware('GenericMiddleware:water/getall');
Route::get('water/export', [WaterController::class, 'actionExport'])->middleware('GenericMiddleware:water/export');
Route::get('/twater/detail/{id}', [WaterController::class, 'getWaterDetail'])->middleware('GenericMiddleware:water/detail')->name('water.detail');

Route::post('district/chgtoinsertwater', [DistrictController::class, 'actionChgToInsertWater'])->middleware('GenericMiddleware:district/chgtoinsertwater');

// RUTAS DE INSTITUTION - CON MIDDLEWARE CORREGIDO
Route::get('institution/getall/{currentPage}', [InstitutionController::class, 'actionGetAll'])->middleware('GenericMiddleware:institution/getall');
Route::get('institution/insert', [InstitutionController::class, 'actionInsert'])->middleware('GenericMiddleware:institution/insert');
Route::post('institution/insert', [InstitutionController::class, 'actionInsert'])->middleware('GenericMiddleware:institution/insert');
Route::get('institution/edit/{idInstitution}', [InstitutionController::class, 'actionEdit'])->middleware('GenericMiddleware:institution/edit');
Route::post('institution/update/{idInstitution}', [InstitutionController::class, 'actionUpdate'])->middleware('GenericMiddleware:institution/update');
Route::post('institution/delete/{idInstitution}', [InstitutionController::class, 'actionDelete'])->middleware('GenericMiddleware:institution/delete');
Route::post('institution/toggle-status/{idInstitution}', [InstitutionController::class, 'actionToggleStatus'])->middleware('GenericMiddleware:institution/toggle-status');
Route::post('institution/getdistricts', [InstitutionController::class, 'actionGetDistricts'])->middleware('GenericMiddleware:institution/getdistricts');
Route::post('institution/getugels', [InstitutionController::class, 'getugels'])->middleware('GenericMiddleware:institution/getugels');
Route::post('institution/usermanagement', [InstitutionController::class, 'actionUserManagement'])->middleware('GenericMiddleware:institution/usermanagement');
Route::post('institution/chgtoinsertwater', [InstitutionController::class, 'actionChgToInsertWater'])->middleware('GenericMiddleware:institution/chgtoinsertwater');


Route::get('ugel/getall/{currentPage}', [UgelController::class, 'actionGetAll'])->middleware('GenericMiddleware:ugel/getall');
Route::get('ugel/insert', [UgelController::class, 'actionInsert'])->middleware('GenericMiddleware:ugel/insert');
Route::post('ugel/insert', [UgelController::class, 'actionInsert'])->middleware('GenericMiddleware:ugel/insert');
Route::get('ugel/edit/{idUgel}', [UgelController::class, 'actionEdit'])->middleware('GenericMiddleware:ugel/edit');
Route::post('ugel/update/{idUgel}', [UgelController::class, 'actionUpdate'])->middleware('GenericMiddleware:ugel/update');
Route::post('ugel/getdistricts', [UgelController::class, 'actionGetDistricts'])->middleware('GenericMiddleware:ugel/getdistricts');
Route::post('ugel/delete/{idUgel}', [UgelController::class, 'actionDelete'])->middleware('GenericMiddleware:ugel/delete');
Route::post('ugel/toggle-status/{idUgel}', [UgelController::class, 'actionToggleStatus'])->middleware('GenericMiddleware:ugel/toggle-status');



Route::get('district/getall/{currentPage}', [DistrictController::class, 'actionGetAll'])->middleware('GenericMiddleware:district/getall');
Route::get('district/insert', [DistrictController::class, 'actionInsert'])->middleware('GenericMiddleware:district/insert');
Route::post('district/insert', [DistrictController::class, 'actionInsert'])->middleware('GenericMiddleware:district/insert');
Route::get('district/edit/{idDistrict}', [DistrictController::class, 'actionEdit'])->middleware('GenericMiddleware:district/edit');
Route::post('district/update/{idDistrict}', [DistrictController::class, 'actionUpdate'])->middleware('GenericMiddleware:district/update');
Route::post('district/delete/{idDistrict}', [DistrictController::class, 'actionDelete'])->middleware('GenericMiddleware:district/delete');
Route::post('district/chgtoinsertwater', [DistrictController::class, 'actionChgToInsertWater'])->middleware('GenericMiddleware:district/chgtoinsertwater');

?>