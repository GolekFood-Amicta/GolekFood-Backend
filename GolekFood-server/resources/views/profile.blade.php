@extends('layouts.main')
@section('container')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Profile</li>
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

                            <form class="row g-3" method="post" action="  route('list-news.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-4">
                                    <div class="pb-2">
                                        <label for="nama" class="form-label">Email</label>
                                        <input type="text" value="{{ auth()->user()->email }}" class="form-control"
                                            disabled>
                                    </div>

                                    <div class="pb-2">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="form-control"
                                        >
                                    </div>

                                    <div class="pb-2">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea type="text"
                                            class="form-control 
                                        @error('alamat') 
                                        is-invalid
                                        @enderror
                                        "
                                            id="alamat" name="alamat">{{ auth()->user()->address }}</textarea>


                                        @error('alamat')
                                            <label class="form-check-label invalid-feedback">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-3 px-3">

                                    <div class="mb-3">
                                       
                                        <h4>Ganti Avatar</h4>
                                        <img src="{{ asset('img/profile-img.jpg') }}" alt="..." class="img-thumbnail rounded float-left m-3">
                                        
                                        <input
                                            class="form-control 
                                            @error('title') 
                                            is-invalid
                                            @enderror"
                                            type="file" id="image" name="image">
                                        @error('body')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>



                                <div class="col-12 py-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>

@endsection
