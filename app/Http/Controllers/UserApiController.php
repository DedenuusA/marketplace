<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserApiController extends Controller
{
    public function userapi(){
        $user = User::all();
        return response()->json(['data' => $user]);
    }

     public function login(Request $request)
    {
        // Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Mencari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah user ditemukan dan password valid
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Menghasilkan token sederhana
        $token = 'asu';

        // Simpan token ke dalam database (misalnya di tabel users atau di tabel lain yang berhubungan)
        $user->remember_token = $token;
        $user->save();

        // Kembalikan token dalam response
        return response()->json([
            'message' => 'Login successful',
            'data' => $user,
            'token' => $token,
        ]);
    }
}