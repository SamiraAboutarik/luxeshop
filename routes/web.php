<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, ShopController, CartController, CheckoutController};
use App\Http\Controllers\Admin\{DashboardController, ProductController as AdminProductController, OrderController as AdminOrderController};

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public shop
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produits/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/panier',            [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter',   [CartController::class, 'add'])->name('cart.add');
    Route::patch('/panier/{cartItem}',[CartController::class, 'update'])->name('cart.update');
    Route::delete('/panier/{cartItem}',[CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/panier',         [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/commande',          [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/commande',         [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/commande/success',  [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/',                      [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products',          AdminProductController::class)->parameters(['products' => 'product']);
    Route::get('orders',                 [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}',         [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status',[AdminOrderController::class, 'updateStatus'])->name('orders.status');
});
