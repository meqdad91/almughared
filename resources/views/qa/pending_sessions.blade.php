@extends('layouts.qa')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📚 Pending Sessions</h3>
        </div>

        @if ($sessions->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 40%">Description</th>
                            <th style="width: 10%">Time From</th>
                            <th style="width: 10%">Time To</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($sessions as $session)
                            <tr class="clickable-row" data-href="{{ route('qa.subjects.pending', $session->id) }}"
                                style="cursor: pointer;">
                                <td class="fw-bold">{{ $session->id }}</td>
                                <td>{{ $session->title }}</td>
                                <td>{{ $session->trainer->name }}</td>
                                <td>{{ $session->time_from }}</td>
                                <td>{{ $session->time_to }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $sessions->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No subjects found. Click <strong>Add Subject</strong> to create one.
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
@endsection