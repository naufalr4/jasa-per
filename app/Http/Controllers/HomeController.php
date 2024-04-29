<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Jasa;
use App\Models\Order;
use App\Models\Pembayaran;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $jasas = Jasa::skip(0)->take(8)->get();

        return view('home.index', compact('sliders', 'categories', 'jasas'));
    }

    public function Jasas($id_subcategory)
    {
        $jasas = Jasa::where('id_subkategori', $id_subcategory)->get();

        return view('home.jasas', compact('jasas'));
    }

    public function add_to_cart(Request $request)
    {
        $input = $request->all();
        Cart::create($input);
    }

    public function delete_from_cart(Cart $cart)
    {
        $cart->delete();
        return redirect('/cart');
    }

    public function Jasa($id_jasa)
    {
        $jasa = Jasa::find($id_jasa);
        $latest_jasas = Jasa::orderByDesc('created_at')->offset(0)->limit(10)->get();

        return view('home.jasa', compact('jasa', 'latest_jasas'));
    }

    public function cart()
    {
        if (!Auth::guard('webkonsumen')->user()) {
            return redirect('/login_konsumen');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $provinsi = json_decode($response);
        $carts = Cart::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Cart::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->where('is_checkout', 0)->sum('total');

        return view('home.cart', compact('carts', 'provinsi', 'cart_total'));
    }

    public function get_kota($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function get_ongkir($destination, $weight)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=22&destination=" . $destination . "&weight=" . $weight . "&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function checkout_orders(Request $request)
    {
        $id = DB::table('orders')->insertGetId([
            'invoice' => date('ymds'),
            'id_konsumen' => $request->id_konsumen,
            'grand_total' => $request->grand_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s'),

        ]);

        for ($i = 0; $i < count($request->id_jasa); $i++) {
            DB::table('orders_details')->insert([
                'id_order' => $id,
                'id_jasa' => $request->id_jasa[$i],
                'tgl_perbaikan' => date('Y-m-d H:i:s'),
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d H:i:s'),
                'jumlah' => $request->jumlah[$i],
            ]);
        }

        Cart::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->update([
            'is_checkout' => 1
        ]);
    }

    public function checkout()
    {
        $about = About::first();
        $orders = Order::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->first();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: e3171a515518ac6f5e817c3322879d97"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }

        $provinsi = json_decode($response);

        return view('home.checkout', compact('about', 'orders', 'provinsi'));
    }

    public function Pembayarans(Request $request)
    {
        Pembayaran::create([
            'id_order' => "$request->id_order",
            'id_konsumen' => Auth::guard('webkonsumen')->user()->id,
            'jumlah' => $request->jumlah,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'detail_alamat' => $request->detail_alamat,
            'status' => 'MENUNGGU',
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama,
            'bank' => $request->bank,
            'gambar' => $request->gambar,
        ]);

        return redirect('/orders');
    }

    public function orders()
    {
        $orders = Order::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->get();
        $Pembayarans = Pembayaran::where('id_konsumen', Auth::guard('webkonsumen')->user()->id)->get();
        return view('home.orders', compact('orders', 'Pembayarans'));
    }

    public function pesanan_selesai(Order $order)
    {
        $order->status = 'Selesai';
        $order->save();

        return redirect('/orders');
    }

    public function about()
    {
        $about = About::first();


        return view('home.about', compact('about'));
    }

    public function contact()
    {
        $about = About::first();

        return view('home.contact', compact('about'));
    }

    public function faq()
    {
        return view('home.faq');
    }
}
