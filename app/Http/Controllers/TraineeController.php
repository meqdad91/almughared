<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Subject;
use App\Models\SubjectReview;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TraineeController extends Controller
{
    public function index()
    {
        $users = Trainee::with('sessions')->paginate(10);
        return view('admin.users.trainees.index', compact('users'));
    }

    public function create()
    {
        $sessions = Session::all();
        return view('admin.users.trainees.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees,email',
            'password' => 'required|string|min:6|confirmed',
            'sessions' => 'nullable|array',
            'sessions.*' => 'exists:sessions,id',
        ]);

        $trainee = Trainee::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['sessions'])) {
            $trainee->sessions()->attach($validated['sessions']);
        }

        return redirect()->route('admin.users.trainees.index')->with('success', 'Trainee created successfully.');
    }

    public function edit(Trainee $trainee)
    {
        $trainee->load('sessions');
        $sessions = Session::all();
        return view('admin.users.trainees.edit', compact('trainee', 'sessions'));
    }

    public function update(Request $request, Trainee $trainee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('trainees')->ignore($trainee->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'sessions' => 'nullable|array',
            'sessions.*' => 'exists:sessions,id',
        ]);

        $trainee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $trainee->password,
        ]);

        $trainee->sessions()->sync($validated['sessions'] ?? []);

        return redirect()->route('admin.users.trainees.index')->with('success', 'Trainee updated successfully.');
    }

    public function destroy(Trainee $trainee)
    {
        $trainee->delete();
        return redirect()->route('admin.users.trainees.index')->with('success', 'Trainee deleted.');
    }

    public function approve(Request $request, Trainee $trainee)
    {
        $trainee->update(['status' => 'approved']);

        return redirect()->route('admin.users.trainees.index')->with('success', 'Trainee approved successfully.');
    }

    public function dashboard()
    {
        $trainee = Auth::guard('trainee')->user();

        if ($trainee->status === 'pending') {
            return view('trainee.dashboard', ['monthlySubjects' => collect(), 'nextSubject' => null]);
        }

        // 1. Get sessions assigned to the trainee
        $sessions = $trainee->sessions()->with([
            'subjects' => function ($q) {
                $q->approved();
            }
        ])->get();
        // 2. Get today's date and current time
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        // 3. Get the next subject (by date and time) - Filter approved
        $nextSubject = Subject::approved()->whereIn('session_id', $sessions->pluck('id'))
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->first();

        // 4. Get all subjects in the current month - Filter approved
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');

        $monthlySubjects = Subject::approved()->whereIn('session_id', $sessions->pluck('id'))
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->get();
        return view('trainee.dashboard', compact('nextSubject', 'monthlySubjects'));
    }

    public function sessions()
    {
        if (Auth::guard('trainee')->user()->status === 'pending') {
            return redirect()->route('trainee.dashboard')->with('error', 'Your account is pending approval.');
        }

        $subjects = Subject::approved()->with('session')->latest()->paginate(10);
        return view('trainee.sessions', compact('subjects'));
    }

    public function sessionDetails($id)
    {
        if (Auth::guard('trainee')->user()->status === 'pending') {
            return redirect()->route('trainee.dashboard')->with('error', 'Your account is pending approval.');
        }

        $subject = Subject::with('session')->findOrFail($id);

        return view('trainee.subject-details', compact('subject'));
    }

    public function storeReview(Request $request, $id)
    {
        if (Auth::guard('trainee')->user()->status === 'pending') {
            return redirect()->route('trainee.dashboard')->with('error', 'Your account is pending approval.');
        }

        $request->validate([
            'rate' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:1000',
        ]);

        $trainee = auth()->guard('trainee')->user();

        SubjectReview::create([
            'subject_id' => $id,
            'trainee_id' => $trainee->id,
            'rate' => $request->rate,
            'review' => $request->review,
        ]);

        return redirect()->route('trainee.dashboard')->with('success', 'Review submitted successfully.');
    }

}
