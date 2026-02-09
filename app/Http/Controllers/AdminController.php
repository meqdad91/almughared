<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $users = Admin::paginate(10);
        return view('admin.users.admins.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users.admins.index')->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.users.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin->id)],
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $admin->password,
        ]);

        return redirect()->route('admin.users.admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.users.admins.index')->with('success', 'Admin deleted.');
    }

    public function dashboard()
    {
        $counts = [
            'trainees' => \App\Models\Trainee::count(),
            'trainers' => \App\Models\Trainer::count(),
            'qas' => \App\Models\Qa::count(),
            'admins' => \App\Models\Admin::count(),
            'sessions' => \App\Models\Session::count(),
            'reviews' => \App\Models\SubjectReview::count(),
        ];

        $recentSessions = \App\Models\Session::with('trainer')->latest()->take(5)->get();
        $recentReviews = \App\Models\SubjectReview::with(['trainee', 'subject'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('counts', 'recentSessions', 'recentReviews'));
    }

    public function pendingSubjects()
    {
        $subjects = \App\Models\Subject::where('status', 'pending_admin')->with('session.trainer')->latest()->paginate(10);
        return view('admin.pending_subjects', compact('subjects'));
    }

    public function showPendingSubject(\App\Models\Subject $subject)
    {
        $subject->load('session.trainer');
        return view('admin.subject_show', compact('subject'));
    }

    public function approveSubject(Request $request, \App\Models\Subject $subject)
    {
        $subject->update(['status' => 'approved', 'rejection_reason' => null]);
        return redirect()->route('admin.users.subjects.pending')->with('success', 'Subject approved successfully.');
    }

    public function rejectSubject(Request $request, \App\Models\Subject $subject)
    {
        $request->validate(['rejection_reason' => 'required|string']);
        $subject->update(['status' => 'rejected_admin', 'rejection_reason' => $request->rejection_reason]);
        return redirect()->route('admin.users.subjects.pending')->with('success', 'Subject rejected.');
    }
}
