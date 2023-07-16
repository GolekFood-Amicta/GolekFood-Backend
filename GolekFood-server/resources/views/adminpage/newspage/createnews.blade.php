@extends('layouts.main')
@section('container')
    <div class="pagetitle">
        <h1>Tambah News</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                <li class="breadcrumb-item active">Tambah News</li>
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

                            <form class=" g-3" method="post" action=" {{ route('list-news.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-3">

                                    <h5>Data Author</h5>
                                    <hr>

                                    <div class="pb-5">
                                        <label for="nama" class="form-label">Nama Author</label>
                                        <input type="text" value="{{ auth()->user()->name }}" class="form-control"
                                            disabled>
                                    </div>

                                    <h5>Data News</h5>
                                    <hr>
                                </div>

                                <div class="col-md-9">
                                    <div class="py-2">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text"
                                            class="form-control 
                                            @error('title') 
                                            is-invalid
                                            @enderror
                                            "
                                            id="title" name="title">

                                        @error('title')
                                            <label class="form-check-label invalid-feedback">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Gambar</label>
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

                                    <div class="py-2">
                                        <label for="bpjs" class="form-label">Isi Artikel</label>
                                        <input id="body" type="hidden" name="body">
                                        <trix-editor input="body"></trix-editor>

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

    <script>
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })
    </script>
@endsection
