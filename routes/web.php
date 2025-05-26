<?php

use Illuminate\Support\Facades\Route;
use Botble\EmailOrder\Http\Controllers\OrderEmailController;

// Define routes for the EmailOrder plugin here 

Route::group(['prefix' => 'admin/email-order', 'as' => 'admin.email-order.', 'middleware' => ['web', 'auth']], function () {
    Route::post('order/{order}/send-or-save', [OrderEmailController::class, 'sendOrSave'])->name('order.send_or_save');
    Route::get('order/{order}/latest', [OrderEmailController::class, 'latest'])->name('order.latest');
}); 