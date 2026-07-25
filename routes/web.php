<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JenisCutiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CutiController;

// Route::get('/', function () {
//     return view('dashboard');
// });

Route::get('/', function(){
    return redirect('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard sesuai role
Route::middleware(['auth', 'role:karyawan'])->get('/hrd/karyawan/dashboard', [AuthController::class, 'karyawanDashboard'])->name('hrd.karyawan.dashboard');
Route::middleware(['auth', 'role:supervisor'])->get('/supervisor/dashboard', [AuthController::class, 'supervisorDashboard'])->name('supervisor.dashboard');
Route::middleware(['auth', 'role:hrd'])->get('/hrd/dashboard', [AuthController::class, 'hrdDashboard'])->name('hrd.dashboard');
Route::middleware(['auth', 'role:admin'])->get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

// Dashboard admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

    // AJAX CRUD USER
    Route::get('/admin/users/ajax', [UserController::class, 'ajaxList'])->name('admin.users.ajaxList');
    Route::post('/admin/users/store', [UserController::class, 'ajaxStore'])->name('admin.users.ajaxStore');
    Route::get('/admin/users/{id}/show', [UserController::class, 'ajaxShow'])->name('admin.users.ajaxShow');
    Route::put('/admin/users/{id}/update', [UserController::class, 'ajaxUpdate'])->name('admin.users.ajaxUpdate');
    Route::delete('/admin/users/{id}/delete', [UserController::class, 'ajaxDestroy'])->name('admin.users.ajaxDestroy');
});

// ======================= HRD AREA =======================
Route::prefix('hrd')->middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'hrdDashboard'])->name('hrd.dashboard');

    // CRUD Departemen
    Route::get('/departemen', [DepartemenController::class, 'index'])->name('hrd.departemen.index');
    Route::get('/departemen/create', [DepartemenController::class, 'create'])->name('hrd.departemen.create');
    Route::post('/departemen/store', [DepartemenController::class, 'store'])->name('hrd.departemen.store');
    Route::get('/departemen/{id}/edit', [DepartemenController::class, 'edit'])->name('hrd.departemen.edit');
    Route::put('/departemen/{id}/update', [DepartemenController::class, 'update'])->name('hrd.departemen.update');
    Route::delete('/departemen/{id}/delete', [DepartemenController::class, 'destroy'])->name('hrd.departemen.destroy');
});

// Area Karyawan for HRD
Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->name('hrd.') 
    ->group(function () {
        Route::get('/dashboard', [AuthController::class, 'hrdDashboard'])->name('dashboard');
        // CRUD Karyawan
        Route::resource('karyawan', KaryawanController::class);
    });

// Area Jenis cuti HRD

Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->name('hrd.') 
    ->group(function () {
    Route::get('/dashboard', [AuthController::class, 'hrdDashboard'])->name('dashboard');
    Route::resource('jeniscuti', JenisCutiController::class);
});

// ROUTE KARYAWAN (pengajuan cuti)
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::resource('cuti', CutiController::class)->only(['index', 'create', 'store', 'show','destroy']);
});

// ROUTE HRD (manajemen cuti)
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/hrd/cuti', [CutiController::class, 'hrdIndex'])->name('hrd.cuti.index');
});
Route::get('/hrd/cuti/export-pdf', [CutiController::class, 'exportPdf'])
    ->name('hrd.cuti.exportpdf');

Route::get('/hrd/cuti/export-excel', [CutiController::class, 'exportExcel'])
    ->name('hrd.cuti.exportexcel');

// ROUTE SUPERVISOR (persetujuan cuti)
Route::middleware(['auth', 'role:supervisor'])->group(function () {
    Route::get('/supervisor/cuti', [CutiController::class, 'spvIndex'])->name('supervisor.cuti.index');
    Route::post('/supervisor/cuti/{id}/approve', [CutiController::class, 'approve'])->name('supervisor.cuti.approve');
    Route::post('/supervisor/cuti/{id}/reject', [CutiController::class, 'reject'])->name('supervisor.cuti.reject');
    Route::get('/supervisor/cuti/riwayat', [CutiController::class, 'spvRiwayat'])->name('supervisor.cuti.riwayat');
});


// Karyawan dashboard route
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/hrd/karyawan/cuti/riwayat', [CutiController::class, 'riwayatKaryawan'])
        ->name('hrd.karyawan.cuti.riwayat');
});

// HRD Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/hrd/dashboard', [AuthController::class, 'hrdDashboard'])->name('hrd.dashboard');

    // Menu dalam HRD
    Route::get('/hrd/karyawan', [KaryawanController::class, 'index'])->name('hrd.karyawan');
    Route::get('/hrd/departemen', [DepartemenController::class, 'index'])->name('hrd.departemen');
    // Route::get('/hrd/jabatan', [JabatanController::class, 'index'])->name('hrd.jabatan');
});


Route::middleware(['auth'])->group(function ()   {

    // Halaman Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Update Profile (nama, password, upload foto)
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});

Route::prefix('hrd')->name('hrd.')->group(function () {
    Route::resource('karyawan', KaryawanController::class);
});

Route::prefix('hrd')->name('hrd.')->group(function () {
    Route::resource('departemen', DepartemenController::class);
});

