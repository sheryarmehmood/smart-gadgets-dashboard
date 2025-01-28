<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariationController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


// Variations CRUD
Route::get('products/{product}/variations', [VariationController::class, 'index'])->name('products.variations.index');
Route::get('products/{product}/variations/create', [VariationController::class, 'create'])->name('products.variations.create');
Route::post('products/{product}/variations', [VariationController::class, 'store'])->name('products.variations.store');
Route::get('products/{product}/variations/{id}/edit', [VariationController::class, 'edit'])->name('products.variations.edit');
Route::put('products/{product}/variations/{id}', [VariationController::class, 'update'])->name('products.variations.update');
Route::delete('products/{product}/variations/{id}', [VariationController::class, 'destroy'])->name('products.variations.destroy');
