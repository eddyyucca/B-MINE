@extends('layouts.main')

@section('content')
    <!-- About Section -->
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Internal Account</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dataaccounts_int.view') }}">Internal</a></li>
                        <li class="breadcrumb-item active">Add Internal Account</li>
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
                            <h3 class="card-title">Add New Internal Account</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dataaccounts_int.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="nik">NIK <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" placeholder="Enter NIK" value="{{ old('nik') }}"
                                        required>
                                    @error('nik')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" placeholder="Enter name" value="{{ old('nama') }}"
                                        required>
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Form group untuk departemen dengan fitur pencarian -->
                                <div class="form-group">
                                    <label for="departement">Department <span class="text-danger">*</span></label>
                                    <select class="form-control select2bs4 @error('departement') is-invalid @enderror"
                                        id="departement" name="departement" required>
                                        <option value="" selected disabled>Departemen</option>
                                        <option value="Business Unit"
                                            {{ old('departement') == 'Business Unit' ? 'selected' : '' }}>Business Unit
                                        </option>
                                        <option value="Business Excellence"
                                            {{ old('departement') == 'Business Excellence' ? 'selected' : '' }}>Business
                                            Excellence</option>
                                        <option value="Human Resources"
                                            {{ old('departement') == 'Human Resources' ? 'selected' : '' }}>Human Resources
                                        </option>
                                        <option value="General Services"
                                            {{ old('departement') == 'General Services' ? 'selected' : '' }}>General
                                            Services</option>
                                        <option value="IER" {{ old('departement') == 'IER' ? 'selected' : '' }}>IER
                                        </option>
                                        <option value="Learning Center&Dev."
                                            {{ old('departement') == 'Learning Center&Dev.' ? 'selected' : '' }}>Learning
                                            Center&Dev.</option>
                                        <option value="Finance & Budget Rep"
                                            {{ old('departement') == 'Finance & Budget Rep' ? 'selected' : '' }}>Finance &
                                            Budget Rep</option>
                                        <option value="Information & Techno"
                                            {{ old('departement') == 'Information & Techno' ? 'selected' : '' }}>
                                            Information & Techno</option>
                                        <option value="Safety, Health, Env"
                                            {{ old('departement') == 'Safety, Health, Env' ? 'selected' : '' }}>Safety,
                                            Health, Env</option>
                                        <option value="PSCM" {{ old('departement') == 'PSCM' ? 'selected' : '' }}>PSCM
                                        </option>
                                        <option value="Engineering"
                                            {{ old('departement') == 'Engineering' ? 'selected' : '' }}>Engineering
                                        </option>
                                        <option value="Plant Operation"
                                            {{ old('departement') == 'Plant Operation' ? 'selected' : '' }}>Plant Operation
                                        </option>
                                        <option value="SHE" {{ old('departement') == 'SHE' ? 'selected' : '' }}>SHE
                                        </option>
                                        <option value="PT. TRAKINDO"
                                            {{ old('departement') == 'PT. TRAKINDO' ? 'selected' : '' }}>PT. TRAKINDO
                                        </option>
                                        <option value="PT. Bina Pertiwi"
                                            {{ old('departement') == 'PT. Bina Pertiwi' ? 'selected' : '' }}>PT. Bina
                                            Pertiwi</option>
                                        <option value="PT. Kinend"
                                            {{ old('departement') == 'PT. Kinend' ? 'selected' : '' }}>PT. Kinend</option>
                                        <option value="PT. Aden" {{ old('departement') == 'PT. Aden' ? 'selected' : '' }}>
                                            PT. Aden</option>
                                        <option value="PT. PTJ" {{ old('departement') == 'PT. PTJ' ? 'selected' : '' }}>PT.
                                            PTJ</option>
                                        <option value="PT. LSS" {{ old('departement') == 'PT. LSS' ? 'selected' : '' }}>PT.
                                            LSS</option>
                                        <option value="PT. EDJS" {{ old('departement') == 'PT. EDJS' ? 'selected' : '' }}>
                                            PT. EDJS</option>
                                        <option value="PT. SUPRIMA"
                                            {{ old('departement') == 'PT. SUPRIMA' ? 'selected' : '' }}>PT. SUPRIMA
                                        </option>
                                        <option value="TMC" {{ old('departement') == 'TMC' ? 'selected' : '' }}>TMC
                                        </option>
                                        <option value="PT. Epiroc"
                                            {{ old('departement') == 'PT. Epiroc' ? 'selected' : '' }}>PT. Epiroc</option>
                                        <option value="PT. PUP" {{ old('departement') == 'PT. PUP' ? 'selected' : '' }}>PT.
                                            PUP</option>
                                        <option value="PT. Transkon"
                                            {{ old('departement') == 'PT. Transkon' ? 'selected' : '' }}>PT. Transkon
                                        </option>
                                        <option value="PT. CAR" {{ old('departement') == 'PT. CAR' ? 'selected' : '' }}>PT.
                                            CAR</option>
                                        <option value="BUMA" {{ old('departement') == 'BUMA' ? 'selected' : '' }}>BUMA
                                        </option>
                                        <option value="INFRA" {{ old('departement') == 'INFRA' ? 'selected' : '' }}>INFRA
                                        </option>
                                        <option value="PT. Predict"
                                            {{ old('departement') == 'PT. Predict' ? 'selected' : '' }}>PT. Predict
                                        </option>
                                        <option value="PT. TKS" {{ old('departement') == 'PT. TKS' ? 'selected' : '' }}>PT.
                                            TKS</option>
                                        <option value="PT. TRIATRA"
                                            {{ old('departement') == 'PT. TRIATRA' ? 'selected' : '' }}>PT. TRIATRA
                                        </option>
                                        <option value="PT. MADP" {{ old('departement') == 'PT. MADP' ? 'selected' : '' }}>
                                            PT. MADP</option>
                                    </select>
                                    @error('departement')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Form group untuk jabatan dengan fitur pencarian -->
                                <div class="form-group">
                                    <label for="jabatan">Position <span class="text-danger">*</span></label>
                                    <select class="form-control select2bs4 @error('jabatan') is-invalid @enderror"
                                        id="jabatan" name="jabatan" required>
                                        <option value="" selected disabled>Position</option>
                                        <option value="Manager - Mining"
                                            {{ old('jabatan') == 'Manager - Mining' ? 'selected' : '' }}>Manager - Mining
                                        </option>
                                        <option value="Superintendent - BE"
                                            {{ old('jabatan') == 'Superintendent - BE' ? 'selected' : '' }}>Superintendent
                                            - BE</option>
                                        <option value="Superintendent - HR"
                                            {{ old('jabatan') == 'Superintendent - HR' ? 'selected' : '' }}>Superintendent
                                            - HR</option>
                                        <option value="Superintendent - Facility Service"
                                            {{ old('jabatan') == 'Superintendent - Facility Service' ? 'selected' : '' }}>
                                            Superintendent - Facility Service</option>
                                        <option value="Superintendent - IER"
                                            {{ old('jabatan') == 'Superintendent - IER' ? 'selected' : '' }}>Superintendent
                                            - IER</option>
                                        <option value="Superintendent - Learning Center"
                                            {{ old('jabatan') == 'Superintendent - Learning Center' ? 'selected' : '' }}>
                                            Superintendent - Learning Center</option>
                                        <option value="Analyst - Budget & Control"
                                            {{ old('jabatan') == 'Analyst - Budget & Control' ? 'selected' : '' }}>Analyst
                                            - Budget & Control</option>
                                        <option value="Superintendent - IT"
                                            {{ old('jabatan') == 'Superintendent - IT' ? 'selected' : '' }}>Superintendent
                                            - IT</option>
                                        <option value="Superintendent - SHE"
                                            {{ old('jabatan') == 'Superintendent - SHE' ? 'selected' : '' }}>Superintendent
                                            - SHE</option>
                                        <option value="Opr. Services"
                                            {{ old('jabatan') == 'Opr. Services' ? 'selected' : '' }}>Opr. Services
                                        </option>
                                        <option value="Superintendent - Logistics"
                                            {{ old('jabatan') == 'Superintendent - Logistics' ? 'selected' : '' }}>
                                            Superintendent - Logistics</option>
                                        <option value="Superintendent - Mine Ctr & Dispatch"
                                            {{ old('jabatan') == 'Superintendent - Mine Ctr & Dispatch' ? 'selected' : '' }}>
                                            Superintendent - Mine Ctr & Dispatch</option>
                                        <option value="Superintendent - Loader"
                                            {{ old('jabatan') == 'Superintendent - Loader' ? 'selected' : '' }}>
                                            Superintendent - Loader</option>
                                        <option value="Jr. Specialist - Leadership Development"
                                            {{ old('jabatan') == 'Jr. Specialist - Leadership Development' ? 'selected' : '' }}>
                                            Jr. Specialist - Leadership Development</option>
                                        <option value="Warehouseman"
                                            {{ old('jabatan') == 'Warehouseman' ? 'selected' : '' }}>Warehouseman</option>
                                        <option value="Safety Officer"
                                            {{ old('jabatan') == 'Safety Officer' ? 'selected' : '' }}>Safety Officer
                                        </option>
                                        <option value="Koord.tire repair"
                                            {{ old('jabatan') == 'Koord.tire repair' ? 'selected' : '' }}>Koord.tire repair
                                        </option>
                                        <option value="Ast. Cook" {{ old('jabatan') == 'Ast. Cook' ? 'selected' : '' }}>
                                            Ast. Cook</option>
                                        <option value="PJO" {{ old('jabatan') == 'PJO' ? 'selected' : '' }}>PJO
                                        </option>
                                        <option value="Site Manager"
                                            {{ old('jabatan') == 'Site Manager' ? 'selected' : '' }}>Site Manager</option>
                                        <option value="Leading Hand"
                                            {{ old('jabatan') == 'Leading Hand' ? 'selected' : '' }}>Leading Hand</option>
                                        <option value="Dokter" {{ old('jabatan') == 'Dokter' ? 'selected' : '' }}>Dokter
                                        </option>
                                        <option value="Site Tecnician"
                                            {{ old('jabatan') == 'Site Tecnician' ? 'selected' : '' }}>Site Tecnician
                                        </option>
                                        <option value="DSM" {{ old('jabatan') == 'DSM' ? 'selected' : '' }}>DSM
                                        </option>
                                        <option value="PJO SITE" {{ old('jabatan') == 'PJO SITE' ? 'selected' : '' }}>PJO
                                            SITE</option>
                                        <option value="LO Asuransi"
                                            {{ old('jabatan') == 'LO Asuransi' ? 'selected' : '' }}>LO Asuransi</option>
                                        <option value="Superintendent Key Project"
                                            {{ old('jabatan') == 'Superintendent Key Project' ? 'selected' : '' }}>
                                            Superintendent Key Project</option>
                                        <option value="Koordinator"
                                            {{ old('jabatan') == 'Koordinator' ? 'selected' : '' }}>Koordinator</option>
                                        <option value="Teknisi" {{ old('jabatan') == 'Teknisi' ? 'selected' : '' }}>
                                            Teknisi</option>
                                        <option value="Staff" {{ old('jabatan') == 'Staff' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="Representative"
                                            {{ old('jabatan') == 'Representative' ? 'selected' : '' }}>Representative
                                        </option>
                                        <option value="Head Operational"
                                            {{ old('jabatan') == 'Head Operational' ? 'selected' : '' }}>Head Operational
                                        </option>
                                    </select>
                                    @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Enter email"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="level">Level <span class="text-danger">*</span></label>
                                    <select class="form-control @error('level') is-invalid @enderror" id="level"
                                        name="level" required>
                                        <option value="" selected disabled>Select Level</option>
                                        <option value="admin" {{ old('level') == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="user" {{ old('level') == 'user' ? 'selected' : '' }}>User
                                        </option>
                                        <option value="she" {{ old('level') == 'she' ? 'selected' : '' }}>SHE</option>
                                        <option value="pjo" {{ old('level') == 'pjo' ? 'selected' : '' }}>PJO</option>
                                        <option value="section_admin"
                                            {{ old('level') == 'section_admin' ? 'selected' : '' }}>Section Admin</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('dataaccounts_int.view') }}" class="btn btn-secondary">Cancel</a>
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
        });
    </script>

    <!-- Script untuk mengaktifkan select2bs4 -->
    <script>
        $(document).ready(function() {
            // Initialize Select2 for departement
            $('#departement').select2bs4({
                placeholder: "Pilih Departemen",
                allowClear: true,
                width: '100%',
                language: {
                    searching: function() {
                        return "Mencari...";
                    },
                    noResults: function() {
                        return "Tidak ada hasil";
                    }
                }
            });

            // Initialize Select2 for jabatan
            $('#jabatan').select2bs4({
                placeholder: "Pilih Jabatan",
                allowClear: true,
                width: '100%',
                language: {
                    searching: function() {
                        return "Mencari...";
                    },
                    noResults: function() {
                        return "Tidak ada hasil";
                    }
                }
            });
        });
    </script>
@endsection
