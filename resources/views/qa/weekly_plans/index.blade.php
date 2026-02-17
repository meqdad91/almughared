@extends('layouts.qa')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Pending Weekly Plans</h2>
    </div>

    @if($plans->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Session</th>
                                <th>Trainer</th>
                                <th class="text-center">Subjects</th>
                                <th class="text-center">Uploaded</th>
                                <th class="text-center" style="width:90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration + ($plans->currentPage() - 1) * $plans->perPage() }}</td>
                                    <td class="fw-semibold">{{ $plan->session->title ?? 'N/A' }}</td>
                                    <td>{{ $plan->trainer->name ?? 'N/A' }}</td>
                                    <td class="text-center">{{ count($plan->parsed_data ?? []) }}</td>
                                    <td class="text-center">{{ $plan->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('qa.weekly-plans.show', $plan) }}" class="btn btn-app btn-app-primary btn-app-sm">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $plans->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#9989;</div>
                <p>No pending weekly plans to review.</p>
            </div>
        </div>
    @endif
@endsection
