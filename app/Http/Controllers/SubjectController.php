<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('session')->orderBy('date', 'desc')->paginate(10);
        return view('subjects.index', compact('subjects'));
    }

    public function allSubjects(Request $request)
    {
        $subjects = Subject::with('session')
            ->when($request->session_id, fn($q) => $q->where('session_id', $request->session_id))
            ->when($request->date, fn($q) => $q->whereDate('date', $request->date))
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $sessions = \App\Models\Session::all();

        return view('subjects.allSubjects', compact('subjects', 'sessions'));
    }

    public function create()
    {
        $sessions = \App\Models\Session::all();
        return view('subjects.create', compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today|unique:subjects,date,NULL,id,session_id,' . $request->session_id,
        ]);

        Subject::create($request->only('session_id', 'title', 'description', 'date'));

        return redirect()->route('admin.users.subjects.index', ['session_id' => $request->session_id])->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $sessions = \App\Models\Session::all();
        return view('subjects.edit', compact('subject', 'sessions'));
    }

    public function show(Subject $subject)
    {
        return view('subjects.show', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'session_id' => 'required|exists:sessions,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => [
                'required',
                'date',
                'after_or_equal:today',
                Rule::unique('subjects')->where(function ($query) use ($request) {
                    return $query->where('session_id', $request->session_id);
                })->ignore($subject->id),
            ],
        ]);

        $data = $request->only('session_id', 'title', 'description', 'date');

        if (Auth::guard('trainer')->check()) {
            // If trainer updates, reset to pending_qa, clear rejection reason
            $data['status'] = 'pending_qa';
            $data['rejection_reason'] = null;
        } elseif (Auth::guard('admin')->check()) {
            // Admin can force update status if needed, or keep it. For now, let's keep it simple or allow status update via form if we added it.
            // But requirement says Admin approves via pending tab. If admin edits details, maybe keep status or reset? 
            // Let's assume editing details doesn't auto-approve.
        }

        $subject->update($data);

        return redirect()->route('admin.users.subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject deleted.');
    }
}

