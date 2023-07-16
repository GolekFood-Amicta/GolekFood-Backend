@extends('layouts.main')

@section('container')
    <div class="pagetitle">
        <h1>Data Hasil Survey</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Data Hasil Survey</li>
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



                            <div class="row p-3 border border-primary table-responsive">

                                <table id="myTable" class="table table-striped border-primary table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Hasil</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @forelse ($dataSurvey as $key => $survey)
                                            <tr>
                                                <td>{{ $dataSurvey->firstitem() + $key }}</td>
                                                @if (($survey->jenis_kelamin) == 'L')
                                                     <td>Laki-Laki </td>
                                                @endif
                                                
                                                @if (($survey->jenis_kelamin) == 'P')
                                                     <td>Perempuan</td>
                                                @endif

                                                <td>{{ $survey->umur }}</td>
                                                <td>{{ $survey->hasil }}</td>
                                                <td>{{ $survey->created_at }}</td>   
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
                                    {!! $dataSurvey->render() !!}
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