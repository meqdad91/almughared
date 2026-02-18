@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Manage Students</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.trainees.create') }}" class="btn btn-app btn-app-primary btn-app-sm">+ Add Student</a>
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
                                <th class="text-center" style="width:100px">Status</th>
                                <th class="text-center" style="width:110px">Join Date</th>
                                <th class="text-center" style="width:200px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $trainee)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $trainee->id }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $trainee->name }}</td>
                                    <td>{{ $trainee->email }}</td>
                                    <td>
                                        @forelse ($trainee->sessions as $session)
                                            <span class="status-badge status-info" style="font-size:0.75rem;">{{ $session->title }}</span>
                                        @empty
                                            <span class="text-muted">None</span>
                                        @endforelse
                                    </td>
                                    <td class="text-center">
                                        @if ($trainee->status === 'approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @else
                                            <span class="status-badge status-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $trainee->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            @if ($trainee->status !== 'approved')
                                                <form action="{{ route('admin.users.trainees.approve', $trainee->id) }}" method="POST" onsubmit="return confirm('Approve this student?')">
                                                    @csrf
                                                    <button type="submit" class="btn btn-app btn-app-success btn-app-sm">Approve</button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.users.trainees.edit', $trainee->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Edit</a>
                                            <form action="{{ route('admin.users.trainees.destroy', $trainee->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                <p>No students found. Click <strong>Add Student</strong> to create one.</p>
            </div>
        </div>
    @endif

@endsection
