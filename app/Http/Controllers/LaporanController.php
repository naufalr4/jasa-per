<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
     public function __construct()
     {
          $this->middleware('auth:api', ['except' => 'index']);
     }

     public function index(Request $request)
     {
          $laporan = DB::table('orders_details')
               ->join('jasas', 'jasas.id', '=', 'orders_details.id')
               ->select(DB::raw('
        nama_barang,
        jasas.nama_jasa,
        count(*) as jumlah_perbaikan,
        SUM(total_estimasi_harga) as pendapatan'))
               ->whereRaw("date(orders_details.created_at) >= '$request->dari'")
               ->whereRaw("date(orders_details.created_at) <= '$request->sampai'")
               ->groupBy('id_jasa', 'nama_barang', 'jasas.nama_jasa', 'estimasi_harga')
               ->get();

          return response()->json([
               'data' => $laporan
          ]);
     }
}
