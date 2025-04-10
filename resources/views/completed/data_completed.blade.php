 @extends('layouts.main')

 @section('content')
     <!-- About Section -->
     {{-- content --}}
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0">Completed Submission</h1>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">Completed Submission</li>
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
                             <h3 class="card-title">List Completed Submission {{ session('logged_in_user')['departement'] }}
                             </h3>
                             @if (session('success'))
                                 <div class="alert alert-success">{{ session('success') }}</div>
                             @endif
                             @if (session('error'))
                                 <div class="alert alert-danger">{{ session('error') }}</div>
                             @endif
                         </div>
                         <div class="card-body">
                             <table id="example1" class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th>No</th>
                                         <th>NIK</th>
                                         <th>Name</th>
                                         <th class="no-export">Actions</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($data_completed as $index => $data_completed)
                                         <tr>
                                             <td>{{ $index + 1 }}</td>
                                             <td>{{ $data_completed->nik }}</td>
                                             <td
                                                 class="{{ !empty($data_completed->reject_history) ? 'bg-danger text-white' : '' }}">
                                                 {{ $data_completed->nama }}</td>
                                             <td class="text-center">
                                                 <button class="btn btn-success text-white"
                                                     onclick="openPrintPageFront('{{ $data_completed->nik }}')">Depan</button>
                                                 <button class="btn btn-success text-white"
                                                     onclick="openPrintPageBack('{{ $data_completed->nik }}')">Belakang</button>
                                                 <a href="{{ route('accept', ['kode' => $data_completed->kode]) }}"
                                                     class="btn btn-primary">Accept</a>
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

     <script>
         function openPrintPageFront(kode) {
             window.open("{{ url('/idcard/generate-idcardFront') }}/" + kode, '_blank');
         }

         function openPrintPageBack(kode) {
             window.open("{{ url('/idcard/generate-idcardBack') }}/" + kode, '_blank');
         }
     </script>
 @endsection

 @section('scripts')
 @endsection
