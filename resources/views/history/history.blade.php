 @extends('layouts.main')

 @section('content')
     <!-- About Section -->
     {{-- content --}}
     <div class="content-header">
         <div class="container-fluid">
             <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1 class="m-0">History Request</h1>
                 </div>
                 <div class="col-sm-6">
                     <ol class="breadcrumb float-sm-right">
                         <li class="breadcrumb-item"><a href="#">Home</a></li>
                         <li class="breadcrumb-item active">history</li>
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
                             <h3 class="card-title">List History</h3>
                         </div>
                         <div class="card-body">
                             <table id="example1" class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th>No</th>
                                         <th>NIK</th>
                                         <th>Name</th>
                                         <th class="no-export">Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>

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
