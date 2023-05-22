<?php

use App\Http\Controllers\InfRecordApointmentController;
use App\Http\Controllers\RecordApointmentController;
use App\Http\Controllers\ServiceScheduleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
    return ServiceScheduleController::showDay($request);
});
Route::post('/', function (Request $request) {
    return ServiceScheduleController::getRecordFio($request);
})->name('schedule');

Route::get('/record_appointment', function (Request $request) {
    return RecordApointmentController::showView($request);
});
Route::post('/record_appointment', function (Request $request) {
    if ($request->input('new') == 'add') {
        return RecordApointmentController::addRecord($request);
    } elseif ($request->input('new') == 'add_car') {
        return RecordApointmentController::addWithNewCar($request);
    } else {
        return RecordApointmentController::newClientAndCar($request);
    }

})->name('add_record_post');

Route::get('/more_inf_record', function (Request $request) {
    return InfRecordApointmentController::showView($request);
});
Route::post('/more_inf_record', function (Request $request) {
    return InfRecordApointmentController::setStatus($request);
})->name('more_inf_record_post');
