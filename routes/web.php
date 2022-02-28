<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
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



Route::get('post', [PostController::class, 'index']);
Route::get('post/{slug?}', [PostController::class, 'show'])->name('post');
Route::post('like', [PostController::class, 'getlike']);
Route::post('like/{id}', [PostController::class, 'like']);
Route::post('dislike', [PostController::class, 'getDislike']);
Route::post('dislike/{id}', [PostController::class, 'dislike']);