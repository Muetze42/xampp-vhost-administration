<?php

use App\Helpers\Process;
use App\Http\Controllers\AppController;
use App\Http\Controllers\PhpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;

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

Route::resource('hosts', HostController::class)->except(['show']);
Route::resource('apps', AppController::class)->only(['create', 'store']);
Route::resource('php', PhpController::class)->only(['index', 'edit', 'update']);

Route::post('update/hosts', [HostController::class, 'updateHostFile'])->name('update.hosts');
Route::post('update/vhosts', [HostController::class, 'updateVHostConf'])->name('update.vhosts');
