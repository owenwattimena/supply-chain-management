<?php

use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ProductionController;
use App\Http\Controllers\Admin\RawMaterialController;
use App\Http\Controllers\Admin\OrderRawMaterialController;
use App\Http\Controllers\Admin\ProductionWorkerController;
use App\Http\Controllers\Admin\ReportProductionController;
use App\Http\Controllers\Admin\ProductionProductController;
use App\Http\Controllers\Admin\IncomingRawMaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('masuk', [AuthController::class, 'index'])->name('login');
Route::post('masuk', [AuthController::class, 'login'])->name('login.do');

Route::middleware(['auth'])->group(function () {
    Route::get('keluar', [AuthController::class, 'logout'])->name('logout');
    // Route::prefix('admin')->group(function () {

    Route::prefix('master')->group(function () {
        Route::prefix('pengguna')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('master.user');
            Route::post('/', [UserController::class, 'store'])->name('master.user.post');
            Route::put('{id}', [UserController::class, 'update'])->name('master.user.put');
            Route::delete('{id}', [UserController::class, 'delete'])->name('master.user.delete');
        });
        Route::prefix('satuan')->group(function () {
            Route::get('/', [UnitController::class, 'index'])->name('master.unit');
            Route::post('/', [UnitController::class, 'store'])->name('master.unit.post');
            Route::put('{id}', [UnitController::class, 'update'])->name('master.unit.put');
            Route::delete('{id}', [UnitController::class, 'delete'])->name('master.unit.delete');
        });
        Route::prefix('bahan-baku')->group(function () {
            Route::get('/', [RawMaterialController::class, 'index'])->name('master.raw-material');
            Route::post('/', [RawMaterialController::class, 'store'])->name('master.raw-material.post');
            Route::post('/{id}/price', [RawMaterialController::class, 'price'])->name('master.raw-material.price');
            Route::put('/{id}', [RawMaterialController::class, 'update'])->name('master.raw-material.put');
            Route::delete('/{id}', [RawMaterialController::class, 'delete'])->name('master.raw-material.delete');
        });
    });
    Route::prefix('persediaan')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('stock');
    });
    Route::prefix('transaksi-bahan-baku')->group(function () {
        Route::get('/', [IncomingRawMaterialController::class, 'index'])->name('incoming-raw-material');
        Route::post('/tambah', [IncomingRawMaterialController::class, 'create'])->name('incoming-raw-material.create');
        Route::get('/{id}', [IncomingRawMaterialController::class, 'show'])->name('incoming-raw-material.show');
        Route::post('/{id}', [IncomingRawMaterialController::class, 'store'])->name('incoming-raw-material.store');
        Route::post('/{id}/final', [IncomingRawMaterialController::class, 'final'])->name('incoming-raw-material.final');
    });
    Route::prefix('pemesanan-bahan-baku')->group(function () {
        Route::get('/', [OrderRawMaterialController::class, 'index'])->name('order-raw-material');
        Route::post('/', [OrderRawMaterialController::class, 'order'])->name('order-raw-material.order');
        Route::get('/{id}', [OrderRawMaterialController::class, 'show'])->name('order-raw-material.show');
        Route::get('/{id}/unduh', [OrderRawMaterialController::class, 'unduh'])->name('order-raw-material.download');
        Route::post('/{id}', [OrderRawMaterialController::class, 'orderMaterial'])->name('order-raw-material.order.material');
        Route::post('/{id}/status', [OrderRawMaterialController::class, 'status'])->name('order-raw-material.status');
        Route::post('/{id}/{idDetail}', [OrderRawMaterialController::class, 'updateOrderMaterial'])->name('order-raw-material.order.updateMaterial');
        Route::delete('/{id}/{idDetail}', [OrderRawMaterialController::class, 'deleteOrderMaterial'])->name('order-raw-material.order.deleteMaterial');
    });

    Route::prefix('produksi')->group(function () {
        Route::prefix('produk')->group(function () {
            Route::get('/', [ProductionProductController::class, 'index'])->name('production.product');
            Route::post('/', [ProductionProductController::class, 'create'])->name('production.product.create');
            Route::put('/{id}', [ProductionProductController::class, 'update'])->name('production.product.udpate');
            Route::delete('/{id}', [ProductionProductController::class, 'delete'])->name('production.product.delete');
        });
        Route::prefix('pekerja')->group(function () {
            Route::get('/', [ProductionWorkerController::class, 'index'])->name('production.worker');
            Route::post('/', [ProductionWorkerController::class, 'create'])->name('production.worker.create');
            Route::put('/{id}', [ProductionWorkerController::class, 'update'])->name('production.worker.update');
            Route::delete('/{id}', [ProductionWorkerController::class, 'delete'])->name('production.worker.delete');
        });
        Route::prefix('produksi')->group(function () {
            Route::get('/', [ProductionController::class, 'index'])->name('production');
            Route::post('/', [ProductionController::class, 'create'])->name('production.create');
            Route::put('/{id}', [ProductionController::class, 'update'])->name('production.update');
            Route::delete('/{id}', [ProductionController::class, 'delete'])->name('production.delete');

            Route::get('/{id}', [ProductionController::class, 'show'])->name('production.detail');
            Route::post('/{id}', [ProductionController::class, 'createDetail'])->name('production.detail.create');
            Route::put('/{id}/detail/{idDetail}', [ProductionController::class, 'updateDetail'])->name('production.detail.update');
            Route::delete('/{id}/detail/{idDetail}', [ProductionController::class, 'deleteDetail'])->name('production.detail.delete');
        
            Route::post('{id}/final', [ProductionController::class, 'final'])->name('production.final');

            Route::post('{id}/kehadiran', [ProductionController::class, 'kehadiran'])->name('production.kehadiran');
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::get('/produksi', [ReportProductionController::class, 'index'])->name('report.production');
        Route::get('/produksi/unduh', [ReportProductionController::class, 'unduh'])->name('report.production.unduh');
    });

    Route::get('/', function () {
        return redirect('dashboard');
    });
    Route::get('dashboard', function () {
        return view('admin.templates.template');
    })->name('dashboard');
    // });
});
