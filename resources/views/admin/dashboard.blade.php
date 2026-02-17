@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Dashboard Overview</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.sessions.create') }}" class="btn btn-app btn-app-primary btn-app-sm">+ New Session</a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card stat-primary">
                <div class="stat-icon">&#128101;</div>
                <div class="stat-value">{{ $counts['trainees'] }}</div>
                <div class="stat-label">Students</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-success">
                <div class="stat-icon">&#128104;&#8205;&#127979;</div>
                <div class="stat-value">{{ $counts['trainers'] }}</div>
                <div class="stat-label">Teachers</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-warning">
                <div class="stat-icon">&#128737;</div>
                <div class="stat-value">{{ $counts['qas'] }}</div>
                <div class="stat-label">Quality Assurance</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card stat-total">
                <div class="stat-icon">&#128197;</div>
                <div class="stat-value">{{ $counts['sessions'] }}</div>
                <div class="stat-label">Sessions</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="m-card">
                <div class="m-card-header d-flex justify-content-between align-items-center">
                    <h3>Recent Sessions</h3>
                    <a href="{{ route('admin.users.sessions.index') }}" class="btn btn-app btn-app-outline btn-app-sm">View All</a>
                </div>
                <div class="m-card-body-flush">
                    <div class="table-responsive">
                        <table class="m-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Teacher</th>
                                    <th class="text-center">Time</th>
                                    <th class="text-center" style="width:80px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSessions as $session)
                                    <tr>
                                        <td class="fw-semibold" style="color:#2b1a40;">{{ $session->title }}</td>
                                        <td>{{ $session->trainer->name ?? 'Unknown' }}</td>
                                        <td class="text-center">
                                            <span class="time-badge">{{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.users.sessions.edit', $session->id) }}" class="btn btn-app btn-app-light btn-app-sm">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No sessions found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="m-card h-100">
                <div class="m-card-header">
                    <h3>Recent Reviews</h3>
                </div>
                <div class="m-card-body">
                    @forelse($recentReviews as $review)
                        <div class="review-item">
                            <div class="review-avatar">{{ substr($review->trainee->name ?? 'S', 0, 1) }}</div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold" style="color:#2b1a40;">{{ $review->trainee->name ?? 'Student' }}</div>
                                <div class="text-muted" style="font-size:0.82rem;">{{ $review->subject->title ?? 'Subject' }}</div>
                                <div class="star-rating mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= ($review->rate ?? 5) ? 'filled' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">No reviews yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
