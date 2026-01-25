@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📚 Subject Management</h3>
            <a href="{{ route('admin.users.subjects.create',['session_id' => request('session_id')]) }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Subject
            </a>
        </div>

        @if ($subjects->count())
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center shadow-sm rounded overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th style="width: 5%">ID</th>
                        <th style="width: 10%">date</th>
                        <th style="width: 30%">Title</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach ($subjects as $subject)
                        <tr>
                            <td class="fw-bold">{{ $subject->id }}</td>
                            <td>{{ $subject->date }}</td>
                            <td>{{ $subject->title }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.subjects.show', $subject->id) }}" class="btn btn-sm btn-info px-3">
                                        👁️ Show
                                    </a>
                                    <a href="{{ route('admin.users.subjects.edit', $subject->id) }}" class="btn btn-sm btn-warning px-3">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.users.subjects.destroy', $subject->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
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
