<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
   public function index()
{
    // Ambil data profil customer yang sedang login
    $profile = Customer::where('id', auth()->guard('customer')->id())->first();
    
    return view('customer.profil', compact('profile'));
}

public function updateProfile(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'alamat' => 'nullable|string',
        'jenis_kelamin' => 'nullable|string|in:laki-laki,perempuan',
        'phone_number' => 'nullable|string|max:15',
    ]);

    // Dapatkan customer yang sedang login
    $customer = auth()->guard('customer')->user();

    // Update data customer
    $customer->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'phone_number' => $request->phone_number,
    ]);

    return response()->json(['message' => true]); // Kembalikan data customer sebagai respons
}

public function updatePassword(Request $request)
{
    // Validasi input
    $request->validate([
        'password' => 'required',
        'newpassword' => 'required|min:3',
        'renewpassword' => 'required|same:newpassword',
    ]);

    // Ambil user yang sedang login
    $customer = auth()->guard('customer')->user();

    // Verifikasi password lama
    if (!Hash::check($request->password, $customer->password)) {
        return response()->json(['message' => false, 'error' => 'Password lama tidak sesuai.']);
    }

    // Update password baru
    $customer->update([
        'password' => Hash::make($request->newpassword),
    ]);

    return response()->json(['message' => true]);
}

public function UploadImageCustomer(Request $request){
     $request->validate([
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Mengambil user yang sedang login
    $customer = auth()->guard('customer')->user();

    // Menyimpan gambar
    $imageName = time().'.'.$request->profile_image->extension();  
    $request->profile_image->move(public_path('images'), $imageName);

    // Update path gambar di tabel users
    $customer->gambar = 'images/' . $imageName;
    $customer->save();

    return response()->json(['success' => true, 'new_image_url' => asset($customer->gambar)]);
}
}
