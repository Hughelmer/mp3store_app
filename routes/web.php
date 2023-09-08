<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongCodeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

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
    Route::get('/admin/createArtist', [AdminController::class, 'createArtist'])->name('admin.createArtist');
    Route::post('/admin/createArtist', [AdminController::class, 'createArtist'])->name('admin.createArtist');
    Route::post('/admin/storeArtist', [AdminController::class, 'storeArtist'])->name('admin.storeArtist');
});

//Album routes
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
Route::get('albums/{album}/songs', [AlbumController::class, 'viewSongs'])->name('albums.songs');

// Song routes
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('song.show');
Route::get('songs/{song}', [SongController::class, 'viewSong'])->name('songs.view');


// Cart routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{song}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/cart/checkout', [CheckoutController::class, 'index'])->name('cart.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Show the order details
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // Store a new order
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

