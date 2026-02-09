@extends('layouts.qa')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">⏳ Pending Subjects (QA Review)</h3>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center bg-white shadow-sm rounded">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr class="clickable-row" data-href="{{ route('qa.subjects.show', $subject->id) }}" style="cursor: pointer;">
                                <td class="fw-bold">{{ $subject->id }}</td>
                                <td>{{ $subject->date }}</td>
                                <td>{{ $subject->title }}</td>
                                <td class="text-start">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 100) !!}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $subject->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('qa.subjects.show', $subject->id) }}" class="btn btn-sm btn-primary">
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
                No pending subjects found for this session.
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