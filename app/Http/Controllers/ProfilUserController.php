<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilUserController extends Controller
{
    public function index(){
        return view('bantuan.index');
    }
   public function uploadImage(Request $request)
{
    $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Mengambil user yang sedang login
    $user = Auth::user();

    // Menyimpan gambar
    $imageName = time().'.'.$request->profile_image->extension();  
    $request->profile_image->move(public_path('images'), $imageName);

    // Update path gambar di tabel users
    $user->gambar = 'images/' . $imageName;
    $user->save();

    return response()->json(['success' => true, 'new_image_url' => asset($user->gambar)]);
}

public function updateProfilUser(Request $request){

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'alamat' => 'nullable|string',
        'jenis_kelamin' => 'nullable|string|in:laki-laki,perempuan',
        'no_telepon' => 'nullable|string|max:15',
    ]);

    // Dapatkan customer yang sedang login
    $user = Auth::user();

    // Update data customer
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'no_telepon' => $request->no_telepon,
    ]);

    return response()->json(['message' => true]);
}
public function UpdatePasswordUser(Request $request)
{
    // Validasi input
    $request->validate([
        'password' => 'required',
        'newpassword' => 'required|min:3',
        'renewpassword' => 'required|same:newpassword',
    ]);

    // Ambil user yang sedang login
    $user = Auth::user();

    // Verifikasi password lama
    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['message' => false, 'error' => 'Password lama tidak sesuai.']);
    }

    // Update password baru
    $user->update([
        'password' => Hash::make($request->newpassword),
    ]);

    return response()->json(['message' => true]);
}

}
