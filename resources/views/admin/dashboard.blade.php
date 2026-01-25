@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7; min-height: 100vh;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1">Dashboard Overview</h3>
                <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }} 👋</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.sessions.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> New Session
                </a>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Trainees Card -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase text-muted fw-bold small mb-1">Total Trainees</p>
                                <h2 class="fw-bold mb-0 text-primary">{{ $counts['trainees'] }}</h2>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-2 rounded">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('admin.users.trainees.index') }}"
                            class="text-decoration-none small text-muted hover-link">
                            View all trainees <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trainers Card -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase text-muted fw-bold small mb-1">Total Trainers</p>
                                <h2 class="fw-bold mb-0 text-success">{{ $counts['trainers'] }}</h2>
                            </div>
                            <div class="bg-success bg-opacity-10 p-2 rounded">
                                <i class="bi bi-person-video3 text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('admin.users.trainers.index') }}"
                            class="text-decoration-none small text-muted hover-link">
                            View all trainers <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- QA Card -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase text-muted fw-bold small mb-1">Quality Assurance</p>
                                <h2 class="fw-bold mb-0 text-warning">{{ $counts['qas'] }}</h2>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-2 rounded">
                                <i class="bi bi-shield-check text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('admin.users.qas.index') }}"
                            class="text-decoration-none small text-muted hover-link">
                            View all QAs <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sessions Card -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase text-muted fw-bold small mb-1">Total Sessions</p>
                                <h2 class="fw-bold mb-0 text-info">{{ $counts['sessions'] }}</h2>
                            </div>
                            <div class="bg-info bg-opacity-10 p-2 rounded">
                                <i class="bi bi-calendar-event text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-2">
                        <a href="{{ route('admin.users.sessions.index') }}"
                            class="text-decoration-none small text-muted hover-link">
                            Manage sessions <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Recent Sessions Table -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">📅 Upcoming/Recent Sessions</h5>
                        <a href="{{ route('admin.users.sessions.index') }}" class="btn btn-sm btn-outline-primary">View
                            All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Title</th>
                                        <th>Trainer</th>
                                        <th>Time</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentSessions as $session)
                                        <tr>
                                            <td class="ps-4 fw-medium">{{ $session->title }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center text-primary fw-bold"
                                                        style="width: 32px; height: 32px;">
                                                        {{ substr($session->trainer->name ?? 'T', 0, 1) }}
                                                    </div>
                                                    <span>{{ $session->trainer->name ?? 'Unknown' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    {{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }}
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('admin.users.sessions.edit', $session->id) }}"
                                                    class="btn btn-sm btn-light">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">No sessions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold">⭐ Recent Reviews</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @forelse($recentReviews as $review)
                                <div class="list-group-item px-0 border-0 mb-3">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 fw-bold">{{ $review->trainee->name ?? 'Student' }}</h6>
                                            <small class="text-muted">{{ $review->subject->name ?? 'Subject' }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark rounded-pill">
                                            <i class="bi bi-star-fill small"></i> {{ $review->rating ?? 5 }}
                                        </span>
                                    </div>
                                    <p class="mb-1 text-muted small text-truncate" style="max-width: 100%;">
                                        "{{ $review->comment ?? 'No comment provided.' }}"
                                    </p>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">No reviews yet.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-link:hover {
            color: var(--bs-primary) !important;
            text-decoration: underline !important;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection