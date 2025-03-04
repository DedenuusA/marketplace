<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class TokoController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        // Query untuk mendapatkan data Toko
        $query = Toko::query();

        // Filter data jika pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            $query->where('user_id', Auth::user()->id);
        }

        $toko = $query->get();

        return FacadesDataTables::of($toko)
            ->addColumn('action', function ($toko) {
                $showBtn = '<button ' .
                            ' class="btn btn-outline-info" ' .
                            ' onclick="showTokos(' . $toko->id . ')">' .
                            '<i class="bi bi-eye-fill"></i>' .
                            '</button> ';
 
                $editBtn = '<button ' .
                            ' class="btn btn-outline-success" ' .
                            ' onclick="editTokos(' . $toko->id . ')">' .
                             '<i class="ri-edit-2-line"></i>' .
                            '</button> ';
 
                $deleteBtn = '<button ' .
                            ' class="btn btn-outline-danger" ' .
                            ' onclick="destroyTokos(' . $toko->id . ')">' .
                             '<i class="bi bi-trash-fill"></i>' .
                            '</button> ';
 
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

        $toko = User::
        when(Auth::user()->role == 'admin', function($query) {
            $query->where('id', auth()->user()->id);
        })
        ->get();
        $selectedUserId = Auth::user()->id;
    return view('toko.index', compact('toko','selectedUserId'));
}

    public function store(Request $request){

        request()->validate([
            'user_id' => 'required|string',
            'nama_toko' => 'required|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required',
            'email' => 'required|string',
            'nama_owner' => 'required|string',
        ]);
  
        $toko = new Toko();
        $toko->user_id = $request->user_id;
        $toko->nama_toko = $request->nama_toko;
        $toko->alamat = $request->alamat;
        $toko->no_telepon = $request->no_telepon;
        $toko->email = $request->email;
        $toko->nama_owner = $request->nama_owner;
        $toko->save();
        return response()->json(['status' => "success"]);
    }
    
 public function show($id)
    {
        $toko = Toko::find($id);
        return response()->json(['toko' => $toko]);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'user_id' => 'required',
            'nama_toko' => 'required|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required',
            'email' => 'required|string',
            'nama_owner' => 'required|string',

        ]);
  
        $toko = Toko::find($id);
        $toko->user_id = $request->user_id;
        $toko->nama_toko = $request->nama_toko;
        $toko->alamat = $request->alamat;
        $toko->no_telepon = $request->no_telepon;
        $toko->email = $request->email;
        $toko->nama_owner = $request->nama_owner;
        $toko->save();
        return response()->json(['status' => "success"]);
    }

    public function destroy($id)
    {
        $toko = Toko::find($id);
    if ($toko) {
        $toko->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Toko Tidak Ada']);
    }
    }
    
}

