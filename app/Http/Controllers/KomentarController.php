<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KomentarController extends Controller
{
    public function index(Request $request){
        request()->validate([
            'nama' => 'required',
            'email' => 'required',
            'pesan' => 'required',
        ]);

        $komentar = new Komentar();
        $komentar->nama = $request->nama;
        $komentar->email = $request->email;
        $komentar->pesan= $request->pesan;
        $komentar->save();
        return response()->json(['success' => true]);
    }

    public function view(){
        if (request()->ajax()) {
            $komentar = Komentar::query();
            return DataTables::of($komentar)
            ->addColumn('action', function ($komentar){
                $deleteBtn = '<button ' .
                ' class="btn btn-outline-danger" ' .
                ' onclick="destroyKomentars(' . $komentar->id . ')">' .
                ' <i class="bi bi-trash-fill"></i>' .
                ' </button> ';

                return $deleteBtn;
            })

            ->rawColumns(['action'])
            ->make();
    
        }
        $komentar = Komentar::all();
        return view('komentar.index', compact('komentar'));
    }

    public function destroy($id)
    {
        $komentar = Komentar::find($id);
        if($komentar) {
            $komentar->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
