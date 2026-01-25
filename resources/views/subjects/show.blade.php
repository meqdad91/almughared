@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <div class="card shadow-sm rounded">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">👁️ View Subject</h4>
                <a href="{{ route('admin.users.subjects.index') }}" class="btn btn-light btn-sm">← Back</a>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h6 class="text-muted">Date:</h6>
                    <p class="fs-5">{{ $subject->date }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Title:</h6>
                    <p class="fs-5 fw-semibold">{{ $subject->title }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted">Description:</h6>
                    <div class="border rounded p-3 bg-white">
                        {!! $subject->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
