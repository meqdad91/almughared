@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">📚 All Subjects</h3>

        <form method="GET" action="{{ route('admin.users.subjects.allSubjects') }}" class="row mb-4 g-3">
            <div class="col-md-4">
                <label for="session_id" class="form-label">Filter by Session:</label>
                <select name="session_id" id="session_id" class="form-select">
                    <option value="">-- All Sessions --</option>
                    @foreach ($sessions as $session)
                        <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                            {{ $session->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="date" class="form-label">Filter by Date:</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">🔍 Filter</button>
                <a href="{{ route('admin.users.subjects.allSubjects') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 15%">Date</th>
                        <th style="width: 30%">Title</th>
                        <th style="width: 30%">Session</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach ($subjects as $subject)
                        <tr>
                            <td class="fw-bold">{{ $subject->id }}</td>
                            <td>{{ $subject->date }}</td>
                            <td>{{ $subject->title }}</td>
                            <td>{{ $subject->session->title ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.users.subjects.show', $subject->id) }}" class="btn btn-sm btn-info px-3">
                                    👁️ Show
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
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No subjects found for the selected filters.
            </div>
        @endif
    </div>
@endsection
