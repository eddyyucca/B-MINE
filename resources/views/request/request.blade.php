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

    .info-box-icon {
        font-size: 30px;
    }
</style>

@section('content')
    {{-- Main Content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mine Permit Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Search Employee</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Search Employee</h3>
                            </div>
                            <div class="card-body">
                                {{-- Form to search employee by NIK --}}
                                @if (!session('data'))
                                    <form method="POST" action="{{ route('search_nik.post') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="namaunit">NIK Employee</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="namaunit" name="nik"
                                                    required placeholder="Enter NIK">
                                            </div>
                                            <small class="form-text text-muted">Enter the employee's NIK to process their
                                                Mine Permit request.</small>
                                        </div>
                                        <div class="card-footer bg-transparent pl-0">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search mr-1"></i> Search NIK
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Display errors if any --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible not-found-animate mt-3">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-exclamation-triangle"></i> {{ $errors->first() }}</h5>
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    {{-- Display success message if any --}}
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible not-found-animate mt-3">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">&times;</button>
                                            <h5><i class="icon fas fa-check-circle"></i> Success!</h5>
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                @else
                                    {{-- You can add logic here to display results if session('data') is true --}}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <!-- Info Box -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Information</h3>
                            </div>
                            <div class="card-body p-3">
                                <div class="callout callout-info p-2 mb-2">
                                    <h5 class="mb-1">Search by NIK</h5>
                                    <p class="mb-0">Enter the employee's NIK (Employee Identification Number) to search
                                        for their details.</p>
                                </div>

                                <div class="info-box bg-light mb-2 p-2">
                                    <span class="info-box-icon bg-info p-2"><i class="fas fa-id-card"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Required Format</span>
                                        <span class="info-box-number">NIK must contain valid digits</span>
                                    </div>
                                </div>

                                <div class="callout callout-warning p-2 mb-2">
                                    <h5 class="mb-1"><i class="fas fa-exclamation-triangle mr-1"></i> Pending Requests
                                    </h5>
                                    <p class="mb-0">Cannot create a new request if there are pending requests in process.
                                    </p>
                                </div>

                                <div class="callout callout-danger p-2 mb-0">
                                    <h5 class="mb-1"><i class="fas fa-ban mr-1"></i> Failed Process</h5>
                                    <p class="mb-0">Process will fail if previous requests weren't accepted by relevant
                                        section.</p>
                                </div>
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
