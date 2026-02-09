@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📚 Session Management</h3>
            <a href="{{ route('admin.users.sessions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Session
            </a>
        </div>

        @if ($sessions->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 20%">Title</th>
                            <th style="width: 20%">Teacher</th>
                            <th style="width: 20%">Time</th>
                            <th style="width: 15%">Days</th>
                            <th style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($sessions as $session)
                            <tr>
                                <td class="fw-bold">{{ $session->id }}</td>
                                <td>{{ $session->title }}</td>
                                <td>{{ $session->trainer->name ?? '-' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->time_from)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->time_to)->format('g:i A') }}
                                </td>
                                <td>
                                    @php
                                        $days = json_decode($session->days, true);
                                    @endphp
                                    @if ($days)
                                        {{ implode(', ', $days) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.users.subjects.index', ['session_id' => $session->id]) }}"
                                            class="btn btn-sm btn-info px-3">
                                            📚 Subjects
                                        </a>
                                        <a href="{{ route('admin.users.sessions.edit', $session->id) }}"
                                            class="btn btn-sm btn-warning px-3">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.users.sessions.destroy', $session->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
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
                {{ $sessions->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No sessions found. Click <strong>Add Session</strong> to create one.
            </div>
        @endif
    </div>
@endsection