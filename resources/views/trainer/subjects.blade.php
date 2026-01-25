@extends('layouts.trainer')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📚 Subject Management</h3>
            <a href="{{ route('trainer.subjects.create', ['session_id' => request('session_id')]) }}"
                class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Subject
            </a>
        </div>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 10%">Date</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 40%">Description</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($subjects as $subject)
                            <tr class="clickable-row" data-href="{{ route('trainer.subjects.show', $subject->id) }}"
                                style="cursor: pointer;">
                                <td class="fw-bold">{{ $subject->id }}</td>
                                <td>{{ $subject->date }}</td>
                                <td>{{ $subject->title }}</td>
                                <td>{!! \Illuminate\Support\Str::limit($subject->description, 50)  !!}</td>
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
