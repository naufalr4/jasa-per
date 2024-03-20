<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

use function Ramsey\Uuid\v1;

class PembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {

        return view('pembayaran.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Pembayaran::all();

        return response()->json([
            'data' => $categories
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
            'tanggal' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time()  . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $Pembayaran = Pembayaran::create($input);

        return response()->json([
            'success' => true,
            'data' => $Pembayaran
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $Pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $Pembayaran)
    {
        return response()->json([
            'data' => $Pembayaran
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $Pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $Pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembayaran  $Pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $Pembayaran)
    {

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }



        $Pembayaran->update([
            'status' => request('status')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $Pembayaran
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $Pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $Pembayaran)
    {

        File::delete('uploads/' . $Pembayaran->gambar);
        $Pembayaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
