@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Add New Session</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.sessions.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <form action="{{ route('admin.users.sessions.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time From</label>
                                <input type="time" name="time_from" class="form-control" required value="{{ old('time_from') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Time To</label>
                                <input type="time" name="time_to" class="form-control" required value="{{ old('time_to') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Days (choose multiple)</label>
                            <select name="days[]" class="form-select" multiple required>
                                @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                    <option value="{{ $day }}" {{ collect(old('days'))->contains($day) ? 'selected' : '' }}>{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Session Link (URL)</label>
                            <input type="url" name="link" class="form-control" required value="{{ old('link') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Capacity (max students)</label>
                            <input type="number" name="capacity" class="form-control" required min="1" value="{{ old('capacity') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teacher</label>
                            <select name="trainer_id" class="form-select" required>
                                <option value="">-- Select Teacher --</option>
                                @foreach ($trainers as $trainer)
                                    <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                        {{ $trainer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-app btn-app-primary">Save Session</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
