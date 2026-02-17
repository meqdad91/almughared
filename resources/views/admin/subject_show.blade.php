@extends('layouts.admin')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Subject Review</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.subjects.pending') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to Pending</a>
        </div>
    </div>

    <div class="m-card mb-4">
        <div class="m-card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                <h4 class="mb-0" style="color:#2b1a40; font-weight:700;">{{ $subject->title }}</h4>
                <span class="status-badge status-info" style="font-size:0.85rem;">{{ ucfirst(str_replace('_', ' ', $subject->status)) }}</span>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <span class="info-label">Session</span>
                    <div class="fw-semibold" style="font-size:1.05rem; color:#2b1a40;">{{ $subject->session->title ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <span class="info-label">Teacher</span>
                    <div>{{ $subject->session->trainer->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <span class="info-label">Date</span>
                    <div>{{ $subject->date }}</div>
                </div>
            </div>

            <div class="mt-3">
                <span class="info-label d-block mb-2">Description</span>
                <div class="desc-content">{!! $subject->description !!}</div>
            </div>
        </div>
    </div>

    @if($subject->rejection_reason)
        <div class="m-alert m-alert-danger mb-4">
            <strong>Previous Rejection Reason:</strong> {{ $subject->rejection_reason }}
        </div>
    @endif

    @if($subject->status === 'pending_admin')
        <div class="d-flex gap-3">
            <form action="{{ route('admin.users.subjects.approve', $subject->id) }}" method="POST"
                  onsubmit="return confirm('Approve this subject to go LIVE?');">
                @csrf
                <button type="submit" class="btn btn-app btn-app-success">Approve</button>
            </form>

            <button type="button" class="btn btn-app btn-app-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                Reject
            </button>
        </div>
    @endif

    {{-- Reject Modal --}}
    @if($subject->status === 'pending_admin')
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.subjects.reject', $subject->id) }}" method="POST">
                @csrf
                <div class="modal-content" style="border-radius:12px; border:none;">
                    <div class="modal-header" style="border-bottom:1px solid #eee;">
                        <h5 class="modal-title" style="font-weight:600; color:#2b1a40;">Reject Subject: {{ $subject->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-form">
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Explain why this subject is being rejected..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #eee;">
                        <button type="button" class="btn btn-app btn-app-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-app btn-app-danger">Reject Subject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
