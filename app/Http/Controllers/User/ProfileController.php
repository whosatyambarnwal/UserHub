<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function show(): View
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    /**
     * Update the user profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'mobile' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
        ], [
            'mobile.regex' => 'The mobile number format is invalid. Please enter a valid phone number.',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
        ]);

        ActivityLog::log('Profile Updated', 'User updated their personal profile details', $user->id);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user password.
     */
    public function changePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ], [
            'password.different' => 'The new password must be different from your current password.',
            'current_password.current_password' => 'The provided current password does not match our records.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::log('Password Changed', 'User changed their password', $user->id);

        return redirect()->route('user.profile')->with('success', 'Password changed successfully.');
    }
}
