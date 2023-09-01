<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongCodeController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Album routes
Route::get('/albums', [AlbumController::class, 'index'])->name('albums');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');

//Song routes
Route::get('/songs', [SongController::class, 'index'])->name('song.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('song.show');

//Artist routes
Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artist.show');

//SongCode routes
Route::get('/song-codes', [SongCodeController::class, 'index'])->name('song-code.index');
Route::get('/song-codes/{id}', [SongCodeController::class, 'show'])->name('song-code.show');

// Cart routes
Route::get('/cart', 'CartController@index')->name('cart');
Route::get('/checkout', 'CheckoutController@index')->name('checkout');

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    // Add more admin routes as needed
});