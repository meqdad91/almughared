@extends('layouts.trainer')

@section('content')
    <div class="page-header">
        <h2>Weekly Plan Details</h2>
        <div class="page-actions">
            <a href="{{ route('trainer.weekly-plans.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
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
                    <span class="info-label">Status</span>
                    <div class="mt-1">
                        @if($weeklyPlan->status === 'pending')
                            <span class="status-badge status-pending">Pending</span>
                        @elseif($weeklyPlan->status === 'approved')
                            <span class="status-badge status-approved">Approved</span>
                        @elseif($weeklyPlan->status === 'declined')
                            <span class="status-badge status-declined">Declined</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <span class="info-label">Uploaded</span>
                    <div>{{ $weeklyPlan->created_at->format('M d, Y \a\t g:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    @if($weeklyPlan->status === 'declined' && $weeklyPlan->decline_reason)
        <div class="m-alert m-alert-danger mb-4">
            <strong>Decline Reason:</strong> {{ $weeklyPlan->decline_reason }}
        </div>
    @endif

    {{-- Subjects Table --}}
    <div class="m-card">
        <div class="m-card-header">
            <h3>Parsed Subjects ({{ count($weeklyPlan->parsed_data ?? []) }})</h3>
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

    @if($weeklyPlan->status === 'declined')
        <div class="mt-3">
            <a href="{{ route('trainer.weekly-plans.create', $weeklyPlan->session_id) }}" class="btn btn-app btn-app-primary">
                Re-upload Plan
            </a>
        </div>
    @endif
@endsection
