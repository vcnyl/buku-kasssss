<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    DashboardController,
    SesiController,
    AdminController,
    AdminProfileController,
    SuperAdminProfileController,
    PenerimaanController,
    PenerimaanAdminController,
    PengeluaranController,
    DashboardSuperAdminController,
    LaporanController,
    SuperAdminLaporanController,
    UserController
};

// Rute untuk pengguna yang belum login
Route::middleware(['guest'])->group(function () {
    Route::get('', [SesiController::class, 'index'])->name('login');
    Route::post('login', [SesiController::class, 'login']);
});

// Rute untuk pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return redirect('admin/dashboard');
    });

    // Rute untuk admin
    Route::middleware('userAkses:admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Profile routes
        Route::prefix('admin/profile')->group(function () {
            Route::get('', [AdminProfileController::class, 'index'])->name('admin.profile.index');
            Route::get('edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
            Route::put('update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        });

        // Laporan route
        Route::get('admin/laporan', [LaporanController::class, 'laporan'])->name('admin.laporan');
        Route::get('/admin/laporan/download', [LaporanController::class, 'downloadPDF'])->name('admin.laporan.download');

        // CRUD Penerimaan untuk Admin
        Route::prefix('admin/penerimaan')->group(function () {
            Route::get('', [PenerimaanAdminController::class, 'index'])->name('admin.penerimaan.index');
            Route::get('create', [PenerimaanAdminController::class, 'create'])->name('admin.penerimaan.create');
            Route::post('', [PenerimaanAdminController::class, 'store'])->name('admin.penerimaan.store');
            Route::get('{id}/edit', [PenerimaanAdminController::class, 'edit'])->name('admin.penerimaan.edit');
            Route::put('{id}', [PenerimaanAdminController::class, 'update'])->name('admin.penerimaan.update');
            Route::delete('{id}', [PenerimaanAdminController::class, 'destroy'])->name('admin.penerimaan.destroy');
        });

        // CRUD Pengeluaran untuk Admin
        Route::prefix('admin/pengeluaran')->group(function () {
            Route::get('', [PengeluaranController::class, 'index'])->name('admin.pengeluaran.index');
            Route::get('create', [PengeluaranController::class, 'create'])->name('admin.pengeluaran.create');
            Route::post('', [PengeluaranController::class, 'store'])->name('admin.pengeluaran.store');
            Route::get('{id}/edit', [PengeluaranController::class, 'edit'])->name('admin.pengeluaran.edit');
            Route::put('{id}', [PengeluaranController::class, 'update'])->name('admin.pengeluaran.update');
            Route::delete('{id}', [PengeluaranController::class, 'destroy'])->name('admin.pengeluaran.destroy');
        });
    });

    // Rute untuk superadmin
    Route::middleware('userAkses:superadmin')->group(function () {
        Route::get('superadmin/dashboard', [DashboardSuperAdminController::class, 'index'])->name('superadmin.dashboard');

        // Profile routes
        Route::prefix('superadmin/profile')->group(function () {
            Route::get('', [SuperAdminProfileController::class, 'index'])->name('superadmin.profile.index');
            Route::get('edit', [SuperAdminProfileController::class, 'edit'])->name('superadmin.profile.edit');
            Route::put('update', [SuperAdminProfileController::class, 'update'])->name('superadmin.profile.update');
        });

        //Laporan Super Admin
        Route::get('/superadmin/laporan', [SuperAdminLaporanController::class, 'laporan'])->name('superadmin.laporan');
        Route::get('superadmin/laporan/download-pdf', [SuperAdminLaporanController::class, 'downloadPDF'])
            ->name('superadmin.laporan.downloadPDF');

        // CRUD Penerimaan untuk Superadmin
        Route::prefix('superadmin/penerimaan')->group(function () {
            Route::get('', [PenerimaanController::class, 'index'])->name('superadmin.penerimaan.index');
            Route::get('create', [PenerimaanController::class, 'create'])->name('superadmin.penerimaan.create');
            Route::post('', [PenerimaanController::class, 'store'])->name('superadmin.penerimaan.store');
            Route::get('{id}/edit', [PenerimaanController::class, 'edit'])->name('superadmin.penerimaan.edit');
            Route::put('{id}', [PenerimaanController::class, 'update'])->name('superadmin.penerimaan.update');
            Route::delete('{id}', [PenerimaanController::class, 'destroy'])->name('superadmin.penerimaan.destroy');
        });

        Route::prefix('superadmin/user')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('superadmin.user.index');
            Route::get('create', [UserController::class, 'create'])->name('superadmin.user.create');
            Route::post('', [UserController::class, 'store'])->name('superadmin.user.store');
            Route::get('{id}/edit', [UserController::class, 'edit'])->name('superadmin.user.edit');
            Route::put('{id}', [UserController::class, 'update'])->name('superadmin.user.update');
            Route::delete('{id}', [UserController::class, 'destroy'])->name('superadmin.user.destroy');
        });
        
        

    });

    Route::get('logout', [SesiController::class, 'logout'])->name('logout');
});
