@extends('layouts.qa')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">🔴 Active Sessions</h3>

        @if ($sessions->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center bg-white shadow-sm rounded">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Teacher</th>
                            <th>Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session)
                            <tr>
                                <td class="fw-bold">{{ $session->id }}</td>
                                <td>{{ $session->title }}</td>
                                <td>{{ $session->trainer->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }} -
                                        {{ \Carbon\Carbon::parse($session->time_to)->format('g:i A') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('qa.subjects.active', $session->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View Subjects
                                    </a>
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
            <div class="alert alert-info py-3 px-4">
                No active sessions found.
            </div>
        @endif
    </div>
@endsection