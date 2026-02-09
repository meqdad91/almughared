@extends('layouts.trainer')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">👥 Students - {{ $session->title }}</h3>
            <a href="{{ route('trainer.session.active') }}" class="btn btn-sm btn-outline-secondary">
                ← Back to Sessions
            </a>
        </div>

        @if ($session->trainees->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center bg-white shadow-sm rounded">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 30%">Name</th>
                            <th style="width: 35%">Email</th>
                            <th style="width: 25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($session->trainees as $trainee)
                            <tr>
                                <td class="fw-bold">{{ $trainee->id }}</td>
                                <td>{{ $trainee->name }}</td>
                                <td>{{ $trainee->email }}</td>
                                <td>
                                    @if ($trainee->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info py-3 px-4">
                No students registered in this session.
            </div>
        @endif
    </div>
@endsection
