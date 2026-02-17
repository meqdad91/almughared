@extends('layouts.qa')

@section('content')
    <div class="page-header">
        <h2>Active Sessions</h2>
    </div>

    @if ($sessions->count())
        <div class="row g-3">
            @foreach ($sessions as $session)
                <div class="col-md-6 col-lg-4">
                    <div class="session-card">
                        <div class="session-card-title">{{ $session->title }}</div>
                        <div class="session-card-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M8 3.5a.5.5 0 0 0-1 0V8a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 7.71z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/></svg>
                            {{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->time_to)->format('g:i A') }}
                        </div>
                        <div class="session-card-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                            {{ $session->trainer->name ?? 'N/A' }}
                        </div>
                        <div class="session-card-actions">
                            <a href="{{ route('qa.subjects.active', $session->id) }}" class="btn btn-app btn-app-primary btn-app-sm flex-fill text-center">
                                View Subjects
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $sessions->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128218;</div>
                <p>No active sessions found.</p>
            </div>
        </div>
    @endif
@endsection
