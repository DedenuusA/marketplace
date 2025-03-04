<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProsesCheckoutController extends Controller
{
    public function prosescheckout(){

        // Ambil customer_id dari pengguna yang sedang login
    $customerId = Auth::guard('customer')->id();
    $customer = Auth::guard('customer')->user();

    // Ambil data keranjang berdasarkan customer_id
    $cart = Cart::where('customer_id', $customerId)->get();

    // Kirim data keranjang ke tampilan
    return view('checkout.prosescheckout', ['cart' => $cart, 'customer' => $customer]);
    }

   public function checkoutcustomer(Request $request)
{
    // Validasi data request
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'shipping_address' => 'required|string|max:1000',
        'no_hp' => 'required|string',
        'catatan' => 'nullable|string',
        'jenis_pembayaran' => 'required|string|in:transfer,cod',
    ]);

    // Ambil ID customer dari auth
    $customerId = Auth::guard('customer')->id();
    

    // Ambil data cart dari tabel cart berdasarkan customer_id
    $cartItems = Cart::where('customer_id', $customerId)->get();

    // Cek jika cart kosong
    if ($cartItems->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Keranjang Anda kosong.'
        ]);
    }

    // Hitung total amount
    $totalAmount = $cartItems->sum(function ($item) {
        $harga = $item->product->harga;
        $diskon = $item->product->diskon;

        // Jika ada diskon, kurangi harga dengan diskon
        if ($diskon > 0) {
            $hasil = $harga - ($harga * $diskon / 100);
        } else {
            $hasil = $harga;
        }

        // Kalikan hasil dengan quantity
        return $hasil * $item->quantity;
    });

    DB::beginTransaction();
    try {
        // Dapatkan atau buat customer
        $customer = Customer::firstOrCreate(
            ['email' => $request->customer_email],
            ['name' => $request->customer_name]
        );

        if (!Auth::guard('customer')->check() && !$customer->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Login Terlebih Dahulu'
            ]);
        }

        // Ambil user_id dari item cart pertama (asumsi semua item cart memiliki user_id yang sama)
        $userId = $cartItems->first()->user_id;

        // Generate slug untuk order
        $slug = $this->generateUniqueSlug($request->customer_name);

        $order = Order::create([
            'user_id' => $userId,
            'customer_id' => $customer->id,
            'customer_name' => $request->customer_name,
            'slug' => $slug,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'no_hp' => $request->no_hp,
            'catatan' => $request->catatan,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'total_amount' => $totalAmount,
        ]);
        
        $adminNumbers = [];

        // Simpan item pesanan dan update stok
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                Order_item::create([
                    'user_id' => $product->user_id,
                    'order_id' => $order->id, // Gunakan satu order yang sudah dibuat
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->harga,
                ]);

                // Kurangi stok produk
                $product->decrement('stok', $item->quantity);

                if (!in_array($product->toko->no_telepon, $adminNumbers)) {
                    $adminNumbers[] = $product->toko->no_telepon;
                }
            }
        }

        // Hapus cart dari database
        Cart::where('customer_id', $customerId)->delete();

        DB::commit();

        // Generate PDF link
        $pdfUrl = url('/generate-pdf/stream/' . $order->slug);

        // Siapkan pesan untuk admin
        $message = "Pesanan Baru!\n\n" .
            "Order ID: $order->id\n" .
            "Nama: " . $request->customer_name . "\n" .
            "Alamat: " . $request->shipping_address . "\n" .
            "No HP: " . $request->no_hp . "\n" .
            "Catatan: " . $request->catatan . "\n" .
            "Total: " . number_format($totalAmount, 0, ',', '.') . "\n" .
            "Link PDF: " . $pdfUrl;

        // Buat URL WhatsApp
        $whatsappUrls = array_map(function ($number) use ($message) {
            return "https://api.whatsapp.com/send?phone=$number&text=" . urlencode($message);
        }, $adminNumbers);

        // Kembalikan respons JSON dengan URL WhatsApp pertama
        // return response()->json([
        //     'success' => true,
        //     'whatsapp_url' => $whatsappUrls[0]
        // ]);
        return redirect()->to($whatsappUrls[0])->with('success', 'Pesanan Telah di Selesaikan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Gagal Menempatkan Pesanan.'
        ]);
    }
}


private function generateUniqueSlug($name)
{
    // Membuat slug dasar dari nama
    $slug = Str::slug($name);
    $originalSlug = $slug;

    // Jika slug sudah ada, tambahkan UUID agar benar-benar unik
    if (Order::where('slug', $slug)->exists()) {
        $slug = "{$originalSlug}-" . Str::uuid(); // Menggunakan UUID untuk memastikan keunikan
    }

    return $slug;
}

}