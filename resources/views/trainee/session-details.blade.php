@extends('layouts.trainee')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        <h2 class="mb-4">Session Details</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h4>{{ $session->title }}</h4>
                <p><strong>Time:</strong>
                    <span class="text-danger">
                    {{ \Carbon\Carbon::parse($session->time_from)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($session->time_to)->format('H:i') }}
                </span>
                </p>
                <p><strong>Days:</strong> {{ implode(', ', json_decode($session->days)) }}</p>
                <p><strong>Zoom Link:</strong>
                    <a href="{{ $session->link }}" target="_blank">{{ $session->link }}</a>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Subjects</div>
            <div class="card-body">
                @if($session->subjects->count())
                    <ul class="list-group">
                        @foreach($session->subjects as $subject)
                            <li class="list-group-item">
                                <strong>{{ $subject->date }}:</strong> {{ $subject->title }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No subjects assigned to this session yet.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
