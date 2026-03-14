<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', function () {
    return view('pages.shop');
})->name('shop');

Route::get('/product/{slug}', function (string $slug) {
    $product = Product::with(['images', 'category'])->where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('pages.product', compact('product'));
})->name('product.show');

Route::get('/cart', function () {
    return view('pages.cart');
})->name('cart');

Route::get('/wishlist', function () {
    return view('pages.wishlist');
})->name('wishlist');

Route::get('/checkout', function () {
    return view('pages.checkout');
})->name('checkout');

Route::get('/order-confirmation/{orderNumber}', function (string $orderNumber) {
    $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
    return view('pages.order-confirmation', compact('order'));
})->name('order.confirmation');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/products', \App\Livewire\Admin\Products\ProductList::class)->name('products.index');
    Route::get('/products/create', \App\Livewire\Admin\Products\ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', \App\Livewire\Admin\Products\ProductForm::class)->name('products.edit');
    Route::get('/products/{id}/inventory', \App\Livewire\Admin\Products\InventoryManager::class)->name('products.inventory');
    Route::get('/orders', \App\Livewire\Admin\Orders\OrderList::class)->name('orders.index');
    Route::get('/orders/{id}', \App\Livewire\Admin\Orders\OrderDetail::class)->name('orders.show');
});
