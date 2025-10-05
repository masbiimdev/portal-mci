<?php

use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route tanpa auth
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/schedule', [HomeController::class, 'jadwal'])->name('jadwal');

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
// Logout
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


// Route dengan auth
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('activities', 'ActivityController');
    Route::resource('users', 'UserController');
    Route::get('/notifications', 'ActivityController@notifications')->name('notifications.index');


    Route::get('jobcards', 'JobcardController@index')->name('jobcards.index');
    Route::get('jobcards/create', 'JobcardController@create')->name('jobcards.create');
    Route::post('jobcards', 'JobcardController@store')->name('jobcards.store');
    Route::get('jobcards/{jobcard}/edit', 'JobcardController@edit')->name('jobcards.edit');
    Route::put('jobcards/{jobcard}', 'JobcardController@update')->name('jobcards.update');
    Route::delete('jobcards/{jobcard}', 'JobcardController@destroy')->name('jobcards.destroy');

    Route::get('jobcards/{jobcard}', 'JobcardController@show')->name('jobcards.show');

    // Form scan
    Route::get('jobcards/{jobcard}/scan', [
        'uses' => 'JobcardController@scanForm',
        'as'   => 'jobcards.scan.form'
    ]);

    // Submit scan
    Route::post('jobcards/{jobcard}/scan', [
        'uses' => 'JobcardController@scan',
        'as'   => 'jobcards.scan'
    ]);


    // QR Code
    Route::get('jobcards/{jobcard}/qr', 'JobcardController@qr')->name('jobcards.qr');

    // Test insert history tanpa scan
    Route::get('jobcards/{jobcard}/test-history', 'JobcardController@testHistory')->name('jobcards.testHistory');

    Route::get('jobcards/{jobcard}/scan-success/{action}', 'JobcardController@scanSuccess')
        ->name('jobcards.scan.success');

    // Tracking
    Route::get('tracking', 'TrackingController@index')->name('tracking.index');
    Route::get('tracking/search', 'TrackingController@ajaxSearch')->name('tracking.ajax.search');
    Route::get('tracking/{jobcard}/history', 'TrackingController@ajaxHistory')->name('tracking.ajax.history');
});
