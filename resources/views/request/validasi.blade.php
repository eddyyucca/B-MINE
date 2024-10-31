@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Employee Data</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Medical Certificate</th>
                    <th>Driver's License</th>
                    <th>Attachment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->nik }}</td>
                        <td>{{ $employee->nama }}</td>
                        <td>
                            @if ($employee->foto_path)
                                <a href="{{ Storage::url($employee->foto_path) }}" target="_blank">View Foto</a>
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>
                            @if ($employee->medical_path)
                                <a href="{{ Storage::url($employee->medical_path) }}" target="_blank">View Medical
                                    Certificate</a>
                            @else
                                No Medical Certificate
                            @endif
                        </td>
                        <td>
                            @if ($employee->drivers_license_path)
                                <a href="{{ Storage::url($employee->drivers_license_path) }}" target="_blank">View Driver's
                                    License</a>
                            @else
                                No Driver's License
                            @endif
                        </td>
                        <td>
                            @if ($employee->attachment_path)
                                <a href="{{ Storage::url($employee->attachment_path) }}" target="_blank">View Attachment</a>
                            @else
                                No Attachment
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
