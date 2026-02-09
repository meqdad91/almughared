@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">📄 Subject Details</h4>
                <a href="{{ route('admin.users.subjects.pending') }}" class="btn btn-light btn-sm">← Back to Pending</a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6 class="text-muted">Session:</h6>
                        <p class="fs-5">{{ $subject->session->title ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Teacher:</h6>
                        <p class="fs-5">{{ $subject->session->trainer->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted">Status:</h6>
                        <span class="badge bg-info text-dark fs-6">{{ $subject->status }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Date:</h6>
                    <p class="fs-5">{{ $subject->date }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted">Title:</h6>
                    <p class="fs-5 fw-semibold">{{ $subject->title }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Description:</h6>
                    <div class="border rounded p-3 bg-white">
                        {!! $subject->description !!}
                    </div>
                </div>

                @if($subject->rejection_reason)
                    <div class="alert alert-danger mb-4">
                        <h6 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Previous Rejection Reason:</h6>
                        <p class="mb-0">{{ $subject->rejection_reason }}</p>
                    </div>
                @endif

                <hr>

                @if($subject->status === 'pending_admin')
                    <div class="d-flex gap-3">
                        {{-- Approve --}}
                        <form action="{{ route('admin.users.subjects.approve', $subject->id) }}" method="POST"
                              onsubmit="return confirm('Approve this subject to go LIVE?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i> Approve
                            </button>
                        </form>

                        {{-- Reject --}}
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-lg me-1"></i> Reject
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($subject->status === 'pending_admin')
    {{-- Reject Modal --}}
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.subjects.reject', $subject->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Subject: {{ $subject->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Subject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
