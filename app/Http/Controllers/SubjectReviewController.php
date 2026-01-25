<?php
namespace App\Http\Controllers;

use App\Models\SubjectReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectReviewController extends SubjectController
{
    public function index()
    {
        // Get all reviews with trainee and subject info
        $reviews = SubjectReview::with(['trainee', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        SubjectReview::create([
            'subject_id' => $request->subject_id,
            'trainee_id' => Auth::id(), // assumes user is logged in
            'rate' => $request->rate,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

}
