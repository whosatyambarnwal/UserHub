<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    /**
     * Show the user login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle a user login request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::user();

        if ($user->isInactive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated. Please contact the administrator.',
            ]);
        }

        $request->session()->regenerate();

        ActivityLog::log('User Login', 'User logged into account portal', Auth::id());

        return redirect()->intended(route('user.dashboard'))->with('success', 'Welcome back!');
    }

    /**
     * Show the user registration form.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('auth.register');
    }

    /**
     * Handle a user registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'mobile.regex' => 'The mobile number format is invalid. Please enter a valid phone number.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
            'role' => 'user',
            'status' => 'active',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        ActivityLog::log('User Registration', 'User registered a new account', $user->id);

        return redirect()->route('user.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            ActivityLog::log('User Logout', 'User logged out', Auth::id());
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
