@extends('layouts.trainer')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Take Attendance</h3>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $subject->title }}</h5>
                <p class="text-muted mb-1"><strong>Session:</strong> {{ $subject->session->title }}</p>
                <p class="text-muted mb-0"><strong>Date:</strong> {{ $subject->date }}</p>
            </div>
        </div>

        @if($trainees->count())
            <form action="{{ route('trainer.attendance.store', $subject->id) }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 40%">Trainee Name</th>
                                <th style="width: 30%">Email</th>
                                <th style="width: 25%">Present</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trainees as $index => $trainee)
                                <tr>
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td>{{ $trainee->name }}</td>
                                    <td>{{ $trainee->email }}</td>
                                    <td>
                                        <div class="form-check d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox"
                                                   name="attendance[]"
                                                   value="{{ $trainee->id }}"
                                                   {{ isset($existingAttendance[$trainee->id]) && $existingAttendance[$trainee->id]->status === 'present' ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Save Attendance
                    </button>
                </div>
            </form>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No trainees enrolled in this session.
            </div>
        @endif
    </div>
@endsection
