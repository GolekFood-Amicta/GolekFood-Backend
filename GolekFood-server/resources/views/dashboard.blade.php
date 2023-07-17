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
                    <div class="p-2">
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    </div>
                    @endif

                    @if (session()->has('error'))
                    <div class="p-2">
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->email_verified_at == null)
                    <div class="p-2">
                        <div class="alert alert-danger p-3" role="alert">
                            Email belum diverifikasi, silahkan cek email anda untuk verifikasi. atau kirim ulang 
                            <a href="{{ route('verification.send') }}" role="button">
                                disini
                            </a>
                        </div>
                    </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span>| User</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6> {{ $info['totalUser'] }} </h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                            
                        </div><!-- End Sales Card -->

                        <div class="row">
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span class="text">|
                                                Antrean Subscription</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6 class="text"> {{ $info['subscription']['inactive'] }}</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span>| Subscription</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6> {{ $info['subscription']['active'] }} </h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                        </div>
                        <div class="row">
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span>| News</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-newspaper"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6> {{ $info['features']['totalNews'] }} </h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span>| Feedback</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6> {{ $info['features']['totalFeedback'] }}</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->
                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6 mt-5">
                                <div class="card info-card sales-card">

                                    <div class="card-body">
                                        <h5 class="card-title">Total <span>| Hasil Survey</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-broadcast"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6> {{ $info['features']['totalSurvey'] }} </h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End Sales Card -->


                        </div>

                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->

    </div>
</section>


@endsection
 