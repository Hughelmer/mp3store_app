<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongCodeController;
use App\Http\Controllers\AdminController;

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

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/createAlbum', [AdminController::class, 'createAlbum'])->name('admin.createAlbum');
    Route::get('/admin/createSong', [AdminController::class, 'createSong'])->name('admin.createSong');
    Route::post('/admin/createAlbum', [AdminController::class, 'createAlbum'])->name('admin.createAlbum');
    Route::post('/admin/createSong', [AdminController::class, 'createSong'])->name('admin.createSong');
});

//Album routes
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');

// Route to view a list of songs from an album
Route::get('albums/{album}/songs', [AlbumController::class, 'viewSongs'])->name('albums.songs');


//Song routes
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('song.show');

// Route to view a single song
Route::get('songs/{song}', [SongController::class, 'viewSong'])->name('songs.view');

//Artist routes
Route::get('/artists', [ArtistController::class, 'index'])->name('artist.index');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artist.show');

//SongCode routes
Route::get('/song-codes', [SongCodeController::class, 'index'])->name('song-code.index');
Route::get('/song-codes/{id}', [SongCodeController::class, 'show'])->name('song-code.show');

// Cart routes
Route::get('/cart', 'CartController@index')->name('cart');
Route::get('/checkout', 'CheckoutController@index')->name('checkout');

