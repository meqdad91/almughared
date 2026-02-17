@extends('layouts.qa')

@section('content')
    <div class="page-header">
        <h2>Subjects &mdash; {{ $session->title }}</h2>
        <div class="page-actions">
            <a href="{{ route('qa.session.active') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to Sessions</a>
        </div>
    </div>

    <div class="search-bar">
        <form method="GET" action="{{ route('qa.subjects.active', $session->id) }}" class="d-flex gap-2 flex-fill">
            <input type="text" name="search" class="form-control" placeholder="Search by title or date..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-app btn-app-primary btn-app-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('qa.subjects.active', $session->id) }}" class="btn btn-app btn-app-light btn-app-sm">Clear</a>
            @endif
        </form>
    </div>

    @if ($subjects->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">#</th>
                                <th style="width:110px">Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center" style="width:140px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr class="clickable-row" data-href="{{ route('qa.subjects.show', $subject->id) }}">
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $subject->title }}</td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 60) !!}</td>
                                    <td class="text-center">
                                        @if($subject->status === 'approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @elseif($subject->status === 'pending_admin')
                                            <span class="status-badge status-info">Pending Admin</span>
                                        @elseif($subject->status === 'rejected_qa')
                                            <span class="status-badge status-rejected">Rejected QA</span>
                                        @elseif($subject->status === 'rejected_admin')
                                            <span class="status-badge status-rejected">Rejected Admin</span>
                                        @else
                                            <span class="status-badge status-pending">{{ ucfirst(str_replace('_', ' ', $subject->status)) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $subjects->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128218;</div>
                <p>No subjects found.</p>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-row').forEach(function(row) {
                row.addEventListener('click', function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
@endsection
