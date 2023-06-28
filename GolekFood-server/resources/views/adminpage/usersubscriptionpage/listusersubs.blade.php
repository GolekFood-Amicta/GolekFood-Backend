@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data Subscription</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Subscription</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
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

                                <table id="myTable" class="table table-striped border-primary table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Email</th>
                                            <th>Subscription</th>
                                            <th>Bukti</th>
                                            <th>Status</th>
                                            <th>Tanggal Awal Subs</th>
                                            <th>Tanggal Berakhir Subs</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataSubs as $key => $subscription)
                                            <tr>
                                                <td>{{ $dataSubs->firstitem() + $key }}</td>
                                                <td>{{ $subscription->user->email }}</td>
                                                <td>{{ $subscription->subscription }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-outline-warning">Lihat Bukti</button>
                                                </td>

                                                @if (($subscription->status) == 'Active')
                                                <td class="bg-success text-white">
                                                    {{ $subscription->status }}
                                                </td>
                                                @elseif (($subscription->status) == 'Inactive')
                                                <td class="bg-primary text-white">
                                                    {{ $subscription->status }}
                                                </td>
                                                @endif

                                                <td>{{ $subscription->subscription_start }}</td>
                                                <td>{{ $subscription->subscription_end }}</td>


                                                
                                               
                                                
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">empty</td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                                <div class="p-3">
                                    {!! $dataSubs->render() !!}
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
