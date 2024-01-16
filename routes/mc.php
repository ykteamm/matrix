<?php

use App\Http\Middleware\LoginAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewOrderController;

Route::middleware([LoginAuth::class])->group(function () {

    Route::get('new-order', [NewOrderController::class, 'index'])->name('new-order.index');


});
