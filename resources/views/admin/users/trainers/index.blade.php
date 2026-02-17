@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Manage Teachers</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.trainers.create') }}" class="btn btn-app btn-app-primary btn-app-sm">+ Add Teacher</a>
        </div>
    </div>

    @if ($users->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Sessions</th>
                                <th class="text-center" style="width:120px">Join Date</th>
                                <th class="text-center" style="width:160px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $admin)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $admin->id }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @forelse ($admin->sessions as $session)
                                            <span class="status-badge status-info" style="font-size:0.75rem;">{{ $session->title }}</span>
                                        @empty
                                            <span class="text-muted">None</span>
                                        @endforelse
                                    </td>
                                    <td class="text-center">{{ $admin->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.users.trainers.edit', $admin->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Edit</a>
                                            <form action="{{ route('admin.users.trainers.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-app btn-app-danger btn-app-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128100;</div>
                <p>No teachers found. Click <strong>Add Teacher</strong> to create one.</p>
            </div>
        </div>
    @endif
@endsection
