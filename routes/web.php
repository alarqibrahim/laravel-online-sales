<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\ShippingServiceController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;


// ==================================================
// ROUTE TOKO / HALAMAN UTAMA
// ==================================================

Route::get('/', [ProductCatalogController::class, 'index'])
    ->name('shop.index');

Route::get('/produk/{product:slug}', [ProductCatalogController::class, 'show'])
    ->name('shop.show');


// ==================================================
// ROUTE AUTENTIKASI
// ==================================================

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

});


// ==================================================
// ROUTE LOGOUT
// ==================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ==================================================
// ROUTE KERANJANG
// ==================================================

Route::middleware(['auth', 'role:customer'])->group(function () {

    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/keranjang/tambah/{product}', [CartController::class, 'store'])
        ->name('cart.store');

    Route::patch('/keranjang/{product}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/keranjang/{product}', [CartController::class, 'destroy'])
        ->name('cart.destroy');


    // ==================================================
    // ROUTE CHECKOUT
    // ==================================================

    Route::get('/checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');

    Route::post('/checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');


    // ==================================================
    // ROUTE PESANAN PELANGGAN
    // ==================================================

    Route::get('/pesanan', [CustomerOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/pesanan/{order}', [CustomerOrderController::class, 'show'])
        ->name('orders.show');

});


// ==================================================
// ROUTE ADMIN
// ==================================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return redirect()->route('admin.categories.index');
        })->name('dashboard');


        // Kategori
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');

        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');

        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');


        // Produk
        Route::resource('products', AdminProductController::class)
            ->except('show');


        // Stok
        Route::get('/stock', [StockController::class, 'index'])
            ->name('stock.index');

        Route::get('/stock/create', [StockController::class, 'create'])
            ->name('stock.create');

        Route::post('/stock', [StockController::class, 'store'])
            ->name('stock.store');


        // Ekspedisi
        Route::get('/shipping', [ShippingServiceController::class, 'index'])
            ->name('shipping.index');

        Route::post('/shipping', [ShippingServiceController::class, 'store'])
            ->name('shipping.store');

        Route::put('/shipping/{shippingService}', [ShippingServiceController::class, 'update'])
            ->name('shipping.update');

        Route::delete('/shipping/{shippingService}', [ShippingServiceController::class, 'destroy'])
            ->name('shipping.destroy');

    });