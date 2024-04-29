@extends('layout.home')

@section('title', 'About')

@section('content')
<!-- Intro -->
<section class="section-wrap intro pb-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-8 mb-50">
                <h2 class="intro-heading">Jasa Perbaikan Elektronik</h2>
                <p>{{$about->deskripsi}}</p>
            </div>
           
        </div>
        <hr class="mb-0">
    </div>
</section> <!-- end intro -->



@endsection
