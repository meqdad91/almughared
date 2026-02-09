@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">➕ Add New Session</h3>

        <form action="{{ route('admin.users.sessions.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Time From:</label>
                    <input type="time" name="time_from" class="form-control" required value="{{ old('time_from') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Time To:</label>
                    <input type="time" name="time_to" class="form-control" required value="{{ old('time_to') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Days (choose multiple):</label>
                <select name="days[]" class="form-select" multiple required>
                    @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <option value="{{ $day }}" {{ collect(old('days'))->contains($day) ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Session Link (URL):</label>
                <input type="url" name="link" class="form-control" required value="{{ old('link') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Teacher:</label>
                <select name="trainer_id" class="form-select" required>
                    <option value="">-- Select Teacher --</option>
                    @foreach ($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                            {{ $trainer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Students:</label>
                <select name="trainees[]" class="form-select" multiple required>
                    @foreach ($trainees as $trainee)
                        <option value="{{ $trainee->id }}" {{ collect(old('trainees'))->contains($trainee->id) ? 'selected' : '' }}>
                            {{ $trainee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.sessions.index') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Save Session
                </button>
            </div>
        </form>
    </div>
@endsection
