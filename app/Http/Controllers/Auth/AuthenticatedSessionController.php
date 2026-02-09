<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use App\Models\Qa;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_type' => 'required|in:admin,qa,trainer,trainee',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $userType = $validated['user_type'];
        $credentials = $request->only('email', 'password');

        if (Auth::guard($userType)->attempt($credentials)) {
            // Check if trainee account is still pending
            if ($userType === 'trainee') {
                $trainee = Auth::guard('trainee')->user();
                if ($trainee->status === 'pending') {
                    Auth::guard('trainee')->logout();
                    return back()->withErrors([
                        'email' => 'Your account is still pending approval. Please wait for admin approval.',
                    ])->withInput();
                }
            }

            $request->session()->regenerate();

            return match ($userType) {
                'admin' => redirect()->intended(route('admin.dashboard')),
                'qa' => redirect()->intended(route('qa.dashboard')),
                'trainer' => redirect()->intended(route('trainer.dashboard')),
                'trainee' => redirect()->route('trainee.dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Detect which guard is logged in
        foreach (['admin', 'qa', 'trainer', 'trainee'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
                break; // only logout the current user
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login'); // or admin login page
    }
}
