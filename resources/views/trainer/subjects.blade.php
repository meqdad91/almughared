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
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('trainer.subjects.active', $session->id) }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search by title or date..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Search
                </button>
                @if(request('search'))
                    <a href="{{ route('trainer.subjects.active', $session->id) }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 10%">Date</th>
                            <th style="width: 20%">Title</th>
                            <th style="width: 35%">Description</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($subjects as $subject)
                            <tr>
                                <td class="fw-bold">
                                    <a href="{{ route('trainer.subjects.show', $subject->id) }}" class="text-decoration-none">
                                        {{ $subject->id }}
                                    </a>
                                </td>
                                <td>{{ $subject->date }}</td>
                                <td>{{ $subject->title }}</td>
                                <td>{!! \Illuminate\Support\Str::limit($subject->description, 50)  !!}</td>
                                <td>
                                    @if($subject->attendances_count === 0)
                                        <a href="{{ route('trainer.attendance.create', $subject->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-clipboard-check me-1"></i> Attendance
                                        </a>
                                    @else
                                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Done</span>
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
                No subjects found. Click <strong>Add Subject</strong> to create one.
            </div>
        @endif
    </div>
@endsection
