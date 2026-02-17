@extends('layouts.trainer')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="m-alert m-alert-danger mb-3">{{ session('error') }}</div>
    @endif

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
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m-5.6 8H5a2 2 0 0 1-2-2 3 3 0 0 1 .879-2.121A3 3 0 0 1 6 9.5c.174 0 .346.014.512.042A4 4 0 0 0 5.5 11c0 .706.07 1.369.252 1.99A2.9 2.9 0 0 1 5.4 15M4.5 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/></svg>
                            {{ $session->trainees_count ?? 0 }} Students
                        </div>
                        <div class="session-card-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/></svg>
                            {{ $session->subjects_count ?? $session->subjects->count() ?? 0 }} Subjects
                        </div>
                        <div class="session-card-actions">
                            <a href="{{ route('trainer.subjects.active', $session->id) }}" class="btn btn-app btn-app-primary btn-app-sm flex-fill text-center">
                                Subjects
                            </a>
                            <a href="{{ route('trainer.session.students', $session->id) }}" class="btn btn-app btn-app-outline btn-app-sm flex-fill text-center">
                                Students
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
