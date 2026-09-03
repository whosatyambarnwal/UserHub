<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access your account.');
        }

        $user = Auth::user();

        if ($user->isInactive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact the administrator.');
        }

        // If user is admin and not impersonating, they can be redirected to admin dashboard or allowed
        // But per strict requirement "IsUser -> Only User can access user pages", allow users & impersonating admins
        if ($user->isAdmin() && ! $request->session()->has('impersonated_by')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
