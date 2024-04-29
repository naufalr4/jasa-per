@extends('layout.home')

@section('title', 'jasa')

@section('content')

<!-- Single jasa -->
<section class="section-wrap pb-40 single-product">
    <div class="container-fluid semi-fluid">
        <div class="row">

            <div class="col-md-6 col-xs-12 product-slider mb-60">

                <div class="flickity flickity-slider-wrap mfp-hover" id="gallery-main">

                    <div class="gallery-cell">
                        <a href="/uploads/{{$jasa->gambar}}" class="lightbox-img">
                            <img src="/uploads/{{$jasa->gambar}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$jasa->gambar}}" class="lightbox-img">
                            <img src="/uploads/{{$jasa->gambar}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$jasa->gambar}}" class="lightbox-img">
                            <img src="/uploads/{{$jasa->gambar}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$jasa->gambar}}" class="lightbox-img">
                            <img src="/uploads/{{$jasa->gambar}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                    <div class="gallery-cell">
                        <a href="/uploads/{{$jasa->gambar}}" class="lightbox-img">
                            <img src="/uploads/{{$jasa->gambar}}" alt="" />
                            <i class="ui-zoom zoom-icon"></i>
                        </a>
                    </div>
                </div> <!-- end gallery main -->

                <div class="gallery-thumbs">
                    <div class="gallery-cell">
                        <img src="/uploads/{{$jasa->gambar}}" alt="" />
                    </div>
                   
                </div> <!-- end gallery thumbs -->

            </div> <!-- end col img slider -->

            <div class="col-md-6 col-xs-12 product-description-wrap">
                <ol class="breadcrumb">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="/jasas/{{$jasa->id_subkategori}}">{{$jasa->subcategory->nama_subcategory}}</a>
                    </li>
                    <li class="active">
                        Jasa
                    </li>
                </ol>
                <h1 class="product-title">{{$jasa->nama_jasa}}</h1>
                <span class="price">
                    <ins>
                        <span class="amount">Estimasi harga Rp. {{number_format($jasa->estimasi_harga)}}</span>
                    </ins>
                </span>
               


                <div class="product-actions">
                    <span>Qty:</span>

                    <div class="quantity buttons_added">
                        <input type="number"  value="1" title="Qty"
                            class="input-text jumlah qty text" />
                        <div class="quantity-adjust">
                            <a href="#" class="plus">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            <a href="#" class="minus">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>

                    <a href="#" class="btn btn-dark btn-lg add-to-cart"><span>Tambah Ke Keranjang</span></a>

                 
                </div>

                <div class="product_meta">    
                    <span class="brand_as">Category: <a href="#">{{$jasa->category->nama_kategori}}</a></span>
                </div>

                <!-- Accordion -->
                <div class="panel-group accordion mb-50" id="accordion">
                    <div class="panel">
                        <div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                class="minus">Deskripsi<span>&nbsp;</span>
                            </a>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                {{$jasa->deskripsi}}
                            </div>
                            <div class="panel-body">
                               <a href=" https://wa.me/{{$jasa->no_tlp}}?text=Halo,%20saya ingin menanyakan mengenai jasa anda " </a>Silahkan Hubungi Kami Jika Ada Pertanyaan
                            </div>
                        </div>
                    </div>
                </div>
                
                

              
            </div> <!-- end col product description -->
        </div> <!-- end row -->

    </div> <!-- end container -->
</section> <!-- end single product -->


<!-- Related Products -->
<section class="section-wrap pt-0 shop-items-slider">
    <div class="container">
        <div class="row heading-row">
            <div class="col-md-12 text-center">
                <h2 class="heading bottom-line">
                    Jasa Lainnya
                </h2>
            </div>
        </div>

        <div class="row">

            <div id="owl-related-items" class="owl-carousel owl-theme">
                @foreach ($latest_jasas as $jasa)
                <div class="product">
                    <div class="product-item hover-trigger">
                        <div class="product-img">
                            <a href="/jasa/{{$jasa->id}}">
                                <img src="/uploads/{{$jasa->gambar}}" alt="">
                                <img src="/uploads/{{$jasa->gambar}}" alt="" class="back-img">
                            </a>
                            
                            <div class="hover-2">
                                <div class="product-actions">
                                    <a href="#" class="product-add-to-wishlist">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="/jasa/{{$jasa->id}}" class="product-quickview">More</a>
                        </div>
                        <div class="product-details">
                            <h3 class="product-title">
                                <a href="/jasa/{{$jasa->id}}">{{$jasa->nama_jasa}}</a>
                            </h3>
                            <span class="category">
                                <a
                                    href="/jasas/{{$jasa->id_subkategori}}">{{$jasa->subcategory->nama_subcategory}}</a>
                            </span>
                        </div>
                        <span class="price">
                            <ins>
                                <span class="amount">Rp. {{number_format($jasa->estimasi_harga)}}</span>
                            </ins>
                        </span>
                    </div>
                </div>
                @endforeach
            </div> <!-- end slider -->

        </div>
    </div>
</section> <!-- end related products -->

@endsection


@push('js')
<script>
    $(function(){
        $('.add-to-cart').click(function(e){
            id_konsumen = {{Auth::guard('webkonsumen')->user()->id}}
            id_jasa = {{$jasa->id}}
            jumlah = $('.jumlah').val()
            total = {{$jasa->estimasi_harga}}*jumlah
            is_checkout = 0

            $.ajax({
                url : '/add_to_cart',
                method : "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}",
                },
                data : {
                    id_konsumen,
                    id_jasa,
                    jumlah,
                    total,
                    is_checkout,
                },
                success : function(data){
                    window.location.href = '/cart'
                }
            });
        })
    })

</script>
@endpush
