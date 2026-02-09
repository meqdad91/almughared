@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">Attendance Records</h3>

        <form method="GET" action="{{ route('admin.users.attendance.index') }}" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="session_id" class="form-label">Filter by Session</label>
                    <select name="session_id" id="session_id" class="form-select">
                        <option value="">All Sessions</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                                {{ $session->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                </div>
                @if(request('session_id'))
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.attendance.index') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                @endif
            </div>
        </form>

        @if($attendances->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 20%">Trainee</th>
                            <th style="width: 20%">Session</th>
                            <th style="width: 25%">Subject</th>
                            <th style="width: 15%">Date</th>
                            <th style="width: 15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $index => $attendance)
                            <tr>
                                <td class="fw-bold">{{ $attendances->firstItem() + $index }}</td>
                                <td>{{ $attendance->trainee->name ?? '-' }}</td>
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
