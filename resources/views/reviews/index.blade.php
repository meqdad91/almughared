@extends('layouts.admin')

@section('content')
    <div class="col-md-10 p-4" style="background: #f4f5f7">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">📝 Subject Reviews</h3>
            {{-- Optional: Export button or filter --}}
            {{-- <a href="#" class="btn btn-primary"><i class="bi bi-download me-1"></i> Export</a> --}}
        </div>

        @if($reviews->count())
            <div class="table-responsive shadow-sm rounded overflow-hidden">
                <table class="table table-striped table-bordered align-middle text-center mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th style="width:5%">#</th>
                        <th style="width:15%">Trainee</th>
                        <th style="width:20%">Subject</th>
                        <th style="width:20%">Session</th>
                        <th style="width:10%">Rating</th>
                        <th style="width:20%">Comment</th>
                        <th style="width:10%">Date</th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @foreach($reviews as $review)
                        <tr>
                            <td class="fw-bold">{{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}</td>
                            <td>{{ $review->trainee->name ?? 'Anonymous' }}</td>
                            <td>{{ $review->subject->title }}</td>
                            <td>{{ $review->subject->session->title }}</td>
                            <td>{{ $review->rate }} / 5</td>
                            <td>{{ $review->review }}</td>
                            <td>{{ $review->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded py-3 px-4">
                No reviews found.
            </div>
        @endif

    </div>
@endsection
