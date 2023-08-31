<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AlbumController;

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
Route::get('/catalog', [CatalogController::class, 'catalog']);
Route::get('/song/{id}', 'SongController@show')->name('song.show');
Route::get('/cart', 'CartController@index')->name('cart');
Route::get('/checkout', 'CheckoutController@index')->name('checkout');
Route::get('/albums', 'AlbumController@index')->name('album.index');
Route::get('/albums/{id}', 'AlbumController@show')->name('album.show');


// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    // Add more admin routes as needed
});