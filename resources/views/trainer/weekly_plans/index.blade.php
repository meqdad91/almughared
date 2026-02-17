@extends('layouts.trainer')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Weekly Plans</h2>
        <div class="page-actions">
            <a href="{{ route('trainer.weekly-plans.template') }}" class="btn btn-app btn-app-outline btn-app-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" class="me-1"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/></svg>
                Download Template
            </a>
        </div>
    </div>

    {{-- Upload Section --}}
    <div class="m-card mb-4">
        <div class="m-card-body m-form">
            <h6 class="mb-3" style="color:#2b1a40; font-weight:600;">Upload a new plan</h6>
            <div class="d-flex gap-2 align-items-end flex-wrap">
                <div style="min-width:250px;">
                    <label class="form-label">Select Session</label>
                    <select id="session-select" class="form-select">
                        <option value="">-- Choose Session --</option>
                        @foreach($trainer->sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->title }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-app btn-app-success" onclick="goToUpload()">
                    Upload Plan
                </button>
            </div>
        </div>
    </div>

    {{-- Plans List --}}
    @if($plans->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Session</th>
                                <th class="text-center">Subjects</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Uploaded</th>
                                <th class="text-center" style="width:80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plans as $plan)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration + ($plans->currentPage() - 1) * $plans->perPage() }}</td>
                                    <td class="fw-semibold">{{ $plan->session->title ?? 'N/A' }}</td>
                                    <td class="text-center">{{ count($plan->parsed_data ?? []) }}</td>
                                    <td class="text-center">
                                        @if($plan->status === 'pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @elseif($plan->status === 'approved')
                                            <span class="status-badge status-approved">Approved</span>
                                        @elseif($plan->status === 'declined')
                                            <span class="status-badge status-declined">Declined</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $plan->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('trainer.weekly-plans.show', $plan) }}" class="btn btn-app btn-app-outline btn-app-sm">View</a>
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
                <div class="empty-state-icon">&#128203;</div>
                <p>No weekly plans uploaded yet. Download the template and upload your first plan.</p>
            </div>
        </div>
    @endif

    <script>
        function goToUpload() {
            var sessionId = document.getElementById('session-select').value;
            if (!sessionId) { alert('Please select a session first.'); return; }
            window.location.href = '{{ url("trainer/weekly-plans/upload") }}/' + sessionId;
        }
    </script>
@endsection
