<?php

use App\Http\Controllers\OrderCommunicationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\TestController;

use App\Http\Controllers\WorkRequestController;
use App\Http\Controllers\WorkRequestDataTableController;
use App\Http\Controllers\WorkRequestItemController;
use App\Http\Controllers\WorkRequestRabController;
use App\Http\Controllers\WorkRequestSpesificationController;
use App\Http\Controllers\WorkRequestSpesificationFileController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WorkRequestVendorController;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Actions\Fortify\CreateNewUser;
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

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/register', function () {
        return view('auth.register', ['roles' => Role::all()]);
    })->name('register');

    Route::post('/register', function (Request $request) {
        $action = new CreateNewUser();
        $action->create($request->all());

        return redirect()->route('register')->with('status', 'User berhasil dibuat.');
    });
});

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

    /*
    |--------------------------------------------------------------------------
    | Notification Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/json', [NotificationController::class, 'getNotificationsJson'])->name('notifications.getNotificationsJson');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadNotificationsCount']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');

 Route::get('/vendors/page', [VendorController::class, 'page'])->name('vendors.page'); // halaman blade
    Route::get('/vendors/{vendor}/show', [VendorController::class, 'show'])->name('vendors.show'); // untuk fetch edit modal (JSON)
    // Vendors CRUD
    Route::resource('vendors', VendorController::class)->parameters([
        'vendors' => 'vendor'
    ])->names([
        'index'  => 'vendors.index',
        'create' => 'vendors.create',
        'store'  => 'vendors.store',
        'show'   => 'vendors.show',
        'edit'   => 'vendors.edit',
        'update' => 'vendors.update',
        'destroy' => 'vendors.destroy',
    ]);
   
    /*
    |--------------------------------------------------------------------------
    | Work Request Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('work_request')->name('work_request.')->group(function () {

        Route::get('/datatable', [WorkRequestDataTableController::class, 'index'])->name('datatable');

        Route::get('/export/data', [WorkRequestController::class, 'export'])->name('export');

        Route::resource('/', WorkRequestController::class)->except(['show', 'edit'])->parameters(['' => 'id'])->names([
            'index' => 'index',
            'create' => 'create',
            'store' => 'store',
            'update' => 'update',
            'destroy' => 'destroy',
        ]);

        // Approval
        Route::put('/process/{id}', [WorkRequestController::class, 'processApproval'])->name('processApproval');
        Route::put('/revision/{id}', [WorkRequestController::class, 'processRevision'])->name('processRevision');
        Route::put('/{id}/rejected', [WorkRequestController::class, 'rejected'])->name('rejected');

        // Route Print PDF Form Request dan RAB
        Route::get('/{id}/print-form-request', [PDFController::class, 'generateRequest'])->name('print-form-request');;
        Route::get('/{id}/print-rab', [PDFController::class, 'generateRab'])->name('print-rab');;

        // Route Show
        Route::get('{id}/show/work_request_items', [WorkRequestController::class, 'show'])->name('work_request_items.show');
        Route::get('{id}/show/work_rabs', [WorkRequestRabController::class, 'show'])->name('work_rabs.show');
        Route::get('{id}/show/work_spesifications', [WorkRequestSpesificationController::class, 'show'])->name('work_spesifications.show');

        // Route Order Communication
        Route::get('{id}/show/order_communication', [OrderCommunicationController::class, 'index'])->name('order_communication.index');
        Route::post('order_communication', [OrderCommunicationController::class, 'store'])->name('order_communication.store');
        Route::post('order_communication/{id}/update-field', [OrderCommunicationController::class, 'update'])->name('order_communication.update-field');
        Route::post('order_communication/{id}/update-vendor', [OrderCommunicationController::class, 'updateVendorInfo'])->name('order_communication.update-vendor');
        Route::post('order_communication/{id}/upload', [OrderCommunicationController::class, 'upload'])->name('order_communication.upload');
        Route::delete('order_communication/{id}/delete-file', [OrderCommunicationController::class, 'deleteFile'])->name('order_communication.delete-file');
        Route::get('order_communication/{id}/view-file/{field}', [OrderCommunicationController::class, 'viewFile'])->name('order_communication.view-file');


        // Work Request Items
        Route::prefix('{id}/edit/work_request_items')->name('work_request_items.')->group(function () {
            Route::get('/', [WorkRequestItemController::class, 'edit'])->name('edit');
            // Route::get('/{work_request_item_id}', [WorkRequestItemController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestItemController::class, 'store'])->name('store');
            Route::put('/{work_request_item_id}/update', [WorkRequestItemController::class, 'update'])->name('update');
            Route::delete('/{work_request_item_id}', [WorkRequestItemController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('{id}/work_request_items')->name('work_request_items.')->group(function () {
            Route::get('/template', [WorkRequestItemController::class, 'downloadTemplate'])
                ->name('template');

            Route::post('/import', [WorkRequestItemController::class, 'importExcel'])
                ->name('import');
        });

        // Work Rabs Items
        Route::prefix('{id}/edit/work_rabs')->name('work_rabs.')->group(function () {
            Route::get('/', [WorkRequestRabController::class, 'edit'])->name('edit');
            // Route::get('/{work_rab_id}', [WorkRequestRabController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestRabController::class, 'store'])->name('store');
            Route::put('/{work_rab_id}/update', [WorkRequestRabController::class, 'update'])->name('update');
            Route::patch('/{work_rab_id}/update', [WorkRequestRabController::class, 'update'])->name('update.patch');

            Route::delete(
                '/{work_rab_id}',
                [WorkRequestRabController::class, 'destroy']
            )->name('destroy');
        });

        // Work spesification
        Route::prefix('{id}/edit/work_spesifications')->name('work_spesifications.')->group(function () {
            Route::get('/', [WorkRequestSpesificationController::class, 'edit'])->name('edit');
            // Route::get('/{work_spesification_id}', [WorkRequestSpesificationController::class, 'show'])->name('show');
            Route::post('/store', [WorkRequestSpesificationController::class, 'store'])->name('store');
            Route::put('/{work_spesification_id}/update', [WorkRequestSpesificationController::class, 'update'])->name('update');
            Route::delete('/{work_spesification_id}', [WorkRequestSpesificationController::class, 'destroy'])->name('destroy');
        });

        // Work spesification Files
        Route::post('{id}/spesification-files', [WorkRequestSpesificationFileController::class, 'store'])
            ->name('work_spesification_files.store');

        Route::delete('{id}/spesification-files/{file}', [WorkRequestSpesificationFileController::class, 'destroy'])
            ->name('work_spesification_files.destroy');

        Route::get('spesification-files/{file}', [WorkRequestSpesificationFileController::class, 'download'])
            ->name('work_spesification_files.download');


        Route::get('{workRequest}/vendors', [WorkRequestVendorController::class, 'index'])
            ->name('vendors.index');                // GET  /work_request/{workRequest}/vendors

        Route::post('{workRequest}/vendors/attach', [WorkRequestVendorController::class, 'attach'])
            ->name('vendors.attach');               // POST /work_request/{workRequest}/vendors/attach  { vendor_ids: [1,2] }

        Route::post('{workRequest}/vendors/detach', [WorkRequestVendorController::class, 'detach'])
            ->name('vendors.detach');               // POST /work_request/{workRequest}/vendors/detach  { vendor_ids: [1] }

        Route::post('{workRequest}/vendors/sync', [WorkRequestVendorController::class, 'sync'])
            ->name('vendors.sync');

        // Histories
        Route::prefix('histories')->name('histories.')->group(function () {
            Route::get('/', [HistoryController::class, 'index'])->name('index');
            Route::get('/{history_id}', [HistoryController::class, 'show'])->name('show');
            Route::post('/store', [HistoryController::class, 'store'])->name('store');
            Route::delete('/{history_id}', [HistoryController::class, 'destroy'])->name('destroy');
        });
    });

    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
