<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class UserController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
        // Query untuk mendapatkan data Toko
        $query = User::query();

        // Filter data jika pengguna adalah admin
        if (Auth::user()->role == 'admin') {
            $query->where('id', Auth::user()->id);
        }

        $user = $query->get();

            return FacadesDataTables::of($user)
            ->addColumn('action', function ($user) {
                 
                $showBtn =  '<button ' .
                                ' class="btn btn-outline-info" ' .
                                ' onclick="showUsers(' . $user->id . ')">' .
                                '<i class="bi bi-eye-fill"></i>' .
                            '</button> ';
 
                $editBtn =  '<button ' .
                                ' class="btn btn-outline-success" ' .
                                ' onclick="editUsers(' . $user->id . ')">' .
                                 '<i class="ri-edit-2-line"></i>' .
                            '</button> ';
                $deleteBtn =  '<button ' .
                                ' class="btn btn-outline-danger" ' .
                                ' onclick="destroyUsers(' . $user->id . ')">' .
                                '<i class="bi bi-trash-fill"></i>' .
                            '</button> ';

                return $showBtn . $editBtn . $deleteBtn;
                })
            ->rawColumns(['action'])
            ->make(true);
    }

    $user = User::all();
    return view('user.index', compact('user'));
}
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            'no_telepon' => 'required',
            'role' => 'required|string',
            'jenis_kelamin' => 'required',
        ]);
  
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->no_telepon = $request->no_telepon;
        $user->role = $request->role;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->save();
        return response()->json(['status' => "success"]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        request()->validate([
            // 'toko_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|string|max:255',
            'no_telepon' => 'required',
            'jenis_kelamin' => 'required',
            'role' => 'required',
        ]);
  
        $user = User::find($id);
        // $user->toko_id = $request->toko_id;
        $user->name = $request->name;
        $user->email = $request->email;
        // $user->password = Hash::make($request->password);
        $user->no_telepon = $request->no_telepon;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->role = $request->role;
        $user->save();
        return response()->json(['status' => "success"]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
    if ($user) {
        $user->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'User tidak di temukan']);
    }
    }

    public function profileUser(){
        $profile = User::where('id', auth()->user()->id)
        ->first();
        return view('user.profile', compact('profile'));
    }


}
