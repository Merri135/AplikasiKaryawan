<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CutiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartemenController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\JenisCutiController;

Route::apiResource('departemen', DepartemenController::class);
Route::apiResource('karyawan', KaryawanController::class);

// Route::middleware('auth:sanctum')->group(function () {

//     Route::apiResource('cutis', CutiController::class);

//     Route::put('/cutis/{id}/approve', [CutiController::class, 'approve']);

//     Route::put('/cutis/{id}/reject', [CutiController::class, 'reject']);

// });

// Login API
Route::post('/login', [AuthController::class, 'login']);

// Route yang membutuhkan token
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('cutis', CutiController::class);

    Route::put('/cutis/{id}/approve', [CutiController::class, 'approve']);

    Route::put('/cutis/{id}/reject', [CutiController::class, 'reject']);
});


Route::middleware('auth:sanctum')->group(function(){

    Route::apiResource('cutis', CutiController::class);

    Route::put('/cutis/{id}/approve',[CutiController::class,'approve']);

    Route::put('/cutis/{id}/reject',[CutiController::class,'reject']);

});
Route::get('/departemen', [DepartemenController::class, 'index']);
Route::post('/departemen', [DepartemenController::class, 'store']);
Route::get('/departemen/{id}', [DepartemenController::class, 'show']);
Route::put('/departemen/{id}', [DepartemenController::class, 'update']);
Route::delete('/departemen/{id}', [DepartemenController::class, 'destroy']);

Route::get('/karyawan', [KaryawanController::class, 'index']);
Route::post('/karyawan', [KaryawanController::class, 'store']);
Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
Route::put('/karyawan/{id}', [KaryawanController::class, 'update']);
Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);

Route::prefix('jenis-cuti')->group(function () {

    Route::get('/', [JenisCutiController::class, 'index']);

    Route::get('/{id}', [JenisCutiController::class, 'show']);

    Route::post('/', [JenisCutiController::class, 'store']);

    Route::put('/{id}', [JenisCutiController::class, 'update']);

    Route::delete('/{id}', [JenisCutiController::class, 'destroy']);

});

Route::apiResource('cuti', CutiController::class);
Route::patch('cuti/{id}/approve', [CutiController::class,'approve']);
Route::patch('cuti/{id}/reject', [CutiController::class,'reject']);
