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


// ALL APPOINTMENTS ROUTES

    Route::get('/', [AppointmentController::class, 'index']);
    
    Route::get('/create', function () {
        return view('appointmentCreate');
    });
    
    Route::post('/create', [AppointmentController::class, 'store'])->name("appointment.create");
    
    Route::get('/selectBy/{date}', [AppointmentController::class, 'getAppointmentsByDate']);

    Route::delete('/delete/{id}', [AppointmentController::class, 'destroy']);