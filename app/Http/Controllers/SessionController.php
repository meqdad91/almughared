<?php
namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Trainer;
use App\Models\Trainee;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    // Display a listing of the sessions
    public function index()
    {
        $sessions = Session::with('trainer')->withCount('trainees')->paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    // Show the form for creating a new session
    public function create()
    {
        $trainers = Trainer::all();
        return view('sessions.create', compact('trainers'));
    }

    // Store a newly created session in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'days' => 'required|array',
            'link' => 'required|url',
            'capacity' => 'required|integer|min:1',
            'trainer_id' => 'required|exists:trainers,id',
        ]);

        Session::create($validated);

        return redirect()->route('admin.users.sessions.index')->with('success', 'Session created successfully.');
    }

    // Show the form for editing an existing session
    public function edit(Session $session)
    {
        $trainers = Trainer::all();
        return view('sessions.edit', compact('session', 'trainers'));
    }

    // Update the specified session in the database
    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_from' => 'required',
            'time_to' => 'required',
            'days' => 'required|array',
            'link' => 'required|url',
            'capacity' => 'required|integer|min:1',
            'trainer_id' => 'required|exists:trainers,id',
        ]);

        $session->update($validated);

        return redirect()->route('admin.users.sessions.index')->with('success', 'Session updated successfully.');
    }

    // Show the manage students page for a session
    public function students(Session $session)
    {
        $session->load('trainees');
        $availableTrainees = Trainee::whereNotIn('id', $session->trainees->pluck('id'))->get();
        return view('sessions.students', compact('session', 'availableTrainees'));
    }

    // Add a student to the session
    public function addStudent(Request $request, Session $session)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
        ]);

        if ($session->trainees()->count() >= $session->capacity) {
            return redirect()->route('admin.users.sessions.students', $session)->with('error', 'Session is full. Maximum capacity is ' . $session->capacity . ' students.');
        }

        $session->trainees()->attach($validated['trainee_id']);

        return redirect()->route('admin.users.sessions.students', $session)->with('success', 'Student added successfully.');
    }

    // Remove a student from the session
    public function removeStudent(Request $request, Session $session)
    {
        $validated = $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
        ]);

        $session->trainees()->detach($validated['trainee_id']);

        return redirect()->route('admin.users.sessions.students', $session)->with('success', 'Student removed successfully.');
    }

    // Remove the specified session from the database
    public function destroy(Session $session)
    {
        // Delete the session and the associated trainees from the pivot table
        $session->trainees()->detach();
        $session->delete();

        return redirect()->route('admin.users.sessions.index')->with('success', 'Session deleted successfully.');
    }
}
