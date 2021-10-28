<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\FilesController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
 * Clients management
 * */
Route::prefix('/clients')->group(function () {
    Route::get('/', [ClientsController::class, 'index']);
    Route::get('/{client}', [ClientsController::class, 'show']);
    Route::post('/store', [ClientsController::class, 'store']);
    Route::patch('/{client}', [ClientsController::class, 'update']);
    Route::post('/destroy', [ClientsController::class, 'destroyMass']);
    Route::delete('/{client}/destroy', [ClientsController::class, 'destroy']);
});

/*
 * Current user
 * */
Route::prefix('/user')->group(function () {
    Route::get('/', [CurrentUserController::class, 'show']);
    Route::patch('/', [CurrentUserController::class, 'update']);
    Route::patch('/password', [CurrentUserController::class, 'updatePassword']);
});

/*
 * File upload (e.g. avatar)
 * */
Route::post('/files/store', [FilesController::class, 'store']);
