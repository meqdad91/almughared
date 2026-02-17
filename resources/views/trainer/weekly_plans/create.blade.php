@extends('layouts.trainer')

@section('content')
    <div class="page-header">
        <h2>Upload Weekly Plan</h2>
        <div class="page-actions">
            <a href="{{ route('trainer.weekly-plans.index') }}" class="btn btn-app btn-app-light btn-app-sm">&larr; Back</a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="m-card">
                <div class="m-card-body m-form">
                    <div class="m-alert m-alert-info mb-4">
                        <strong>Session:</strong> {{ $session->title }}<br>
                        <small>Download the <a href="{{ route('trainer.weekly-plans.template') }}" style="color: #1e40af; font-weight:600;">template file</a>, fill in up to 7 subjects, then upload below.</small>
                    </div>

                    @if($errors->any())
                        <div class="m-alert m-alert-danger mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('trainer.weekly-plans.store', $session) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="file" class="form-label">Select .docx File</label>
                            <input type="file" name="file" id="file" class="form-control" accept=".docx" required>
                            <div class="form-text">Only .docx files accepted. Max 5MB.</div>
                        </div>
                        <button type="submit" class="btn btn-app btn-app-primary">
                            Upload Plan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
