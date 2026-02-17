@extends('layouts.admin')

@section('content')
    <div class="page-header">
        <h2>Subject Reviews</h2>
    </div>

    @if($reviews->count())
        <div class="m-card">
            <div class="m-card-body-flush">
                <div class="table-responsive">
                    <table class="m-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Student</th>
                                <th>Subject</th>
                                <th>Session</th>
                                <th class="text-center" style="width:90px">Rating</th>
                                <th>Comment</th>
                                <th class="text-center" style="width:130px">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td class="text-center fw-semibold">{{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}</td>
                                    <td class="fw-semibold" style="color:#2b1a40;">{{ $review->trainee->name ?? 'Anonymous' }}</td>
                                    <td>{{ $review->subject->title }}</td>
                                    <td>{{ $review->subject->session->title }}</td>
                                    <td class="text-center">
                                        <div class="star-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= $review->rate ? 'filled' : '' }}">&#9733;</span>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ $review->review }}</td>
                                    <td class="text-center">{{ $review->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">{{ $reviews->links() }}</div>
    @else
        <div class="m-card">
            <div class="empty-state">
                <div class="empty-state-icon">&#11088;</div>
                <p>No reviews found.</p>
            </div>
        </div>
    @endif
@endsection
