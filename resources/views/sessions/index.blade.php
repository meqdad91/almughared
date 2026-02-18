@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Session Management</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.sessions.create') }}" class="btn btn-app btn-app-primary btn-app-sm">+ Add Session</a>
        </div>
    </div>

    @if ($sessions->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">ID</th>
                                <th>Title</th>
                                <th>Teacher</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Days</th>
                                <th class="text-center" style="width:220px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $session->id }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $session->title }}</td>
                                    <td>{{ $session->trainer->name ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="time-badge">
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->time_from)->format('g:i A') }} -
                                            {{ \Carbon\Carbon::createFromFormat('H:i:s', $session->time_to)->format('g:i A') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $session->trainees_count ?? $session->trainees->count() }} / {{ $session->capacity }}
                                    </td>
                                    <td class="text-center">
                                        @php $days = is_array($session->days) ? $session->days : json_decode($session->days, true); @endphp
                                        {{ $days ? implode(', ', $days) : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.users.subjects.index', ['session_id' => $session->id]) }}" class="btn btn-app btn-app-outline btn-app-sm">Subjects</a>
                                            <a href="{{ route('admin.users.sessions.students', $session->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Students</a>
                                            <a href="{{ route('admin.users.sessions.edit', $session->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Edit</a>
                                            <form action="{{ route('admin.users.sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
        <div class="mt-4">{{ $sessions->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128197;</div>
                <p>No sessions found. Click <strong>Add Session</strong> to create one.</p>
            </div>
        </div>
    @endif
@endsection
