@extends('layouts.main')
@section('container')
    <div class="pagetitle">
        <h1>Kirim Email Langganan Berita</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                <li class="breadcrumb-item active">Kirim Email Langganan Berita</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-sm-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body p-3">

                            <form class="row g-3" method="post" action=" route('list-news.store') }}"
                                {{-- enctype="multipart/form-data" --}}
                                >
                                @csrf
                                <div class="col-md-6">

                                    <h5>Data Author</h5>
                                    <hr>

                                    <div class="pb-5">
                                        <label for="nama" class="form-label">Nama Pengirim</label>
                                        <input type="text" value="hello@golekfood.my.id" class="form-control"
                                            disabled>
                                    </div>

            
                                </div>

                                <div class="col-md-3">

                                    <h5>Data Penerima</h5>
                                    <hr>

                                    <div class="pb-5">
                                        <label for="nama" class="form-label">Jumlah penerima</label>
                                        <input type="text" value="{{ $totalSubscriptionNews }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                
                                <div class="col-md-9">
                                    
                                    <h5>Data Berita</h5>
                                    <hr>
                                    <div class="py-2">
                                        <label for="title" class="form-label">Subject</label>
                                        <input type="text"
                                            class="form-control 
                                            @error('subject') 
                                            is-invalid
                                            @enderror
                                            "
                                            id="subject" name="subject">

                                        @error('subject')
                                            <label class="form-check-label invalid-feedback">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                        

                                    <div class="py-2">
                                        <label for="body" class="form-label">Body</label>
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
