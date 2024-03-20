<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);


        if (auth()->attempt($credentials)) {
            $token = Auth::guard('api')->attempt($credentials);
            return response()->json([
                'success' => 'true',
                'message' => 'Login Berhasil',
                'token' => $token
            ]);
        }

        return response()->json([
            'success' => 'false',
            'message' => 'email atau password salah'
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
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

    public function login_konsumen()
    {
        return view('auth.login_konsumen');
    }

    public function login_konsumen_action(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/login_konsumen');
        }

        $credentials = $request->only('email', 'password');
        $Konsumen = Konsumen::where('email', $request->email)->first();
        if ($Konsumen) {
            //  if (Auth::guard('webkonsumen')->attempt($credentials)) {

            if (Hash::check($request->password, $Konsumen->password)) {
                $request->session()->regenerate();
                echo "login berhasil";
            } else {
                Session::flash('failed', "Password salah");
                return redirect('/login_konsumen');
            }
        } else {
            Session::flash('failed', "Email Tidak ditemukan");
            return redirect('/login_konsumen');
        }
    }

    public function register_konsumen()
    {
        return view('auth.register_konsumen');
    }

    public function register_konsumen_action(Request $request)
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
            Session::flash('errors', $validator->errors()->toArray());
            return redirect('/register_konsumen');
        }

        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        unset($input['konfirmasi_password']);
        Konsumen::create($input);

        Session::flash('success', 'Account successfully created!');
        return redirect('/login_konsumen');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }

    public function logout_konsumen()
    {
        Auth::guard('webkonsumen')->logout();
        Session::flush();
        return redirect('/');
    }
}
