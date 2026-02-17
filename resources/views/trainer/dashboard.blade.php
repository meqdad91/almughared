@extends('layouts.trainer')

@section('content')
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

    @php
        use Carbon\Carbon;

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startDay = $startOfMonth->dayOfWeek;
        $subjectsByDate = $monthlySubjects->groupBy('date');
    @endphp

    <div class="full-calendar">
        <div class="calendar-header">
            <h3>{{ $now->format('F Y') }} &mdash; My Teaching Calendar</h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Sun</th>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- Empty cells before month starts --}}
                    @for ($i = 0; $i < $startDay; $i++)
                        <td class="empty-cell"></td>
                    @endfor

                    @for ($day = 1; $day <= $endOfMonth->day; $day++)
                        @php
                            $currentDate = $now->copy()->startOfMonth()->day($day)->format('Y-m-d');
                            $isToday = $currentDate === now()->format('Y-m-d');
                        @endphp

                        <td class="{{ $isToday ? 'today-cell' : '' }}">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="day-number">{{ $day }}</span>
                                @if($isToday)
                                    <span class="badge bg-primary" style="font-size: 0.65rem;">Today</span>
                                @endif
                            </div>

                            @if(isset($subjectsByDate[$currentDate]))
                                @foreach($subjectsByDate[$currentDate] as $subject)
                                    <a href="{{ route('trainer.subjects.show', $subject->id) }}"
                                       class="subject-pill"
                                       title="{{ $subject->title }}">
                                        {{ $subject->title }}
                                    </a>
                                @endforeach
                            @endif
                        </td>

                        @if(($day + $startDay) % 7 == 0)
                            </tr><tr>
                        @endif
                    @endfor

                    {{-- Fill remaining cells --}}
                    @php $remaining = (7 - ($endOfMonth->day + $startDay) % 7) % 7; @endphp
                    @for ($i = 0; $i < $remaining; $i++)
                        <td class="empty-cell"></td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </div>
@endsection
