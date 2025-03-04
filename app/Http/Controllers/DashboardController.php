<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Pelanggan;
use App\Models\Product;
use App\Models\Toko;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $toko = Toko::count();
        $transaksi = Order::count();
        $revenue = Order::sum('total_amount');

        return view('dashboard',compact(['toko','transaksi','revenue']));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() {
        Auth::logout();
        return redirect()->route('login.index')->with('success', 'Anda Berhasil Keluar');
    }


//    public function dashboard()
// {
//     /** PIE CHART */
//     $rows = Product::selectRaw('nama_product, COUNT(*) AS total')
//         ->join('order_items', 'products.id', '=', 'order_items.product_id')
//         ->groupBy('nama_product')->get();
//     $pie = [];
//     foreach ($rows as $row) {
//         $pie[] = [
//             'name' =>  $row->nama_product,
//             'y' =>  $row->total,
//         ];
//     }

//     /** LINE CHART: Pendapatan Harian */
//     $daily_sales = Order_item::selectRaw('DATE(orders.created_at) AS date, SUM(orders.total_amount) AS total_amount')
//         ->join('orders', 'order_items.order_id', '=', 'orders.id')
//         ->groupBy('date')
//         ->orderBy('date')
//         ->get();

//     $line = [];
//     foreach ($daily_sales as $sale) {
//         $line['dates'][] = $sale->date; // Menggunakan format tanggal
//         $line['data'][] = $sale->total_amount;
//     }

//     /** COLUMN CHART */
//     $rows = Order_item::selectRaw('nama_kategori, YEAR(orders.created_at) AS year, MONTH(orders.created_at) AS month, SUM(quantity) AS total')
//         ->join('orders', 'order_items.order_id', '=', 'orders.id')
//         ->join('products', 'order_items.product_id', '=', 'products.id')
//         ->join('kategoris', 'products.kategori_id', '=', 'kategoris.id')
//         ->groupByRaw('nama_kategori, YEAR(orders.created_at), MONTH(orders.created_at)')
//         ->get();

//     $column = [];
//     foreach ($rows as $row) {
//         $column['kategoris'][$row->year . '-' . $row->month] = $row->year . '-' . $row->month;
//         $column['series'][$row->nama_kategori]['name'] = $row->nama_kategori;
//         $column['series'][$row->nama_kategori]['data'][$row->year . '-' . $row->month] = $row->total;
//     }
//     foreach ($column['series'] as $key => $val) {
//         $column['series'][$key]['data'] = array_values($val['data']);
//     }
//     $column['kategoris'] = array_values($column['kategoris']);
//     $column['series'] = array_values($column['series']);
    
//     /** PRODUCTS SOLD */
//     $products_sold = Product::select('nama_product')
//         ->join('order_items', 'products.id', '=', 'order_items.product_id')
//         ->groupBy('nama_product')
//         ->get();

//     return view('test', compact('pie', 'line', 'column', 'products_sold'));
// }


    // public function test()
    // {
    // 	$data = DB::table('users')->get();
    // 	return view('test', compact('data'));
    // }

    // function action(Request $request)
    // {
    // 	if($request->ajax())
    // 	{
    // 		if($request->action == 'edit')
    // 		{
    // 			$data = array(
    // 				'status'	=>	$request->status,
    // 			);
    // 			DB::table('orders')
    // 				->where('id', $request->id)
    // 				->update($data);
    // 		}
    // 		return response()->json($request);
    // 	}
    // }
}

