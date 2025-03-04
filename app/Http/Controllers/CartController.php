<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


//     public function addToCart(Request $request)
// {
//     // Periksa apakah user sudah login
//     if (!Auth::guard('customer')->check()) {
//         return response()->json(['message' => 'Anda harus login terlebih dahulu'], 401);
//     }

//     $customerId = Auth::guard('customer')->id(); // Mendapatkan ID pengguna yang sedang login

//     // Validasi input
//     $request->validate([
//         'quantity' => 'required|integer|min:1',
//         'product_id' => 'required|exists:products,id',
//         'user_id' => 'required|exists:users,id',
//     ]);

//     $productId = $request->input('product_id');
//     $quantity = $request->input('quantity');
//     $userId = $request->input('user_id');

//     // Cari produk berdasarkan ID
//     $product = Product::find($productId);

//     if (!$product) {
//         return response()->json(['message' => 'Produk tidak ditemukan'], 404);
//     }

//     // Cari item di keranjang yang sesuai
//     $cartItem = Cart::where('customer_id', $customerId)
//                     ->where('product_id', $productId)
//                     ->where('user_id', $userId)
//                     ->first();

//     if ($cartItem) {
//         // Jika item sudah ada di keranjang, tambahkan kuantitasnya
//         $cartItem->quantity += $quantity;
//         $cartItem->save();
//     } else {
//         // Jika item belum ada di keranjang, buat item baru
//         Cart::create([
//             'customer_id' => $customerId,
//             'product_id' => $productId,
//             'user_id' => $userId,
//             'quantity' => $quantity
//         ]);
//     }

//     return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang'], 200);
// }

//    public function addToCart(Request $request)
// {
//     // Validasi input
//     $validated = $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'user_id' => 'required|exists:users,id',
//         'quantity' => 'required|integer|min:1'
//     ]);

//     // Cek apakah pengguna sudah login
//     if (!Auth::guard('customer')->check()) {
//         return response()->json([
//             'success' => false,
//             'message' => 'User must be logged in.'
//         ]);
//     }

//     $customerId = Auth::guard('customer')->user();
//     // Ambil ID customer dari tabel customer berdasarkan user_id
//     $userId = $request->user_id;
//     $product = Product::where('user_id', $userId)->first();

//     if (!$product) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Customer not found.'
//         ]);
//     }

//     // Buat entri baru di tabel cart
//     $cart = new Cart();
//     $cart->user_id = $userId;
//     $cart->customer_id = $customerId->id; // Ambil ID customer dari tabel customer
//     $cart->product_id = $request->product_id;
//     $cart->quantity = $request->quantity;
//     $cart->save();

//     return response()->json([
//         'success' => true
//     ]);
// }


//     public function viewCart()
//     {
//         $cart = Session::get('cart', []);
//         return view('cart.index', ['cart' => $cart]);
//     }

//     public function remove(Request $request)
//     {
//         $productId = $request->input('product_id');
//         $cart = Session::get('cart', []);

//         if (isset($cart[$productId])) {
//             unset($cart[$productId]);
//             Session::put('cart', $cart);
//         }

//         return redirect()->route('cart.view')->with('success', 'Product berhasil di hapus');
//     }
    
// public function update(Request $request)
// {
//     $cart = Session::get('cart', []);
//     $productId = $request->input('product_id');
//     $newQuantity = $request->input('quantity');

//     foreach ($cart as &$item) {
//         if ($item['id'] == $productId) {
//             $item['quantity'] = $newQuantity;
//             break;
//         }
//     }

//     Session::put('cart', $cart);

//     return response()->json(['success' => true]);
// }

// public function checkout(Request $request)
// {
    
//     $userId = $request->input('user_id'); // Ambil user_id dari request
//     $productId = $request->input('product_id');
//     $quantity = $request->input('quantity', 1); // Default quantity to 1

//     // Fetch product details
//     $product = Product::find($productId);
//     if (!$product) {
//         return response()->json(['message' => 'Produk tidak ditemukan'], 404);
//     }

//      $cart = Session::get('cart', []);

//     // Add or update product in cart
//     if (isset($cart[$productId])) {
//         $cart[$productId]['quantity'] += $quantity;
//     } else {
//         $cart[$productId] = [
//             'id' => $product->id,
//             'name' => $product->nama_product,
//             'price' => $product->harga,
//             'quantity' => $quantity,
//             'image' => $product->image,
//         ];
//     }

//     Session::put('cart', $cart);
//     Session::put('user_id', $userId); // Simpan user_id dalam session jika diperlukan

//     return response()->json(['success' => 'Produk berhasil di Proses']);

// }

public function getCartCount()
{
    $user = Auth::guard('customer')->id(); // Mengambil pengguna yang sedang login

    if (!$user) {
        return response()->json(['success' => false, 'error' => 'Customer Belum Login.']);
    }
    // Mengambil data keranjang dari sesi
    $cartItems = Cart::where('customer_id', $user)->get(); // 'cart' adalah kunci sesi, dan [] adalah nilai default

    // Menghitung jumlah item di keranjang
    $cartCount = count($cartItems);

    return response()->json(['success' => true, 'cart_count' => $cartCount]);
}

public function checkoutproduct($id)
{

     if (!Auth::guard('customer')->check()) {
        return redirect()->route('customer.login');
    }

    $customerId = Auth::guard('customer')->id();
    
    $product = Product::findOrFail($id);
    $userId = $product->user_id;

    // Cek apakah produk sudah ada di cart
    $cartItem = Cart::where('product_id', $id)
                    ->where('customer_id', $customerId)
                    ->where('user_id', $userId)
                    ->first();

    if ($cartItem) {
        // Jika sudah ada, tambahkan kuantitas
        $cartItem->increment('quantity');
    } else {
        // Jika belum ada, tambahkan item baru ke cart
        Cart::create([
            'product_id' => $id,
            'customer_id' => $customerId,
            'quantity' => 1,
            'user_id' => $userId,
        ]);
    }

    // Ambil semua cart item untuk ditampilkan
    $cart = Cart::where('customer_id', $customerId)->get();

    return view('shopdetail.cart-detail', [
        'product' => $product,
        'cart' => $cart,
    ]);
}

}
