<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\OriginController;
use App\Http\Controllers\ShippersController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarkingController;
use App\Http\Controllers\TrackingController;

use App\Http\Controllers\ModBusController;
use App\Http\Controllers\ScaleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');

	// Customer
	Route::get('customers', [CustomersController::class, 'index']);
	Route::post('customer-store', [CustomersController::class, 'store']);
	Route::post('customer-update', [CustomersController::class, 'update']);

	// Origin
	Route::get('origins', [OriginController::class, 'index']);
	Route::post('origin-store', [OriginController::class, 'store']);
	Route::post('origin-update', [OriginController::class, 'update']);

	// Shipper
	Route::get('shippers', [ShippersController::class, 'index']);
	Route::post('shipper-store', [ShippersController::class, 'store']);
	Route::post('shipper-update', [ShippersController::class, 'update']);

	// Unit
	Route::get('units', [UnitController::class, 'index']);
	Route::post('unit-store', [UnitController::class, 'store']);
	Route::post('unit-update', [UnitController::class, 'update']);

	// User
	Route::get('users', [UserController::class, 'index']);
	Route::post('user-store', [UserController::class, 'store']);
	Route::post('user-update', [UserController::class, 'update']);

	// Marking
	Route::get('markings', [MarkingController::class, 'index']);
	Route::get('create_marking', [MarkingController::class, 'create'])->name('Create Marking');
	Route::post('marking-store', [MarkingController::class, 'store']);
	Route::get('edit_marking/{id}', [MarkingController::class, 'edit'])->name('Edit Marking');
	Route::post('marking-update', [MarkingController::class, 'update']);
	Route::get('delete_marking/{id}', [MarkingController::class, 'delete']);
	Route::get('/print-marking/{id}', [MarkingController::class, 'print']);
	Route::get('/delete-marking-detail/{id}', [MarkingController::class, 'deleteDetail']);

	//Tracking
	Route::get('trackings', [TrackingController::class, 'index']);
	Route::post('tracking-in', [TrackingController::class, 'in']);
	Route::post('tracking-out', [TrackingController::class, 'out']);

	// Modbus
	// Route::get('modbus', [ModBusController::class, 'index']);
	// Route::get('/modbus', [ModBusController::class, 'showForm'])->name('modbus.form');
	// Route::post('/modbus/read', [ModBusController::class, 'readData'])->name('modbus.read');
	// Route::get('/debug-com-ports', [ModBusController::class, 'debugComPorts']);

	// Scale
	Route::get('scale', [ScaleController::class, 'index']);
	Route::post('scale-read', [ScaleController::class, 'read']);
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');