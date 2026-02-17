@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Attendance Records</h2>
    </div>

    <div class="search-bar mb-4">
        <form method="GET" action="{{ route('admin.users.attendance.index') }}" class="d-flex gap-2 align-items-end flex-wrap">
            <div style="min-width:220px;">
                <label class="form-label mb-1" style="font-size:0.85rem; color:#6b7280;">Filter by Session</label>
                <select name="session_id" class="form-control">
                    <option value="">All Sessions</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                            {{ $session->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-app btn-app-primary btn-app-sm">Filter</button>
            @if(request('session_id'))
                <a href="{{ route('admin.users.attendance.index') }}" class="btn btn-app btn-app-light btn-app-sm">Clear</a>
            @endif
        </form>
    </div>

    @if($attendances->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Trainee</th>
                                <th>Session</th>
                                <th>Subject</th>
                                <th class="text-center" style="width:110px">Date</th>
                                <th class="text-center" style="width:110px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $index => $attendance)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $attendances->firstItem() + $index }}</td>
                                    <td>{{ $attendance->trainee->name ?? '-' }}</td>
                                    <td>{{ $attendance->subject->session->title ?? '-' }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $attendance->subject->title }}</td>
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
                <p>No attendance records found.</p>
            </div>
        </div>
    @endif
@endsection
