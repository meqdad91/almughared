@extends('layouts.qa')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📚 Subjects - {{ $session->title }}</h3>
            <a href="{{ route('qa.session.active') }}" class="btn btn-sm btn-outline-secondary">
                ← Back to Sessions
            </a>
        </div>

        <form method="GET" action="{{ route('qa.subjects.active', $session->id) }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by title or date..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ route('qa.subjects.active', $session->id) }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 12%">Date</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 38%">Description</th>
                            <th style="width: 20%">Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($subjects as $subject)
                            <tr class="clickable-row" data-href="{{ route('qa.subjects.show', $subject->id) }}" style="cursor: pointer;">
                                <td class="fw-bold">{{ $subject->id }}</td>
                                <td>{{ $subject->date }}</td>
                                <td>{{ $subject->title }}</td>
                                <td class="text-start">{!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 80) !!}</td>
                                <td>
                                    @if($subject->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($subject->status === 'pending_admin')
                                        <span class="badge bg-info text-dark">Pending Admin</span>
                                    @elseif($subject->status === 'rejected_qa')
                                        <span class="badge bg-danger">Rejected (QA)</span>
                                    @elseif($subject->status === 'rejected_admin')
                                        <span class="badge bg-danger">Rejected (Admin)</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $subject->status }}</span>
                                    @endif
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
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No subjects found.
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-row').forEach(row => {
                row.addEventListener('click', function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
@endsection
