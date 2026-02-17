<?php

use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\JobcardController;
use App\Http\Controllers\AnnonController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ValveController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\CalibrationHistoryController;
use App\Http\Controllers\ToolController;
use App\ActivityItemResult;
use App\Http\Controllers\DashboardDocController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FolderDocController;
use App\Http\Controllers\HomeDocController;
use App\Http\Controllers\KalibrasiDashboardController;
use App\Http\Controllers\ProjectDocController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route tanpa auth
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/schedule', [HomeController::class, 'jadwal'])->name('jadwal');
Route::post('/schedule/result', [HomeController::class, 'storeOrUpdateResult'])->name('jadwal.store');
// Route::get('/schedule/result/{id}', [HomeController::class, 'showResult'])
Route::post('/telegram/webhook', [TelegramController::class, 'handle']);
// Tracking
Route::get('tracking', 'TrackingController@index')->name('tracking.index')->middleware('check.sup');
Route::get('tracking/search', 'TrackingController@ajaxSearch')->name('tracking.ajax.search');
Route::get('tracking/{jobcard}/history', 'TrackingController@ajaxHistory')->name('tracking.ajax.history');
// Kalibrasi Scan
Route::get('/scan/{token}', [ToolController::class, 'scan'])->name('tools.scan');

// Dokumen Control
// PROJECT
// =======================
Route::get('/portal/document', [HomeDocController::class, 'index'])
    ->name('document');
Route::get('/portal/document/preview/{document}', [HomeDocController::class, 'preview'])
    ->name('document.preview');

// =======================
// FOLDER PER PROJECT
// =======================
Route::get('/portal/document/{project}', [HomeDocController::class, 'folders'])
    ->name('document.folder');

Route::get('/portal/document/{project}', [HomeDocController::class, 'folders'])
    ->name('document.folder');

// =======================
// DOCUMENT LIST PER FOLDER
// /portal/document/{project}/folder/{folder}
// =======================
Route::get('/portal/document/{project}/folder/{folder}', [HomeDocController::class, 'documents'])
    ->name('document.list');

// =======================
// INITIAL UPLOAD / STORE DOCUMENT
// POST /portal/document/{project}/folder/{folder}
// =======================
Route::post('/portal/document/{project}/folder/{folder}', [HomeDocController::class, 'store'])
    ->name('document.store');

// =======================
// UPDATE FILE (OVERWRITE)
// PUT /portal/document/{document}
// =======================
Route::put('/portal/document/{document}', [HomeDocController::class, 'update'])
    ->name('document.update');

// =======================
// SHOW DOCUMENT + HISTORY
// /portal/document/show/{document}
// =======================
Route::get('/portal/document/show/{document}', [HomeDocController::class, 'show'])
    ->name('document.show');

// Destroy
Route::delete('/portal/documents/delete/{document}', [HomeDocController::class, 'destroy'])
    ->name('documents.destroy');

Route::get('/portal/documents/{document}/stats', [HomeDocController::class, 'downloadStats'])->name('document.stats');
Route::get('/portal/documents/{document}/history', [HomeDocController::class, 'history'])->name('document.history');

// =======================
// DOWNLOAD FILE
// /portal/document/download/{document}
// =======================
Route::get('/portal/document/download/{document}', [HomeDocController::class, 'download'])
    ->name('portal.document.download');

// =======================
// DOWNLOAD ALL FILES DI FOLDER
// /portal/document/download-all/{project}/folder/{folder}
// =======================
Route::get('/portal/document/download-all/{project}/folder/{folder}', [HomeDocController::class, 'downloadAll'])
    ->name('portal.document.download.all');

// Undee Construction Page
Route::get('/under-construction', [HomeController::class, 'under'])->name('under');
//     ->name('jadwal.show');
// Lihat Detail Pengumuman
Route::get('/pengumuman/show/{title}', [AnnonController::class, 'show'])->name('announcements.show');

// kalibrasi
Route::get('/kalibrasi', [HomeController::class, 'kalibrasi'])->name('kalibrasi');

Route::get('/portal/inventory', [HomeController::class, 'inventory'])->name('inventory');
Route::get('/portal/inventory/data', [HomeController::class, 'getData'])->name('inventory.data');
Route::get('/portal/inventory/summary', [HomeController::class, 'getSummary'])->name('inventory.summary');
Route::get('/portal/inventory/chart', [HomeController::class, 'getChart'])->name('inventory.chart');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/notifications', 'ActivityController@notifications')->name('notifications.index');



// Route dengan auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', 'UserController');

    Route::resource('modules', 'AccessController');
    Route::get('/access/user', [AccessController::class, 'userAccess'])->name('access.user');
    Route::post('/access/user/update', [AccessController::class, 'updateUserAccess'])->name('access.user.update');
});


Route::middleware(['auth', 'module.access:announcement'])->group(function () {
    Route::resource('announcements', 'AnnonController')->except(['show']);
});

Route::middleware(['auth', 'module.access:activities'])->group(function () {
    Route::resource('activities', 'ActivityController');
});

Route::middleware(['auth', 'module.access:inventory'])->group(function () {
    // Inventory
    // Master Data : Valve
    Route::resource('valves', 'ValveController');
    // Master Date : Spare Part
    Route::resource('spare-parts', 'SparePartController');
    // Master Data : Rack
    Route::resource('racks', 'RackController');
    // Dashboard
    Route::get('inventory', 'InventoryController@index')->name('inventory.index');
    // Material
    Route::resource('materials', 'MaterialController');
    // Material In
    Route::resource('material_in', 'MaterialInController');
    // Material Out
    Route::resource('material_out', 'MaterialOutController');
    // Stock Card
    Route::get('stock-card', 'StockCardController@index')->name('stock-card.index');
    // Stock Opname
    Route::resource('stock-opname', 'StockOpnameController');
    // Adjustment
    Route::post('stock-opname/{id}/adjust', 'StockOpnameController@adjust')->name('stock-opname.adjust');
    // Report
    Route::get('/report/stock-summary', 'InventoryController@stockSummary')->name('report.stock-summary');
    Route::get('/report/stock-summary/pdf', 'InventoryController@reportPdf')->name('stock-summary.pdf');
    Route::get('/report/stock-summary/excel', 'InventoryController@reportExcel')->name('stock-summary.excel');
});

Route::middleware(['auth', 'module.access:production'])->group(function () {
    Route::get('jobcards', 'JobcardController@index')->name('jobcards.index');
    Route::get('jobcards/create', 'JobcardController@create')->name('jobcards.create');
    Route::post('jobcards', 'JobcardController@store')->name('jobcards.store');
    Route::get('jobcards/{jobcard}/edit', 'JobcardController@edit')->name('jobcards.edit');
    Route::put('jobcards/{jobcard}', 'JobcardController@update')->name('jobcards.update');
    Route::delete('jobcards/{jobcard}', 'JobcardController@destroy')->name('jobcards.destroy');

    Route::get('jobcards/{jobcard}', 'JobcardController@show')->name('jobcards.show');

    // QR Code
    Route::get('jobcards/{jobcard}/qr', 'JobcardController@qr')->name('jobcards.qr');

    // Test insert history tanpa scan
    Route::get('jobcards/{jobcard}/test-history', 'JobcardController@testHistory')->name('jobcards.testHistory');

    Route::get('jobcards/{jobcard}/scan-success/{action}', 'JobcardController@scanSuccess')
        ->name('jobcards.scan.success');

    // routes/web.php
    Route::get('jobcards/{id}/print', 'JobcardController@print')->name('jobcards.print');
    Route::get('jobcards/export/pdf', 'JobcardController@exportPdf')->name('jobcards.export.pdf');
    Route::get('/jobcard/public/{id}', [JobcardController::class, 'publicShow'])->name('jobcards.public.show');


    // Form scan
    Route::get('jobcards/{jobcard}/scan', [
        'uses' => 'JobcardController@scanForm',
        'as'   => 'jobcards.scan.form'
    ])->middleware('admin.only');
    // Submit scan
    Route::post('jobcards/{jobcard}/scan', [
        'uses' => 'JobcardController@scan',
        'as'   => 'jobcards.scan'
    ]);
});

Route::get('/kalibrasi/dashboard', [KalibrasiDashboardController::class, 'index'])
    ->name('kalibrasi.dashboard');


// ---- ROUTE TOOLS (tanpa prefix histories) ---
Route::middleware(['auth', 'module.access:kalibrasi'])
    ->group(function () {
        Route::get('tools/print', [ToolController::class, 'printAll'])->name('tools.printAll');
        Route::resource('tools', 'ToolController');
        Route::post('tools/{tool}/regenerate-qr', [ToolController::class, 'regenerateQr'])
            ->name('tools.regenerateQr');
    });

// ---- ROUTE HISTORY (prefix histories) ----
Route::middleware(['auth', 'module.access:kalibrasi'])
    ->prefix('histories')
    ->name('histories.')
    ->group(function () {
        Route::get('/', [CalibrationHistoryController::class, 'index'])->name('index');
        Route::get('/create', [CalibrationHistoryController::class, 'create'])->name('create');
        Route::get('/{tool_id}', [CalibrationHistoryController::class, 'show'])->name('show'); // <-- ini
        Route::post('/', [CalibrationHistoryController::class, 'store'])->name('store');
        Route::get('/{history}/edit', [CalibrationHistoryController::class, 'edit'])->name('edit');
        Route::put('/{history}', [CalibrationHistoryController::class, 'update'])->name('update');
        Route::delete('/{history}', [CalibrationHistoryController::class, 'destroy'])->name('destroy');
        Route::get('/{history}/download', [CalibrationHistoryController::class, 'downloadCertificate'])->name('download');
    });


//  --- Route For Document Transmittal/Control ---

Route::middleware(['auth', 'module.access:document'])
    ->prefix('document')
    ->name('document.')
    ->group(function () {
        Route::get('/document/dashboad', [DashboardDocController::class, 'index'])->name('index');
        // Project
        Route::get('/document/project', [ProjectDocController::class, 'index'])->name('project.index');
        Route::get('/document/project/create', [ProjectDocController::class, 'create'])->name('project.create');
        Route::post('/document/project/store', [ProjectDocController::class, 'store'])->name('project.store');
        Route::get('/document/project/{project}/edit', [ProjectDocController::class, 'edit'])->name('project.edit');
        Route::put('/document/project/{project}', [ProjectDocController::class, 'update'])->name('project.update');
        // Folder

        Route::get('/folders', [FolderDocController::class, 'index'])
            ->name('folders.index');

        // ⬇️ TAMBAHKAN project DI SINI
        Route::get('/folders/create/{project}', [FolderDocController::class, 'create'])
            ->name('folders.create');

        Route::post('/folders/{project}', [FolderDocController::class, 'store'])
            ->name('folders.store');

        Route::get('/folders/{folder}/edit', [FolderDocController::class, 'edit'])
            ->name('folders.edit');

        Route::put('/folders/{folder}', [FolderDocController::class, 'update'])
            ->name('folders.update');

        Route::delete('/folders/{folder}', [FolderDocController::class, 'destroy'])
            ->name('folders.destroy');
        // // Document

        // Route::get('/document/{project}', [DocumentController::class, 'index'])
        //     ->name('index');

        // Route::get('/document/{project}/create', [DocumentController::class, 'create'])
        //     ->name('create');

        // Route::post('/document/store', [DocumentController::class, 'store'])
        //     ->name('store');

        // Route::get('/document/detail/{document}', [DocumentController::class, 'show'])
        //     ->name('show');

        // Route::put('/document/{document}', [DocumentController::class, 'update'])
        //     ->name('update');

        // Route::patch('/document/{document}/final', [DocumentController::class, 'setFinal'])
        //     ->name('final');

        // Route::delete('/document/{document}', [DocumentController::class, 'destroy'])
        //     ->name('destroy');
    });
