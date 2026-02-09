@php
    $layout = auth()->guard('trainer')->check()
        ? 'layouts.trainer'
        : 'layouts.admin';
@endphp

@extends($layout)

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">

        <h2 class="mb-4">Subject Details</h2>

        {{-- Subject Info --}}
        <div class="card mb-4">
            <div class="card-body">

                <h4 class="d-flex justify-content-between align-items-center">
                    <span>{{ $subject->title }}</span>

                    @if($subject->session && $subject->session->link)
                        <a href="{{ $subject->session->link }}"
                           class="btn btn-success"
                           target="_blank">
                            Join The Session
                        </a>
                    @endif
                </h4>

                <hr>

                <p><strong>Date:</strong> {{ $subject->date }}</p>

                <p><strong>Session:</strong> {{ $subject->session->title ?? 'N/A' }}</p>

                <p class="text-danger">
                    <strong>Time:</strong>
                    {{ \Carbon\Carbon::parse($subject->session->time_from)->format('g:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($subject->session->time_to)->format('g:i A') }}
                </p>

                <p><strong>Description:</strong></p>
                <div>{!! $subject->description !!}</div>

            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url()->previous() ?: route('trainer.dashboard') }}" class="btn btn-secondary">← Back</a>

            @if(auth()->guard('trainer')->check() && $subject->attendances_count === 0)
                <a href="{{ route('trainer.attendance.create', $subject->id) }}" class="btn btn-outline-primary">
                    <i class="bi bi-clipboard-check me-1"></i> Take Attendance
                </a>
            @endif
        </div>
    </div>
@endsection
