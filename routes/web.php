<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SongController;

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

Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');

Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/{id}', [SongController::class, 'show'])->name('song.show');
Route::get('songs/{song}', [SongController::class, 'viewSong'])->name('songs.view');

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

Route::middleware(['auth'])->group(function () {
    Route::get('/audio/{filename}', function ($filename) {
        $filePath = 'public/audio/songs/' . $filename;
        
        if (Storage::exists($filePath)) {
            return Storage::response($filePath);
        }

        abort(404);
    })->name('audio.file');

    Route::delete('/albums/{album}', [AlbumController::class, 'destroy'])->name('albums.destroy');
    Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('song.destroy');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/place-order', [CheckoutController::class, 'placeOrder'])->name('cart.place-order');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('/albums/{id}/download', [AlbumController::class, 'download'])->name('albums.download');
    Route::get('/orders/download/song/{song}', [OrderController::class, 'downloadSong'])->name('download.song');
    Route::get('/orders/download/album/{album}', [OrderController::class, 'downloadAlbum'])->name('download.album');
});

Route::middleware('product_type')->group(function () {
    Route::post('/cart/add/song/{id}', [CheckoutController::class, 'addSong'])->name('cart.addSong');
    Route::post('/cart/add/album/{id}', [CheckoutController::class, 'addAlbum'])->name('cart.addAlbum');
});

