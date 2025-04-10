 @extends('layouts.main')

 @section('content')
     <!-- About Section -->
     {{-- content --}}
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0">Outstanding Request</h1>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">Outstanding</li>
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
                             <h3 class="card-title">List Outstanding {{ session('logged_in_user')['departement'] }}</h3>
                         </div>
                         <div class="card-body">
                             <table id="example1" class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th>No</th>
                                         <th>NIK</th>
                                         <th>Name</th>
                                         <th class="no-export">Outstanding</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @php
                                         $userLevel = session('logged_in_user')['level'];
                                         $userDepartment = session('logged_in_user')['departement'] ?? null;
                                     @endphp

                                     @foreach ($dataReqs as $index => $dataReq)
                                         @php
                                             $showRow = false;

                                             // Filter berdasarkan level pengguna
                                             if ($userLevel == 'admin' || $userLevel == 'she') {
                                                 // Admin dan SHE melihat semua status
                                                 $showRow = true;
                                             } elseif (
                                                 $userLevel == 'pjo' &&
                                                 $dataReq->status >= 2 &&
                                                 $dataReq->status <= 4
                                             ) {
                                                 // PJO melihat status 2 sampai 4
                                                 $showRow = true;
                                             } elseif (
                                                 ($userLevel == 'bec' || $userLevel == 'ktt') &&
                                                 $dataReq->status >= 3 &&
                                                 $dataReq->status <= 4
                                             ) {
                                                 // BEC dan KTT melihat status 3 sampai 4
                                                 $showRow = true;
                                             } elseif (
                                                 $userLevel == 'section_admin' &&
                                                 $dataReq->status >= 1 &&
                                                 $dataReq->status <= 4
                                             ) {
                                                 // Section Admin melihat status 1 sampai 4 dengan departemen yang sama
                                                 if ($userDepartment == $dataReq->dep_req) {
                                                     $showRow = true;
                                                 }
                                             }
                                         @endphp

                                         @if ($showRow)
                                             <tr>
                                                 <td>{{ $index + 1 }}</td>
                                                 <td>{{ $dataReq->nik }}</td>
                                                 <td
                                                     class="{{ !empty($dataReq->reject_history) ? 'bg-danger text-white' : '' }}">
                                                     {{ $dataReq->nama }}
                                                 </td>
                                                 <td style="text-align: center;">
                                                     @if ($dataReq->status == 1)
                                                         <span
                                                             style="background-color: #17a2b8; color: white; padding: 3px 8px; border-radius: 4px; display: inline-block; width: 100%; text-align: center;">SHE
                                                             Process</span>
                                                     @elseif ($dataReq->status == 2)
                                                         <span
                                                             style="background-color: #007bff; color: white; padding: 3px 8px; border-radius: 4px; display: inline-block; width: 100%; text-align: center;">PJO
                                                             Process</span>
                                                     @elseif ($dataReq->status == 3)
                                                         <span
                                                             style="background-color: #ffc107; color: #212529; padding: 3px 8px; border-radius: 4px; display: inline-block; width: 100%; text-align: center;">BEC
                                                             Process</span>
                                                     @elseif ($dataReq->status == 4)
                                                         <span
                                                             style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 4px; display: inline-block; width: 100%; text-align: center;">KTT
                                                             Process</span>
                                                     @endif
                                                 </td>
                                             </tr>
                                         @endif
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
 @endsection

 @section('scripts')
 @endsection
