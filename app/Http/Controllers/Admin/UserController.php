<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the users with filters and search.
     */
    public function index(Request $request): View
    {
        $isTrashView = $request->get('view') === 'trash';

        $query = $isTrashView ? User::onlyTrashed() : User::query();

        // Search Filter (Name, Email, Mobile)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($role = $request->input('role')) {
            if (in_array($role, ['admin', 'user'], true)) {
                $query->where('role', $role);
            }
        }

        // Status Filter
        if ($status = $request->input('status')) {
            if (in_array($status, ['active', 'inactive'], true)) {
                $query->where('status', $status);
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        $activeCount = User::count();
        $trashCount = User::onlyTrashed()->count();

        return view('admin.users.index', compact('users', 'isTrashView', 'activeCount', 'trashCount'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'mobile.regex' => 'The mobile number format is invalid. Please enter a valid phone number.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::log(
            'User Created',
            "Administrator created new user: {$user->name} ({$user->email}) with role [{$user->role}]",
            Auth::id()
        );

        return redirect()->route('admin.users.index')->with('success', "User '{$user->name}' created successfully.");
    }

    /**
     * Display the specified user details.
     */
    public function show(User $user): View
    {
        $userLogs = ActivityLog::where('user_id', $user->id)->latest()->take(10)->get();

        return view('admin.users.show', compact('user', 'userLogs'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View|RedirectResponse
    {
        if ($user->isSuperAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'The Super Administrator account cannot be edited by other administrators.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->isSuperAdmin() && Auth::id() !== $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'The Super Administrator account cannot be modified by other administrators.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'mobile' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'role' => ['required', 'in:admin,user'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'mobile.regex' => 'The mobile number format is invalid. Please enter a valid phone number.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'] ?? null,
            'role' => $user->isSuperAdmin() ? 'admin' : $validated['role'],
            'status' => $user->isSuperAdmin() ? 'active' : $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        ActivityLog::log(
            'User Updated',
            "Administrator updated details for: {$user->name} ({$user->email})",
            Auth::id()
        );

        return redirect()->route('admin.users.index')->with('success', "User '{$user->name}' updated successfully.");
    }

    /**
     * Toggle active/inactive status of the user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The Super Administrator account status cannot be changed.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own active status.');
        }

        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();

        ActivityLog::log(
            'Status Changed',
            "Administrator changed status of {$user->name} to [{$user->status}]",
            Auth::id()
        );

        return redirect()->back()->with('success', "User '{$user->name}' is now {$user->status}.");
    }

    /**
     * Soft delete the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The Super Administrator account cannot be deleted.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        ActivityLog::log(
            'User Deleted',
            "Administrator moved user {$userName} ({$userEmail}) to trash",
            Auth::id()
        );

        return redirect()->route('admin.users.index')->with('success', "User '{$userName}' has been moved to trash.");
    }

    /**
     * Restore a soft-deleted user.
     */
    public function restore(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        ActivityLog::log(
            'User Restored',
            "Administrator restored user {$user->name} ({$user->email}) from trash",
            Auth::id()
        );

        return redirect()->route('admin.users.index', ['view' => 'trash'])->with('success', "User '{$user->name}' restored successfully.");
    }

    /**
     * Permanently delete a user from storage.
     */
    public function forceDelete(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The Super Administrator account cannot be permanently deleted.');
        }

        $userName = $user->name;
        $user->forceDelete();

        ActivityLog::log(
            'User Permanently Deleted',
            "Administrator permanently deleted user {$userName}",
            Auth::id()
        );

        return redirect()->route('admin.users.index', ['view' => 'trash'])->with('success', "User '{$userName}' permanently deleted.");
    }

    /**
     * Impersonate a user (login as user).
     */
    public function impersonate(User $user): RedirectResponse
    {
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'The Super Administrator account cannot be impersonated.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot impersonate yourself.');
        }

        if ($user->isInactive()) {
            return redirect()->back()->with('error', 'Cannot impersonate an inactive user.');
        }

        $adminId = Auth::id();

        ActivityLog::log(
            'Impersonation Started',
            "Administrator started impersonating user {$user->name} ({$user->email})",
            $adminId
        );

        Auth::login($user);
        session(['impersonated_by' => $adminId]);

        return redirect()->route('user.dashboard')->with('info', "You are now impersonating {$user->name}.");
    }

    /**
     * Stop impersonating and return to admin.
     */
    public function leaveImpersonate(): RedirectResponse
    {
        if (! session()->has('impersonated_by')) {
            return redirect()->route('admin.dashboard');
        }

        $adminId = session()->pull('impersonated_by');
        $admin = User::find($adminId);

        if ($admin) {
            Auth::login($admin);
            ActivityLog::log('Impersonation Ended', 'Administrator returned to admin panel', $admin->id);

            return redirect()->route('admin.users.index')->with('success', 'Returned to Administrator panel.');
        }

        Auth::logout();

        return redirect()->route('admin.login')->with('info', 'Session expired. Please login again.');
    }
}
