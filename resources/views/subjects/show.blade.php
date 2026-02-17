@php
    $layout = auth()->guard('trainer')->check()
        ? 'layouts.trainer'
        : 'layouts.admin';
@endphp

@extends($layout)

@section('content')
    <div class="page-header">
        <h2>Subject Details</h2>
        <div class="page-actions">
            <a href="{{ url()->previous() ?: route('admin.dashboard') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
            @if(auth()->guard('trainer')->check() && $subject->attendances_count === 0)
                <a href="{{ route('trainer.attendance.create', $subject->id) }}" class="btn btn-app btn-app-outline btn-app-sm">
                    Take Attendance
                </a>
            @endif
        </div>
    </div>

    <div class="m-card mb-4">
        <div class="m-card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <h4 class="mb-0" style="color:#2b1a40; font-weight:700;">{{ $subject->title }}</h4>
                @if($subject->session && $subject->session->link)
                    <a href="{{ $subject->session->link }}" class="btn btn-app btn-app-success btn-app-sm" target="_blank">
                        Join The Session
                    </a>
                @endif
            </div>

            <div class="info-row">
                <span class="info-label">Date</span>
                <span class="info-value">{{ $subject->date }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Session</span>
                <span class="info-value">{{ $subject->session->title ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Time</span>
                <span class="info-value" style="color: #dc2626; font-weight:500;">
                    {{ \Carbon\Carbon::parse($subject->session->time_from)->format('g:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($subject->session->time_to)->format('g:i A') }}
                </span>
            </div>

            <div class="mt-3">
                <span class="info-label d-block mb-2">Description</span>
                <div class="desc-content">{!! $subject->description !!}</div>
            </div>
        </div>
    </div>
@endsection
