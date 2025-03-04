<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
// public function index(Request $request)
//     { 

//      $customer = Auth::guard('customer')->user();
    
//     if (!$customer) {
//         // Jika tidak ada data pelanggan, redirect atau tampilkan pesan error
//         return redirect()->route('customer.login')->with('error', 'Silahkan login terlebih dahulu.');
//     }
//     $cart = Session::get('cart', []);

// // Mengembalikan tampilan checkout dengan data keranjang belanja
// return view('checkout.index', compact('cart','customer'));
//     }

// public function processCheckout(Request $request)
// {

//     // Validasi data
//     $validated = $request->validate([
//         'customer_name' => 'required|string|max:255',
//         'customer_email' => 'required|email|max:255',
//         'shipping_address' => 'required|string|max:1000',
//         'no_hp' => 'required|string',
//         'catatan' => 'nullable|string',
//         'jenis_pembayaran' => 'required|string|in:transfer,cod',
//     ]);

//     // Ambil user_id dari session
//     $userId = Session::get('user_id');
//     // dd($userId);

//     // Ambil keranjang dari session
//     $cart = Session::get('cart', []);
//     // dd($cart);

//     if (!$userId) {
//         return redirect()->route('cart.view')->with('error', 'Pengguna tidak ada.');
//     }
    
//     if (empty($cart)) {
//         return redirect()->route('cart.view')->with('error', 'Keranjang Anda kosong.');
//     }

//     // Hitung total harga
//     $totalAmount = array_reduce($cart, function ($carry, $item) {
//         return $carry + $item['price'] * $item['quantity'];
//     }, 0);
//     // dd($totalAmount);

//     // Mulai transaksi
//     DB::beginTransaction();
//     try {

//         // Mengambil data customer berdasarkan email dari permintaan
//     $customer = Customer::where('email', $request->customer_email)->first();
    
//     // Memeriksa apakah pengguna sudah login dengan guard 'customer'
//     if (!Auth::guard('customer')->check() && $customer) {
//         // Redirect ke halaman login dengan pesan error
//         return redirect()->route('customer.login')
//                          ->with('error', 'Silahkan Login Terlebih Dahulu');
//     }

//         // dd($customer);

//         // Simpan data pesanan
//         $order = Order::create([
//             'user_id' => $userId,
//             'customer_id' => $customer->id,
//             'customer_name' => $request->input('customer_name'),
//             'customer_email' => $request->input('customer_email'),
//             'shipping_address' => $request->input('shipping_address'),
//             'no_hp' => $request->input('no_hp'),
//             'catatan' => $request->input('catatan'),
//             'jenis_pembayaran' => $request->input('jenis_pembayaran'),
//             'total_amount' => $totalAmount,
//         ]);

//         $adminNumbers = []; // Untuk menyimpan nomor WhatsApp unik

//         // Simpan rincian item pesanan
//         foreach ($cart as $item) {
//             // Ambil user_id dari tabel product
//             $product = Product::find($item['id']);
//             $productUserId = $product ? $product->user_id : null;

//             Order_item::create([
//                 'user_id' => $productUserId, // Simpan user_id produk
//                 'order_id' => $order->id,
//                 'product_id' => $item['id'],
//                 'quantity' => $item['quantity'],
//                 'price' => $item['price'],
//             ]);

//             // Kurangi stok produk
//             if ($product) {
//                 $product->stok -= $item['quantity'];
//                 $product->save();
//             }

//             // Tambahkan nomor WhatsApp admin jika belum ada
//             if ($product && !in_array($product->whatsapp_number, $adminNumbers)) {
//                 $adminNumbers[] = $product->whatsapp_number;
//             }
//         }

//         // Simpan ID order
//         $orderId = $order->id;

//         // Simpan pesan sukses di session
//         $request->session()->flash('success', 'Pesanan Berhasil di Selesaikan.');

//         // Hapus item dari keranjang
//         Session::forget('cart');

//         DB::commit();

//         // Generate pesan untuk admin
//         $message = "Pesanan Baru!\n\n" .
//             "Order ID: $orderId\n" .
//             "Nama: " . $request->input('customer_name') . "\n" .
//             "Alamat: " . $request->input('shipping_address') . "\n" .
//             "No HP: " . $request->input('no_hp') . "\n" .
//             "Catatan: " . $request->input('catatan') . "\n" .
//             "Total: " . number_format($totalAmount, 0, ',', '.') . "\n";

//         // Redirect ke nomor WhatsApp admin
//         $whatsappUrls = array_map(function ($number) use ($message) {
//             return "https://api.whatsapp.com/send?phone=$number&text=" . urlencode($message);
//         }, $adminNumbers);

//         // Redirect ke URL WhatsApp pertama
//         return redirect()->to($whatsappUrls[0])->with('success', 'Pesanan Telah di Selesaikan.');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         // dd($e->getMessage()); // Uncomment to debug
//         return redirect()->route('cart.view')->with('error', 'Gagal Menempatkan Pesanan, Login Dulu .');
//     }
// }

}
