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
                {{-- Optional header content --}}
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Complete the data for submission</h3>
                            </div>

                            <div class="card-body">
                                {{-- Form to submit additional data --}}
                                @if (!empty($data_karyawan))
                                    <form id="myForm2" action="{{ route('insert_request') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
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
                                                placeholder="Job Title" value="{{ $data_karyawan['jabatan'] }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="departement">Departement</label>
                                            <input type="text" class="form-control" id="departement" name="departement"
                                                placeholder="Departement" value="{{ $data_karyawan['departement'] }}"
                                                readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="dep_req">Departement Request</label>
                                            <input type="text" class="form-control" id="dep_req" name="dep_req"
                                                placeholder="Departement Request"
                                                value="{{ session('logged_in_user')['departement'] }}" readonly>
                                        </div>
                                        <!-- Pesan error jika departemen tidak sama -->
                                        @if ($data_karyawan['departement'] !== session('logged_in_user')['departement'])
                                            <p class="text-danger mt-2">Request tidak dapat dilanjutkan, departemen berbeda.
                                            </p>
                                        @endif
                                        {{-- Upload photo --}}
                                        <div class="form-group">
                                            <label for="foto_view">Upload Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="foto_view"
                                                        name="foto_view" onchange="previewImage(event)" accept="image/*">
                                                    <label class="custom-file-label" for="foto_view">Choose file</label>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <img id="preview" src="" alt="Image Preview"
                                                    style="max-width: 300px; display: none;">
                                            </div>
                                        </div>
                                        <div class="card card-secondary">
                                            <div class="card-header">
                                                <h3 class="card-title">Access Minepermit</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[CHR-BT]" value="no">
                                                            <input type="checkbox" name="permissions[CHR-BT]"
                                                                id="checkboxCHRBT" value="yes">
                                                            <label for="checkboxCHRBT"> CHR-BT </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[CHR-FSP]"
                                                                value="no">
                                                            <input type="checkbox" name="permissions[CHR-FSP]"
                                                                id="checkboxCHRFSP" value="yes">
                                                            <label for="checkboxCHRFSP"> CHR-FSP </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[CP-FSP]"
                                                                value="no">
                                                            <input type="checkbox" name="permissions[CP-FSP]"
                                                                id="checkboxCPFSP" value="yes">
                                                            <label for="checkboxCPFSP"> CP-FSP </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[CP-BT]"
                                                                value="no">
                                                            <input type="checkbox" name="permissions[CP-BT]"
                                                                id="checkboxCPBT" value="yes">
                                                            <label for="checkboxCPBT"> CP-BT </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[PIT-BT]"
                                                                value="no">
                                                            <input type="checkbox" name="permissions[PIT-BT]"
                                                                id="checkboxPITBT" value="yes">
                                                            <label for="checkboxPITBT"> PIT-BT </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
                                                            <input type="hidden" name="permissions[PIT-TA]"
                                                                value="no">
                                                            <input type="checkbox" name="permissions[PIT-TA]"
                                                                id="checkboxPITTA" value="yes">
                                                            <label for="checkboxPITTA"> PIT-TA </label>
                                                        </div>
                                                        |
                                                        <div class="icheck-primary d-inline">
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
                                        {{-- Medical certificate --}}
                                        <div class="form-group">
                                            <label for="medical_certificate">Medical Certificate</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input"
                                                        id="medical_certificate" name="medical_certificate"
                                                        accept=".pdf" onchange="file_mc()">
                                                    <label class="custom-file-label" for="medical_certificate">Choose
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
                                                    <input type="file" class="custom-file-input" id="attachment"
                                                        name="attachment" accept=".pdf" onchange="file_a()">
                                                    <label class="custom-file-label" for="attachment">Choose
                                                        File
                                                        Attachment</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- License type --}}
                                        <div class="form-group">
                                            <label for="license_type">Choose Simper/MinerPermit:</label>
                                            <select id="license_type" name="license_type" class="form-control"
                                                onchange="toggleFormElements()">
                                                <option value="">Select...</option>
                                                <option value="1">Mine Permit</option>
                                                <option value="2">Simper & Mine Permit</option>
                                            </select>
                                        </div>
                                        {{-- Conditional Simper and Mine Permit --}}
                                        <div id="simport-form" style="display: none;">
                                            <div class="form-group">
                                                <label for="drivers_license">Driver's License</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="drivers_license" name="drivers_license" accept=".pdf"
                                                            onchange="file_dl()">
                                                        <label class="custom-file-label" for="drivers_license">Choose
                                                            File
                                                            Driver's License</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Upload</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sio">SIO:</label>
                                                <select id="sio" name="sio" class="form-control"
                                                    onchange="toggleSIOInput()">
                                                    <option value="">Pilih...</option>
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
                                                            <label class="custom-file-label" for="sio_file">Choose File
                                                                SIO</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="options">Units</label>
                                                <div id="dynamic-units">
                                                    <!-- Unit pertama -->
                                                    <div class="unit-group mb-3">
                                                        <div class="form-group">
                                                            <label for="unit_type">Choose License Type:</label>
                                                            <select id="unit_type" name="unit_type[]"
                                                                class="form-control select2bs4" style="width: 100%;">
                                                                <option value="">Select...</option>
                                                                @foreach ($licenses as $license)
                                                                    <option value="{{ $license->id_units }}">
                                                                        {{ $license->nama_unit }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Checkbox untuk opsi -->
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="options[0][]" value="P" id="checkboxP">
                                                            <label class="form-check-label" for="checkboxP">P</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="options[0][]" value="R" id="checkboxR">
                                                            <label class="form-check-label" for="checkboxR">R</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="options[0][]" value="T" id="checkboxT">
                                                            <label class="form-check-label" for="checkboxT">T</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="options[0][]" value="I" id="checkboxI">
                                                            <label class="form-check-label" for="checkboxI">I</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="options[0][]" value="O" id="checkboxI">
                                                            <label class="form-check-label" for="checkboxI">O</label>
                                                        </div>

                                                        <!-- Tombol untuk menghapus unit -->
                                                        <div class="input-group-append">
                                                            <button class="btn btn-danger remove-unit"
                                                                type="button">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-success" id="add-unit">Add
                                                Option</button>
                                        </div>

                                        {{-- Mine permit form --}}
                                        <div id="minepermit-form" style="display: none;">
                                            <p>Fields for Minepermit will be added here.</p>
                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                                        </div>

                                    </form>
                                @else
                                    <p>No data found for submission. Please check the input.</p>
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

        <!-- Checkboxes untuk P, R, T, I -->
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="P">
            <label class="form-check-label">P</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="R">
            <label class="form-check-label">R</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="T">
            <label class="form-check-label">T</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="I">
            <label class="form-check-label">I</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="options[${unitCount}][]" value="O">
            <label class="form-check-label">O</label>
        </div>

        <!-- Tombol untuk menghapus unit -->
        <div class="input-group-append">
            <button class="btn btn-danger remove-unit" type="button">Remove</button>
        </div>
    </div>`;

            unitContainer.insertAdjacentHTML('beforeend', newUnit);
            unitCount++;
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-unit')) {
                event.target.closest('.unit-group').remove();
            }
        });

        // Foto preview
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

        // File SKS
        function file_mc() {
            const fileInput = document.getElementById('medical_certificate');
            const fileName = fileInput.files[0].name;
            const label = fileInput.nextElementSibling;

            label.innerHTML = fileName;
        }

        // File SIMPOL
        function file_dl() {
            const fileInput = document.getElementById('drivers_license');
            const fileName = fileInput.files[0].name;
            const label = fileInput.nextElementSibling;

            label.innerHTML = fileName;
        }

        // File Attachment
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

            if (licenseType === '2') {
                simperForm.style.display = 'block';
                minepermitForm.style.display = 'none';
            } else if (licenseType === '1') {
                simperForm.style.display = 'none';
                minepermitForm.style.display = 'block';
            } else {
                simperForm.style.display = 'none';
                minepermitForm.style.display = 'none';
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
            const label = document.querySelector(`label[for='${fileInput.id}']`);

            label.innerHTML = fileName ? fileName : 'Choose File SIO';
        }
    </script>
@endsection
