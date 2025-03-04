<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class KeranjangController extends Controller
{
    public function index(Request $request) {

    if ($request->ajax()) {
        $query = Cart::with('product'); // Menggunakan relasi untuk mengambil data produk

        if (Auth::user()->role == 'admin') {
            $query->where('user_id', Auth::user()->id);
        }

        $keranjang = $query->get();

        return DataTables::of($keranjang)
            // ->addColumn('action', function($keranjang) {
            //     $showBtn = '<button class="btn btn-outline-info" onclick="showkeranjangkeranjang(' . $keranjang->id . ')">' .
            //                '<i class="bi bi-eye-fill"></i>' .
            //                '</button> ';

            //     $deleteBtn = '<button class="btn btn-outline-danger" onclick="destroykeranjangkeranjang(' . $keranjang->id . ')">' .
            //                  '<i class="bi bi-trash-fill"></i>' .
            //                  '</button> ';

            //     return $showBtn . $deleteBtn;
            // })
            ->addColumn('image', function ($keranjang){
                return $keranjang->product->image;
            })
            ->addColumn('product_name', function($keranjang) {
                return $keranjang->product->nama_product; // Mengambil nama produk dari relasi
            })
            ->addColumn('harga', function($keranjang){
                return $keranjang->product->harga;
            })
            ->addColumn('diskon', function($keranjang){
                return $keranjang->product->diskon . '%';
            })
            ->addColumn('hasil', function($keranjang){
                $harga = $keranjang->product->harga;
                $diskon = $keranjang->product->diskon;
                $hasil = $harga - ($harga * $diskon / 100);
                return 'Rp' . number_format($hasil, 0, ',', '.');
            })
            ->addColumn('customer_name', function($keranjang){
                return $keranjang->customer->nama;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $keranjang = Cart::all();
    return view('/keranjang.index', compact('keranjang'));
}
}