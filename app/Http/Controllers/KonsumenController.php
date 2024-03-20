<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class KonsumenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $Konsumens = Konsumen::all();

        return response()->json([
            'data'=> $Konsumens
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
            'nama_konsumen' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'konfirmasi_password' => 'required|same:password',
            'provinsi' => 'required',
            'kota/Kab' => 'required',
            'kecamatan' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
             $validator->errors(),
            422    
            );
           
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        unset($input['konfirmasi_password']);
        $Konsumen = Konsumen::create($input);

        return response()->json([
            'data' => $Konsumen
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Konsumen  $Konsumen
     * @return \Illuminate\Http\Response
     */
    public function show(Konsumen $Konsumen)
    {
        return response()->json([
            'data' => $Konsumen
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Konsumen  $Konsumen
     * @return \Illuminate\Http\Response
     */
    public function edit(Konsumen $Konsumen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Konsumen  $Konsumen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Konsumen $Konsumen)
    {

        $validator = Validator::make($request->all(), [
            'nama_konsumen' => 'required',
            'email' => 'required',
            'password' => 'required',
            'provinsi' => 'required',
            'kota/Kab' => 'required',
            'kecamatan' => 'required',
            'alamat' => 'required',
            'no_tlp' => 'required'
            
            
        ]);

        if ($validator->fails()) {
            return response()->json(
             $validator->errors(),
            422    
            );
           
        }

        $input = $request->all();

       


        $Konsumen->update($input);

        return response()->json([
            'message' => 'success',
            'data' => $Konsumen
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Konsumen  $Konsumen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Konsumen $Konsumen)
    {
     
        $Konsumen->delete();
        
        return response()->json([
            'message' => 'success'
        ]);
    }
}
