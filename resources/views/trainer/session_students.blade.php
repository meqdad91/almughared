@extends('layouts.trainer')

@section('content')
    <div class="page-header">
        <h2>Students &mdash; {{ $session->title }}</h2>
        <div class="page-actions">
            <a href="{{ route('trainer.session.active') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to Sessions</a>
        </div>
    </div>

    @if ($session->trainees->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="text-center" style="width:120px">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($session->trainees as $index => $trainee)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $trainee->name }}</td>
                                    <td>{{ $trainee->email }}</td>
                                    <td class="text-center">
                                        @if ($trainee->status === 'approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @else
                                            <span class="status-badge status-pending">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#128101;</div>
                <p>No students registered in this session.</p>
            </div>
        </div>
    @endif
@endsection
