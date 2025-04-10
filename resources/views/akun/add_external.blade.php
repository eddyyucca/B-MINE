@extends('layouts.main')

@section('content')
    <!-- About Section -->
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add External Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dataaccounts_ext.view') }}">External</a></li>
                        <li class="breadcrumb-item active">Add External Account</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New External Account</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dataaccounts_ext.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Name</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" placeholder="Enter name" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Enter password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm password">
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="form-control @error('level') is-invalid @enderror" id="level"
                                        name="level">
                                        <option value="">Select Level</option>
                                        <option value="bec" {{ old('level') == 'bec' ? 'selected' : '' }}>BEC</option>
                                        <option value="ktt" {{ old('level') == 'ktt' ? 'selected' : '' }}>KTT</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group" id="area-group" style="display: none;">
                                    <label for="area">Area</label>
                                    <select class="form-control @error('area') is-invalid @enderror" id="area"
                                        name="area">
                                        <option value="">Select Area</option>
                                        <option value="BT" {{ old('area') == 'BT' ? 'selected' : '' }}>BT</option>
                                        <option value="FSP" {{ old('area') == 'FSP' ? 'selected' : '' }}>FSP</option>
                                        <option value="TA" {{ old('area') == 'TA' ? 'selected' : '' }}>TA</option>
                                        <option value="TJ" {{ old('area') == 'TJ' ? 'selected' : '' }}>TJ</option>
                                    </select>
                                    @error('area')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('dataaccounts_ext.view') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Form validation
            $('.form-control').on('change', function() {
                $(this).removeClass('is-invalid');
            });

            // Show/hide area field based on level selection
            $('#level').on('change', function() {
                if ($(this).val() === 'ktt') {
                    $('#area-group').show();
                } else {
                    $('#area-group').hide();
                    $('#area').val('');
                }
            });

            // Set initial state based on selected value (useful when form reloads after validation)
            if ($('#level').val() === 'ktt') {
                $('#area-group').show();
            }
        });
    </script>
@endsection
