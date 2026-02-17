@extends('layouts.trainee')

@section('content')
    <div class="page-header">
        <h2>My Sessions</h2>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr class="clickable-row" data-href="{{ route('trainee.session.show', $subject->id) }}">
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $subject->title }}</td>
                                    <td>{!! \Illuminate\Support\Str::limit(strip_tags($subject->description), 60) !!}</td>
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
                <div class="empty-state-icon">&#128218;</div>
                <p>No subjects available yet.</p>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.clickable-row').forEach(function(row) {
                row.addEventListener('click', function () {
                    window.location.href = this.dataset.href;
                });
            });
        });
    </script>
@endsection
