@extends('layouts.trainee')

@section('content')
    <div class="page-header">
        <h2>Subject Details</h2>
        <div class="page-actions">
            @if($subject->session && $subject->session->link)
                <a href="{{ $subject->session->link }}" class="btn btn-app btn-app-success btn-app-sm" target="_blank">
                    Join The Session
                </a>
            @endif
        </div>
    </div>

    {{-- Subject Info --}}
    <div class="m-card mb-4">
        <div class="m-card-body">
            <h4 class="mb-3" style="color:#2b1a40; font-weight:700;">{{ $subject->title }}</h4>

            <div class="info-row">
                <span class="info-label">Date</span>
                <span class="info-value">{{ $subject->date }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Session</span>
                <span class="info-value">{{ $subject->session->title }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Time</span>
                <span class="info-value" style="color:#dc2626; font-weight:500;">
                    {{ \Carbon\Carbon::parse($subject->session->time_from)->format('g:i A') }}
                    -
                    {{ \Carbon\Carbon::parse($subject->session->time_to)->format('g:i A') }}
                </span>
            </div>

            <div class="mt-3">
                <span class="info-label d-block mb-2">Description</span>
                <div class="desc-content">{!! $subject->description !!}</div>
            </div>
        </div>
    </div>

    @php
        use Carbon\Carbon;
        $trainee = Auth::guard('trainee')->user();
        $hasReviewed = $subject->subject_reviews->where('trainee_id', $trainee->id)->count() > 0;
        $isPastOrToday = Carbon::parse($subject->date)->lte(Carbon::today());
    @endphp

    {{-- Review Form --}}
    @if($isPastOrToday && !$hasReviewed)
        <div class="m-card mb-4">
            <div class="m-card-header">
                <h3>Leave a Review</h3>
            </div>
            <div class="m-card-body m-form">
                <form action="{{ route('trainee.subject.review.store', $subject->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="rate" class="form-label">Rating</label>
                        <select name="rate" id="rate" class="form-select" required style="max-width:200px;">
                            <option value="" disabled selected>Choose rating</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Star' : 'Stars' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="review" class="form-label">Comment</label>
                        <textarea name="review" id="review" rows="3" class="form-control" required placeholder="Share your thoughts about this subject..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-app btn-app-success">
                        Submit Review
                    </button>
                </form>
            </div>
        </div>
    @elseif(!$isPastOrToday)
        <div class="m-alert m-alert-warning mb-4">
            Reviews will be available after the session date ({{ $subject->date }}).
        </div>
    @else
        <div class="m-alert m-alert-info mb-4">
            You have already submitted a review for this subject.
        </div>
    @endif

    {{-- Existing Reviews --}}
    @if($subject->subject_reviews && $subject->subject_reviews->count())
        <div class="m-card">
            <div class="m-card-header">
                <h3>Reviews ({{ $subject->subject_reviews->count() }})</h3>
            </div>
            <div class="m-card-body">
                @foreach($subject->subject_reviews as $review)
                    <div class="review-item">
                        <div class="review-meta">
                            <div class="review-avatar">{{ strtoupper(substr($review->trainee->name ?? 'A', 0, 1)) }}</div>
                            <div>
                                <div class="review-author">{{ $review->trainee->name ?? 'Anonymous' }}</div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $review->rate ? 'filled' : '' }}">&#9733;</span>
                                        @endfor
                                    </div>
                                    <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="review-text">{{ $review->review }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
