<?php

use App\Http\Controllers\TestController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\WorkRequestController;
use App\Http\Controllers\WorkRequestItemController;
use App\Http\Controllers\WorkRequestRabController;
use App\Http\Controllers\WorkRequestSpesificationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');
Route::get('/token', [TestController::class, 'getDataToken'])->name('token');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route::get('/docs-pengadaan', [DashboardController::class, 'docs_pengadaan'])->name('docs-pengadaan');
    // Route::get('/docs-pengadaan/create', [DashboardController::class, 'docs_pengadaan_create'])->name('docs-pengadaan.create');

    // Route::get('/docs-pengadaan/1/edit', [DashboardController::class, 'docs_pengadaan_edit'])->name('docs-pengadaan.edit');
    // Route::get('/docs-pengadaan/1/edit/request', [DashboardController::class, 'docs_pengadaan_edit_request'])->name('docs-pengadaan_request.index');
    // Route::get('/docs-pengadaan/1/edit/rab', [DashboardController::class, 'docs_pengadaan_edit_rab'])->name('docs-pengadaan_rab.index');
    // Route::get('/docs-pengadaan/1/edit/spesification', [DashboardController::class, 'docs_pengadaan_edit_spesification'])->name('docs-pengadaan_spesification.index');

    // Work Request - work_request.index
    // Route::resource('work_request', WorkRequestController::class);
    // Route::resource('work_request_items', WorkRequestItemController::class);

    Route::prefix('work_request')->name('work_request.')->group(function () {

        Route::resource('/', WorkRequestController::class)->except(['show', 'edit'])->parameters(['' => 'id'])->names([
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'update' => 'update',
            'destroy' => 'destroy',
        ]);

        // Details
        // Route::get('/{id}/show', [WorkRequestController::class, 'show'])->name('show');
        // Route::prefix('{id}/show')->name('work_request.')->group(function () {
        //     Route::get('/work_request_items/{work_request_item_id}', [WorkRequestItemController::class, 'show'])->name('items.show');
        //     Route::get('/work_rabs/{work_rab_id}', [WorkRequestRabController::class, 'show'])->name('rabs.show');
        //     Route::get('/work_spesifications/{work_spesification_id}', [WorkRequestSpesificationController::class, 'show'])->name('spesifications.show');
        // });
        Route::get('{id}/show/work_request_items', [WorkRequestController::class, 'show'])->name('work_request_items.show');
        Route::get('{id}/show/work_rabs', [WorkRequestRabController::class, 'show'])->name('work_rabs.show');
        Route::get('{id}/show/work_spesifications', [WorkRequestSpesificationController::class, 'show'])->name('work_spesifications.show');


        // Work Request Items
        Route::prefix('{id}/edit/work_request_items')->name('work_request_items.')->group(function () {
            Route::get('/', [WorkRequestItemController::class, 'edit'])->name('edit');
            // Route::get('/{work_request_item_id}', [WorkRequestItemController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestItemController::class, 'store'])->name('store');
            Route::put('/{work_request_item_id}/update', [WorkRequestItemController::class, 'update'])->name('update');
            Route::delete('/{work_request_item_id}', [WorkRequestItemController::class, 'destroy'])->name('destroy');
        });

        // Work Rabs Items
        Route::prefix('{id}/edit/work_rabs')->name('work_rabs.')->group(function () {
            Route::get('/', [WorkRequestRabController::class, 'edit'])->name('edit');
            // Route::get('/{work_rab_id}', [WorkRequestRabController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestRabController::class, 'store'])->name('store');
            Route::put('/{work_rab_id}/update', [WorkRequestRabController::class, 'update'])->name('update');
            Route::delete('/{work_rab_id}', [WorkRequestRabController::class, 'destroy'])->name('destroy');
        });

        // Work spesification
        Route::prefix('{id}/edit/work_spesifications')->name('work_spesifications.')->group(function () {
            Route::get('/', [WorkRequestSpesificationController::class, 'edit'])->name('edit');
            // Route::get('/{work_spesification_id}', [WorkRequestSpesificationController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestSpesificationController::class, 'store'])->name('store');
            Route::put('/{work_spesification_id}/update', [WorkRequestSpesificationController::class, 'update'])->name('update');
            Route::delete('/{work_spesification_id}', [WorkRequestSpesificationController::class, 'destroy'])->name('destroy');
        });
    });

    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
