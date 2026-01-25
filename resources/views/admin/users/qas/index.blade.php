@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">👤 User Management - Admin</h3>
            <a href="{{ route('admin.users.admins.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Admin
            </a>
        </div>

        @if ($users->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 20%">Name</th>
                        <th style="width: 25%">Email</th>
                        <th style="width: 20%">Join Date</th>
                        <th style="width: 30%">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach ($users as $admin)
                        <tr>
                            <td class="fw-bold">{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('admin.users.admins.edit', $admin->id) }}" class="btn btn-sm btn-warning px-3">
                                        ✏️ Edit
                                    </a>

                                    {{-- Delete Form --}}
                                    <form action="{{ route('admin.users.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No users found. Click <strong>Add Admin</strong> to create one.
            </div>
        @endif
    </div>
@endsection
