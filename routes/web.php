
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\PromotionController;
use App\Http\Controllers\Auth\RegisteredUserController;



Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

Route::get('/promotions', [PromotionController::class, 'index'])->name('client.promotions');

/*
|--------------------------------------------------------------------------
| PANIER CLIENT
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/add/{product}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::post('/increase/{id}', [CartController::class, 'increase'])
        ->name('cart.increase');

    Route::post('/decrease/{id}', [CartController::class, 'decrease'])
        ->name('cart.decrease');

    Route::delete('/remove/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::delete('/clear', [CartController::class, 'clear'])
        ->name('cart.clear');
});

/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/


Route::prefix('client')->name('client.')->group(function () {

    // GET → page checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout');

    // POST → valider la commande
    Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('auth') ->name('checkout.store');  // ← ce nom doit correspondre exactement
});


        Route::get('/order/success', function () {
            return view('client.order_success');
        })->name('client.order_success');



/*
|--------------------------------------------------------------------------
| CLIENT (PUBLIC)
|--------------------------------------------------------------------------
*/
// Make root show login page for guests and keep client dashboard accessible when authenticated
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Client dashboard route (kept for authenticated users)
Route::get('/dashboard', [HomeController::class, 'index'])->name('client.dashboard');
Route::get('/products', [ClientProductController::class, 'index'])->name('client.products');
    Route::get('/products/{product}', [ClientProductController::class, 'show'])->name('client.products.show');
    
/*
|--------------------------------------------------------------------------
| orders ADMIN
|--------------------------------------------------------------------------
*/
// Liste commandes (admin)
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');

// Détails commande
Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');

// Changer statut
Route::put('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Authentication routes (uses controllers under App\Http\Controllers\Auth)
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Registration routes (already defined above for RegisteredUserController)

// Password reset
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Détail produit
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Produits
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');

    Route::get('/products/create', [AdminController::class, 'createProduct']) ->name('admin.products.create');

    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');

    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');

    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');

    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');

        

Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');

Route::get('/admin/promotions/create', [AdminController::class, 'createPromotion'])->name('admin.promotions.create');
Route::post('/admin/promotions', [AdminController::class, 'storePromotion'])->name('admin.promotions.store');

    // Catégories
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/products', [ProductController::class, 'index']) ->name('admin.products');
    // Catégories (admin)
Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');

});





