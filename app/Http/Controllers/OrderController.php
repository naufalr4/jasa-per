<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy', 'ubah_status', 'baru', 'dikonfirmasi', 'diproses', 'diperbaiki', 'diterima', 'selesai']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = order::with('konsumen')->get();
        $jasas = order::with('jasa')->get();

        return response()->json([
            'data' => $orders, $jasas

        ]);
    }

    public function list()
    {
        $jasas = Jasa::all();
        return view('perbaikan.index', compact('jasas'));
    }

    public function dikonfirmasi_list()
    {
        return view('perbaikan.dikonfirmasi');
    }

    public function diproses_list()
    {
        return view('perbaikan.diproses');
    }

    public function diperbaiki_list()
    {
        return view('perbaikan.diperbaiki');
    }

    public function diterima_list()
    {
        return view('perbaikan.diterima');
    }

    public function selesai_list()
    {
        return view('perbaikan.selesai');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [


            'id_jasa' => 'required',
            'tgl_perbaikan' => 'required',
            'total' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $order = order::create($input);

        for ($i = 0; $i < count($input['id_perbaikan']); $i++) {
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_jasa' => $input['id_jasa'][$i],
                'tgl_perbaikan' => $input['tgl_perbaikan'][$i],
                'total' => $input['total'][$i],
                'jumlah' => $input['jumlah'][$i],
            ]);
        }
        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
    {
        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {

        $validator = Validator::make($request->all(), [
            'id_order' => 'required',
            'id_jasa' => 'required',
            'tgl_perbaikan' => 'required',
            'total' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();
        $order->update($input);

        OrderDetail::where('id_order', $order['id'])->delete();

        for ($i = 0; $i < count($input['id_order']); $i++) {
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_jasa' => $input['id_jasa'][$i],
                'tgl_perbaikan' => $input['tgl_perbaikan'][$i],
                'total' => $input['total'][$i],
                'jumlah' => $input['jumlah'][$i],
            ]);
        }

        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function ubah_status(Request $request, order $order)
    {
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function baru()
    {

        $orders = order::with('konsumen')->where('status', 'Baru')->get();
        $jasas = order::with('jasa')->where('status', 'Baru')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    public function dikonfirmasi()
    {

        $orders = order::with('konsumen')->where('status', 'Dikonfirmasi')->get();
        $jasas = order::with('jasa')->where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    public function diproses()
    {

        $orders = order::with('konsumen')->where('status', 'Diproses')->get();
        $jasas = order::with('jasa')->where('status', 'Diproses')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    public function diperbaiki()
    {

        $orders = order::with('konsumen')->where('status', 'Diperbaiki')->get();
        $jasas = order::with('jasa')->where('status', 'Diperbaiki')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    public function diterima()
    {

        $orders = order::with('konsumen')->where('status', 'Diterima')->get();
        $jasas = order::with('jasa')->where('status', 'Diterima')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    public function selesai()
    {

        $orders = order::with('konsumen')->where('status', 'Selesai')->get();
        $jasas = order::with('jasa')->where('status', 'Selesai')->get();

        return response()->json([
            'data' => $orders, $jasas
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        File::delete('uploads/' . $order->gambar);
        $order->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}
