<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Trainee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $sessions = Session::withCount('trainees')
            ->with('trainer')
            ->get()
            ->filter(fn($s) => !$s->capacity || $s->trainees_count < $s->capacity);

        return view('auth.register', compact('sessions'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:trainees,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'session_id' => ['required', 'exists:sessions,id'],
        ]);

        $trainee = Trainee::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        $trainee->sessions()->attach($request->session_id);

        Auth::guard('trainee')->login($trainee);

        return redirect()->route('trainee.dashboard');
    }
}
