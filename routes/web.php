<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/admin', [AuthController::class, 'adminDashboard'])->middleware('auth:admin');
Route::get('/home', [AuthController::class, 'customerHome'])->middleware('auth');
Route::get('customer/home', [AuthController::class, 'customerHome'])->name('customer.home');
Route::get('/', function () {
    return view('welcome');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
use App\Http\Controllers\Admin\AdminController;

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('customer/home', [AuthController::class, 'customerHome'])->name('customer.home');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('admin');
use App\Http\Controllers\Customer\HomeController;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('admin');
    // Route cho trang admin
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// Route cho trang khách hàng
Route::get('/', [HomeController::class, 'index'])->name('customer.home');
// Route đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route đăng ký
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Route trang chủ của khách hàng
Route::get('/home', [AuthController::class, 'customerHome'])->name('customer.home');

// Route dashboard cho admin
Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
use App\Http\Controllers\Customer\CategoryController;

// Route để hiển thị danh sách danh mục
Route::get('/categories', [CategoryController::class, 'index'])->name('danhmuc');

// Route để hiển thị sản phẩm theo danh mục
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('danhmuc.show');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.details');




Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


use App\Http\Controllers\Customer\ProductController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    

Route::get('/products/category/{category}', [ProductController::class, 'indexByCategory'])->name('products.index');
Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // Đường dẫn cho tất cả sản phẩm
Route::get('/products/category/{category}', [ProductController::class, 'indexByCategory'])->name('products.index.by.category'); // Đường dẫn cho sản phẩm theo danh mục
Route::get('/categories/{categoryId}/products', [ProductController::class, 'indexByCategory'])->name('products.index.by.category');

use App\Http\Controllers\Customer\CartController;

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');


// Route để hiển thị giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route để cập nhật sản phẩm trong giỏ hàng


// Route để xóa sản phẩm khỏi giỏ hàng
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/hinh-anh-san-pham', [CartController::class, 'showImage']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');

use App\Http\Controllers\Customer\OrderController;

Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');


Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

// Thanh toán cho sản phẩm ngay lập tức
Route::post('/buy-now/{product}', [OrderController::class, 'buyNow'])->name('buy.now');
// Trang thông báo thành công
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');
Route::post('/buy-now/{product}', [OrderController::class, 'buyNow'])->name('buy.now');
Route::post('/buy-now', [OrderController::class, 'buyNow'])->name('order.buy');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');


Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/checkout/{order}', [OrderController::class, 'processPayment'])->name('order.processPayment');

use App\Http\Controllers\Customer\BrandController;

Route::get('brands', [BrandController::class, 'index'])->name('brands.index');

// Hiển thị sản phẩm theo thương hiệu
Route::get('products/brand/{brand}', [BrandController::class, 'showByBrand'])->name('products.index.by.brand');

Route::get('products/brand/{brand}', [ProductController::class, 'indexByBrand'])->name('products.index.by.brand');
Route::get('products/brand/{brand}', [ProductController::class, 'showProductsByBrand'])->name('products.index.by.brand');
Route::get('products/brand/{brandId}', [ProductController::class, 'showProductsByBrand'])->name('products.index.by.brand');
Route::get('products/brand/{brandId}', [ProductController::class, 'showByBrand'])->name('products.index.by.brand');
Route::get('products/brand/{brandId}', [ProductController::class, 'showProductsByBrand'])->name('products.index.by.brand');
Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('products/brand/{brandId}', [ProductController::class, 'showByBrand'])->name('products.by.brand');
// Route để hiển thị chi tiết sản phẩm
Route::get('products/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/{order}/process-payment', [OrderController::class, 'processPayment'])->name('order.processPayment');
Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('order.checkout');


Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

// web.php
// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// // web.php
// Route::post('/add-to-cart', [CartController::class, 'add'])->name('add.to.cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('add.to.cart');

// Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
// Hiển thị trang giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Route cập nhật giỏ hàng (đảm bảo đúng phương thức và route name)

// Route xóa sản phẩm khỏi giỏ hàng
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


use App\Http\Controllers\Customer\CheckoutController;

Route::post('/checkout/selected', [CheckoutController::class, 'checkoutSelected'])->name('checkout.selected');

Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

Route::post('/checkout', [CheckoutController::class, 'checkoutSelected'])->name('checkout.selected');
// Trang giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Thanh toán
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Route để lưu đơn hàng
Route::post('/checkout', [OrderController::class, 'store'])->name('order.store');

Route::get('/stores', function () {
    return view('stores.index');
})->name('stores.index');

Route::get('/support', function () {
    return view('support.support_customer');
})->name('support.support_customer');

// Routes for Admin Dashboard
Route::prefix('admin')->middleware('auth', 'admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('products', Admin\ProductController::class);
    Route::resource('orders', Admin\OrderController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('brands', Admin\BrandController::class);
    Route::resource('users', Admin\UserController::class);
});
// Route cho admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
});

// Route cho khách hàng
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [AuthController::class, 'customerHome'])->name('customer.home');
});

use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/products', AdminProductController::class);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
});
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('products.index');

Route::prefix('admin')->middleware('auth', 'admin')->group(function () {
    Route::get('products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('admin.products.store'); // Route này quan trọng
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    
});

use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::prefix('admin')->group(function () {
    Route::resource('orders', AdminOrderController::class)->names([
        'index' => 'admin.orders.index',
        'create' => 'admin.orders.create',
        'store' => 'admin.orders.store',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
        'destroy' => 'admin.orders.destroy',
    ]);
});


use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
});


// route('admin.categories.index', ['admin' => $adminId]);
use App\Http\Controllers\Admin\BrandController as AdminBrandController;

Route::prefix('admin')->group(function () {
    Route::resource('brands', AdminBrandController::class)->names([
        'index' => 'admin.brands.index',
        'create' => 'admin.brands.create',
        'store' => 'admin.brands.store',
        'edit' => 'admin.brands.edit',
        'update' => 'admin.brands.update',
        'destroy' => 'admin.brands.destroy',
    ]);
});


use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::prefix('admin')->group(function () {
    Route::resource('users', AdminUserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
});
Route::get('/ban-chay', [ProductController::class, 'getBestSellers'])->name('bestSellers');

use App\Http\Controllers\Customer\ClinicSpaController;



Route::get('/clinic-spa', [ClinicSpaController::class, 'index']);
Route::get('/clinic-spa/{id}', [ClinicSpaController::class, 'show'])->name('clinicSpa.show');

// web.php
Route::get('/order-history', [OrderController::class, 'showOrderHistory'])->name('order.history');
Route::post('/order/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');


Route::get('/search', [HomeController::class, 'search'])->name('home.search');


Route::get('/icon', function () {
    return view('icon.now2h');
})->name('icon.now2h');


use App\Http\Controllers\Admin\NhanVienController as AdminNhanVienController;

Route::prefix('admin')->group(function () {
    Route::resource('nhanvien', AdminNhanVienController::class)->names([
        'index' => 'admin.nhanvien.index',
        'create' => 'admin.nhanvien.create',
        'store' => 'admin.nhanvien.store',
        'edit' => 'admin.nhanvien.edit',
        'update' => 'admin.nhanvien.update',
        'destroy' => 'admin.nhanvien.destroy',
    ]);
});
use App\Http\Controllers\Admin\SearchController;

Route::get('/admin/search', [SearchController::class, 'index'])->name('admin.search');


use App\Http\Controllers\Customer\PageController;

// Thêm route
Route::get('/hot_deals', [PageController::class, 'showHotDeals'])->name('hot_deals');

// Tạo hàm trong Controller (bước tiếp theo)



// Định nghĩa route cho chức năng thanh toán sản phẩm đã chọn
Route::post('/cart/checkout-selected', [CartController::class, 'checkoutSelected'])->name('cart.checkoutSelected');

Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkoutAll');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/updatee', [CartController::class, 'updatee'])->name('cart.updatee');
Route::get('/password/change', [UserController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/password/change', [UserController::class, 'changePassword'])->name('password.update');
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
Route::post('/products/{product}/comments', [CustomerProductController::class, 'addComment'])->name('product.comment');

use App\Http\Controllers\Admin\CommentController as AdminCommentController;
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('comments', AdminCommentController::class);
});
Route::post('/comment/{comment}/reply', [AdminCommentController::class, 'replyComment'])->name('comment.reply');
// routes/web.php

Route::delete('admin/comments/{id}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
// routes/web.php
// routes/web.php

use App\Http\Controllers\Admin\ReportController;

Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');



Route::get('/order_history/{status?}', [OrderController::class, 'showOrderHistory'])->name('order_history');
Route::get('/order-history', [OrderController::class, 'showOrderHistory'])->name('order.history');
// Định nghĩa route cho việc trả đơn/hàng hoàn
Route::post('/order/{id}/return', [OrderController::class, 'return'])->name('order.return');
Route::post('/process-checkout', [OrderController::class, 'processCheckout'])->name('process.checkout');

Route::middleware(['web'])->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
});

Route::get('/admin/products/search', [AdminProductController::class, 'search'])->name('admin.products.search');
Route::get('/admin/products/{id}', [AdminProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/orders/search', [OrderController::class, 'search'])->name('admin.orders.search');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::get('/order/{id}/details', [OrderController::class, 'details'])->name('order.details');


use App\Http\Controllers\Admin\StoreController;

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('stores', StoreController::class);
});
