<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\review;
use App\Models\Toko;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopDetailController extends Controller
{

    public function index($slug)
{
    
    $products = Product::where('slug', $slug)
        ->with(['kategori', 'reviews', 'orderItem.order.customer']) // Load customer via order
        ->withCount('orderItem')
        ->get();
        // dd($products);

    // Hitung rating rata-rata untuk setiap produk
    foreach ($products as $item) {
        $totalRating = $item->reviews->sum('rating');
        $totalReviews = $item->reviews->count();
        $item->averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
    }

    // Kembalikan tampilan dengan data
    return view('shopdetail.index', [
        'products' => $products,
    ]);
}

   public function addcart(Request $request)
{
    // Periksa apakah user sudah login
    if (!Auth::guard('customer')->user()) {
        return response()->json(['message' => 'Anda harus login terlebih dahulu'], 401);
    }

    $customerId = Auth::guard('customer')->user()->id;

    // Validasi input
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'product_id' => 'required|exists:products,id',
        'user_id' => 'required|exists:users,id'
    ]);

    // Mulai transaksi untuk memastikan data konsisten
    DB::beginTransaction();
    
    try {
        $product = Product::find($request->input('product_id'));

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $stokTersedia = $product->stok;

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $request->input('user_id'))
                        ->where('customer_id', $customerId)
                        ->where('product_id', $product->id)
                        ->first();

        // Hitung total kuantitas yang akan ditambahkan, termasuk jika sudah ada di keranjang
        $totalQuantity = $request->input('quantity');
        if ($cartItem) {
            $totalQuantity += $cartItem->quantity;
        }

        // Cek apakah total kuantitas melebihi stok
        if ($totalQuantity > $stokTersedia) {
            DB::rollBack();
            return response()->json(['message' => 'Jumlah melebihi stok yang tersedia'], 422);
        }

        // Jika item sudah ada, tambahkan kuantitasnya, jika tidak, buat baru
        if ($cartItem) {
            $cartItem->quantity = $totalQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $request->input('user_id'),
                'customer_id' => $customerId,
                'product_id' => $product->id,
                'quantity' => $request->input('quantity')
            ]);
        }

        // Commit transaksi jika semuanya berjalan baik
        DB::commit();

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang'], 200);

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();
        return response()->json(['message' => 'Terjadi kesalahan saat menambahkan ke keranjang'], 500);
    }
}

public function detail(){
    // Ambil customer_id dari pengguna yang sedang login
    $customerId = Auth::guard('customer')->id();

    // Ambil data keranjang berdasarkan customer_id
    $cart = Cart::where('customer_id', $customerId)->get();

    // Kirim data keranjang ke tampilan
    return view('shopdetail.cart-detail', ['cart' => $cart]);
}

public function updateCart(Request $request)
{
    $itemId = $request->input('item_id');
    $quantity = $request->input('quantity');

    // Temukan item di keranjang dan update kuantitasnya
    $cartItem = Cart::find($itemId);
    if ($cartItem) {
        $cartItem->quantity = $quantity;
        $cartItem->save();
    }else{
        return response()->json(['message' => 'Error'], 523);
    }

    // Mengembalikan respons sukses
    return response()->json(['success' => true]);
}

public function destroy($itemId){
    $product = Cart::find($itemId);
    if($product){
        $product->delete();
        return response()->json(['success' => true]);
    }else{
        return response()->json(['success' => false], 400);
    }
}

public function getTotal()
{
    $cart = Cart::all();
    // Hitung total harga semua item dalam cart
    $total = $cart->sum(function ($item) {
        return $item->product->harga * $item->quantity;
    });

    // Format total sebagai mata uang
    $formattedTotal = number_format($total, 2); // Ubah format sesuai kebutuhan

    return response()->json([
        'success' => true,
        'total' => $formattedTotal
    ]);
}
// CheckoutController.php
public function checkoutdetail(Request $request)
{
    // Periksa apakah user sudah login
    if (!Auth::guard('customer')->user()) {
        return response()->json(['message' => 'Anda harus login terlebih dahulu'], 401);
    }

    $customerId = Auth::guard('customer')->user()->id;

    // Validasi input
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'product_id' => 'required|exists:products,id',
        'user_id' => 'required|exists:users,id'
    ]);

    // Mulai transaksi untuk memastikan data konsisten
    DB::beginTransaction();
    
    try {
        $product = Product::find($request->input('product_id'));

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $stokTersedia = $product->stok;

        // Cek apakah produk sudah ada di keranjang
        $cartItem = Cart::where('user_id', $request->input('user_id'))
                        ->where('customer_id', $customerId)
                        ->where('product_id', $product->id)
                        ->first();

        // Hitung total kuantitas yang akan ditambahkan, termasuk jika sudah ada di keranjang
        $totalQuantity = $request->input('quantity');
        if ($cartItem) {
            $totalQuantity += $cartItem->quantity;
        }

        // Cek apakah total kuantitas melebihi stok
        if ($totalQuantity > $stokTersedia) {
            DB::rollBack();
            return response()->json(['message' => 'Jumlah melebihi stok yang tersedia'], 422);
        }

        // Jika item sudah ada, tambahkan kuantitasnya, jika tidak, buat baru
        if ($cartItem) {
            $cartItem->quantity = $totalQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $request->input('user_id'),
                'customer_id' => $customerId,
                'product_id' => $product->id,
                'quantity' => $request->input('quantity')
            ]);
        }

        // Commit transaksi jika semuanya berjalan baik
        DB::commit();

        return response()->json(['message' => 'Produk berhasil diproses'], 200);

    } catch (\Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        DB::rollBack();
        return response()->json(['message' => 'Terjadi kesalahan saat proses product'], 500);
    }

}
}
