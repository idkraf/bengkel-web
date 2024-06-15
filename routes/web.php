<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\VerificationController;
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
Auth::routes();
// Login and Logout Routes...
// Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [LoginController::class,'login']);
// Route::post('logout',  [LoginController::class,'logout'])->name('logout');

// // Registration Routes...
// Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('register', [RegisterController::class, 'register']);

// // Password Reset Routes...
// Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

// // Confirm Password 
// Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
// Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

// // Email Verification Routes...
// Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
// Route::get('email/resend',  [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::get('home', function () {return view('dashboard.homepage');});
    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::resource('group', 'GroupController');
    Route::post('users/block/{id}', 'UsersController@block')->name(
        'users.block'
    );
    Route::put('users/update/{id}', 'UsersController@update')->name(
        'users_update'
    );
    Route::get('block-users', 'UsersController@blockUser')->name('block-users');
    Route::get('group-users', 'GroupController@index')->name('group-users');
    Route::post('group/destroy/{id}', 'GroupController@destroy')->name('group-destroy');
    Route::post('group/memberDestroy/{id}', 'GroupController@memberDestroy')->name('group-memberDestroy');
    
    Route::get('admob-list', 'SettingController@admobList')->name('admob-list');
    
    Route::get('status_on_off_ajax', 'SettingController@status_on_off_ajax');
    
    Route::get('admob-list/edit', 'SettingController@edit');
    Route::get('admob-list/update', 'SettingController@update');
    
    Route::get('setting', 'SettingController@setting')->name('setting');
    
    Route::get('notification', 'NotificationController@index')->name(
        'notification'
    );
    Route::post('add-notification', 'NotificationController@store')->name(
        'add-notification'
    );
    Route::post('notification/destroy/{id}', 'NotificationController@destroy')->name(
        'notification-destroy'
    );
    
    Route::post('setting-update', 'SettingController@setting_update')->name(
        'setting-update'
    );
    
    
});

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
