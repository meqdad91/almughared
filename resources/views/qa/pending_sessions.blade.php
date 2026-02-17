@extends('layouts.qa')

@section('content')
    <div class="page-header">
        <h2>Pending Sessions</h2>
    </div>

    @if ($sessions->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">#</th>
                                <th>Title</th>
                                <th>Trainer</th>
                                <th class="text-center">Time</th>
                                <th class="text-center" style="width:80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sessions as $session)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $session->id }}</td>
                                    <td class="fw-semibold">{{ $session->title }}</td>
                                    <td>{{ $session->trainer->name }}</td>
                                    <td class="text-center">
                                        <span class="time-badge">
                                            {{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->time_to)->format('g:i A') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('qa.subjects.pending', $session->id) }}" class="btn btn-app btn-app-outline btn-app-sm">
                                            Review
                                        </a>
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
                <div class="empty-state-icon">&#9989;</div>
                <p>No pending sessions at the moment.</p>
            </div>
        </div>
    @endif
@endsection
