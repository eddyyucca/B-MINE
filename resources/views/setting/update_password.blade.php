@extends('layouts.main')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Your Password</h3>
                        </div>

                        {{-- Success Alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {{-- Error Alert --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="{{ route('akun.update_password') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                        id="new_password" name="new_password" required>
                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Password must be at least 8 characters long.
                                    </small>
                                </div>

                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Password
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shield-alt text-primary"></i> Password Security Tips
                            </h3>
                        </div>
                        <div class="card-body">
                            <h5><i class="fas fa-check-circle text-success"></i> Characteristics of a Strong Password:</h5>
                            <ul class="list-unstyled ml-4">
                                <li><i class="fas fa-arrow-right text-primary"></i> At least 8 characters long</li>
                                <li><i class="fas fa-arrow-right text-primary"></i> Contains uppercase letters (A-Z)</li>
                                <li><i class="fas fa-arrow-right text-primary"></i> Contains lowercase letters (a-z)</li>
                                <li><i class="fas fa-arrow-right text-primary"></i> Contains numbers (0-9)</li>
                                <li><i class="fas fa-arrow-right text-primary"></i> Contains special characters (!@#$%^&*)
                                </li>
                            </ul>

                            <div class="alert alert-warning mt-3">
                                <h5><i class="fas fa-exclamation-triangle"></i> Avoid Common Mistakes:</h5>
                                <ul class="mb-0">
                                    <li>Don't use sequential numbers or letters (123456, abcdef)</li>
                                    <li>Don't use personal information (name, birth date, etc.)</li>
                                    <li>Don't reuse passwords across multiple accounts</li>
                                    <li>Don't share your password with others</li>
                                </ul>
                            </div>

                            <div class="alert alert-info mt-3">
                                <h5><i class="fas fa-lightbulb"></i> Password Management Tips:</h5>
                                <ul class="mb-0">
                                    <li>Consider using a reputable password manager</li>
                                    <li>Change your passwords regularly (every 3-6 months)</li>
                                    <li>Use different passwords for different accounts</li>
                                    <li>Enable two-factor authentication when available</li>
                                </ul>
                            </div>

                            <div class="card-footer bg-transparent p-0 mt-3">
                                <div class="alert alert-success mb-0">
                                    <h5 class="mb-2"><i class="fas fa-key"></i> Password Example:</h5>
                                    <p class="mb-0">Weak: <span class="text-danger">password123</span></p>
                                    <p class="mb-0">Strong: <span class="text-success">P@$$w0rd!2023</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
