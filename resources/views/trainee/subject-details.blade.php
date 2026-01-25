@extends('layouts.trainee')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">

        <h2 class="mb-4">Subject Details</h2>

        {{-- Subject Info --}}
        <div class="card mb-4">
            <div class="card-body">

                <h4 class="d-flex justify-content-between align-items-center">
                    <span>{{ $subject->title }}</span>

                    <a href="{{ $subject->session->link }}"
                       class="btn btn-success"
                       target="_blank">
                        Join The Session
                    </a>
                </h4>

                <hr>

                <p><strong>Date:</strong> {{ $subject->date }}</p>

                <p><strong>Session:</strong> {{ $subject->session->title }}</p>

                <p class="text-danger">
                    <strong>Time:</strong>
                    {{ \Carbon\Carbon::parse($subject->session->time_from)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($subject->session->time_to)->format('H:i') }}
                </p>

                <p><strong>Description:</strong></p>
                <div>{!! $subject->description !!}</div>

            </div>
        </div>

        @php
            use Carbon\Carbon;

            $trainee = Auth::guard('trainee')->user();

            $hasReviewed = $subject->subject_reviews
                ->where('trainee_id', $trainee->id)
                ->count() > 0;

            $isPastOrToday = Carbon::parse($subject->date)->lte(Carbon::today());
        @endphp

        {{-- Review Section --}}
        @if($isPastOrToday && !$hasReviewed)
            <div class="card">
                <div class="card-header">Leave a Review</div>
                <div class="card-body">

                    <form action="{{ route('trainee.subject.review.store', $subject->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="rate" class="form-label">Rating (1–5)</label>
                            <select name="rate" id="rate" class="form-select" required>
                                <option value="" disabled selected>Choose rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="review" class="form-label">Comment</label>
                            <textarea name="review" id="review" rows="4"
                                      class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Submit Review
                        </button>
                    </form>

                </div>
            </div>

        @elseif(!$isPastOrToday)
            <div class="alert alert-warning">
                ⏳ Reviews will be available after the session date.
            </div>

        @else
            <div class="alert alert-info">
                ✅ You have already submitted a review for this subject.
            </div>
        @endif

        {{-- Existing Reviews --}}
        @if($subject->subject_reviews && $subject->subject_reviews->count())
            <div class="card mt-4">
                <div class="card-header">Reviews</div>
                <div class="card-body">

                    @foreach($subject->subject_reviews as $review)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>Rating:</strong> {{ $review->rate }} / 5 <br>
                            <strong>Comment:</strong> {{ $review->review }} <br>
                            <small class="text-muted">
                                By: {{ $review->trainee->name ?? 'Anonymous' }}
                                on {{ $review->created_at->format('M d, Y') }}
                            </small>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif

    </div>
@endsection
