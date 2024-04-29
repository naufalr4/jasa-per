@extends('layout.home')

@section('title', 'Checkout')

@section('content')
<!-- Checkout -->
<section class="section-wrap checkout pb-70">
    <div class="container relative">
        <div class="row">

            <div class="ecommerce col-xs-12">
                <h2>My Payments</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nominal Transfer</th>
                        <th>Status</th>
                        <th>Gambar</th>
                    </thead>
                    <tbody>
                        @foreach ($Pembayarans as $index => $pembayaran)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td>{{$pembayaran->created_at}}</td>
                            <td>Rp. {{($pembayaran->jumlah)}}</td>
                            <td>{{$pembayaran->status}}</td>
                            <td>{{$pembayaran->gambar}}</td>
                          
                        </tr>
                        @endforeach
                    </tbody>
                  
        
                </table>

                <h2>My Orders</h2>
                <table class="table table-ordered table-hover table-striped">
                    <thead>
                        <th>No</th>
                        <th>Jasa</th>
                        <th>Tanggal</th>
                        <th>Grand Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                        <th>pembayaran</th>
                    </thead>
                    <tbody>
                        @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{$index+1}}</td>
                             <td>{{$order->id_jasa}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>Rp. {{number_format($order->grand_total)}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <form action="/pesanan_selesai/{{$order->id}}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">SELESAI</button>
                                </form>
                            </td>
                            <td> <a href="/checkout" class="btn btn-warning">Bayar</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- end ecommerce -->

        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end checkout -->
@endsection

