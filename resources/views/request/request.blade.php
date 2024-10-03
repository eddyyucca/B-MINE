@extends('layouts.main')
<style>
    .overlay {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .d-none {
        display: none;
    }
</style>
@section('content')
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search Employee</h3>
                            </div>
                            <div class="card-body">

                                <form id="myForm" action="{{ route('search_nik') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="namaunit">NIK Employee</label>
                                            <input type="text" class="form-control" id="namaunit" name="nik"
                                                required placeholder="NIK">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Search NIK</button>
                                    </div>
                                </form>

                                @if (session('data'))
                                    <div>
                                        <h3>Data Karyawan</h3>
                                        <p><strong>ID Karyawan:</strong> {{ session('data')['id_kar'] }}</p>
                                        <p><strong>NIK:</strong> {{ session('data')['nik'] }}</p>
                                        <p><strong>Nama:</strong> {{ session('data')['nama'] }}</p>
                                        <p><strong>Departemen:</strong> {{ session('data')['departement'] }}</p>
                                        <p><strong>Jabatan:</strong> {{ session('data')['jabatan'] }}</p>
                                        <p><strong>Status:</strong> {{ session('data')['status_mp'] }}</p>
                                        <p><strong>Level:</strong> {{ session('data')['level'] }}</p>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div>
                                        <!-- Animated "Not Found" message -->
                                        <div class="alert alert-danger alert-dismissible not-found-animate">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $errors->first() }}</h5>
                                            {{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- end content --}}

    <!-- CSS Animasi -->
    <style>
        .not-found-animate {
            animation: fadeInAndOut 3s ease-in-out infinite;
        }

        @keyframes fadeInAndOut {

            0%,
            100% {
                opacity: 0;
                transform: scale(0.9);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        // jQuery to show loading spinner when the form is submitted
        $(document).ready(function() {
            $('#myForm').on('submit', function() {
                $('#loading').removeClass('d-none'); // Show loading spinner
            });
        });
    </script>
@endsection
