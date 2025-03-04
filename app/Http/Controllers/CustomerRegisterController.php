<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterController extends Controller
{
    public function index(){
        return view('/customer.register');
    }

    public function store(Request $request){
        $nama = $request->input('nama');
        $email = $request->input('email');
        $password = $request->input('password');
        $phone_number = $request->input('phone_number');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $alamat = $request->input('alamat');

        $customer = Customer::create([
            'nama'      => $nama,
            'email'     => $email,
            'password'  => Hash::make($password),
            'phone_number' => $phone_number,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
        ]);

        if($customer) {
            return response()->json([
                'success' => true,
                'message' => 'Register Berhasil!'
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register Gagal!'
            ], 400);
        }
        
    }
}
