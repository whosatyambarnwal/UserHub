<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login with an admin account.');
        }

        $user = Auth::user();

        if ($user->isInactive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        if (! $user->isAdmin()) {
            abort(403, 'Unauthorized access. Only administrators are allowed to access this area.');
        }

        return $next($request);
    }
}
