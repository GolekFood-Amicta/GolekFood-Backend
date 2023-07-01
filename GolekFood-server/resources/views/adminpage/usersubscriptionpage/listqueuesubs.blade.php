@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data Antrean Subscription</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Antrean Subscription</li>
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
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataSubs as $key => $subscription)
                                            <tr>
                                                <td>{{ $dataSubs->firstitem() + $key }}</td>
                                                <td>{{ $subscription->user->email }}</td>
                                                <td>{{ $subscription->subscription }}</td>
                                                <td>
                                                    <a href="{{ $subscription->urlImage }}" class="btn btn-outline-warning">Lihat Bukti</a>
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

                                                <td>{{ $subscription->created_at->format('d/m/Y') }}</td>



                                                <td>
                                                    <div class="container">
                                                        <div class="row justify-content-start">
                                                            <div class=" px-1 py-1">

                                                                <form action="{{ route('list-usersubs.update', ['list_usersub' => $subscription->id]) }}"
                                                                    method="post">

                                                                    @csrf
                                                                    @method('put')
                                                                    <button class="btn btn-success"
                                                                        onclick="return confirm('Apakah Anda yakin ingin Approve subscription ini?')">
                                                                        <i class="bi bi-check-circle text-white"> Approve Subscription</i>
                                                                    </button>
                                                                </form>

                                                       


                                                            </div>
                                                            <div class=" px-1 py-1">
                                                                <form
                                                                    action=" {{ route('list-usersubs.destroy', ['list_usersub' => $subscription->id]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button class="btn btn-danger"
                                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data Antrean ini?')">
                                                                        <i class="bi bi-trash3 ">Decline Subscription</i>
                                                                    </button>


                                                                </form>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </td>
                                               
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">empty</td>
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
