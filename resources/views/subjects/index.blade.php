@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Subject Management</h2>
        <div class="page-actions">
            <a href="{{ route('admin.users.subjects.create',['session_id' => request('session_id')]) }}" class="btn btn-app btn-app-primary btn-app-sm">+ Add Subject</a>
        </div>
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
                                <th class="text-center" style="width:200px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $subject->id }}</td>
                                    <td>{{ $subject->date }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $subject->title }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.users.subjects.show', $subject->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Show</a>
                                            <a href="{{ route('admin.users.subjects.edit', $subject->id) }}" class="btn btn-app btn-app-outline btn-app-sm">Edit</a>
                                            <form action="{{ route('admin.users.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-app btn-app-danger btn-app-sm">Delete</button>
                                            </form>
                                        </div>
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
                <p>No subjects found. Click <strong>Add Subject</strong> to create one.</p>
            </div>
        </div>
    @endif
@endsection
