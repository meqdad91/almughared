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
    public function dashboard()
    {
        $sessions = Session::with('subjects')->get();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');
        $currentDayName = $now->format('l'); // Sunday, Monday...

        // 3. Get the next subject (by date and time)
        $nextSubject = Subject::whereIn('session_id', $sessions->pluck('id'))
            ->whereDate('date', '>=', $today)
            ->orderBy('date')
            ->first();

        // 4. Get all subjects in the current month
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');

        $monthlySubjects = Subject::whereIn('session_id', $sessions->pluck('id'))
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
        $subjects = Subject::where('session_id', $session->id)->latest()->paginate(10);
        return view('trainer.pending_subjects', compact('subjects'));
    }
    function activeSubjects(Session $session)
    {
        $subjects = Subject::approved()->where('session_id', $session->id)->latest()->paginate(10);
        return view('trainer.subjects', compact('subjects'));
    }

    public function activeSessions()
    {
        $sessions = Session::orderBy('time_from', 'desc')->paginate(10);
        return view('trainer.active_sessions', compact('sessions'));
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
