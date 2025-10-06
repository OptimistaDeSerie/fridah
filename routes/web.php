<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('/',[HomeController::class, 'index'])->name('index');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}',[CartController::class,'increase_item_quantity'])->name('cart.increase.qty');
Route::put('/cart/reduce-quantity/{rowId}',[CartController::class,'reduce_item_quantity'])->name('cart.reduce.qty');
Route::delete('/cart/remove/{rowId}',[CartController::class,'remove_item_from_cart'])->name('cart.remove');
Route::delete('/cart/clear',[CartController::class,'empty_cart'])->name('cart.empty');
Route::get('/checkout',[CartController::class,'checkout'])->name('cart.checkout');
Route::post('/place-an-order',[CartController::class,'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation/{order}', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');
Route::get('/cart/delivery-fee', [CartController::class, 'get_delivery_fee'])->name('cart.delivery.fee');

/* When authenticated user clicks the dynamic profile link (their name) */
Route::middleware('auth')->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/save', [AdminController::class, 'add_category_save'])->name('admin.category.save');
    Route::get('/admin/category/{id}/edit', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/{id}/delete', [AdminController::class, 'delete_category'])->name('admin.category.delete');
    Route::get('/admin/products',[AdminController::class,'products'])->name('admin.products');
    Route::get('/admin/product/add',[AdminController::class,'add_product'])->name('admin.product.add');
    Route::post('/admin/product/save',[AdminController::class,'product_save'])->name('admin.product.save');
    Route::get('/admin/product/{id}/edit',[AdminController::class,'edit_product'])->name('admin.product.edit');
    Route::put('/admin/product/update',[AdminController::class,'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/{id}/delete',[AdminController::class,'delete_product'])->name('admin.product.delete');
    // Delivery Fees
    Route::get('/admin/delivery-fees', [AdminController::class, 'deliveryFees'])->name('admin.delivery-fees');
    Route::get('/admin/delivery-fee/add', [AdminController::class, 'addDeliveryFee'])->name('admin.delivery-fee.add');
    Route::post('/admin/delivery-fee/save', [AdminController::class, 'saveDeliveryFee'])->name('admin.delivery-fee.save');
    Route::get('/admin/delivery-fee/{id}/edit', [AdminController::class, 'editDeliveryFee'])->name('admin.delivery-fee.edit');
    Route::put('/admin/delivery-fee/update', [AdminController::class, 'updateDeliveryFee'])->name('admin.delivery-fee.update');
    Route::delete('/admin/delivery-fee/{id}/delete', [AdminController::class, 'deleteDeliveryFee'])->name('admin.delivery-fee.delete');
    // Carriers
    Route::get('/admin/carriers', [AdminController::class, 'carriers'])->name('admin.carriers');
    Route::get('/admin/carrier/add', [AdminController::class, 'addCarrier'])->name('admin.carrier.add');
    Route::post('/admin/carrier/save', [AdminController::class, 'saveCarrier'])->name('admin.carrier.save');
    Route::get('/admin/carrier/{id}/edit', [AdminController::class, 'editCarrier'])->name('admin.carrier.edit');
    Route::put('/admin/carrier/update', [AdminController::class, 'updateCarrier'])->name('admin.carrier.update');
    Route::delete('/admin/carrier/{id}/delete', [AdminController::class, 'deleteCarrier'])->name('admin.carrier.delete');
    //weight
    Route::get('/admin/weights', [AdminController::class, 'weights'])->name('admin.weights');
    Route::get('/admin/weight/add', [AdminController::class, 'addWeight'])->name('admin.weight.add');
    Route::post('/admin/weight/save', [AdminController::class, 'saveWeight'])->name('admin.weight.save');
    Route::get('/admin/weight/{id}/edit', [AdminController::class, 'editWeight'])->name('admin.weight.edit');
    Route::put('/admin/weight/update', [AdminController::class, 'updateWeight'])->name('admin.weight.update');
    Route::delete('/admin/weight/{id}/delete', [AdminController::class, 'deleteWeight'])->name('admin.weight.delete');

    //orders
    Route::get('/admin/orders',[AdminController::class,'orders'])->name('admin.orders');
    /* Route::get('/admin/order/{id}/items',[AdminController::class,'order_items'])->name('admin.order.items'); */
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Logout
    Route::get('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

require __DIR__.'/auth.php';
