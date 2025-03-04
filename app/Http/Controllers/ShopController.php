<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Product;
use App\Models\Toko;
use Illuminate\Http\Request;

class ShopController extends Controller
{
     public function index(){
        $tokos = Toko::all();
        $categories = Kategori::all();
        // $featuredProducts = Product::where('id', true)->get();
        
        // Hitung jumlah toko
        $totalTokos = $tokos->count();
        
        // Tentukan toko yang aktif berdasarkan hari ini
        // Misalnya, kita gunakan hari ke berapa dalam bulan ini untuk menentukan toko
        $dayOfMonth = now()->minute; // Bisa juga gunakan month atau year sesuai kebutuhan
        $activeTokoIndex = ($dayOfMonth / 4) % $totalTokos; // Menghindari index out of range

        // Ambil toko aktif
        $activeToko = $tokos[$activeTokoIndex];

        // Ambil ID toko aktif
        $tokoId = $activeToko->id;

        // Ambil produk dari toko aktif
       $products = Product::where('toko_id', $tokoId)
            ->with('kategori', 'toko', 'reviews')
            ->withCount('orderItem')
            ->paginate(12);

            foreach ($products as $item) {
            $totalRating = $item->reviews->sum('rating');
            $totalReviews = $item->reviews->count();
            $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
            $item->averageRating = $averageRating;
            }
        

        // Kirim data toko dan produk ke view
        return view('shop.index', [
            'products' => $products,
            'activeToko' => $activeToko,
            'categories' => $categories,
            // 'featuredProducts' => $featuredProducts,

        ]);

    }

    public function show($slug)
{
    // Ambil kategori berdasarkan slug
    $category = Kategori::where('slug', $slug)->firstOrFail(); // Mengambil satu kategori atau return 404 jika tidak ditemukan
    $categories = Kategori::all();

    // Ambil barang berdasarkan kategori
    $items = Product::where('kategori_id', $category->id) // Menggunakan ID kategori dari hasil query sebelumnya
        ->with('kategori')
        ->get();

    // Ambil semua toko
    $tokos = Toko::all();
    $totalTokos = $tokos->count();

    // Tentukan toko yang aktif berdasarkan menit saat ini (bisa disesuaikan ke hari atau lainnya)
    $minuteOfHour = now()->minute; 
    $activeTokoIndex = $minuteOfHour % $totalTokos; // Menggunakan modulo untuk mencegah out of range index

    // Ambil toko aktif
    $activeToko = $tokos[$activeTokoIndex];

    // Ambil ID toko aktif
    $tokoId = $activeToko->id;

    // Ambil produk dari toko aktif
    $products = Product::where('toko_id', $tokoId)
        ->with('kategori', 'toko', 'reviews')
        ->withCount('orderItem')
        ->paginate(12);

    // Hitung rating rata-rata untuk setiap produk
    foreach ($products as $item) {
        $totalRating = $item->reviews->sum('rating');
        $totalReviews = $item->reviews->count();
        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;
        $item->averageRating = $averageRating; // Simpan rata-rata rating ke item
    }

    // Kembalikan view dengan data kategori, barang, toko aktif, dan produk
    return view('shop.kategori', [
        'categories' => $categories,
        'items' => $items,
        'activeToko' => $activeToko,
        'products' => $products
    ]);
}

public function search(Request $request)
{
    // Ambil query pencarian dari input
    $query = $request->input('q');

    // Cari produk berdasarkan nama, deskripsi, atau properti lain yang sesuai
    $products = Product::where('nama_product', 'LIKE', '%' . $query . '%')
        ->orWhere('deskripsi', 'LIKE', '%' . $query . '%')
        ->with('kategori', 'toko')
        ->paginate(8);

    // Tampilkan hasil pencarian di view yang sama atau view berbeda
    return view('shop.search_result', [
        'products' => $products,
        'query' => $query
    ]);
}


}
