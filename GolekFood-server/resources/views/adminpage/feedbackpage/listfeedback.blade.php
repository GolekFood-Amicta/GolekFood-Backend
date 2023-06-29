@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data Feedback Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Feedback Pengguna</li>
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
                                <form class="py-3 " action="{{ route('search-feedback') }}" method="GET">
                                    <div class="row justify-content-end">
                                        <div class="col-md-3">
                                            <input type="text" name="search" class="form-control"  required/>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                                
                                <table id="myTable" class="table table-striped border-primary table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Email</th>
                                            <th>Subject</th>
                                            <th>Content</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataFeedback as $key => $feedback)
                                            <tr>
                                                <td>{{ $dataFeedback->firstitem() + $key }}</td>
                                                <td>{{ $feedback->user->email }}</td>
                                                <td>{{ $feedback->subject }}</td>
                                                <td>{{ $feedback->content }}</td>   
                                                <td>{{ $feedback->created_at->format('d/m/Y') }}</td>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">empty</td>
                                            </tr>
                                        @endforelse

                                        

                                    </tbody>

                                </table>

            
                                

                                <div class="p-3">
                                    {!! $dataFeedback->render() !!}
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