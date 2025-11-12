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
use App\ActivityItemResult;
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

// Undee Construction Page
Route::get('/under-construction', [HomeController::class, 'under'])->name('under');
//     ->name('jadwal.show');
// Lihat Detail Pengumuman
Route::get('/pengumuman/show/{title}', [AnnonController::class, 'show'])->name('announcements.show');

Route::get('/portal/inventory', [HomeController::class, 'inventory'])->name('inventory')->middleware('check.sup');
Route::get('/portal/inventory/data', [HomeController::class, 'getData'])->name('inventory.data');
Route::get('/portal/inventory/summary', [HomeController::class, 'getSummary'])->name('inventory.summary');
Route::get('/portal/inventory/chart', [HomeController::class, 'getChart'])->name('inventory.chart');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


// Route dengan auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', 'UserController');
    Route::get('/notifications', 'ActivityController@notifications')->name('notifications.index');

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
