<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CustomerLoginController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('customer.login'); // Pastikan path view sesuai
    }

    /**
     * Menangani proses login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check_login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal!'
            ], 401);
        }
    }

    public function checklogin(Request $request){
       return response()->json([
        'logged_in' => Auth::guard('customer')->check()
       ], 201);
    }
}