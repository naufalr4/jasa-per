@extends('layout.home')

@section('title', 'Checkout')

@section('content')
<!-- Checkout -->
<section class="section-wrap checkout pb-70">
    <div class="container relative">
        <div class="row">

            <div class="ecommerce col-xs-12">

                <form name="checkout" class="checkout ecommerce-checkout row" method="POST" action="/pembayarans">
                    @csrf
                    <input type="hidden" name="id_order" value="{{$orders->id}}">
                    <div class="col-md-8" id="customer_details">
                        <div>
                            <h2 class="heading uppercase bottom-line full-grey mb-30">alamat pembayaran</h2>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">Provinsi
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <select name="provinsi" id="provinsi" class="country_to_state provinsi"
                                    rel="calc_shipping_state">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinsi->rajaongkir->results as $provinsi)
                                    <option value="{{$provinsi->province_id}}">{{$provinsi->province}}</option>
                                    @endforeach
                                </select>
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">Kota
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <select name="kota" id="kota" class="country_to_state kota"
                                    rel="calc_shipping_state">

                                </select>
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">Detail Alamat
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder value name="detail_alamat"
                                    id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">Atas Nama
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder value name="atas_nama"
                                    id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">No Rekening
                                    
                                </label>
                                <input type="text" class="input-text" placeholder value name="no_rekening"
                                    id="billing_first_name">
                            </p>
                             <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">bank
                                    
                                </label>
                                <input type="text" class="input-text" placeholder value name="bank"
                                    id="billing_first_name">
                            </p>
                            <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">Nominal Transfer
                                    <abbr class="required" title="required">*</abbr>
                                </label>
                                <input type="text" class="input-text" placeholder value name="jumlah"
                                    id="billing_first_name">
                            </p>
                             <p class="form-row form-row-first validate-required ecommerce-invalid ecommerce-invalid-required-field"
                                id="billing_first_name_field">
                                <label for="billing_first_name">bank
                                    
                                </label>
                                <input type="file" class="input-textx" placeholder value name="gambar"
                                    id="billing_first_name">
                            </p>

                            <div class="clear"></div>

                        </div>

                        <div class="clear"></div>

                    </div> <!-- end col -->

                    <!-- Your Order -->
                    <div class="col-md-4">
                        <div class="order-review-wrap ecommerce-checkout-review-order" id="order_review">
                            <h2 class="heading uppercase bottom-line full-grey"><a href="/orders">Orderan Kamu</a></h2>
                            <table class="table shop_table ecommerce-checkout-review-order-table">
                                <tbody>
                                    <tr class="order-total">
                                        <th><strong>Order Total</strong></th>
                                        <td>
                                            <strong><span class="amount">Rp.
                                                    {{number_format($orders->grand_total)}}</span></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div id="payment" class="ecommerce-checkout-payment">
                                <h2 class="heading uppercase bottom-line full-grey">Metode Pembayaran</h2>
                                <ul class="payment_methods methods">

                                    <li class="payment_method_bacs">
                                        
                                        <label for="payment_method_bacs"> Transfer Bank</label>
                                        
                                            <p>Silahkan Melakukan Pembayaran Melalui Rekening bank tertera dibawah.</p>
                                            <p>Atas Nama : {{$about->atas_nama}}</p>
                                            <p>No Rekening : {{$about->no_rekening}}</p>
                                            <p>Bank : {{$about->bank}}</p>
                               
                                    </li>
                                    <li class="payment_method_cod">
                                       
                                        <label for="payment_method_bacs"> COD</label>
                                      
                                            <p>Silahkan Melakukan Pembayaran Langsung Kepada Teknisi.</p>

                                    </li>
                                </ul>
                                <div class="form-row place-order">
                                    <input type="submit" name="ecommerce_checkout_place_order"
                                        class="btn btn-lg btn-dark" id="place_order" value="Bayar">
                                </div>
                            </div>
                        </div>
                    </div> <!-- end order review -->
                </form>

            </div> <!-- end ecommerce -->

        </div> <!-- end row -->
    </div> <!-- end container -->
</section> <!-- end checkout -->
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
        })
</script>
@endpush
