<?php

use App\Http\Controllers\Api\MessagingApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['messagingApiSignatureVerification'])->post('/messagingApi', [MessagingApiController::class, 'webhook']);
