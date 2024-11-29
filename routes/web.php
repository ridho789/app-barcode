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
use App\Http\Controllers\MarkingController;

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

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

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

	// Marking
	Route::get('markings', [MarkingController::class, 'index']);
	Route::get('create_marking', [MarkingController::class, 'create'])->name('Create Marking');
	Route::post('marking-store', [MarkingController::class, 'store']);
	Route::get('edit_marking/{id}', [MarkingController::class, 'edit'])->name('Edit Marking');
	Route::post('marking-update', [MarkingController::class, 'update']);
	Route::get('delete_marking/{id}', [MarkingController::class, 'delete']);
	Route::get('/print-marking-details/{id}', [MarkingController::class, 'print']);
	Route::get('/delete-marking-detail/{id}', [MarkingController::class, 'deleteDetail']);
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