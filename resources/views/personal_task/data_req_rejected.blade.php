@extends('layouts.main')
<script>
    function openPdf(nik) {
        const url = '{{ url('karyawan') }}/' + nik + '/idcard-pdf';
        const popup = window.open(url, 'ID Card', 'width=600,height=400'); // Buka popup
        popup.focus(); // Fokus pada popup
    }
</script>


@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Rejected Tasks History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rejected Tasks</li>
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
                            <h3 class="card-title">Rejected Tasks List</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Rejected By</th>
                                        <th>Reason</th>
                                        <th>Rejection Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $userLevel = session('logged_in_user')['level'];
                                        $userDepartment = session('logged_in_user')['departement'] ?? null;
                                    @endphp

                                    @if ($dataReqs->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No rejected tasks found</td>
                                        </tr>
                                    @else
                                        @foreach ($dataReqs as $index => $dataReq)
                                            @php
                                                $rejectHistory = $dataReq->reject_history ?: [];
                                                $showRow = false;

                                                // Filter berdasarkan level pengguna
                                                if (in_array($userLevel, ['admin', 'section_admin', 'pjo'])) {
                                                    // Admin, section_admin, dan PJO melihat semua data reject_history
                                                    $showRow = !empty($rejectHistory);
                                                } elseif (in_array($userLevel, ['bec', 'ktt'])) {
                                                    // BEC dan KTT hanya melihat reject_history dengan nilai 4 dan 5
                                                    $showRow =
                                                        !empty($rejectHistory) &&
                                                        (array_key_exists('4', $rejectHistory) ||
                                                            array_key_exists('5', $rejectHistory));
                                                }
                                            @endphp

                                            @if ($showRow)
                                                @php
                                                    $latestReject = end($rejectHistory);
                                                    $stageMap = [
                                                        2 => 'SHE',
                                                        3 => 'PJO',
                                                        4 => 'BEC',
                                                        5 => 'KTT',
                                                    ];

                                                    $rejectedBy = $latestReject
                                                        ? $stageMap[key($rejectHistory)] ?? 'Unknown'
                                                        : '-';
                                                    $reason = $latestReject['reason'] ?? '-';
                                                    $timestamp = isset($latestReject['timestamp'])
                                                        ? date('Y-m-d H:i:s', strtotime($latestReject['timestamp']))
                                                        : '-';

                                                    // Cek apakah departemen pengguna sama dengan departemen data
                                                    $canClearHistory = $userDepartment == $dataReq->dep;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dataReq->nik }}</td>
                                                    <td>{{ $dataReq->nama }}</td>
                                                    <td>{{ $rejectedBy }}</td>
                                                    <td>{{ $reason }}</td>
                                                    <td>{{ $timestamp }}</td>
                                                    <td>
                                                        @if ($canClearHistory)
                                                            <form
                                                                action="{{ route('clear.reject.history', $dataReq->kode) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure you want to clear this rejection history?')">
                                                                    <i class="fas fa-trash"></i> Clear History
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $dataReqs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @parent
    <script></script>
@endsection
