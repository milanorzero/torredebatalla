<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\PointController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\EventCalendarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TournamentAdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PointHistoryController;
use App\Http\Controllers\EventTournamentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Models\Order;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [UserController::class, 'home'])->name('index');
Route::get('/product_details/{id}', [UserController::class, 'productDetails'])->name('product_details');
Route::get('/allproducts', [UserController::class, 'viewAllProducts'])->name('view_allproducts');
Route::get('/search', [UserController::class, 'searchProducts'])->name('search_products');
Route::get('/events', EventTournamentController::class)->name('events');
Route::get('/ligas', EventTournamentController::class)->name('ligas');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/contacto', [ContactController::class, 'show'])->name('contacto');
Route::post('/contacto', [ContactController::class, 'send'])->name('contacto.send');
/*
|--------------------------------------------------------------------------
| CART (INVITADO + USUARIO)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CART (INVITADO + USUARIO)
|--------------------------------------------------------------------------
*/

Route::post('/addtocart/{id}', [UserController::class, 'addToCart'])
    ->name('add_to_cart');

Route::get('/cartproducts', [UserController::class, 'cartProducts'])
    ->name('cartproducts');

Route::get('/removecartproduct/{id}', [UserController::class, 'removeCartProduct'])
    ->name('removecartproduct');

Route::post('/cart/{action}/{id}', [UserController::class, 'updateCart'])
    ->name('cart.update');

/*
|--------------------------------------------------------------------------
| CHECKOUT (SIN AUTH)
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/checkout/success/{order}', function (Order $order) {
    return redirect()
        ->route('index')
        ->with('success', "Orden #{$order->id} creada correctamente.");
})->name('checkout.success');

Route::get('/pagar/mercadopago', [MercadoPagoController::class, 'init'])->name('mercadopago.init');

// Checkout Bricks (checkout embebido)
Route::get('/mercadopago/bricks/checkout', [MercadoPagoController::class, 'bricksCheckout'])
    ->name('mercadopago.bricks.checkout');
Route::post('/mercadopago/bricks/process_payment', [MercadoPagoController::class, 'bricksProcessPayment'])
    ->name('mercadopago.bricks.process_payment');
Route::get('/mercadopago/bricks/status/{paymentId}', [MercadoPagoController::class, 'bricksStatus'])
    ->whereNumber('paymentId')
    ->name('mercadopago.bricks.status');

Route::get('/mercadopago/return', [MercadoPagoController::class, 'return'])->name('mercadopago.return');
Route::get('/mercadopago/return/success', [MercadoPagoController::class, 'returnSuccess'])->name('mercadopago.return.success');
Route::get('/mercadopago/return/failure', [MercadoPagoController::class, 'returnFailure'])->name('mercadopago.return.failure');
Route::get('/mercadopago/return/pending', [MercadoPagoController::class, 'returnPending'])->name('mercadopago.return.pending');
Route::post('/mercadopago/webhook', [MercadoPagoController::class, 'webhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('mercadopago.webhook');

Route::get('/payment/transfer/{order}', [PaymentController::class, 'transfer'])->name('payment.transfer');
Route::post('/payment/transfer/{order}/upload', [PaymentController::class, 'uploadTransferProof'])->name('payment.transfer.upload');


// Fallback for hosts that don't allow symlinks (storage:link)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/storage/payments/{path}', [StorageController::class, 'paymentProof'])
        ->where('path', '.*')
        ->name('admin.storage.payments');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {

    // Slider CRUD
    Route::resource('slider', \App\Http\Controllers\Admin\SliderItemController::class, [
        'names' => [
            'index' => 'slider.index',
            'create' => 'slider.create',
            'store' => 'slider.store',
            'edit' => 'slider.edit',
            'update' => 'slider.update',
            'destroy' => 'slider.destroy',
        ]
    ])->except(['show']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pos', [PosController::class, 'create'])->name('pos.create');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');

    Route::get('/points', [PointController::class, 'create'])->name('points.create');
    Route::post('/points', [PointController::class, 'store'])->name('points.store');

    Route::get('/events/calendar', [EventCalendarController::class, 'edit'])->name('events.calendar.edit');
    Route::post('/events/calendar', [EventCalendarController::class, 'update'])->name('events.calendar.update');

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/tournaments', [TournamentAdminController::class, 'index'])->name('tournaments.index');
        Route::get('/tournaments/create', [TournamentAdminController::class, 'create'])->name('tournaments.create');
        Route::post('/tournaments', [TournamentAdminController::class, 'store'])->name('tournaments.store');
        Route::get('/tournaments/{tournament}/edit', [TournamentAdminController::class, 'edit'])->name('tournaments.edit');
        Route::put('/tournaments/{tournament}', [TournamentAdminController::class, 'update'])->name('tournaments.update');
        Route::post('/tournaments/{tournament}/unpublish', [TournamentAdminController::class, 'unpublish'])->name('tournaments.unpublish');
        Route::delete('/tournaments/{tournament}', [TournamentAdminController::class, 'destroy'])->name('tournaments.destroy');
    });

    Route::get('/products', [AdminController::class, 'viewProduct'])->name('viewproduct');
    Route::get('/products/add', [AdminController::class, 'addProduct'])->name('addproduct');
    Route::post('/products/add', [AdminController::class, 'postAddProduct'])->name('postaddproduct');

    Route::get('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('updateproduct');
    Route::post('/products/update/{id}', [AdminController::class, 'postUpdateproduct'])->name('postupdateproduct');
    Route::get('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('deleteproduct');

    Route::get('/categories/add', [AdminController::class, 'addCategory'])->name('addcategory');
    Route::post('/categories/add', [AdminController::class, 'postAddCategory'])->name('postaddcategory');
    Route::get('/categories', [AdminController::class, 'viewCategory'])->name('viewcategory');
    Route::get('/categories/delete/{id}', [AdminController::class, 'deleteCategory'])->name('categorydelete');
    Route::get('/categories/update/{id}', [AdminController::class, 'updateCategory'])->name('categoryupdate');
    Route::post('/categories/update/{id}', [AdminController::class, 'postupdateCategory'])->name('postupdatecategory');

    Route::get('/orders', [OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/payment-proof', [OrderAdminController::class, 'paymentProof'])->name('orders.payment-proof');
    Route::post('/orders/{order}/approve', [OrderAdminController::class, 'approve'])->name('orders.approve');
    Route::post('/orders/{order}/reject', [OrderAdminController::class, 'reject'])->name('orders.reject');
    Route::post('/orders/{order}/cancel', [OrderAdminController::class, 'cancel'])->name('orders.cancel');

    Route::get('/blog', [BlogPostController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogPostController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogPostController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [BlogPostController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogPostController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogPostController::class, 'destroy'])->name('blog.destroy');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mis-puntos', PointHistoryController::class)->name('points.history');
});

require __DIR__.'/auth.php';
