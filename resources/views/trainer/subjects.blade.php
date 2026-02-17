@extends('layouts.trainer')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="m-alert m-alert-danger mb-3">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <h2>Subject Management</h2>
        <div class="page-actions">
            <a href="{{ route('trainer.subjects.create', ['session_id' => request('session_id')]) }}"
                class="btn btn-app btn-app-primary">
                + Add Subject
            </a>
        </div>
    </div>

    <div class="search-bar">
        <form method="GET" action="{{ route('trainer.subjects.active', $session->id) }}" class="d-flex gap-2 flex-fill">
            <input type="text" name="search" class="form-control" placeholder="Search by title or date..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-app btn-app-primary btn-app-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('trainer.subjects.active', $session->id) }}" class="btn btn-app btn-app-light btn-app-sm">Clear</a>
            @endif
        </form>
    </div>

    @if ($subjects->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">#</th>
                                <th style="width:110px">Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center" style="width:140px">Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="text-center fw-semibold">
                                        <a href="{{ route('trainer.subjects.show', $subject->id) }}" class="text-decoration-none" style="color: #5f63f2;">
                                            {{ $subject->id }}
                                        </a>
                                    </td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold">
                                        <a href="{{ route('trainer.subjects.show', $subject->id) }}" class="text-decoration-none" style="color: #2b1a40;">
                                            {{ $subject->title }}
                                        </a>
                                    </td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 50) !!}</td>
                                    <td class="text-center">
                                        @if($subject->attendances_count === 0)
                                            <a href="{{ route('trainer.attendance.create', $subject->id) }}" class="btn btn-app btn-app-outline btn-app-sm">
                                                Take Attendance
                                            </a>
                                        @else
                                            <span class="status-badge status-approved">Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $subjects->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128218;</div>
                <p>No subjects found. Click <strong>Add Subject</strong> to create one.</p>
            </div>
        </div>
    @endif
@endsection
