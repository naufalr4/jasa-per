@extends('layout.home')

@section('title', 'Cart')

@section('content')
<!-- Cart -->
<section class="section-wrap shopping-cart">
    <div class="container relative">
        <form class="form-cart">
            <input type="hidden" name="id_konsumen" value="{{Auth::guard('webkonsumen')->user()->id}}">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrap mb-30">
                        <table class="shop_table cart table">
                            <thead>
                                <tr>
                                    
                                    <th class="jasa-name" colspan="2">jasa</th>
                                    <th class="jasa-harga">harga</th>
                                    <th class="jasa-jumlah">jumlah</th>
                                    <th class="jasa-subtotal" colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                <input type="hidden" name="id_jasa[]" value="{{$cart->jasa->id}}">
                                <input type="hidden" name="jumlah[]" value="{{$cart->jumlah}}">
                                <input type="hidden" name="total[]" value="{{$cart->total}}">
                                <tr class="cart_item">
                                   
                                      <td class="jasa-name">
                                        <a href="#">{{$cart->jasa->nama_jasa}}</a>
                                        
                                    </td>
                                   <td></td>
                                    <td class="jasa-harga">
                                        <span class="amount">{{ "Rp. " . number_format($cart->jasa->estimasi_harga)}}</span>
                                    </td>
                                    <td class="jasa-jumlah">
                                        <span class="amount">{{ $cart->jumlah }}</span>
                                    </td>
                                    <td class="jasa-subtotal">
                                        <span class="amount">{{ "Rp. " . number_format($cart->total)}}</span>
                                    </td>
                                    <td class="jasa-remove">
                                        <a href="/delete_from_cart/{{$cart->id}}" class="remove"
                                            title="Remove this item">
                                            <i class="ui-close"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-50">
                        <div class="col-md-5 col-sm-12">
                        </div>
                        <div class="col-md-7">
                            <div class="actions">
                                <div class="wc-proceed-to-checkout">
                                    <a href="#" class="btn btn-lg btn-dark checkout"><span>proceed to
                                            checkout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end col -->
            </div> <!-- end row -->

            <div class="row">
               
                   
                </div> <!-- end col shipping calculator -->

                <div class="col-md-6">
                    <div class="cart_totals">
                        <h2 class="heading relative bottom-line full-grey uppercase mb-30">Cart Totals</h2>

                        <table class="table shop_table">
                            <tbody>
                                <tr class="cart-subtotal">
                                    <th>Cart Subtotal</th>
                                    <td>
                                        <span class="amount cart-total">{{$cart_total}}</span>
                                    </td>
                                </tr>
                               
                                <tr class="order-total">
                                    <th>Order Total</th>
                                    <td>
                                        <input type="hidden" name="grand_total" class="grand_total">
                                        <strong><span class="amount grand-total">0</span></strong>
                                    </td>
                                </tr>

                                 <p>
                        <a href="#" name="calc_shipping" class="btn btn-lg btn-stroke mt-10 mb-mdm-40 update-total"
                            style="padding: 20px 40px">
                            Update Totals
                        </a>
                    </p>
                            </tbody>
                        </table>

                    </div>
                </div> <!-- end col cart totals -->

            </div> <!-- end row -->
        </form>

    </div> <!-- end container -->
</section> <!-- end cart -->
@endsection

@push('js')
<script>
    $(function(){
            $('.provinsi').change(function(){
                $.ajax({
                    url : '/get_kota/' + $(this).val(),
                    success : function (data){
                        data = JSON.parse(data)
                        option = ""
                        data.rajaongkir.results.map((kota)=> {
                            option += `<option value=${kota.city_id}>${kota.city_name}</option>`
                        })
                        $('.kota').html(option)
                    }
                });
            });

            $('.update-total').click(function(e){
                e.preventDefault()
                $.ajax({
                    url : '/get_ongkir/' + $('.kota').val(9) + '/' + $('.berat').val(1),
                    success : function (data){
                        data = JSON.parse(data)

                        grandtotal = parseInt($('.cart-total').text())

                        $('.shipping-cost').text(grandtotal)
                        $('.grand-total').text(grandtotal)
                        $('.grand_total').val(grandtotal)
                    }
                });
            });

            $('.checkout').click(function(e){
                e.preventDefault()
                $.ajax({
                    url : '/checkout_orders',
                    method : 'POST',
                    data : $('.form-cart').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}",
                    },
                    success : function(){
                        location.href = '/checkout'
                    }
                })
            })
        });
</script>
@endpush
