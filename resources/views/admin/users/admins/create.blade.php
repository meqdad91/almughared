@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Add Admin</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.admins.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to List</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <form method="POST" action="{{ route('admin.users.admins.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter full name..." value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="Enter email..." value="{{ old('email') }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter password..." required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-app btn-app-primary">Save Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
