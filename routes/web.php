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
    Route::get('/about-us', [HomeController::class, 'about_us'])->name('about.us');
    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact.us');
    Route::get('/shipping-policy', [HomeController::class, 'shipping_policy'])->name('shipping.policy');
    Route::get('/return-policy', [HomeController::class, 'return_policy'])->name('return.policy');
    Route::get('/terms-condition', [HomeController::class, 'terms_condition'])->name('terms.condition');
    Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy.policy');
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
    Route::get('/account-orders',[UserController::class,'orders'])->name('user.orders');
    Route::get('/account-order-details/{order_id}',[UserController::class,'order_details'])->name('user.order.details');
    Route::put('/account-order/cancel-order',[UserController::class,'cancel_order'])->name('user.cancel_order');
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
    Route::get('/admin/order/{id}/item',[AdminController::class,'orderItem'])->name('admin.order.item');
    Route::put('/admin/order/update-status',[AdminController::class,'update_order_status'])->name('admin.order.status.update');

    // Home Sliders
    Route::get('/admin/sliders', [AdminController::class, 'sliders'])->name('admin.sliders'); 
    Route::get('/admin/slider/add', [AdminController::class, 'add_slider'])->name('admin.slider.add');
    Route::post('/admin/slider/save', [AdminController::class, 'add_slider_save'])->name('admin.slider.save');
    Route::get('/admin/slider/edit/{id}', [AdminController::class, 'edit_slider'])->name('admin.slider.edit');
    Route::put('/admin/slider/update', [AdminController::class, 'update_slider'])->name('admin.slider.update');
    Route::delete('/admin/slider/delete/{id}', [AdminController::class, 'delete_slider'])->name('admin.slider.delete');

    // Popular Categories
    Route::get('/admin/popular-categories', [AdminController::class, 'popular_categories'])->name('admin.popular.categories');
    Route::get('/admin/popular-category/add', [AdminController::class, 'add_popular_category'])->name('admin.popular.category.add');
    Route::post('/admin/popular-category/save', [AdminController::class, 'add_popular_category_save'])->name('admin.popular.category.save');
    Route::get('/admin/popular-category/edit/{id}', [AdminController::class, 'edit_popular_category'])->name('admin.popular.category.edit');
    Route::put('/admin/popular-category/update', [AdminController::class, 'update_popular_category'])->name('admin.popular.category.update');
    Route::delete('/admin/popular-category/delete/{id}', [AdminController::class, 'delete_popular_category'])->name('admin.popular.category.delete');

    // Hot Deals
    Route::get('/admin/hot-deals', [AdminController::class, 'hot_deals'])->name('admin.hot.deals');
    Route::get('/admin/hot-deal/add', [AdminController::class, 'add_hot_deal'])->name('admin.hot.deal.add');
    Route::post('/admin/hot-deal/save', [AdminController::class, 'add_hot_deal_save'])->name('admin.hot.deal.save');
    Route::get('/admin/hot-deal/edit/{id}', [AdminController::class, 'edit_hot_deal'])->name('admin.hot.deal.edit');
    Route::put('/admin/hot-deal/update', [AdminController::class, 'update_hot_deal'])->name('admin.hot.deal.update');
    Route::delete('/admin/hot-deal/delete/{id}', [AdminController::class, 'delete_hot_deal'])->name('admin.hot.deal.delete');

    // Home Banners 
    Route::get('/admin/banners', [AdminController::class, 'banners'])->name('admin.banners');
    Route::get('/admin/banner/add', [AdminController::class, 'add_banner'])->name('admin.banner.add');
    Route::post('/admin/banner/save', [AdminController::class, 'add_banner_save'])->name('admin.banner.save');
    Route::get('/admin/banner/edit/{id}', [AdminController::class, 'edit_banner'])->name('admin.banner.edit');
    Route::put('/admin/banner/update', [AdminController::class, 'update_banner'])->name('admin.banner.update');
    Route::delete('/admin/banner/delete/{id}', [AdminController::class, 'delete_banner'])->name('admin.banner.delete');

    // Shop Banners
    Route::get('/admin/shop-banners', [AdminController::class, 'shop_banners'])->name('admin.shop_banners');
    Route::get('/admin/shop-banner/add', [AdminController::class, 'add_shop_banner'])->name('admin.shop_banner.add');
    Route::post('/admin/shop-banner/save', [AdminController::class, 'save_shop_banner'])->name('admin.shop_banner.save');
    Route::get('/admin/shop-banner/edit/{id}', [AdminController::class, 'edit_shop_banner'])->name('admin.shop_banner.edit');
    Route::put('/admin/shop-banner/update', [AdminController::class, 'update_shop_banner'])->name('admin.shop_banner.update');
    Route::delete('/admin/shop-banner/delete/{id}', [AdminController::class, 'delete_shop_banner'])->name('admin.shop_banner.delete');
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
