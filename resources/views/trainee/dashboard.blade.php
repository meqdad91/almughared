@extends('layouts.trainee')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="mb-4">My Training Calendar</h2>

        @php
            use Carbon\Carbon;

            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();
            $startDay = $startOfMonth->dayOfWeek; // 0 (Sun) - 6 (Sat)

            // Group subjects by date for fast access
            $subjectsByDate = $monthlySubjects->groupBy('date');
        @endphp

        <div class="card">
            <div class="card-body">

                <!-- Month Header -->
                <h4 class="text-center mb-3">
                    {{ $now->format('F Y') }}
                </h4>

                <!-- Calendar -->
                <table class="table table-bordered bg-white" style="table-layout: fixed; width: 100%;">
                    <thead class="table-light text-center">
                    <tr>
                        <th style="width: 14.28%">Sun</th>
                        <th style="width: 14.28%">Mon</th>
                        <th style="width: 14.28%">Tue</th>
                        <th style="width: 14.28%">Wed</th>
                        <th style="width: 14.28%">Thu</th>
                        <th style="width: 14.28%">Fri</th>
                        <th style="width: 14.28%">Sat</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        {{-- Empty cells before month starts --}}
                        @for ($i = 0; $i < $startDay; $i++)
                            <td></td>
                        @endfor

                        {{-- Days of the month --}}
                        @for ($day = 1; $day <= $endOfMonth->day; $day++)
                            @php
                                $currentDate = $now->copy()->startOfMonth()->day($day)->format('Y-m-d');
                            @endphp

                            @php
                                $isToday = $currentDate === now()->format('Y-m-d');
                            @endphp

                            <td style="vertical-align: top;height: 120px; {{ $isToday ? 'background:#e7f1ff; border:2px solid #0d6efd;' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong>{{ $day }}</strong>

                                    @if($isToday)
                                        <span class="badge bg-primary">Today</span>
                                    @endif
                                </div>

                                {{-- Subjects --}}
                                @if(isset($subjectsByDate[$currentDate]))
                                    @foreach($subjectsByDate[$currentDate] as $subject)
                                        <div class="mt-2 p-2 rounded bg-primary text-white small">
                                            <div class="fw-bold" title="{{ $subject->title }}">
                                                <a href="{{ route('trainee.session.show', $subject->id) }}"
                                                   class="text-white text-decoration-underline">
                                                    {{ $subject->title }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>

                            {{-- New row every 7 days --}}
                            @if( ($day + $startDay) % 7 == 0 )
                    </tr><tr>
                        @endif
                        @endfor

                    </tr>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
