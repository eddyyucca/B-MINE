@extends('layouts.main')

@section('content')
    <!-- About Section -->
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Internal</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Internal</li>
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
                            <h3 class="card-title">Internal Accounts</h3>
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

                        <div class="card-body">
                            <a href="{{ route('dataaccounts_int.tambah') }}" class="btn btn-primary mb-3">
                                <i class="fas fa-plus"></i> Add Internal Account
                            </a>

                            <table id="internal-accounts-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Position</th>
                                        <th>Level</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataKar as $index => $dataKar)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dataKar->nik }}</td>
                                            <td>{{ $dataKar->nama }}</td>
                                            <td>{{ $dataKar->departement }}</td>
                                            <td>{{ $dataKar->jabatan }}</td>
                                            <td>{{ $dataKar->level }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        onclick="openLevelModal('{{ $dataKar->nik }}', '{{ $dataKar->nama }}', '{{ $dataKar->level }}')">
                                                        <i class="fas fa-edit"></i> Change Level
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm ml-1"
                                                        onclick="openDeleteModal('{{ $dataKar->nik }}', '{{ $dataKar->nama }}')">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </div>
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

    <!-- Modal for Level Change -->
    <div class="modal fade" id="changeLevelModal" tabindex="-1" role="dialog" aria-labelledby="changeLevelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLevelModalLabel">Change Account Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dataaccounts_int.update_level') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="nik" id="account_nik">
                        <p>Account Name: <strong id="account_name"></strong></p>
                        <div class="form-group">
                            <label for="level">Select Level</label>
                            <select class="form-control" id="account_level" name="level" required>
                                <option value="">-- Select Level --</option>
                                <option value="admin">Administrator </option>
                                <option value="section_admin">Section Admin </option>
                                <option value="she">SHE Level</option>
                                <option value="pjo">PJO Level</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Delete Account -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dataaccounts_int.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <input type="hidden" name="nik" id="delete_account_nik">
                        <p>Are you sure you want to delete this account?</p>
                        <p>Account: <strong id="delete_account_name"></strong></p>
                        <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> This action cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Destroy existing DataTable instance if it exists
            if ($.fn.dataTable.isDataTable('#internal-accounts-table')) {
                $('#internal-accounts-table').DataTable().destroy();
            }

            // Initialize DataTable with new configuration
            $("#internal-accounts-table").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        });

        // Function to open the level change modal with the correct account data
        function openLevelModal(nik, name, level) {
            // Set hidden input and display values
            document.getElementById('account_nik').value = nik;
            document.getElementById('account_name').innerText = name;

            // Set current level in dropdown
            const levelSelect = document.getElementById('account_level');
            for (let i = 0; i < levelSelect.options.length; i++) {
                if (levelSelect.options[i].value === level) {
                    levelSelect.options[i].selected = true;
                    break;
                }
            }

            // Show the modal
            $('#changeLevelModal').modal('show');
        }

        // Function to open the delete account modal
        function openDeleteModal(nik, name) {
            // Set hidden input and display values
            document.getElementById('delete_account_nik').value = nik;
            document.getElementById('delete_account_name').innerText = name;

            // Show the modal
            $('#deleteAccountModal').modal('show');
        }
    </script>
@endsection
