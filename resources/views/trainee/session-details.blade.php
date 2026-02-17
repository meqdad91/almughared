@extends('layouts.trainee')

@section('content')
    <div class="page-header">
        <h2>Session Details</h2>
        <div class="page-actions">
            <a href="{{ route('trainee.session.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
        </div>
    </div>

    {{-- Session Info --}}
    <div class="m-card mb-4">
        <div class="m-card-body">
            <h4 class="mb-3" style="color:#2b1a40; font-weight:700;">{{ $session->title }}</h4>

            <div class="info-row">
                <span class="info-label">Time</span>
                <span class="info-value" style="color:#dc2626; font-weight:500;">
                    {{ \Carbon\Carbon::parse($session->time_from)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->time_to)->format('g:i A') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Days</span>
                <span class="info-value">{{ implode(', ', json_decode($session->days)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Zoom Link</span>
                <span class="info-value">
                    <a href="{{ $session->link }}" target="_blank" style="color:#5f63f2; font-weight:500;">{{ $session->link }}</a>
                </span>
            </div>
        </div>
    </div>

    {{-- Subjects --}}
    <div class="m-card">
        <div class="m-card-header">
            <h3>Subjects</h3>
        </div>
        @if($session->subjects->count())
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th style="width:120px">Date</th>
                                <th>Title</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($session->subjects as $subject)
                                <tr>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold">{{ $subject->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-state" style="padding:2rem;">
                <p>No subjects assigned to this session yet.</p>
            </div>
        @endif
    </div>
@endsection
