<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $layout = 'layouts.app';
        if (Auth::guard('admin')->check()) {
            $layout = 'layouts.admin';
        } elseif (Auth::guard('qa')->check()) {
            $layout = 'layouts.qa';
        } elseif (Auth::guard('trainee')->check()) {
            $layout = 'layouts.trainee';
        } elseif (Auth::guard('trainer')->check()) {
            // Assuming a trainer layout exists or falling back to a similar one
            $layout = view()->exists('layouts.trainer') ? 'layouts.trainer' : 'layouts.admin';
        }

        return view('profile.edit', [
            'user' => $request->user(),
            'layout' => $layout,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $user = $request->user();

        // Handle Avatar Upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists and not default
            if ($user->avatar && $user->avatar !== config('chatify.user_avatar.default')) {
                // simple Delete file logic or use Storage::delete
                // Assuming stored in storage/app/public
                \Illuminate\Support\Facades\Storage::delete($user->avatar);
                // OR if it's just a path string relative to public...
                // Better: rely on standard Laravel Storage
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
