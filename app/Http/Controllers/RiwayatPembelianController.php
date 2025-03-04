<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RiwayatPembelianController extends Controller
{
  public function index(Request $request)
{
   // Mengambil status dari input, default 'belum_bayar'
    $status = $request->input('status', 'belum-bayar');
    
    // Mengambil pesanan berdasarkan status untuk pelanggan yang sedang login
    $orders = Order::where('customer_id', auth()->guard('customer')->user()->id)
                   ->where('status', $status)
                   ->orderBy('created_at', 'DESC')
                   ->paginate(10);

    // Memuat relasi 'orderItems' pada setiap pesanan
    $orders->load('orderItems'); // Jika relasi sudah diatur di model Order
    
    // Mengambil rating terkait pesanan berdasarkan product_id
    $ratings = Review::where('customer_id', auth()->guard('customer')->user()->id)
                     ->get()
                     ->keyBy('product_id'); // Mengasumsikan rating terkait dengan product_id

    // Mengembalikan tampilan dengan data yang telah diambil
    return view('customer.riwayatpembelian', [
        'orders' => $orders,
        'customer' => auth()->guard('customer')->user(),
        'ratings' => $ratings,
        'status' => $status,
    ]);
}

 public function getRating($productId)
    {
        $rating = review::where('product_id', $productId)->where('customer_id', auth()->guard('customer')->user()->id)->first();
        return response()->json(['rating' => $rating ? $rating->rating : 0]);
    }

public function getOrderDetails($order_item_id)
{
    $orderItem = Order_item::with('order')->find($order_item_id);

    if (!$orderItem) {
        return response()->json(['message' => 'Prosess'], 404);
    }

    return view('order.details', compact('orderItem'))->render();
}


}