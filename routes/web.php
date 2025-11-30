<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CekLogin;
use App\Http\Middleware\CekLogout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
})->name('home')->middleware(CekLogin::class);


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware(CekLogout::class);;
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register')->middleware(CekLogout::class);;
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard')->middleware(CekLogin::class);;

Route::get('/order', [OrderController::class, 'showOrder'])->name('order')->middleware(CekLogin::class);;
Route::post('/orders', [OrderController::class, 'create'])->name('orders.create');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

Route::get('/admin', [AdminController::class, 'showAdmin'])->name('admin')->middleware(CekLogin::class);;
Route::put('/admin/{id}', [AdminController::class, 'assign'])->name('orders.assign')->middleware(CekLogin::class);;

Route::get('/operator', [OperatorController::class, 'showOperator'])->name('operator')->middleware(CekLogin::class);;
Route::put('/operator/{id}/start', [OperatorController::class, 'start'])->name('operator.start');
Route::put('/operator/{id}/finish', [OperatorController::class, 'finish'])->name('operator.finish');


Route::post('/admin/payment/{id}', [AdminController::class, 'payments'])->name('admin.payments');
Route::post('/admin/order/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.order.updateStatus');
Route::delete('/admin/order/payment/delete/{id}', [AdminController::class, 'deletePayment'])
    ->name('admin.order.deletePayment');

Route::post('/admin/order/{id}/upload-payment-proof', [AdminController::class, 'uploadPaymentProof'])
    ->name('admin.order.uploadPaymentProof');

Route::get('/payment-proof/{filename}', function ($filename) {
    $path = 'C:/document_laundry/' . $filename;
    if (!file_exists($path)) abort(404);
    return response()->file($path);
})->name('payment.proof');



Route::get('/customer', function () {
    return view('others.customer');
})->name('customer')->middleware(CekLogin::class);;

Route::get('/reports', function () {
    return view('others.report');
})->name('reports')->middleware(CekLogin::class);;

Route::get('/settings', function () {
    return view('others.settings');
})->name('settings')->middleware(CekLogin::class);;

Route::get('/payement', function () {
    return view('others.pembayaran');
})->name('payment')->middleware(CekLogin::class);;

Route::get('/customer-support', function () {
    return view('others.bantuanpelanggan');
})->name('customer-support')->middleware(CekLogin::class);;

// Route::get('/task-history', function () {
//     return view('others.task-history');
// })->name('task-history')->middleware(CekLogin::class);;


Route::get('/task-history', [OperatorController::class, 'historyTask'])->name('task-history')->middleware(CekLogin::class);;
