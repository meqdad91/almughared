@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">👤 User Management - Student</h3>
            <a href="{{ route('admin.users.trainees.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Student
            </a>
        </div>

        @if ($users->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 12%">Name</th>
                        <th style="width: 18%">Email</th>
                        <th style="width: 18%">Sessions</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 12%">Join Date</th>
                        <th style="width: 25%">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach ($users as $trainee)
                        <tr>
                            <td class="fw-bold">{{ $trainee->id }}</td>
                            <td>{{ $trainee->name }}</td>
                            <td>{{ $trainee->email }}</td>
                            <td>
                                @forelse ($trainee->sessions as $session)
                                    <span class="badge bg-info text-dark mb-1">{{ $session->title }}</span>
                                @empty
                                    <span class="text-muted">None</span>
                                @endforelse
                            </td>
                            <td>
                                @if ($trainee->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $trainee->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    @if ($trainee->status !== 'approved')
                                        <button type="button" class="btn btn-sm btn-success px-3" data-bs-toggle="modal" data-bs-target="#approveModal{{ $trainee->id }}">
                                            ✅ Approve
                                        </button>
                                    @endif

                                    <a href="{{ route('admin.users.trainees.edit', $trainee->id) }}" class="btn btn-sm btn-warning px-3">
                                        ✏️ Edit
                                    </a>

                                    <form action="{{ route('admin.users.trainees.destroy', $trainee->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
                No users found. Click <strong>Add Student</strong> to create one.
            </div>
        @endif
    </div>

    {{-- Approve Modals --}}
    @foreach ($users as $trainee)
        @if ($trainee->status !== 'approved')
            <div class="modal fade" id="approveModal{{ $trainee->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $trainee->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('admin.users.trainees.approve', $trainee->id) }}">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModalLabel{{ $trainee->id }}">Approve Student: {{ $trainee->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
