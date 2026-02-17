@extends('layouts.trainer')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Take Attendance</h2>
        <div class="page-actions">
            <a href="{{ url()->previous() }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
        </div>
    </div>

    {{-- Subject Info --}}
    <div class="m-card mb-4">
        <div class="m-card-body" style="padding: 1rem 1.5rem;">
            <div class="d-flex flex-wrap gap-4 align-items-center">
                <div>
                    <span class="info-label">Subject</span>
                    <div class="fw-semibold" style="color:#2b1a40; font-size:1.05rem;">{{ $subject->title }}</div>
                </div>
                <div>
                    <span class="info-label">Session</span>
                    <div>{{ $subject->session->title }}</div>
                </div>
                <div>
                    <span class="info-label">Date</span>
                    <div>{{ $subject->date }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($trainees->count())
        <form action="{{ route('trainer.attendance.store', $subject->id) }}" method="POST">
            @csrf
            <div class="m-card">
                <div class="m-card-body-flush">
                    <div class="table-responsive">
                        <table class="m-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:60px">#</th>
                                    <th>Trainee Name</th>
                                    <th>Email</th>
                                    <th class="text-center" style="width:100px">Present</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainees as $index => $trainee)
                                    <tr>
                                        <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                        <td class="fw-semibold">{{ $trainee->name }}</td>
                                        <td>{{ $trainee->email }}</td>
                                        <td class="text-center">
                                            <input class="m-check" type="checkbox"
                                                   name="attendance[]"
                                                   value="{{ $trainee->id }}"
                                                   {{ isset($existingAttendance[$trainee->id]) && $existingAttendance[$trainee->id]->status === 'present' ? 'checked' : '' }}>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-app btn-app-primary">
                    Save Attendance
                </button>
            </div>
        </form>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128101;</div>
                <p>No trainees enrolled in this session.</p>
            </div>
        </div>
    @endif
@endsection
