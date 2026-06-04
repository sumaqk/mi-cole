<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WaterController;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UgelController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ContenidoController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\GeneralController;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::prefix('public')->group(function () {
    Route::get('stats', [InstitutionController::class, 'publicStats']);
    Route::get('ugel-chart', [InstitutionController::class, 'publicUgelChart']);
    Route::get('district-chart', [InstitutionController::class, 'publicDistrictChart']);
    Route::get('map-data', [InstitutionController::class, 'publicMapData']);
    Route::get('institutions', [InstitutionController::class, 'publicInstitutions']);
    Route::get('gallery', [InstitutionController::class, 'publicGallery']);
    Route::get('institutions/{id}/gallery', [InstitutionController::class, 'publicInstitutionGallery']);
    Route::get('contents', [ContenidoController::class, 'contents']);
    Route::get('contents/{id}', [ContenidoController::class, 'contentDetail']);
    Route::get('videos', [ContenidoController::class, 'videos']);
    Route::post('check-files', [ContenidoController::class, 'checkFiles']);
    Route::get('file', [ContenidoController::class, 'serveFile']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('general/backup', [GeneralController::class, 'apiBackup']);

    Route::prefix('water')->group(function () {
        Route::get('/', [WaterController::class, 'index']);
        Route::post('/', [WaterController::class, 'store']);
        Route::get('current-status', [WaterController::class, 'currentStatus']);
        Route::post('week', [WaterController::class, 'updateWeek']);
        Route::get('{id}', [WaterController::class, 'show']);
    });

    Route::prefix('institutions')->group(function () {
        Route::get('/', [InstitutionController::class, 'index']);
        Route::get('export', [InstitutionController::class, 'exportAll']);
        Route::post('/', [InstitutionController::class, 'store']);
        Route::get('provinces', [InstitutionController::class, 'provinces']);
        Route::get('districts', [InstitutionController::class, 'districts']);
        Route::get('ugels', [InstitutionController::class, 'ugels']);
        Route::get('{id}', [InstitutionController::class, 'show']);
        Route::put('{id}', [InstitutionController::class, 'update']);
        Route::delete('{id}', [InstitutionController::class, 'destroy']);
        Route::post('{id}/toggle-status', [InstitutionController::class, 'toggleStatus']);
        Route::post('{id}/assign-users', [InstitutionController::class, 'assignUsers']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('export', [UserController::class, 'exportAll']);
        Route::get('search', [UserController::class, 'search']);
        Route::get('form-options', [UserController::class, 'formOptions']);
        Route::post('change-password', [UserController::class, 'changePassword']);
        Route::post('upload-avatar', [UserController::class, 'uploadAvatar']);
        Route::get('{id}', [UserController::class, 'show']);
        Route::put('{id}', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'destroy']);
        Route::post('{id}/toggle-status', [UserController::class, 'toggleStatus']);
        Route::post('{id}/reset-password', [UserController::class, 'adminResetPassword']);
    });

    Route::prefix('ugels')->group(function () {
        Route::get('/', [UgelController::class, 'index']);
        Route::post('/', [UgelController::class, 'store']);
        Route::get('{id}', [UgelController::class, 'show']);
        Route::put('{id}', [UgelController::class, 'update']);
        Route::delete('{id}', [UgelController::class, 'destroy']);
        Route::post('{id}/toggle-status', [UgelController::class, 'toggleStatus']);
        Route::get('{idProvince}/districts', [UgelController::class, 'districts']);
    });

    Route::prefix('districts')->group(function () {
        Route::get('/', [DistrictController::class, 'index']);
        Route::post('/', [DistrictController::class, 'store']);
        Route::get('provinces', [DistrictController::class, 'provinces']);
        Route::get('by-province/{idProvince}', [DistrictController::class, 'byProvince']);
        Route::put('{id}', [DistrictController::class, 'update']);
        Route::delete('{id}', [DistrictController::class, 'destroy']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('categories', [ContenidoController::class, 'adminCategories']);
        Route::get('contents', [ContenidoController::class, 'adminContentsIndex']);
        Route::post('contents', [ContenidoController::class, 'adminContentsStore']);
        Route::put('contents/{id}', [ContenidoController::class, 'adminContentsUpdate']);
        Route::delete('contents/{id}', [ContenidoController::class, 'adminContentsDelete']);
        Route::post('contents/{id}/toggle-status', [ContenidoController::class, 'adminContentsToggleStatus']);

        Route::get('videos', [ContenidoController::class, 'adminVideosIndex']);
        Route::post('videos', [ContenidoController::class, 'adminVideosStore']);
        Route::put('videos/{id}', [ContenidoController::class, 'adminVideosUpdate']);
        Route::delete('videos/{id}', [ContenidoController::class, 'adminVideosDelete']);
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
        Route::get('map-data', [DashboardController::class, 'mapData']);
        Route::get('export-nonreporting', [DashboardController::class, 'exportNonReporting']);
        Route::get('export-withreporting', [DashboardController::class, 'exportWithReporting']);
    });
});
