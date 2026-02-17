@extends('layouts.trainee')

@section('content')
    <div class="page-header">
        <h2>My Attendance</h2>
    </div>

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-total">
                <div class="stat-icon">&#128218;</div>
                <div class="stat-value">{{ $totalSubjects }}</div>
                <div class="stat-label">Total Subjects</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">&#9989;</div>
                <div class="stat-value">{{ $presentCount }}</div>
                <div class="stat-label">Present</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-danger">
                <div class="stat-icon">&#10060;</div>
                <div class="stat-value">{{ $absentCount }}</div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">&#128200;</div>
                <div class="stat-value">{{ $attendanceRate }}%</div>
                <div class="stat-label">Rate</div>
            </div>
        </div>
    </div>

    {{-- Attendance Table --}}
    @if($attendances->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Session</th>
                                <th>Subject</th>
                                <th class="text-center">Date</th>
                                <th class="text-center" style="width:110px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $index => $attendance)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $attendances->firstItem() + $index }}</td>
                                    <td>{{ $attendance->subject->session->title ?? '-' }}</td>
                                    <td class="fw-semibold">{{ $attendance->subject->title }}</td>
                                    <td class="text-center">{{ $attendance->subject->date }}</td>
                                    <td class="text-center">
                                        @if($attendance->status === 'present')
                                            <span class="status-badge status-present">Present</span>
                                        @else
                                            <span class="status-badge status-absent">Absent</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $attendances->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128203;</div>
                <p>No attendance records found yet.</p>
            </div>
        </div>
    @endif
@endsection
