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

                            <div class="row">
                                <div class="col py-3">
                                    <a class="btn btn-success" href="{{ route('create-news') }}" role="button">
                                        <i class="bi bi-plus">Tambah News</i>
                                    </a>
                                </div>

                                <div class="col">
                                    <form class="py-3 " action="{{ route('search-news') }}" method="GET">
                                        <div class="row justify-content-end">
                                            <div class="col-md-3">
                                                <input type="text" name="search" class="form-control"  required/>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="row p-3 border border-primary ">

                                <table id="myTable" class="table table-striped border-primary table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Author</th>
                                            <th>Aksi</th>
                                            <th>Tanggal</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataNews as $key => $news)
                                            <tr>
                                                <td>{{ $dataNews->firstitem() + $key }}</td>
                                                <td>{{ $news->title }}</td>
                                                <td>{{ $news->user->email }}</td>
                                                
                                                <td>
                                                    <div class="row justify-content-start">
                                                        <div class="px-2 py-1">
                                                            <a href=" route('list-bidang.edit', ['list_bidang' => $bidang->id]) }}"
                                                                type="button" class="btn btn-primary">
                                                                <i class="bi bi-pencil text-white"> Perbaharui Data</i>
                                                            </a>
                                                        </div>

                                                        <div
                                                            class=" px-2 py-1
                                                        ">
                                                            <form
                                                                action=" route('list-bidang.destroy', ['list_bidang' => $bidang->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button class="btn btn-danger"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus bidang ini?')">
                                                                    <i class="bi bi-trash3"> Hapus Data</i>
                                                                </button>
                                                            </form>
                                                        </div>

                                                    </div>

                                                </td>
                                                <td>{{ $news->created_at->diffForHumans(); }}</td>   
                                                

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">empty</td>
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