<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServicePackController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\OrderController;
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
    return redirect('/login');
});
//Login
Route::get('/login',[LoginController::class,'viewLogin'])->name('login');
Route::post('/login',[LoginController::class,'postLogin'])->name('post.login');
//Sign Up
Route::get('/register',[LoginController::class,'viewRegister'])->name('register');
Route::post('/register',[LoginController::class,'postRegister'])->name('post.register');
//Logout
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::group(['middleware' => 'user'], function () {
    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::post('/dashboard',[AdminController::class,'index'])->name('admin.search');
    //notification
    Route::post('/markAsRead',[NotificationController::class,'markAsRead'])->name('notification.markAsRead');
    Route::post('/markAllAsRead',[NotificationController::class,'markAllAsRead'])->name('notification.markAllAsRead');
    Route::get('/notifications',[NotificationController::class,'loadNotify'])->name('notification.loadNotify');
    //users
    Route::get('/users/create',[UserController::class,'create'])->name('users.create');
    Route::post('/users/store',[UserController::class,'store'])->name('users.store');
    Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
    Route::post('/users/update',[UserController::class,'update'])->name('users.update');
    Route::get('/users/destroy/{id}',[UserController::class,'destroy'])->name('users.destroy');
    Route::get('/users',[UserController::class,'index'])->name('users.index');
    //category
    Route::get('/categories/create',[CategoriesController::class,'create'])->name('categories.create');
    Route::post('/categories/store',[CategoriesController::class,'store'])->name('categories.store');
    Route::get('/categories/{id}/edit',[CategoriesController::class,'edit'])->name('categories.edit');
    Route::post('/categories/update',[CategoriesController::class,'update'])->name('categories.update');
    Route::get('/categories/destroy/{id}',[CategoriesController::class,'destroy'])->name('categories.destroy');
    Route::get('/categories',[CategoriesController::class,'index'])->name('categories.index');
    //service
    Route::get('/services/create',[ServiceController::class,'create'])->name('services.create');
    Route::post('/services/store',[ServiceController::class,'store'])->name('services.store');
    Route::get('/services/show',[ServiceController::class,'show'])->name('services.show');
    Route::get('/services/{id}/edit',[ServiceController::class,'edit'])->name('services.edit');
    Route::post('/services/update',[ServiceController::class,'update'])->name('services.update');
    Route::get('/services/destroy/{id}',[ServiceController::class,'destroy'])->name('services.destroy');
    Route::get('/services',[ServiceController::class,'index'])->name('services.index');
    //service pack
    Route::post('/service-pack/update-form',[ServicePackController::class,'updateForm'])->name('service_pack.update_form');
    Route::get('/service-pack/create',[ServicePackController::class,'create'])->name('service_pack.create');
    Route::post('/service-pack/store',[ServicePackController::class,'store'])->name('service_pack.store');
    Route::get('/service-pack/{id}/edit',[ServicePackController::class,'edit'])->name('service_pack.edit');
    Route::post('/service-pack/update',[ServicePackController::class,'update'])->name('service_pack.update');
    Route::get('/service-pack/destroy/{id}',[ServicePackController::class,'destroy'])->name('service_pack.destroy');
    Route::get('/service-pack',[ServicePackController::class,'index'])->name('service_pack.index');
    //recharge history
    Route::get('/recharges-history',[AdminController::class,'getRechargeHistory'])->name('recharges.history');
    //order history
    Route::get('/view-status/{id}',[AdminController::class,'viewStatus'])->name('view.status');
    Route::post('/update-status/{id}',[AdminController::class,'updateStatus'])->name('update.status');
    Route::get('/order-history',[AdminController::class,'history'])->name('order.history');
    // banks
    Route::resource('banks', BanksController::class);
    // setting
    Route::post('/settings/update-contact/{id}',[SettingController::class,'updateContact'])->name('settings.update_contact');
    Route::resource('settings', SettingController::class);
});

Route::group(['middleware' => 'login'], function () {
    //user info
    Route::get('/user-dashboard',[UserController::class,'userDashboard'])->name('user.dashboard');
    Route::get('/info',[UserController::class,'info'])->name('info');
    Route::post('/info-update/{id}',[UserController::class,'updateInfo'])->name('info.update');
    Route::get('/amount',[UserController::class,'getAmount'])->name('amount');
    //recharge
    Route::get('/recharge',[UserController::class,'recharge'])->name('recharge');
    Route::get('/recharge-history',[UserController::class,'getRechargeHistory'])->name('recharge.history');
    //order history
    Route::get('/order-show',[OrderController::class,'historyShow'])->name('order.show');
    Route::get('/user-order-history',[UserController::class,'history'])->name('user.order.history');
    // order
    Route::get('/service/{slug}',[OrderController::class,'getService'])->name('order.get-service');
    Route::get('/service-pack/{id}',[OrderController::class,'getServicePack'])->name('order.get-service-pack');
    Route::post('/service/{service_id}/order',[OrderController::class,'order'])->name('order.order-service-pack');
    // contacts
    Route::get('/contacts',[UserController::class,'contacts'])->name('contacts');
     //transaction history
     Route::get('/transaction-history',[UserController::class,'getTransactionHistory'])->name('transaction.history');
});

//transaction
Route::post('handler-bank-transfer',[FrontendController::class,'transtionInfo'])->name('transtion.info');

Route::get('/delete-transtion',[FrontendController::class,'deleteTranstion']);

Route::get('/delete-servicebill',[FrontendController::class,'deleteServiceBills']);
