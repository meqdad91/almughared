@extends('layouts.trainee')

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

    @if(Auth::guard('trainee')->user()->status === 'pending')
        <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
            <div class="text-center p-5" style="background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); max-width: 500px; width: 100%;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">&#9203;</div>
                <h3 style="color: #2b1a40; font-weight: 700; margin-bottom: 0.75rem;">Account Pending Approval</h3>
                <p style="color: #64748b; font-size: 1rem; line-height: 1.6;">
                    Your account is currently under review. An administrator will approve your registration shortly. Please check back later.
                </p>
                <div style="margin-top: 1.5rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    @else
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
                <h3>{{ $now->format('F Y') }} &mdash; My Training Calendar</h3>
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
                                        <a href="{{ route('trainee.session.show', $subject->id) }}"
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
    @endif
@endsection
