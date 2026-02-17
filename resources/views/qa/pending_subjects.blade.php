@extends('layouts.qa')

@section('content')
    <div class="page-header">
        <h2>Pending Subjects</h2>
        <div class="page-actions">
            <a href="{{ route('qa.session.pending') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back to Sessions</a>
        </div>
    </div>

    @if ($subjects->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:60px">#</th>
                                <th style="width:110px">Date</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="text-center" style="width:130px">Status</th>
                                <th class="text-center" style="width:90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold">{{ $subject->title }}</td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 80) !!}</td>
                                    <td class="text-center">
                                        <span class="status-badge status-pending">{{ ucfirst(str_replace('_', ' ', $subject->status)) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('qa.subjects.show', $subject->id) }}" class="btn btn-app btn-app-primary btn-app-sm">
                                            Review
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $subjects->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#9989;</div>
                <p>No pending subjects for this session.</p>
            </div>
        </div>
    @endif
@endsection
