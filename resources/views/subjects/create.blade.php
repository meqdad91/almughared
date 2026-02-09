@php
    $layout = auth()->guard('trainer')->check()
        ? 'layouts.trainer'
        : 'layouts.admin';
@endphp

@extends($layout)


@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h3 class="mb-4">➕ Add New Subject</h3>

        <form action="{{ auth()->guard('trainer')->check() ? route('trainer.subjects.store') : route('admin.users.subjects.store') }}" method="POST">
            @csrf

            <input type="hidden" name="session_id" value="{{ $sessions[0]->id }}">
            <div class="mb-3">
                <label class="form-label">Date:</label>
                <input type="date" name="date" class="form-control" required value="{{ old('date') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" id="editor" rows="6">{{ old('description') }}</textarea>
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
                <a href="{{ auth()->guard('trainer')->check()
                    ? route('trainer.subjects.active', ['session' => $sessions[0]->id ])
                    : route('admin.users.subjects.index')
                }}" class="btn btn-secondary">← Back</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Save Subject
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@endsection
