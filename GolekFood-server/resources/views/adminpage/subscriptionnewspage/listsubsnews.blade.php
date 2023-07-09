@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data Langganan Berita</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Langganan Berita</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-3">
                            <!-- card -->

                            @if (session()->has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <div class="row p-3 border border-primary ">
                                <div class="col py-3">
                                    <a class="btn btn-primary" href="{{ route('create-langganan-news') }}" role="button">
                                        <i class="bi bi-plus">Tulis Berita ke Mailist</i>
                                    </a>
                                </div>

                                <form class="col py-3 " action="{{ route('search-langganan-news') }}" method="GET">
                                    <div class="row justify-content-end">
                                        <div class="col-md-6">
                                            <input type="text" name="search" class="form-control"  required/>
                                        </div>
                                        <div class="col-md-6">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <h5 class="pt-3 text-bold">Mailist Berlangganan</h5>
                                <p class="pb-1">total : {{ $dataSubscriptionNews->count() }}</p>

                                <table id="myTable" class="table table-striped border-primary table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataSubscriptionNews as $key => $subscriptionNews)
                                            <tr>
                                                <td>{{ $dataSubscriptionNews->firstitem() + $key }}</td>
                                                <td>{{ $subscriptionNews->email }}</td>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center">empty</td>
                                            </tr>
                                        @endforelse

                                        

                                    </tbody>

                                </table>

            
                                

                                <div class="p-3">
                                    {!! $dataSubscriptionNews->render() !!}
                                </div>
                            
                            
                            </div>

                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection