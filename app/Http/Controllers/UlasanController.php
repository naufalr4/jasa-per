<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UlasanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $this->middleware('auth');
        return view('ulasan.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ulasans = Ulasan::all();

        return response()->json([
            'data' => $ulasans
        ]);
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

            'id_perbaikan' => 'required',
            'id_konsumen' => 'required',
            'nama_jasa' => 'required',
            'nama_barang' => 'required',
            'kerusakan' => 'required',
            'jenis_perbaikan' => 'required',
            'deskripsi' => 'required',
            'rating' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $Ulasan = Ulasan::create($input);

        return response()->json([
            'success' => true,
            'data' => $Ulasan
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ulasan  $Ulasan
     * @return \Illuminate\Http\Response
     */
    public function show(Ulasan $Ulasan)
    {
        return response()->json([
            'success' => true,
            'data' => $Ulasan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ulasan  $Ulasan
     * @return \Illuminate\Http\Response
     */
    public function edit(Ulasan $Ulasan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ulasan  $Ulasan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ulasan $Ulasan)
    {

        $validator = Validator::make($request->all(), [
            'id_perbaikan' => 'required',
            'id_konsumen' => 'required',
            'nama_jasa' => 'required',
            'nama_barang' => 'required',
            'kerusakan' => 'required',
            'jenis_perbaikan' => 'required',
            'deskripsi' => 'required',
            'rating' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();


        $Ulasan->update($input);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $Ulasan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ulasan  $Ulasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ulasan $Ulasan)
    {

        $Ulasan->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
