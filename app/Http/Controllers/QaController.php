<?php

namespace App\Http\Controllers;

use App\Models\Qa;
use App\Models\Session;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class QaController extends Controller
{
    public function index()
    {
        $users = Qa::paginate(10);
        return view('admin.users.qas.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.qas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:qas,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Qa::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.qas.index')->with('success', 'QA created successfully.');
    }

    public function edit(Qa $qa)
    {
        $admin = $qa;
        return view('admin.users.qas.edit', compact('admin'));
    }

    public function update(Request $request, Qa $qa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('qas')->ignore($qa->id)],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $qa->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $qa->password,
        ]);

        return redirect()->route('admin.users.qas.index')->with('success', 'QA updated successfully.');
    }

    public function destroy(Qa $qa)
    {
        $qa->delete();
        return redirect()->route('admin.users.qas.index')->with('success', 'QA deleted.');
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
        return view('qa.dashboard', compact('nextSubject', 'monthlySubjects'));
    }

    function pendingSessions()
    {
        $sessions = Session::latest()->paginate(10);
        return view('qa.pending_sessions', compact('sessions'));
    }
    function pendingSubjects(Session $session)
    {
        $subjects = Subject::where('session_id', $session->id)
            ->where('status', 'pending_qa')
            ->latest()
            ->paginate(10);
        return view('qa.pending_subjects', compact('subjects'));
    }

    function activeSubjects(Request $request, Session $session)
    {
        $subjects = Subject::where('session_id', $session->id)
            ->where('status', '!=', 'pending_qa')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('date', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
        return view('qa.subjects', compact('subjects', 'session'));
    }

    public function activeSessions()
    {
        $sessions = Session::orderBy('time_from', 'desc')->paginate(10);
        return view('qa.active_sessions', compact('sessions'));
    }
    public function showSubject(Subject $subject)
    {
        $subject->load('session');
        return view('qa.subject_show', compact('subject'));
    }

    public function approveSubject(Subject $subject)
    {
        $subject->update(['status' => 'pending_admin', 'rejection_reason' => null]);
        return redirect()->route('qa.subjects.pending', $subject->session_id)->with('success', 'Subject approved and sent to Admin.');
    }

    public function rejectSubject(Request $request, Subject $subject)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        $subject->update(['status' => 'rejected_qa', 'rejection_reason' => $request->rejection_reason]);
        return redirect()->route('qa.subjects.pending', $subject->session_id)->with('success', 'Subject rejected and returned to Trainer.');
    }
}
