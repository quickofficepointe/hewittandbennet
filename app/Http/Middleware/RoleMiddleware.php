<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Usage: ->middleware('role:admin,hr'). Directors may also enter any staff
 * module (admin, hr, accountant) so they keep oversight of the whole college.
 */
class RoleMiddleware
{
    private const DIRECTOR_OVERSIGHT = ['admin', 'hr', 'accountant'];

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();

            return redirect()->route('login')->withErrors(['email' => 'Your account has been deactivated. Please contact the administrator.']);
        }

        if (empty($roles) || $user->hasRole(...$roles)) {
            return $next($request);
        }

        if ($user->role === User::DIRECTOR && array_intersect($roles, self::DIRECTOR_OVERSIGHT)) {
            return $next($request);
        }

        abort(403, 'You do not have access to this section.');
    }
}
