<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'site.pages.home')->name('home');

Route::controller(LoginController::class)->group(function () {
    Route::get('admin/login', 'showLoginForm')->name('admin.login');
    Route::post('admin/login', 'login')->name('admin.login.post');

    Route::get('admin/register', 'showRegisterForm')->name('admin.register');
    Route::post('admin/register', 'register')->name('admin.register.store');

    Route::get('admin/logout', 'logout')->name('admin.logout');

});
Route::get('category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('product/{product:slug}', [ProductController::class, 'show'])->name('product.show');



Route::group(['middleware' => ['auth']], function () {
    Route::post('/product/add/cart', [ProductController::class , 'addToCart'])->name('product.add.cart');

    Route::controller(CartController::class)->group(function (){
        Route::get('cart', 'getCart')->name('checkout.cart');
        Route::get('cart/item/{id}/remove', 'removeItem')->name('checkout.cart.remove');
        Route::get('cart/clear', 'clearCart')->name('checkout.cart.clear');

    });
    Route::get('checkout', [CheckoutController::class, 'getCheckout'])->name('checkout.index');
    Route::post('checkout/order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('checkout/payment/complete', [CheckoutController::class, 'complete'])->name('checkout.payment.complete');


    Route::controller(PayPalController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::get('handle-payment', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });

    Route::get('account/orders', [AccountController::class, 'getOrders'])->name('account.orders');
     
});




require __DIR__.'/auth.php';
