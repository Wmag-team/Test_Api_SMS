<?php
use App\Http\Controllers\ApiProxyController;
use Illuminate\Support\Facades\Route;

Route::get('/getNumber', [ApiProxyController::class, 'getNumber']);
Route::get('/getSms', [ApiProxyController::class, 'getSms']);
Route::get('/cancelNumber', [ApiProxyController::class, 'cancelNumber']);
Route::get('/getStatus', [ApiProxyController::class, 'getStatus']);
