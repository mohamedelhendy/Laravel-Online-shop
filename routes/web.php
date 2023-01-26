<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;

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

Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('/details/{id}', [HomeController::class,'details']);
Route::post('/details/addReview/{id}', [HomeController::class,'addReview']);
Route::post('/details/updateReview/{id}', [HomeController::class,'updateReview']);
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/editCart', [HomeController::class, 'editCart']);
Route::get('logout', [HomeController::class,'logout']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/send', [HomeController::class, 'sendOrder']);
    Route::get('/add-product', [HomeController::class, 'add_product']);
    Route::get('/like-product', [HomeController::class, 'like_product']);
    Route::post('/subscribe', [HomeController::class, 'subscribe']);
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'can:is_admin'])->prefix('/admin')->group(function () {
    Route::get('', [adminController::class, 'admin']);
    Route::get('users', [adminController::class,'users'])->name('users');
    Route::get('users/setAdmin/{id}', [adminController::class,'setAdmin']);
    Route::delete('users/{id}', [adminController::class,'deleteUser']);
    Route::delete('orders/deleteProduct/{id}', [OrderController::class,'deleteProduct']);
    Route::resource('products', ProductsController::class);
    Route::resource('categories', CategoriesController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('colors', ColorsController::class);
});
