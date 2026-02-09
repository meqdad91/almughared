<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Subject;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TrainerController extends Controller
{
    public function index()
    {
        $users = Trainer::with('sessions')->paginate(10);
        return view('admin.users.trainers.index', compact('users'));
    }

    public function create()
    {
        $sessions = Session::all();
        return view('admin.users.trainers.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainers,email',
            'password' => 'required|string|min:6|confirmed',
            'sessions' => 'nullable|array',
            'sessions.*' => 'exists:sessions,id',
        ]);

        $trainer = Trainer::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if (!empty($validated['sessions'])) {
            Session::whereIn('id', $validated['sessions'])->update(['trainer_id' => $trainer->id]);
        }

        return redirect()->route('admin.users.trainers.index')->with('success', 'Trainer created successfully.');
    }

    public function edit(Trainer $trainer)
    {
        $admin = $trainer->load('sessions');
        $sessions = Session::all();
        return view('admin.users.trainers.edit', compact('admin', 'sessions'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('trainers')->ignore($trainer->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'sessions' => 'nullable|array',
            'sessions.*' => 'exists:sessions,id',
        ]);

        $trainer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $trainer->password,
        ]);

        // Assign selected sessions to this trainer
        if (!empty($validated['sessions'])) {
            Session::whereIn('id', $validated['sessions'])->update(['trainer_id' => $trainer->id]);
        }

        return redirect()->route('admin.users.trainers.index')->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('admin.users.trainers.index')->with('success', 'Trainer deleted.');
    }

    public function dashboard()
    {
        $sessions = Session::with(['subjects' => function ($q) {
            $q->approved();
        }])->get();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');

        // Get the next approved subject (by date)
        $nextSubject = Subject::approved()->whereIn('session_id', $sessions->pluck('id'))
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->first();

        // Get all approved subjects in the current month
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');

        $monthlySubjects = Subject::approved()->whereIn('session_id', $sessions->pluck('id'))
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->get();

        return view('trainer.dashboard', compact('nextSubject', 'monthlySubjects'));
    }

    function pendingSessions()
    {
        $sessions = Session::latest()->paginate(10);
        return view('trainer.pending_sessions', compact('sessions'));
    }
    function pendingSubjects(Session $session)
    {
        $subjects = Subject::where('session_id', $session->id)
            ->whereIn('status', ['pending_qa', 'pending_admin', 'rejected_qa', 'rejected_admin'])
            ->latest()
            ->paginate(10);
        return view('trainer.pending_subjects', compact('subjects'));
    }
    function activeSubjects(Request $request, Session $session)
    {
        $subjects = Subject::approved()->where('session_id', $session->id)
            ->withCount('attendances')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('date', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('trainer.subjects', compact('subjects', 'session'));
    }

    public function activeSessions()
    {
        $sessions = Session::withCount('trainees')->orderBy('time_from', 'desc')->paginate(10);
        return view('trainer.active_sessions', compact('sessions'));
    }

    public function sessionStudents(Session $session)
    {
        $session->load('trainees');
        return view('trainer.session_students', compact('session'));
    }
    public function approveSubject(Subject $subject)
    {
        $subject->update(['status' => 'pending_admin', 'rejection_reason' => null]);
        return redirect()->back()->with('success', 'Subject approved and sent to Admin.');
    }

    public function rejectSubject(Request $request, Subject $subject)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        $subject->update(['status' => 'rejected_qa', 'rejection_reason' => $request->rejection_reason]);
        return redirect()->back()->with('success', 'Subject rejected and returned to Trainer.');
    }
}
