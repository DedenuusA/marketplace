<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Komentar;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use App\Models\review;
use App\Models\Toko;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MarketPlaceController extends Controller
{
    public function index()

     {
        // Mendapatkan semua toko
        $tokos = Toko::all();
        
        // Hitung jumlah toko
        $totalTokos = $tokos->count();
        
        // Tentukan toko yang aktif berdasarkan hari ini
        // Misalnya, kita gunakan hari ke berapa dalam bulan ini untuk menentukan toko
        $dayOfMonth = now()->minute; // Bisa juga gunakan month atau year sesuai kebutuhan
        $activeTokoIndex = ($dayOfMonth / 4) % $totalTokos; // Menghindari index out of range

        $activeToko = $tokos[$activeTokoIndex];

        $tokoId = $activeToko->id;
        
        $product = Product::where('toko_id', $tokoId)
            ->with('kategori', 'toko', 'reviews')
            ->withCount('orderItem')
            ->paginate(8);

          foreach ($product as $item) {
            $totalRating = $item->reviews->sum('rating');
            $totalReviews = $item->reviews->count();
            $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
            $item->averageRating = $averageRating;
}

// $harga = 500000;
// $diskon = 30;
// $total = $harga * $diskon / 100;
// $hasil = $harga - $total;
// dd($hasil);

        return view('marketplace.index', [
            'product' => $product,
            'activeToko' => $activeToko,
           
        ]);
    }

    public function test(){
        return view('/customer.login');
    }

    public function view(){
        
        return view('contack.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success', 'Anda Telah Logout.');
    }

    public function testimonial(){
        $komentar = review::with('customer','order')->get();
        return view('marketplace.testimonial', compact('komentar'));
    }

}

