<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\processVipTearController;

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
    return view('index');
});

Route::post('/processVipTier', [ProcessVipTearController::class, 'processFromAjax']);
Route::post('/processVipTier2', [ProcessVipTearController::class, 'processFromAjax']);
