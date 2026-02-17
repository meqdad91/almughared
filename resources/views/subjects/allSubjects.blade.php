@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>All Subjects</h2>
    </div>

    <div class="search-bar mb-4">
        <form method="GET" action="{{ route('admin.users.subjects.allSubjects') }}" class="d-flex gap-2 align-items-end flex-wrap">
            <div style="min-width:200px;">
                <label class="form-label mb-1" style="font-size:0.85rem; color:#6b7280;">Filter by Session</label>
                <select name="session_id" class="form-control">
                    <option value="">-- All Sessions --</option>
                    @foreach ($sessions as $session)
                        <option value="{{ $session->id }}" {{ request('session_id') == $session->id ? 'selected' : '' }}>
                            {{ $session->title }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:180px;">
                <label class="form-label mb-1" style="font-size:0.85rem; color:#6b7280;">Filter by Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <button type="submit" class="btn btn-app btn-app-primary btn-app-sm">Filter</button>
            @if(request('session_id') || request('date'))
                <a href="{{ route('admin.users.subjects.allSubjects') }}" class="btn btn-app btn-app-light btn-app-sm">Reset</a>
            @endif
        </form>
    </div>

    @if ($subjects->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">ID</th>
                                <th style="width:110px">Date</th>
                                <th>Title</th>
                                <th>Session</th>
                                <th class="text-center" style="width:90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $subject->title }}</td>
                                    <td>{{ $subject->session->title ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.users.subjects.show', $subject->id) }}" class="btn btn-app btn-app-primary btn-app-sm">Show</a>
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
                <div class="empty-state-icon">&#128218;</div>
                <p>No subjects found for the selected filters.</p>
            </div>
        </div>
    @endif
@endsection
