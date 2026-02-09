@extends('layouts.trainee')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">My Attendance</h3>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total Subjects</h5>
                        <h2 class="fw-bold">{{ $totalSubjects }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">Present</h5>
                        <h2 class="fw-bold text-success">{{ $presentCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Absent</h5>
                        <h2 class="fw-bold text-danger">{{ $absentCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Rate</h5>
                        <h2 class="fw-bold text-primary">{{ $attendanceRate }}%</h2>
                    </div>
                </div>
            </div>
        </div>

        @if($attendances->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 25%">Session</th>
                            <th style="width: 30%">Subject</th>
                            <th style="width: 20%">Date</th>
                            <th style="width: 20%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $index => $attendance)
                            <tr>
                                <td class="fw-bold">{{ $attendances->firstItem() + $index }}</td>
                                <td>{{ $attendance->subject->session->title ?? '-' }}</td>
                                <td>{{ $attendance->subject->title }}</td>
                                <td>{{ $attendance->subject->date }}</td>
                                <td>
                                    @if($attendance->status === 'present')
                                        <span class="badge bg-success">Present</span>
                                    @else
                                        <span class="badge bg-danger">Absent</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No attendance records found.
            </div>
        @endif
    </div>
@endsection
