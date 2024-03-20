<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\jasa_perbaikan;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use function Ramsey\Uuid\v1;

class JasaPerbaikanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('jasa-perbaikan.index', compact('categories', 'subcategories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jasa_perbaikan = jasa_Perbaikan::with('category', 'subcategory')->get();


        return response()->json([
            'data' => $jasa_perbaikan
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

            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_jasa' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg',
            'deskripsi' => 'required',
            'Jam_Buka' => 'required',
            'estimasi_harga' => 'required'


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

        $jasa_perbaikans = jasa_perbaikan::create($input);

        return response()->json([
            'success' => true,
            'data' => $jasa_perbaikans
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\_  $_
     * @return \Illuminate\Http\Response
     */
    public function show(jasa_perbaikan $jasa_perbaikan)
    {
        return response()->json([
            'success' => true,
            'data' => $jasa_perbaikan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\_  $_
     * @return \Illuminate\Http\Response
     */
    public function edit(jasa_perbaikan $jasa_perbaikan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\_  $_
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, jasa_perbaikan $jasa_perbaikan)
    {

        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_jasa' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg',
            'deskripsi' => 'required',
            'Jam_Buka' => 'required',
            'estimasi_harga' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $jasa_perbaikan->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time()  . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }


        $jasa_perbaikan->update($input);

        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $jasa_perbaikan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\_  $_
     * @return \Illuminate\Http\Response
     */
    public function destroy(jasa_perbaikan $jasa_perbaikan)
    {
        File::delete('uploads/' . $jasa_perbaikan->gambar);
        $jasa_perbaikan->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
