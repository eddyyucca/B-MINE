@extends('layouts.main')

@section('content')
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div><!-- /.container-fluid -->
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Search Employee</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Animated "Not Found" message -->

                                {{-- Display errors if any --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible not-found-animate">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $errors->first() }}</h5>
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Display success message if any --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible not-found-animate">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check-circle"></i> Sukses!</h5>
                                        {{ session('success') }}
                                    </div>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

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
@endsection
