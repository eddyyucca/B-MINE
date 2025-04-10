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
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Mine Permit Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Mine Permit Request Form</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Complete the data for submission</h3>
                        </div>

                        <div class="card-body">
                            {{-- Form to submit additional data --}}
                            @if (!empty($data_karyawan))
                                <form id="myForm2" action="{{ route('insert_request') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nik">NIK</label>
                                                <input type="text" class="form-control" id="nik" name="nik"
                                                    placeholder="NIK" value="{{ $data_karyawan['nik'] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Full Name</label>
                                                <input type="text" class="form-control" id="name" name="nama"
                                                    placeholder="Full Name" value="{{ $data_karyawan['nama'] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="jobtitle">Job Title</label>
                                                <input type="text" class="form-control" id="jabatan" name="jabatan"
                                                    placeholder="Job Title" value="{{ $data_karyawan['jabatan'] }}"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="departement">Department</label>
                                                <input type="text" class="form-control" id="departement"
                                                    name="departement" placeholder="Department"
                                                    value="{{ $data_karyawan['departement'] }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="dep_req">Department Request</label>
                                                <input type="text" class="form-control" id="dep_req" name="dep_req"
                                                    placeholder="Department Request"
                                                    value="{{ session('logged_in_user')['departement'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Error message if departments don't match -->
                                    @if ($data_karyawan['departement'] !== session('logged_in_user')['departement'])
                                        <p class="text-danger mt-2">Request cannot proceed, different departments.</p>
                                    @endif
                                    {{-- Upload photo --}}
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="foto_view">Upload Photo</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="foto_view"
                                                            name="foto_view" onchange="previewImage(event)"
                                                            accept="image/*">
                                                        <label class="custom-file-label" for="foto_view">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <div class="mt-3">
                                                    <img id="preview" src="" alt="Image Preview"
                                                        style="max-width: 100%; max-height: 150px; display: none; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Access Minepermit</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group clearfix">
                                                        <label class="mb-2">Select Access Areas:</label>

                                                        <!-- Area CHR -->
                                                        <div class="mb-3">
                                                            <h6 class="text-muted mb-2">CHR Area</h6>
                                                            <div class="d-flex flex-wrap gap-3">
                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CHR-BT]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CHR-BT]"
                                                                        id="checkboxCHRBT" value="yes">
                                                                    <label for="checkboxCHRBT"> CHR-BT </label>
                                                                </div>

                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CHR-FSP]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CHR-FSP]"
                                                                        id="checkboxCHRFSP" value="yes">
                                                                    <label for="checkboxCHRFSP"> CHR-FSP </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Area CP -->
                                                        <div class="mb-3">
                                                            <h6 class="text-muted mb-2">CP Area</h6>
                                                            <div class="d-flex flex-wrap gap-3">
                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CP-BT]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CP-BT]"
                                                                        id="checkboxCPBT" value="yes">
                                                                    <label for="checkboxCPBT"> CP-BT </label>
                                                                </div>

                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CP-FSP]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CP-FSP]"
                                                                        id="checkboxCPFSP" value="yes">
                                                                    <label for="checkboxCPFSP"> CP-FSP </label>
                                                                </div>

                                                                <!-- Tambahan CP-TA -->
                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CP-TA]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CP-TA]"
                                                                        id="checkboxCPTA" value="yes">
                                                                    <label for="checkboxCPTA"> CP-TA </label>
                                                                </div>

                                                                <!-- Tambahan CP-TJ -->
                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[CP-TJ]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[CP-TJ]"
                                                                        id="checkboxCPTJ" value="yes">
                                                                    <label for="checkboxCPTJ"> CP-TJ </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Area PIT -->
                                                        <div class="mb-3">
                                                            <h6 class="text-muted mb-2">PIT Area</h6>
                                                            <div class="d-flex flex-wrap gap-3">
                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[PIT-BT]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[PIT-BT]"
                                                                        id="checkboxPITBT" value="yes">
                                                                    <label for="checkboxPITBT"> PIT-BT </label>
                                                                </div>

                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[PIT-TA]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[PIT-TA]"
                                                                        id="checkboxPITTA" value="yes">
                                                                    <label for="checkboxPITTA"> PIT-TA </label>
                                                                </div>

                                                                <div class="icheck-primary mr-4 mb-2">
                                                                    <input type="hidden" name="permissions[PIT-TJ]"
                                                                        value="no">
                                                                    <input type="checkbox" name="permissions[PIT-TJ]"
                                                                        id="checkboxPITTJ" value="yes">
                                                                    <label for="checkboxPITTJ"> PIT-TJ </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-default mt-4">
                                        <div class="card-header">
                                            <h3 class="card-title">Required Documents</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{-- Medical certificate --}}
                                                    <div class="form-group">
                                                        <label for="medical_certificate">Medical Certificate</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="medical_certificate" name="medical_certificate"
                                                                    accept=".pdf" onchange="file_mc()">
                                                                <label class="custom-file-label"
                                                                    for="medical_certificate">Choose
                                                                    File Medical Certificate</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="attachment">Attachment</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                    id="attachment" name="attachment" accept=".pdf"
                                                                    onchange="file_a()">
                                                                <label class="custom-file-label" for="attachment">Choose
                                                                    File
                                                                    Attachment</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="expiry_date">Expiry Date <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" id="expiry_date"
                                                            name="expiry_date" placeholder="Enter the expiry date"
                                                            required>
                                                        <div class="invalid-feedback">Please enter an expiry date.</div>
                                                        <small class="form-text text-muted">
                                                            Enter the date closest to expiration for any of the following
                                                            documents:<br>
                                                            • Medical Certificate<br>
                                                            • Attachment<br>
                                                            • Driver's License<br>
                                                            • SIO (Certificate of Operation)
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- License type --}}
                                    <div class="card card-default mt-4">
                                        <div class="card-header">
                                            <h3 class="card-title">Permit Selection</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="license_type">Choose Permit Type: <span
                                                        class="text-danger">*</span></label>
                                                <select id="license_type" name="license_type"
                                                    class="form-control select2bs4" onchange="toggleFormElements()"
                                                    required>
                                                    <option value="">Select...</option>
                                                    <option value="1">Mine Permit Only</option>
                                                    <option value="2">Simper & Mine Permit</option>
                                                </select>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i> Select "Mine Permit Only" if you
                                                    don't need access to use facilities.
                                                    Select "Simper & Mine Permit" if you need both permits.
                                                </small>
                                                <div class="invalid-feedback">Please select a permit type.</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Conditional Simper and Mine Permit --}}
                                    <div id="simport-form" style="display: none;">
                                        <div class="card card-success mt-3">
                                            <div class="card-header">
                                                <h3 class="card-title">Simper & Mine Permit Details</h3>
                                                <div class="card-tools">
                                                    <span class="badge badge-info">Additional information required</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="drivers_license">Driver's License</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="drivers_license" name="drivers_license"
                                                                        accept=".pdf" onchange="file_dl()">
                                                                    <label class="custom-file-label"
                                                                        for="drivers_license">Choose
                                                                        File
                                                                        Driver's License</label>
                                                                </div>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text">Upload</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="no_sim">Police License Number</label>
                                                            <input type="text" class="form-control" id="no_sim"
                                                                name="no_sim" placeholder="Enter police license number">
                                                        </div>
                                                        <!-- Tipe SIM yang ditambahkan dengan checkbox -->
                                                        <div class="form-group">
                                                            <label>License Type</label>
                                                            <div class="checkbox-container">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="sim[]" id="sim_a" value="A">
                                                                    <label class="form-check-label" for="sim_a">SIM
                                                                        A</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="sim[]" id="sim_b1" value="B1">
                                                                    <label class="form-check-label" for="sim_b1">SIM
                                                                        B1</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="sim[]" id="sim_b2" value="B2">
                                                                    <label class="form-check-label" for="sim_b2">SIM
                                                                        B2</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="sim[]" id="sim_a_umum" value="BII UMUM">
                                                                    <label class="form-check-label" for="sim_a_umum">SIM B2
                                                                        UMUM</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="sio">SIO:</label>
                                                            <select id="sio" name="sio"
                                                                class="form-control select2bs4"
                                                                onchange="toggleSIOInput()">
                                                                <option value="">Select...</option>
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                        </div>
                                                        <div id="sio-input" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="sio_file">Upload SIO File:</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="sio_file" name="sio_file" accept=".pdf"
                                                                            onchange="fileSIO()">
                                                                        <label class="custom-file-label"
                                                                            for="sio_file">Choose File
                                                                            SIO</label>
                                                                    </div>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <h5 class="mb-3">Unit Selection</h5>
                                                        <div class="form-group">
                                                            <div id="dynamic-units">
                                                                <!-- First unit -->
                                                                <div class="unit-group mb-3">
                                                                    <div class="form-group">
                                                                        <label for="unit_type">Choose License Type:</label>
                                                                        <select id="unit_type" name="unit_type[]"
                                                                            class="form-control select2bs4"
                                                                            style="width: 100%;">
                                                                            <option value="">Select...</option>
                                                                            @foreach ($licenses as $license)
                                                                                <option value="{{ $license->id_units }}">
                                                                                    {{ $license->nama_unit }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <!-- Checkbox for options -->
                                                                    <div class="d-flex flex-wrap mt-2">
                                                                        <div class="form-check form-check-inline mr-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="options[0][]"
                                                                                value="P" id="checkboxP">
                                                                            <label class="form-check-label"
                                                                                for="checkboxP">P</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline mr-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="options[0][]"
                                                                                value="R" id="checkboxR">
                                                                            <label class="form-check-label"
                                                                                for="checkboxR">R</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline mr-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="options[0][]"
                                                                                value="T" id="checkboxT">
                                                                            <label class="form-check-label"
                                                                                for="checkboxT">T</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline mr-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="options[0][]"
                                                                                value="I" id="checkboxI">
                                                                            <label class="form-check-label"
                                                                                for="checkboxI">I</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline mr-3">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" name="options[0][]"
                                                                                value="O" id="checkboxO">
                                                                            <label class="form-check-label"
                                                                                for="checkboxO">O</label>
                                                                        </div>
                                                                        <!-- Button to remove unit -->
                                                                        <div class="ml-auto">
                                                                            <button
                                                                                class="btn btn-sm btn-danger remove-unit"
                                                                                type="button">Remove</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-success mt-3"
                                                                id="add-unit">Add Option</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Mine permit form --}}
                                        <div id="minepermit-form" style="display: none;">
                                            <div class="card card-warning mt-3">
                                                <div class="card-header">
                                                    <h3 class="card-title">Mine Permit Details</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="alert alert-info">
                                                        <i class="icon fas fa-info-circle"></i>
                                                        You have selected Mine Permit only. This option does not require
                                                        access to use facilities.
                                                    </div>
                                                    <p class="text-muted">No additional information needed. You can proceed
                                                        with submission.</p>
                                                </div>
                                            </div>
                                        </div>

                                </form>
                            @else
                                <p>No data found for submission. Please check the input.</p>
                            @endif
                        </div>
                    </div>

                    @if (!empty($data_karyawan))
                        <!-- Submit button outside the main form structure -->
                        <div class="card-footer bg-white border-top shadow-sm mt-3">
                            <div class="d-flex justify-content-end">
                                <button type="button" onclick="window.history.back()"
                                    class="btn btn-secondary mr-2">Cancel</button>
                                <button type="submit" form="myForm2" class="btn btn-primary">Submit Form</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection

@section('scripts')
    <script>
        let unitCount = 1;

        document.getElementById('add-unit').addEventListener('click', function() {
            const unitContainer = document.getElementById('dynamic-units');
            const newUnit = `
                <div class="unit-group mb-3">
                    <div class="form-group">
                        <label for="unit_type">Choose License Type:</label>
                        <select id="unit_type${unitCount}" name="unit_type[]" class="form-control select2bs4" style="width: 100%;">
                            <option value="">Select...</option>
                            @foreach ($licenses as $license)
                                <option value="{{ $license->id_units }}">{{ $license->nama_unit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Checkboxes for P, R, T, I, O -->
                    <div class="d-flex flex-wrap mt-2">
                        <div class="form-check form-check-inline mr-3">
                            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="P">
                            <label class="form-check-label">P</label>
                        </div>
                        <div class="form-check form-check-inline mr-3">
                            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="R">
                            <label class="form-check-label">R</label>
                        </div>
                        <div class="form-check form-check-inline mr-3">
                            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="T">
                            <label class="form-check-label">T</label>
                        </div>
                        <div class="form-check form-check-inline mr-3">
                            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="I">
                            <label class="form-check-label">I</label>
                        </div>
                        <div class="form-check form-check-inline mr-3">
                            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="O">
                            <label class="form-check-label">O</label>
                        </div>
                        <!-- Button to remove unit -->
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-danger remove-unit" type="button">Remove</button>
                        </div>
                    </div>
                </div>`;

            unitContainer.insertAdjacentHTML('beforeend', newUnit);
            unitCount++;

            // Initialize Select2 for the new dropdown
            $(`#unit_type${unitCount-1}`).select2({
                theme: 'bootstrap4'
            });
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-unit')) {
                event.target.closest('.unit-group').remove();
            }
        });

        // Photo preview
        function previewImage(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById('preview');
            const label = fileInput.nextElementSibling;

            // Update the label with the file name
            label.innerHTML = file.name;

            // Check if file is an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                };

                reader.readAsDataURL(file);
            } else {
                preview.style.display = "none";
            }
        }

        // Medical Certificate file
        function file_mc() {
            const fileInput = document.getElementById('medical_certificate');
            const fileName = fileInput.files[0].name;
            const label = fileInput.nextElementSibling;

            label.innerHTML = fileName;
        }

        // Driver's License file
        function file_dl() {
            const fileInput = document.getElementById('drivers_license');
            const fileName = fileInput.files[0].name;
            const label = fileInput.nextElementSibling;

            label.innerHTML = fileName;
        }

        // Attachment file
        function file_a() {
            const fileInput = document.getElementById('attachment');
            const fileName = fileInput.files[0].name;
            const label = fileInput.nextElementSibling;

            label.innerHTML = fileName;
        }


        // Toggle form elements for license types
        function toggleFormElements() {
            const licenseType = document.getElementById('license_type').value;
            const simperForm = document.getElementById('simport-form');
            const minepermitForm = document.getElementById('minepermit-form');

            // Reset any form elements that might have been filled
            if (licenseType === '') {
                simperForm.style.display = 'none';
                minepermitForm.style.display = 'none';
                return;
            }

            if (licenseType === '2') {
                // Show Simper & Mine Permit form, hide Mine Permit form
                simperForm.style.display = 'block';
                minepermitForm.style.display = 'none';

                // Make relevant fields required
                document.getElementById('drivers_license').setAttribute('required', 'required');
            } else if (licenseType === '1') {
                // Show Mine Permit form, hide Simper & Mine Permit form
                simperForm.style.display = 'none';
                minepermitForm.style.display = 'block';

                // Remove required attributes from Simper form fields
                if (document.getElementById('drivers_license')) {
                    document.getElementById('drivers_license').removeAttribute('required');
                }
            }
        }

        function toggleSIOInput() {
            const sioSelect = document.getElementById('sio');
            const sioInput = document.getElementById('sio-input');

            if (sioSelect.value === 'yes') {
                sioInput.style.display = 'block';
            } else {
                sioInput.style.display = 'none';
            }
        }

        function fileSIO() {
            const fileInput = document.getElementById('sio_file');
            const fileName = fileInput.files[0] ? fileInput.files[0].name : '';
            const label = fileInput.nextElementSibling; // Mendapatkan label yang berdekatan langsung

            if (fileName) {
                label.textContent = fileName;
            } else {
                label.textContent = 'Choose File SIO';
            }
        }

        // permit type

        // Validasi saat form di-submit
        document.querySelector('form').addEventListener('submit', function(event) {
            const licenseType = document.getElementById('license_type');

            if (!licenseType.value) {
                event.preventDefault();
                licenseType.classList.add('is-invalid');
            } else {
                licenseType.classList.remove('is-invalid');
            }
        });

        // Hapus pesan error saat user memilih opsi
        document.getElementById('license_type').addEventListener('change', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });

        // Validasi saat form di-submit
        document.querySelector('form').addEventListener('submit', function(event) {
            const expiryDate = document.getElementById('expiry_date');

            if (!expiryDate.value) {
                event.preventDefault();
                expiryDate.classList.add('is-invalid');
            } else {
                expiryDate.classList.remove('is-invalid');
            }
        });

        // Hapus pesan error saat user memilih tanggal
        document.getElementById('expiry_date').addEventListener('input', function() {
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    </script>
@endsection
