<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Import the Request class

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            auth()->logout(); // Log out the user to prevent further access
            return redirect('/login')
                ->with('message', 'Please verify your email before logging in.');
        }

        return redirect()->intended($this->redirectPath());
    }

    // Rest of your code...
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
