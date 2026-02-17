@extends('layouts.admin')

@section('content')
    @if(session('success'))
        <div class="m-alert m-alert-success mb-3">{{ session('success') }}</div>
    @endif

    <div class="page-header">
        <h2>Pending Subjects</h2>
    </div>

    @if ($subjects->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">ID</th>
                                <th>Teacher</th>
                                <th style="width:110px">Date</th>
                                <th>Title</th>
                                <th class="text-center" style="width:130px">Status</th>
                                <th class="text-center" style="width:90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr class="clickable-row" data-href="{{ route('admin.users.subjects.pending.show', $subject->id) }}">
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->session->trainer->name ?? 'N/A' }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $subject->title }}</td>
                                    <td class="text-center">
                                        <span class="status-badge status-info">QA Approved</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.subjects.pending.show', $subject->id) }}" class="btn btn-app btn-app-primary btn-app-sm">Review</a>
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
                <p>No pending subjects waiting for Admin approval.</p>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-row').forEach(row => {
                row.addEventListener('click', function (e) {
                    if (!e.target.closest('a, button')) {
                        window.location.href = this.dataset.href;
                    }
                });
            });
        });
    </script>
@endsection
