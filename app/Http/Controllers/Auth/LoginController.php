<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/portal';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** Lets people sign in with either their email address or username (e.g. admission number). */
    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [$field => $login, 'password' => $request->input('password')];
    }

    protected function authenticated(Request $request, $user)
    {
        if (! $user->is_active) {
            $this->guard()->logout();
            $request->session()->invalidate();

            throw ValidationException::withMessages([
                $this->username() => 'Your account has been deactivated. Please contact the administrator.',
            ]);
        }

        $user->forceFill(['last_login_at' => now()])->save();

        return redirect()->intended(route('portal.dashboard'));
    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }
}
