@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Edit Student</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.trainees.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to List</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <form method="POST" action="{{ route('admin.users.trainees.update', $trainee->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $trainee->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $trainee->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter new password...">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sessions" class="form-label">Assign Sessions</label>
                            <select name="sessions[]" id="sessions" class="form-select @error('sessions') is-invalid @enderror" multiple size="5">
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->id }}" {{ collect(old('sessions', $trainee->sessions->pluck('id')->toArray()))->contains($session->id) ? 'selected' : '' }}>
                                        {{ $session->title }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl to select multiple sessions</small>
                            @error('sessions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-app btn-app-primary">Update Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
