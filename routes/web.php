<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;

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
    Route::get('/docs-pengadaan', [DashboardController::class, 'docs_pengadaan'])->name('docs-pengadaan');
    Route::get('/docs-pengadaan/create', [DashboardController::class, 'docs_pengadaan_create'])->name('docs-pengadaan.create');
    Route::get('/docs-pengadaan/1/edit', [DashboardController::class, 'docs_pengadaan_edit'])->name('docs-pengadaan.edit');



    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
