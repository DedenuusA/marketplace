<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;
use Illuminate\Support\Str;


class KategoriController extends Controller
{
    public function index(Request $request){
        
       if ($request->ajax()) {
        // Query untuk mendapatkan data Toko
        $query = Kategori::query();

        // Filter data jika pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            $query->where('user_id', Auth::user()->id);
        }

        $kategori = $query->get();

            return FacadesDataTables::of($kategori)
            ->addColumn('action', function ($kategori) {
                 
                $showBtn =  '<button ' .
                                ' class="btn btn-outline-info" ' .
                                ' onclick="showKategoris(' . $kategori->id . ')">' .
                                '<i class="bi bi-eye-fill"></i>' .
                            '</button> ';
 
                $editBtn =  '<button ' .
                                ' class="btn btn-outline-success" ' .
                                ' onclick="editKategoris(' . $kategori->id . ')">' .
                                '<i class="ri-edit-2-line"></i>' .
                            '</button> ';
 
                $deleteBtn =  '<button ' .
                                ' class="btn btn-outline-danger" ' .
                                ' onclick="destroyKategoris(' . $kategori->id . ')">' .
                                '<i class="bi bi-trash-fill"></i>' .
                            '</button> ';
 
                return $showBtn . $editBtn . $deleteBtn;
            })
           ->rawColumns(['action'])
            ->make(true);
    }

    $kategori = User::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('id', auth()->user()->id);
        })
        ->get();
        $toko = Toko::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->get();
        $selectedUserId = Auth::user()->id;

    return view('kategori.index', compact('kategori', 'toko', 'selectedUserId'));
}
    public function store(Request $request)
    {
        request()->validate([
            'user_id' => 'required',
            'toko_id' => 'required',
            'nama_kategori' => 'required|max:255',
        ]);

        $slug = $this->generateUniqueSlug($request->nama_kategori);
        
        $kategori = new Kategori();
        $kategori->user_id = $request->user_id;
        $kategori->toko_id = $request->toko_id;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->slug = $slug;
        $kategori->save();
        return response()->json(['status' => "success"]);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        return response()->json(['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'user_id' => 'required',
            'toko_id' => 'required',
            'nama_kategori' => 'required|max:255',
        ]);
  
        $kategori = Kategori::find($id);
        $kategori->user_id = $request->user_id;
        $kategori->toko_id = $request->toko_id;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        return response()->json(['status' => "success"]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
    if ($kategori) {
        $kategori->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Kategori Tidak Ada']);
    }
    }

    private function generateUniqueSlug($name)
{
    // Membuat slug dasar dari nama
    $slug = Str::slug($name);
    $originalSlug = $slug;

    // Jika slug sudah ada, tambahkan UUID agar benar-benar unik
    if (Kategori::where('slug', $slug)->exists()) {
        $slug = "{$originalSlug}-" . Str::uuid(); // Menggunakan UUID untuk memastikan keunikan
    }

    return $slug;
}
    
}
