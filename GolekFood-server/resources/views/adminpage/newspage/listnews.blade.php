@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data News</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data News</li>
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
                                            <th>Judul</th>
                                            <th>Author</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataNews as $key => $news)
                                            <tr>
                                                <td>{{ $dataNews->firstitem() + $key }}</td>
                                                <td>{{ $news->title }}</td>
                                                <td>{{ $news->user->email }}</td>
                                                <td>{{ $news->created_at }}</td>   
                                                <td>Ini button</td>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">empty</td>
                                            </tr>
                                        @endforelse

                                        

                                    </tbody>

                                </table>

                                {!! $dataNews->render() !!}
                            </div>

                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection