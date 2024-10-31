@extends('layouts.main')

@section('content')
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Personal Task</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Personal Task</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
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
                                        <th>Code</th>
                                        <th class="no-export">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataReqs as $index => $dataReq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dataReq->nik }}</td>
                                            <td>{{ $dataReq->nama }}</td>
                                            <td>{{ $dataReq->kode }}</td>
                                            <td align="center" class="no-export">
                                                <a href="view_data/{{ $dataReq->kode }}" class="btn btn-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="approve_data/{{ $dataReq->kode }}" class="btn btn-primary">
                                                    <i class="fas fa-check-square"></i>
                                                </a>

                                                @if ($dataReq->attachment_path)
                                                    <!-- Link untuk membuka PDF jika file ada -->
                                                    <a href="{{ asset('storage/app/public/' . str_replace('public/', '', $dataReq->attachment_path)) }}"
                                                        target="_blank" class="btn btn-warning">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">No PDF</span>
                                                @endif
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
