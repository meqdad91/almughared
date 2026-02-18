@extends('layouts.admin')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Review Weekly Plan</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.weekly-plans.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
        </div>
    </div>

    {{-- Plan Info --}}
    <div class="m-card mb-4">
        <div class="m-card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <span class="info-label">Session</span>
                    <div class="fw-semibold" style="font-size:1.05rem; color:#2b1a40;">{{ $weeklyPlan->session->title ?? 'N/A' }}</div>
                </div>
                <div class="col-md-4">
                    <span class="info-label">Trainer</span>
                    <div>{{ $weeklyPlan->trainer->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-2">
                    <span class="info-label">Uploaded</span>
                    <div>{{ $weeklyPlan->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
                <div class="col-md-2">
                    <span class="info-label">Status</span>
                    <div>
                        @if($weeklyPlan->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($weeklyPlan->status === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($weeklyPlan->status === 'declined')
                            <span class="badge bg-danger">Declined</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($weeklyPlan->status === 'declined' && $weeklyPlan->decline_reason)
        <div class="m-alert m-alert-danger mb-3">
            <strong>Decline Reason:</strong> {{ $weeklyPlan->decline_reason }}
        </div>
    @endif

    {{-- Subjects Table --}}
    <div class="m-card mb-4">
        <div class="m-card-header">
            <h3>Subjects Preview ({{ count($weeklyPlan->parsed_data ?? []) }})</h3>
        </div>
        <div class="m-card-body-flush">
            <div class="table-responsive">
                <table class="m-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px">#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th class="text-center" style="width:120px">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeklyPlan->parsed_data ?? [] as $i => $subject)
                            <tr>
                                <td class="text-center fw-semibold">{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $subject['title'] }}</td>
                                <td>{!! $subject['description'] !!}</td>
                                <td class="text-center">{{ $subject['date'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($weeklyPlan->status === 'pending')
        <div class="d-flex gap-3">
            <form action="{{ route('admin.users.weekly-plans.approve', $weeklyPlan) }}" method="POST"
                  onsubmit="return confirm('Approve this weekly plan? This will create {{ count($weeklyPlan->parsed_data ?? []) }} subjects.');">
                @csrf
                <button type="submit" class="btn btn-app btn-app-success">Approve Plan</button>
            </form>

            <button type="button" class="btn btn-app btn-app-danger" data-bs-toggle="modal" data-bs-target="#declineModal">
                Decline
            </button>
        </div>
    @endif

    {{-- Decline Modal --}}
    @if($weeklyPlan->status === 'pending')
    <div class="modal fade" id="declineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.users.weekly-plans.decline', $weeklyPlan) }}" method="POST">
                @csrf
                <div class="modal-content" style="border-radius:12px; border:none;">
                    <div class="modal-header" style="border-bottom:1px solid #eee;">
                        <h5 class="modal-title" style="font-weight:600; color:#2b1a40;">Decline Weekly Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-form">
                        <div class="mb-3">
                            <label class="form-label">Decline Reason</label>
                            <textarea name="decline_reason" class="form-control" rows="3" required placeholder="Explain why this plan is being declined..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #eee;">
                        <button type="button" class="btn btn-app btn-app-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-app btn-app-danger">Decline Plan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection
