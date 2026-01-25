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
        $sessions = Session::with('trainer')->paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    // Show the form for creating a new session
    public function create()
    {
        $trainers = Trainer::all();
        $trainees = Trainee::all();
        return view('sessions.create', compact('trainers', 'trainees'));
    }

    // Store a newly created session in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i',
            'days' => 'required|array',
            'link' => 'required|url',
            'trainer_id' => 'required|exists:trainers,id',
            'trainees' => 'required|array',
            'trainees.*' => 'exists:trainees,id',
        ]);

        // Create the session
        $session = Session::create([
            'title' => $validated['title'],
            'time_from' => $validated['time_from'],
            'time_to' => $validated['time_to'],
            'days' => json_encode($validated['days']),
            'link' => $validated['link'],
            'trainer_id' => $validated['trainer_id'],
        ]);

        // Attach selected trainees
        $session->trainees()->attach($validated['trainees']);

        return redirect()->route('sessions.index')->with('success', 'Session created successfully.');
    }

    // Show the form for editing an existing session
    public function edit(Session $session)
    {
        $trainers = Trainer::all();
        $trainees = Trainee::all();
        return view('sessions.edit', compact('session', 'trainers', 'trainees'));
    }

    // Update the specified session in the database
    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i',
            'days' => 'required|array',
            'link' => 'required|url',
            'trainer_id' => 'required|exists:trainers,id',
            'trainees' => 'required|array',
            'trainees.*' => 'exists:trainees,id',
        ]);

        // Update the session
        $session->update([
            'title' => $validated['title'],
            'time_from' => $validated['time_from'],
            'time_to' => $validated['time_to'],
            'days' => json_encode($validated['days']),
            'link' => $validated['link'],
            'trainer_id' => $validated['trainer_id'],
        ]);

        // Sync the trainees (update the pivot table)
        $session->trainees()->sync($validated['trainees']);

        return redirect()->route('sessions.index')->with('success', 'Session updated successfully.');
    }

    // Remove the specified session from the database
    public function destroy(Session $session)
    {
        // Delete the session and the associated trainees from the pivot table
        $session->trainees()->detach();
        $session->delete();

        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully.');
    }
}
