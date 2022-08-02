<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Post;
use Inertia\Inertia;
use App\Http\Controllers\AttendanceSystemController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::resource('attendance', AttendanceSystemController::class);
    Route::post('attendance/punchin', 'App\Http\Controllers\AttendanceSystemController@punchIn')->name('attendance/punchin');
    Route::post('attendance/punchout', 'App\Http\Controllers\AttendanceSystemController@punchOut')->name('attendance/punchout');
    Route::post('attendance/sickleave', 'App\Http\Controllers\AttendanceSystemController@sickLeave')->name('attendance/sickleave');
});
