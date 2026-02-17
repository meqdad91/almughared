@php
    $layout = auth()->guard('trainer')->check()
        ? 'layouts.trainer'
        : 'layouts.admin';
@endphp

@extends($layout)

@section('content')
    <div class="page-header">
        <h2>Add New Subject</h2>
        <div class="page-actions">
            @if(auth()->guard('trainer')->check())
                <a href="{{ route('trainer.subjects.active', ['session' => $sessions[0]->id]) }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
            @else
                <a href="{{ route('admin.users.subjects.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
            @endif
        </div>
    </div>

    @if ($errors->any())
        <div class="m-alert m-alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <form action="{{ auth()->guard('trainer')->check() ? route('trainer.subjects.store') : route('admin.users.subjects.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $sessions[0]->id }}">

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required value="{{ old('date') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="editor" rows="6">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-app btn-app-primary">Save Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@endsection
