<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group. No CSRF protection
| applies here, so it is safe to receive Paystack webhooks.
|
*/

// Paystack Webhook
Route::post('/paystack/webhook', [CartController::class, 'paystack_webhook'])->name('paystack.webhook');

// Optional: You can also expose a test route to check API connectivity
Route::get('/ping', function() {
    return response()->json(['status' => 'ok']);
});