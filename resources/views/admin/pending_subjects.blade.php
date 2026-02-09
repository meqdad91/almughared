@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">⏳ Pending Subjects (Admin Review)</h3>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center bg-white shadow-sm rounded">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Teacher</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr class="clickable-row" data-href="{{ route('admin.users.subjects.pending.show', $subject->id) }}" style="cursor: pointer;">
                                <td class="fw-bold">{{ $subject->id }}</td>
                                <td>{{ $subject->session->trainer->name ?? 'N/A' }}</td>
                                <td>{{ $subject->date }}</td>
                                <td>{{ $subject->title }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">QA Approved</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.subjects.pending.show', $subject->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $subjects->links() }}
            </div>
        @else
            <div class="alert alert-info py-3 px-4">
                No pending subjects waiting for Admin approval.
            </div>
        @endif
    </div>

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
