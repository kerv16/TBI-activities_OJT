<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/events', [PostController::class, 'index'])->name('posts.index');
    Route::get('/events/{year?}', [PostController::class, 'index'])->name('posts.index.year');
    Route::get('/report', [PostController::class, 'report'])->name('posts.report');
    Route::get('/events/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
