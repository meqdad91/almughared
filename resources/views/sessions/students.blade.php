@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Manage Students — {{ $session->title }}</h2>
        <div class="page-actions">
            <span class="me-3" style="font-size:0.95rem; color:#555;">{{ $session->trainees->count() }} / {{ $session->capacity }} students</span>
            <a href="{{ route('admin.users.sessions.edit', $session->id) }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to Session</a>
        </div>
    </div>

    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="m-alert m-alert-danger mb-3">{{ session('error') }}</div>
    @endif

    {{-- Add Student --}}
    @if($availableTrainees->count() && $session->trainees->count() < $session->capacity)
        <div class="m-card mb-4">
            <div class="m-card-body">
                <form action="{{ route('admin.users.sessions.addStudent', $session->id) }}" method="POST" class="d-flex align-items-end gap-3">
                    @csrf
                    <div class="flex-grow-1">
                        <label class="form-label">Add Student</label>
                        <select name="trainee_id" class="form-select" required>
                            <option value="">-- Select Student --</option>
                            @foreach ($availableTrainees as $trainee)
                                <option value="{{ $trainee->id }}">{{ $trainee->name }} ({{ $trainee->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-app btn-app-primary btn-app-sm">Add</button>
                </form>
            </div>
        </div>
    @elseif($session->trainees->count() >= $session->capacity)
        <div class="m-alert m-alert-warning mb-3">This session is full ({{ $session->capacity }}/{{ $session->capacity }} students).</div>
    @endif

    {{-- Current Students --}}
    @if($session->trainees->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th style="width:50px" class="text-center">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center" style="width:120px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($session->trainees as $i => $trainee)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="fw-semibold">{{ $trainee->name }}</td>
                                    <td>{{ $trainee->email }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.users.sessions.removeStudent', $session->id) }}" method="POST" onsubmit="return confirm('Remove this student?')">
                                            @csrf
                                            <input type="hidden" name="trainee_id" value="{{ $trainee->id }}">
                                            <button type="submit" class="btn btn-app btn-app-danger btn-app-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128100;</div>
                <p>No students enrolled yet. Use the form above to add students.</p>
            </div>
        </div>
    @endif
@endsection
