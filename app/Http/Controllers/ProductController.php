<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Product;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request){
    
        if ($request->ajax()) {
        // Query untuk mendapatkan data Toko
        $query = Product::query();

        // Filter data jika pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            $query->where('user_id', Auth::user()->id);
        }

        $product = $query->get();

            return DataTables::of($product)
            ->addColumn('action', function ($product) {
                 
                $showBtn =  '<button ' .
                                ' class="btn btn-outline-info" ' .
                                ' onclick="showProducts(' . $product->id . ')">' .
                                '<i class="bi bi-eye-fill"></i>' .
                            '</button> ';
 
                $editBtn =  '<button ' .
                                ' class="btn btn-outline-success" ' .
                                ' onclick="editProducts(' . $product->id . ')">' .
                                 '<i class="ri-edit-2-line"></i>' .
                            '</button> ';
 
                $deleteBtn =  '<button ' .
                                ' class="btn btn-outline-danger" ' .
                                ' onclick="destroyProducts(' . $product->id . ')">' .
                                 '<i class="bi bi-trash-fill"></i>' .
                            '</button> ';
 
                return $showBtn . $editBtn . $deleteBtn;
              })
              ->addColumn('hasil', function($product){
                $harga = $product->harga;
                $diskon = $product->diskon;
                $hasil = $harga - ($harga * $diskon / 100);
                return 'Rp' . number_format($hasil, 0, ',', '.');
              })
           ->rawColumns(['action'])
            ->make(true);
    }

    $product = User::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('id', auth()->user()->id);
        })
        ->get();
        $toko = Toko::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
         ->get();
        $kategori = Kategori::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->get();
        $selectedUserId = Auth::user()->id;
    
    return view('product.index', compact('product','toko', 'kategori', 'selectedUserId'));
}

    public function store(Request $request){

    $request->validate([
        'user_id' => 'required',
        'toko_id' => 'required',
        'kategori_id' => 'required',
        'nama_product' => 'required|max:255',
        'deskripsi' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'kondisi' => 'required|string',
        'image' => 'required|image|mimes:png,jpg,jpeg',
        'stok' => 'required|integer',
    ]);

    $number = Toko::where('user_id', $request->user_id)->first();

    if($number){
        $number_whatsapp = $number->no_telepon;
    }else{
        $number_whatsapp = null;
    }

    $slug = $this->generateUniqueSlug($request->nama_product);

    $product = new Product();
    $product->user_id = $request->user_id;
    $product->toko_id = $request->toko_id;
    $product->kategori_id = $request->kategori_id;
    $product->nama_product = $request->nama_product;
    $product->slug = $slug;
    $product->deskripsi = $request->deskripsi;
    $product->harga = $request->harga;
    $product->diskon = $request->diskon;
    $product->kondisi = $request->kondisi;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('images', $imageName, 'public');
        $product->image = $imageName;
    }
    $product->stok = $request->stok;
    $product->whatsapp_number= $number_whatsapp;


    $product->save();
    
    return response()->json(['status' => "success"]);
   
}
public function show($id)
{
    // Temukan produk berdasarkan ID
    $product = Product::find($id);

    // Cek jika produk ditemukan
    if ($product) {
        // Ambil harga asli dan diskon
        $harga = $product->harga;
        $diskon = $product->diskon;

        // Jika diskon ada (lebih dari 0), hitung harga setelah diskon
        if ($diskon > 0) {
            $hargaSetelahDiskon = $harga - ($harga * $diskon / 100);
        } else {
            // Jika tidak ada diskon, harga setelah diskon sama dengan harga asli
            $hargaSetelahDiskon = $harga;
        }

        // Kembalikan respons JSON dengan produk dan harga setelah diskon
        return response()->json([
            'product' => $product,
            'harga_setelah_diskon' => number_format($hargaSetelahDiskon, 2), // Format angka dengan 2 desimal
        ]);
    } else {
        // Jika produk tidak ditemukan, kembalikan pesan error
        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }
}


   public function update(Request $request, $id)
{
    // Validasi input
    $validatedData = $request->validate([
        'user_id' => 'required',
        'toko_id' => 'required',
        'kategori_id' => 'required',
        'nama_product' => 'required|max:255',
        'deskripsi' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'diskon' => 'required',
        'kondisi' => 'required|string',
        'image' => 'nullable|string', // Expecting image as base64 encoded string
        'stok' => 'required|integer',

    ]);

    // Temukan produk berdasarkan ID
    $product = Product::find($id);
    $number = Toko::where('user_id', $request->user_id)->first();

    if (!$product) {
        return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
    }

    if($number){
        $number_whatsapp = $number->no_telepon;
    }else{
        $number_whatsapp = null;
    }

    // Perbarui atribut produk
    $product->user_id = $request->user_id;
    $product->toko_id = $request->toko_id;
    $product->kategori_id = $request->kategori_id;
    $product->nama_product = $request->nama_product;
    $product->deskripsi = $request->deskripsi;
    $product->harga = $request->harga;
    $product->diskon = $request->diskon;
    $product->kondisi = $request->kondisi;

    // Jika ada data URL gambar yang diterima
    if ($request->has('image')) {
        $image = $request->input('image');
        $imageData = explode(',', $image);
        
        if (count($imageData) == 2) {
            $imageType = explode(':', explode(';', $imageData[0])[0])[1];
            $imageExtension = explode('/', $imageType)[1];
            
            if (in_array($imageExtension, ['png', 'jpg', 'jpeg'])) {
                $imageName = time() . '.' . $imageExtension;
                $imagePath = storage_path('app/public/images/' . $imageName);
                file_put_contents($imagePath, base64_decode($imageData[1]));
                $product->image = $imageName;
            } else {
                return response()->json(['status' => 'error', 'message' => 'Jenis Gambar Tidak Valid'], 422);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Jenis Gambar Tidak Valid'], 422);
        }
    }

    $product->stok = $request->stok;
    $product->whatsapp_number = $number_whatsapp;

    // Simpan perubahan pada produk
    $product->save();

    // Kembalikan respons sukses
    return response()->json(['status' => 'success']);
}
     public function destroy($id)
    {
        $product = Product::find($id);
    if ($product) {
        $product->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Product Tidak Ada']);
    }
    }

    private function generateUniqueSlug($name)
{
    // Membuat slug dasar dari nama
    $slug = Str::slug($name);
    $originalSlug = $slug;

    // Jika slug sudah ada, tambahkan UUID agar benar-benar unik
    if (Product::where('slug', $slug)->exists()) {
        $slug = "{$originalSlug}-" . Str::uuid(); // Menggunakan UUID untuk memastikan keunikan
    }

    return $slug;
}

}
