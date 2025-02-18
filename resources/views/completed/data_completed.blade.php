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
                                                     onclick="openPrintPageFront('{{ $data_completed->kode }}')">Depan</button>
                                                 <button class="btn btn-success text-white"
                                                     onclick="openPrintPageBack('{{ $data_completed->kode }}')">Belakang</button>
                                                 <a href="{{ url('/accept/' . $data_completed->kode) }}"
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
             // Buat URL untuk membuka halaman ID card berdasarkan kode pegawai
             const url = '{{ url('generate-idcardFront') }}/' + kode;
             const popup = window.open(url, 'ID Card', 'width=1500,height=1500');
             popup.focus();
         }

         function openPrintPageBack(kode) {
             // Buat URL untuk membuka halaman ID card berdasarkan kode pegawai
             const url = '{{ url('generate-idcardBack') }}/' + kode;
             const popup = window.open(url, 'ID Card', 'width=1500,height=1500');
             popup.focus();
         }
     </script>
 @endsection

 @section('scripts')
 @endsection
