<?php

use GmailLogo\Font;
use GmailLogo\Generator;
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

Route::get('/', [\App\Http\Controllers\IndexController::class, 'index']);
Route::get('/installation', [\App\Http\Controllers\InstallationController::class, 'index']);
Route::get('/usage', [\App\Http\Controllers\UsageController::class, 'index']);
Route::get('/examples', [\App\Http\Controllers\ExamplesController::class, 'index']);
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index']);
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'post']);
Route::get('/thank-you', [\App\Http\Controllers\ContactController::class, 'thankYou']);

