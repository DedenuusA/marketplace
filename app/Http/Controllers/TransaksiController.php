<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index(Request $request){

        
        if ($request->ajax()){
            $query = Order::query();

            if(Auth::user()->role == 'admin'){
                $query->where('user_id', Auth::user()->id);
            }

            $transaksi = $query->get();

            return DataTables::of($transaksi)
            ->addColumn('action', function($transaksi){
               $showBtn = '<button ' .
           'class="btn btn-outline-info" ' .
           'onclick="showTransaksi(' . $transaksi->id . ')">' .
           '<i class="bi bi-eye-fill"></i>' .
           '</button> ';

$deleteBtn = '<button ' .
             'class="btn btn-outline-danger" ' .
             'onclick="destroyTransaksi(' . $transaksi->id . ')">' .
             '<i class="bi bi-trash-fill"></i>' .
             '</button> ';
            $slug = json_encode($transaksi->slug);
            $slug = str_replace('"', "'", $slug);
$printBtn = '<button ' .
            'class="btn btn-outline-primary" ' .
            'onclick="printTransaksi(' . $slug . ')">' .
            '<i class="ri-printer-fill"></i>' .
            '</button>';

                return $showBtn . $deleteBtn . $printBtn;
              })
           ->rawColumns(['action'])
            ->make(true);
        }
        $transaksi = Order::all();
        return view('/transaksi.index', compact('transaksi'));
    }

  public function show($orderId)
{
    $orderItems = Order_item::with(['product', 'user','order'])
        ->where('order_id', $orderId)
        ->get();

    return response()->json(['orderItems' => $orderItems]);
}
public function destroy($id)
    {
        $transaksi = Order::find($id);
    if ($transaksi) {
        $transaksi->delete();
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'message' => 'Transaksi Tidak Ada']);
    }
    }

    public function getPDF($type, $slug)
{
    $order = Order::where('slug', $slug)->first();

    $pdf = Pdf::loadView('checkout.invoice', compact('order'));

    if ($type == 'stream') {
        return $pdf->stream('transaksi-' . $slug . '.pdf');
    }

    return $pdf->download('transaksi-' . $slug . '.pdf');
}

// public function update(Request $request, $id){
    
//     request()->validate([
//         'customer_name' => 'required',
//         'customer_email' => 'required',
//         'shipping_address' => 'required',
//         'no_hp' => 'required',
//         'catatan' => 'required',
//         'jenis_pembayaran' => 'required',
//         'total_amount' => 'required',
//         'status' => 'required',
//     ]);

//     $transaksi = Order::find($id);
//     $transaksi->customer_name = $request->customer_name;
//     $transaksi->customer_email = $request->customer_email;
//     $transaksi->shipping_address = $request->shipping_address;
//     $transaksi->no_hp = $request->no_hp;
//     $transaksi->catatan = $request->catatan;
//     $transaksi->jenis_pembayaran = $request->jenis_pembayaran;
//     $transaksi->total_amount = $request->total_amount;
//     $transaksi->status = $request->status;
//     $transaksi->save();
//     return response()->json(['message' => "success"]);
// }

public function showtransaksi($id)
    {
        $transaksi = Order::find($id);
        return response()->json(['transaksi' => $transaksi]);
    }

public function updateStatus(Request $request)
{
    // Validasi ID transaksi
    $transaction = Order::find($request->id);

    // Periksa apakah transaksi ditemukan
    if (!$transaction) {
        // Mengembalikan respons error jika transaksi tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Transaksi tidak ditemukan.',
        ], 404);
    }

    // Mengupdate status transaksi jika ditemukan
    $transaction->status = $request->status;
    $transaction->save();

    // Mengembalikan respons sukses
    return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);
}
}
