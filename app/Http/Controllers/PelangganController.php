<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class PelangganController extends Controller
{
     public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Pelanggan::query();

        if (Auth::user()->role == 'admin') {
            $query->where('user_id', Auth::user()->id);
        }

       $pelanggan = $query->get();

        return FacadesDataTables::of($pelanggan)
            ->addColumn('action', function ($pelanggan) {
                $showBtn = '<button ' .
                            ' class="btn btn-outline-info" ' .
                            ' onclick="showPelanggans(' .$pelanggan->id . ')">' .
                            '<i class="bi bi-eye-fill"></i>' .
                            '</button> ';
 
                $editBtn = '<button ' .
                            ' class="btn btn-outline-success" ' .
                            ' onclick="editPelanggans(' .$pelanggan->id . ')">' .
                            '<i class="ri-edit-2-line"></i>' .
                            '</button> ';
 
                $deleteBtn = '<button ' .
                            ' class="btn btn-outline-danger" ' .
                            ' onclick="destroyPelanggans(' .$pelanggan->id . ')">' .
                            '<i class="bi bi-trash-fill"></i>' .
                            '</button> ';
 
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

       $pelanggan = Pelanggan::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('user_id', auth()->user()->id);
        })
        ->get();
    return view('pelanggan.index', compact('pelanggan'));
}

    public function store(Request $request){

        request()->validate([
            'nama_pelanggan' => 'required|max:255',
            'email' => 'required',
            'telepon' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
        ]);
  
        $user = Toko::where('user_id', auth()->user()->id)->first();
        $userId = $user->user_id;
        
       $pelanggan = new Pelanggan();
       $pelanggan->user_id = $userId;
       $pelanggan->nama_pelanggan = $request->nama_pelanggan;
       $pelanggan->alamat = $request->alamat;
       $pelanggan->telepon = $request->telepon;
       $pelanggan->jenis_kelamin = $request->jenis_kelamin;
       $pelanggan->email = $request->email;
       $pelanggan->save();
        return response()->json(['status' => "success"]);
    }
    
 public function show($id)
    {
       $pelanggan = Pelanggan::find($id);
        return response()->json(['pelanggan' => $pelanggan]);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'nama_pelanggan' => 'required|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|string',
            'nama_owner' => 'required|string',
        ]);
        
  
       $pelanggan = Pelanggan::find($id);
       $pelanggan->user_id = $request->user_id;
       $pelanggan->nama_pelanggan = $request->nama_pelanggan;
       $pelanggan->alamat = $request->alamat;
       $pelanggan->telepon = $request->telepon;
       $pelanggan->jenis_kelamin = $request->jenis_kelamin;
       $pelanggan->email = $request->email;
       $pelanggan->save();
        return response()->json(['status' => "success"]);
    }

    public function destroy($id)
    {
       $pelanggan = Pelanggan::find($id);
    if ($pelanggan) {
       $pelanggan->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Pelanggan Tidak Ada']);
    }
    }
    
}

