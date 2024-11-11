@extends('layouts.main')

@section('content')
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Personal Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Personal Task</li>
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
                            <h3 class="card-title">Personal Task</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Request</th>
                                        <th class="no-export">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataReqs as $index => $dataReq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dataReq->nik }}</td>
                                            <td>{{ $dataReq->nama }}</td>
                                            <td>
                                                @if ($dataReq->validasi_in == 1)
                                                    Simper & MinePermit
                                                @elseif ($dataReq->validasi_in == 2)
                                                    MinePermit
                                                @else
                                                    {{-- Jika ada nilai lain atau untuk penanganan default --}}
                                                    -
                                                @endif
                                            </td>
                                            <td align="center" class="no-export">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#profileModal"
                                                    data-photo="{{ $dataReq->foto_path ? asset(str_replace('public', 'storage/app/public', $dataReq->foto_path)) : '' }}"
                                                    data-medical="{{ $dataReq->medical_path ? asset(str_replace('public', 'storage/app/public', $dataReq->medical_path)) : '' }}"
                                                    data-license="{{ $dataReq->drivers_license_path ? asset(str_replace('public', 'storage/app/public', $dataReq->drivers_license_path)) : '' }}"
                                                    data-attachment="{{ $dataReq->attachment_path ? asset(str_replace('public', 'storage/app/public', $dataReq->attachment_path)) : '' }}"
                                                    data-name="{{ $dataReq->nama }}" data-nik="{{ $dataReq->nik }}"
                                                    data-jabatan="{{ $dataReq->jab }}"
                                                    data-departement="{{ $dataReq->dept }}">
                                                    Lihat Berkas Pengajuan <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Berkas Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Foto Karyawan -->
                    <img id="employeePhoto" class="img-fluid" alt="Foto Karyawan"
                        style="width: 150px; height: 150px; object-fit: cover; margin-top: 20px; border-radius: 10px;">
                    <p id="photoNotAvailable" style="display: none;">Foto tidak tersedia</p>

                    <!-- Informasi Profil -->
                    <div class="mt-3">
                        <p><strong>Nama:</strong> <span id="profileName"></span></p>
                        <p><strong>NIK:</strong> <span id="profileNik"></span></p>
                        <p><strong>Jabatan:</strong> <span id="profileJabatan"></span></p>
                        <p><strong>Departement:</strong> <span id="profileDepartement"></span></p>
                    </div>

                    <!-- Tombol untuk Melihat Dokumen PDF -->
                    <div class="mt-4">
                        <button type="button" class="btn btn-info" id="medicalBtn">View Medical Certificate</button>
                        <p id="medicalNotAvailable" style="display: none;">Medical Certificate tidak tersedia</p>

                        <button type="button" class="btn btn-info" id="licenseBtn">View Driver's License</button>
                        <p id="licenseNotAvailable" style="display: none;">Driver's License tidak tersedia</p>

                        <button type="button" class="btn btn-info" id="attachmentBtn">View Attachment</button>
                        <p id="attachmentNotAvailable" style="display: none;">Attachment tidak tersedia</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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


    <script>
        $(document).ready(function() {
            $('#profileModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var photoPath = button.data('photo');
                var medicalPath = button.data('medical');
                var licensePath = button.data('license');
                var attachmentPath = button.data('attachment');
                var name = button.data('name');
                var nik = button.data('nik');
                var jabatan = button.data('jabatan');
                var departement = button.data('departement');
                var modal = $(this);
                modal.find('#profileName').text(name || 'Tidak Diketahui');
                modal.find('#profileNik').text(nik || 'Tidak Diketahui');
                modal.find('#profileJabatan').text(jabatan || 'Tidak Diketahui');
                modal.find('#profileDepartement').text(departement || 'Tidak Diketahui');
                // Set foto di dalam modal
                if (photoPath) {
                    modal.find('#employeePhoto').attr('src', photoPath).show();
                    modal.find('#photoNotAvailable').hide(); // Sembunyikan pesan jika foto ada
                } else {
                    modal.find('#employeePhoto').hide(); // Sembunyikan gambar jika foto tidak ada
                    modal.find('#photoNotAvailable').show(); // Tampilkan pesan jika foto tidak ada
                }

                // Cek Medical Certificate
                if (medicalPath) {
                    modal.find('#medicalBtn').show().attr('onclick', "window.open('" + medicalPath +
                        "', '_blank')");
                    modal.find('#medicalNotAvailable').hide(); // Sembunyikan pesan jika file ada
                } else {
                    modal.find('#medicalBtn').hide(); // Sembunyikan tombol jika file tidak ada
                    modal.find('#medicalNotAvailable').show(); // Tampilkan pesan jika file tidak ada
                }

                // Cek Driver's License
                if (licensePath) {
                    modal.find('#licenseBtn').show().attr('onclick', "window.open('" + licensePath +
                        "', '_blank')");
                    modal.find('#licenseNotAvailable').hide();
                } else {
                    modal.find('#licenseBtn').hide();
                    modal.find('#licenseNotAvailable').show();
                }

                // Cek Attachment
                if (attachmentPath) {
                    modal.find('#attachmentBtn').show().attr('onclick', "window.open('" + attachmentPath +
                        "', '_blank')");
                    modal.find('#attachmentNotAvailable').hide();
                } else {
                    modal.find('#attachmentBtn').hide();
                    modal.find('#attachmentNotAvailable').show();
                }
            });
        });


        function viewDocument(doc) {
            window.open(doc, '_blank');
        }
    </script>
@endsection
