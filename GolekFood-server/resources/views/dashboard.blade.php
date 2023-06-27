@extends('layouts.main')
@section('container')

<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">
                <div class="card">
                    @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                    <div class="card-body">
                        //buatkan card untuk menampilan jumlah data feedback, jumlah data news, jumlah user yang terdaftar
                    
                        


                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->

    </div>
</section>


@endsection
 