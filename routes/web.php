<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProspectController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CollectionController;

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

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return view('admin.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login-user');

Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('auth.dashboard.index');
    })->name('dashboard');

    Route::resource('users', UserController::class);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //role & permission
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);

    //Attendence
    Route::resource('attendance', AttendanceController::class);

    //Prospect
    Route::resource('prospect', ProspectController::class);

    //Quotation
    Route::resource('quotation', QuotationController::class);

    //Supplier
    Route::resource('supplier', SupplierController::class);

    //Lead
    Route::resource('lead', LeadController::class);

    //Followup
    Route::resource('followup', FollowupController::class);

    //SMS
    Route::resource('sms', SMSController::class);

    //Collection
    Route::resource('collection', CollectionController::class);

     //Task
     Route::resource('task', TaskController::class);

    //Order
    Route::resource('order', OrderController::class);

});

Route::get('theme_mode', function (Request $request) {
    $request->session()->put('theme', $request->theme);
    return back();
})->name('theme.update');
