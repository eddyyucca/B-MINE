@extends('layouts.main')

{{-- Custom CSS --}}
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

@section('content')
    {{-- Main Content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                {{-- Optional header content --}}
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Reset Password</h3>
                            </div>
                            <div class="card-body">
                                {{-- Form to search employee by NIK --}}
                                @if (!session('data'))
                                    <form id="myForm" action="{{ route('search_nik') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="namaunit">NIK Employee</label>
                                            <input type="text" class="form-control" id="namaunit" name="nik"
                                                required placeholder="Enter NIK">
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Search NIK</button>
                                        </div>
                                    </form>

                                    {{-- Display errors if any --}}
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
                                @else
                                    {{-- You can add logic here to display results if session('data') is true --}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- You can add any additional scripts here --}}
@endsection
