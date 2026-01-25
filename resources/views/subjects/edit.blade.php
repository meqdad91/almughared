@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">✏️ Edit Subject</h3>

        @if($subject->status === 'rejected_qa' || $subject->status === 'rejected_admin')
            <div class="alert alert-danger">
                <h5 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Subject Rejected</h5>
                <p>This subject was returned for the following reason:</p>
                <p class="mb-0 fw-bold">"{{ $subject->rejection_reason }}"</p>
                <hr>
                <p class="mb-0 small">Please update the details below to resubmit for approval.</p>
            </div>
        @elseif($subject->status === 'pending_qa')
            <div class="alert alert-warning">
                <i class="bi bi-hourglass-split"></i> This subject is currently awaiting QA approval.
            </div>
        @elseif($subject->status === 'pending_admin')
            <div class="alert alert-info">
                <i class="bi bi-hourglass-split"></i> This subject is approved by QA and is awaiting Admin final approval.
            </div>
        @endif

        <form action="{{ route('admin.users.subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="session_id" value="{{ old('session_id', $subject->session_id) }}">

            <div class="mb-3">
                <label class="form-label">Date:</label>
                <input type="date" name="date" class="form-control" required value="{{ old('date', $subject->date) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title', $subject->title) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" id="editor"
                    rows="6">{{ old('description', $subject->description) }}</textarea>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.subjects.index') }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Update Subject
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection