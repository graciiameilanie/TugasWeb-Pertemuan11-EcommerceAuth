
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard pengguna yang sudah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Daftar produk
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

// Route untuk admin dan editor
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    // Form tambah produk
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');

    // Simpan produk baru
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    // Form edit produk
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    // Simpan perubahan produk
    Route::put('/products/{product}', [ProductController::class, 'update'])
        ->name('products.update');
});

// Route khusus admin untuk menghapus produk
Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->name('products.destroy');

// Detail produk (letakkan paling bawah)
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')
    ->name('products.show');


// Profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Route autentikasi Laravel Breeze
require __DIR__.'/auth.php';
