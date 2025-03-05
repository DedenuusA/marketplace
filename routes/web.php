<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartCountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\NavbarController;
use App\Http\Controllers\OrderContorller;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilUserController;
use App\Http\Controllers\ProsesCheckoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RiwayatPembelianController;
use App\Http\Controllers\RiwayatPesananController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UserController;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
// Route::get('/', function () {
//     return view('marketplace.index');
// });

Route::get('/admin', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'check_login'])->name('login.check_login');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/logout', [DashboardController::class, 'logout'])->name('dashboard.logout')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/profile/user', [UserController::class, 'profileUser'])->name('profile.user')->middleware(['auth', 'role:super_admin,admin']);

Route::post('/upload/image', [ProfilUserController::class, 'uploadImage'])->name('upload.image')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/user/update-profile', [ProfilUserController::class, 'updateProfilUser'])->name('updateprofil.user')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/password/update/user', [ProfilUserController::class, 'UpdatePasswordUser'])->name('updatepassword.user')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/bantuan/question', [ProfilUserController::class, 'index'])->name('bantuan.index')->middleware('auth', 'role:super_admin,admin');

Route::get('/kategoris', [KategoriController::class, 'index'])->name('kategoris.index')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/kategoris', [KategoriController::class, 'store'])->name('kategoris.store')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/kategoris/{id}', [KategoriController::class, 'show'])->name('kategoris.show')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/kategoris/{id}', [KategoriController::class, 'update'])->name('kategoris.update')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/kategoris/{id}', [KategoriController::class, 'destroy'])->name('kategoris.destroy')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/tokos', [TokoController::class, 'index'])->name('tokos.index')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/tokos', [TokoController::class, 'store'])->name('tokos.store')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/tokos/{id}', [TokoController::class, 'show'])->name('tokos.show')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/tokos/{id}', [TokoController::class, 'update'])->name('tokos.update')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/tokos/{id}', [TokoController::class, 'destroy'])->name('tokos.destroy')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/pelanggans', [PelangganController::class, 'index'])->name('pelanggans.index')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/pelanggans', [PelangganController::class, 'store'])->name('pelanggans.store')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/pelanggans/{id}', [PelangganController::class, 'show'])->name('pelanggans.show')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/pelanggans/{id}', [PelangganController::class, 'update'])->name('pelanggans.update')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/pelanggans/{id}', [PelangganController::class, 'destroy'])->name('pelanggans.destroy')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show')->middleware(['auth', 'role:super_admin,admin']);
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/generate-pdf/{type}/{slug}' , [TransaksiController::class, 'getPDF'])->name('generate.getPDF')->middleware(['auth', 'role:super_admin,admin']);
Route::put('/transaksis/{id}', [TransaksiController::class, 'update'])->name('transaksis.update')->middleware(['auth', 'role:super_admin,admin']);
Route::get('/transaksis/{id}', [TransaksiController::class, 'showtransaksi'])->name('transaksi.showtransaksi')->middleware(['auth', 'role:super_admin,admin']);
Route::post('/update/status', [TransaksiController::class, 'updateStatus'])->name('tabledit.action');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index')->middleware(['auth', 'role:super_admin,admin']);

Route::get('/', [MarketPlaceController::class, 'index'])->name('market_place.index');
Route::get('/contack', [MarketPlaceController::class, 'view'])->name('contack.view');
Route::get('/customer/logout', [MarketPlaceController::class, 'logout'])->name('customer.logout');
Route::get('/testimonial', [MarketPlaceController::class, 'testimonial'])->name('testimonial.index');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/categories/{slug}', [ShopController::class, 'show'])->name('categories.show');
Route::get('/search', [ShopController::class, 'search'])->name('products.search');


Route::get('/shop-detail/{slug}', [ShopDetailController::class, 'index'])->name('product.detail');
Route::middleware('check.customer')->post('/add/cart', [ShopDetailController::class, 'addcart'])->name('add.cart');
Route::get('/detail-cart', [ShopDetailController::class, 'detail'])->name('detail.cart');
Route::middleware('check.customer')->post('/update-cart', [ShopDetailController::class, 'updateCart']);
Route::middleware('check.customer')->delete('/delete/cart/{itemId}', [ShopDetailController::class, 'destroy'])->name('delete.cart');
Route::middleware('check.customer')->get('/get-cart-total', [ShopDetailController::class, 'getTotal'])->name('get.cart.total');
Route::middleware('check.customer')->post('/checkout-detail', [ShopDetailController::class, 'checkoutdetail'])->name('checkout.detail');
Route::middleware('check.customer')->get('/checkout-product-detail', [ShopDetailController::class, 'prodcutdetail'])->name('checkout.productdetail');

Route::middleware('check.customer')->get('/proses/checkout', [ProsesCheckoutController::class, 'prosescheckout'])->name('proses.checkout');
Route::middleware('check.customer')->post('/checkout/customer', [ProsesCheckoutController::class, 'checkoutcustomer'])->name('checkout.customer');

Route::middleware('check.customer')->get('/cart/count', [CartController::class, 'getCartCount'])->name('get.cart.count');
Route::middleware('check.customer')->get('/checkout-product/{id}', [CartController::class, 'checkoutproduct'])->name('checkout.product');

Route::get('/customer/check_login', [CustomerLoginController::class, 'index'])->name('customer.login');
Route::post('/customer', [CustomerLoginController::class,'check_login'])->name('customer.check_login');
Route::get('/check/login', [CustomerLoginController::class, 'checklogin'])->name('check.login');

Route::get('/customer/register', [CustomerRegisterController::class, 'index'])->name('customer.register');
Route::post('/proses/register', [CustomerRegisterController::class, 'store'])->name('customer.store');

Route::middleware('check.customer')->get('/riwayat/pembelian', [RiwayatPembelianController::class, 'index'])->name('riwayat.pembelian');
Route::middleware('check.customer')->get('/ratings/{productId}', [RiwayatPembelianController::class, 'getRating'])->name('ratings.get');
Route::middleware('check.customer')->get('/order/details/{order_item_id}', [RiwayatPembelianController::class, 'getOrderDetails'])->name('order.detail');

Route::middleware('check.customer')->post('/save-review', [ReviewController::class, 'store']);
Route::middleware('check.customer')->get('/get-review/{order_item_id}', [ReviewController::class, 'edit']);
Route::middleware('check.customer')->post('/update-review', [ReviewController::class, 'update']);
Route::middleware('check.customer')->get('/get-rating/{order_item_id}', [ReviewController::class, 'getRating']);

Route::middleware('check.customer')->get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::middleware('check.customer')->post('/customer/update-profile', [ProfileController::class, 'updateProfile'])->name('customer.update-profile');
Route::middleware('check.customer')->post('/customer/update-password', [ProfileController::class, 'updatePassword'])->name('customer.update-password');
Route::middleware('check.customer')->post('/upload/image/customer', [ProfileController::class, 'UploadImageCustomer'])->name('customer.uploadimage');

route::post('/komentar', [KomentarController::class, 'index'])->name('komentar.index');
route::get('/view', [KomentarController::class, 'view'])->name('komentar.view');
route::delete('/komentar/{id}' , [KomentarController::class, 'destroy'])->name('komentar.destory');


// Route::get('/test', [DashboardController::class, 'test'])->name('tabledit.action');

Route::get('/user/api', [UserApiController::class,'userapi']);

Route::get('/404', function() {
      abort(404);
});
