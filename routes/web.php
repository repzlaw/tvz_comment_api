<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FailedAccessController;
use App\Http\Controllers\SettingsController;

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
})->middleware('auth');

//settings route
Route::prefix('/settings')->name('setting.')->middleware(['auth'])->group(function(){
    Route::get('/', [SettingsController::class, 'index'])->name('all');
    Route::get('/ip-address', [SettingsController::class, 'ipAddress'])->name('ip.all');
    Route::post('/ip-address/create', [SettingsController::class, 'createIp'])->name('ip.create');
    Route::post('/ip-address/edit', [SettingsController::class, 'editIp'])->name('ip.edit');
    Route::post('/security', [SettingsController::class, 'security'])->name('security');
    Route::post('/api_key/generate', [SettingsController::class, 'generateAPIKey'])->name('api_key.generate');
    Route::get('/failed-access', [FailedAccessController::class, 'index'])->name('failed.all');

});

// Route::get('/comment',[CommentsController::class,'index']);
