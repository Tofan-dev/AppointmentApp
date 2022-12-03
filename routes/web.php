<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// ALL APPOINTMENTS ROUTES


Route::group(['prefix' => 'appointments'], function(){
    Route::get('/', [AppointmentController::class, 'index']);
    Route::get('/create', [AppointmentController::class, 'create']);
    Route::post('/create', [AppointmentController::class, 'store']);
});