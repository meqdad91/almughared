@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Edit QA</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.qas.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to List</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <form method="POST" action="{{ route('admin.users.qas.update', $admin->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $admin->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $admin->email) }}" required>
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
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" placeholder="Confirm new password...">
                        </div>

                        <button type="submit" class="btn btn-app btn-app-primary">Update QA</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
