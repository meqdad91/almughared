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
                                                <button type="button" class="btn btn-app btn-app-success btn-app-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $trainee->id }}">
                                                    Approve
                                                </button>
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

    {{-- Approve Modals --}}
    @foreach ($users as $trainee)
        @if ($trainee->status !== 'approved')
            <div class="modal fade" id="approveModal{{ $trainee->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.users.trainees.approve', $trainee->id) }}">
                        @csrf
                        <div class="modal-content" style="border-radius:12px; border:none;">
                            <div class="modal-header" style="border-bottom:1px solid #eee;">
                                <h5 class="modal-title" style="font-weight:600; color:#2b1a40;">Approve Student: {{ $trainee->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body m-form">
                                <div class="mb-3">
                                    <label for="session_id_{{ $trainee->id }}" class="form-label">Assign to Session</label>
                                    <select name="session_id" id="session_id_{{ $trainee->id }}" class="form-select" required>
                                        <option value="">-- Select Session --</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top:1px solid #eee;">
                                <button type="button" class="btn btn-app btn-app-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-app btn-app-success">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endforeach
@endsection
