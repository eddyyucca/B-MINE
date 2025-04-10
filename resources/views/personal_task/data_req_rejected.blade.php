@extends('layouts.main')
<script>
    function openPdf(nik) {
        const url = '{{ url('karyawan') }}/' + nik + '/idcard-pdf';
        const popup = window.open(url, 'ID Card', 'width=600,height=400'); // Open popup
        popup.focus(); // Focus on popup
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
                            {{-- Success Alert --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Error Alert --}}
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Rejected By</th>
                                        <th>Reason</th>
                                        <th>Rejection Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $userLevel = session('logged_in_user')['level'] ?? 'none';
                                        $userDepartment = session('logged_in_user')['departement'] ?? null;
                                    @endphp

                                    @if ($dataReject->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No rejected tasks found</td>
                                        </tr>
                                    @else
                                        @foreach ($dataReject as $index => $dataRejects)
                                            @php
                                                // Decode JSON string if it's a string
if (is_string($dataRejects->reject_history)) {
    $rejectData = json_decode($dataRejects->reject_history, true) ?? [];
} else {
    $rejectData = is_array($dataRejects->reject_history)
        ? $dataRejects->reject_history
        : [];
}

$showRow = !empty($rejectData);

// Filter based on user level if needed
if (in_array($userLevel, ['bec', 'ktt']) && !empty($rejectData)) {
    // For BEC and KTT, only show if stage is 4 or 5
    $stage = isset($rejectData['stage'])
        ? (int) $rejectData['stage']
                                                        : 0;
                                                    $showRow = $stage == 4 || $stage == 5;
                                                }
                                            @endphp

                                            @if ($showRow)
                                                @php
                                                    $stageMap = [
                                                        '2' => 'SHE',
                                                        '3' => 'PJO',
                                                        '4' => 'BEC',
                                                        '5' => 'KTT',
                                                    ];

                                                    $stage = $rejectData['stage'] ?? '';
                                                    $rejectedBy = isset($stageMap[$stage])
                                                        ? $stageMap[$stage]
                                                        : 'Unknown';
                                                    $reason = $rejectData['reason'] ?? '-';

                                                    // Format the rejection date if it exists
                                                    $timestamp = isset($rejectData['rejected_at'])
                                                        ? date('Y-m-d H:i:s', strtotime($rejectData['rejected_at']))
                                                        : '-';

                                                    // Check if user's department matches data department
                                                    $canClearHistory = $userDepartment == $dataRejects->dept;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $dataRejects->nik }}</td>
                                                    <td>{{ $dataRejects->nama }}</td>
                                                    <td>{{ $rejectedBy }}</td>
                                                    <td>{{ $reason }}</td>
                                                    <td>{{ $timestamp }}</td>
                                                    <td>
                                                        @if ($canClearHistory)
                                                            <form
                                                                action="{{ route('clear.reject.history', $dataRejects->kode) }}"
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
                            {{ $dataReject->links() }}
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
