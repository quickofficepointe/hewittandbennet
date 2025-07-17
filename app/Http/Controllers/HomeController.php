<?php

namespace App\Http\Controllers;

use App\Models\CourseRegistration;
use App\Models\hewitt_banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Auth::id()) {
            if (Auth::user()->role == '0') {
                return redirect()->route('director.dashboard');
            } elseif (Auth::user()->role == '1') {
                return redirect()->route('staff.dashboard');
            } elseif (Auth::user()->role == '2') {
                return redirect()->route('student.dashboard');
            } elseif (Auth::user()->role == '3') {
                return redirect()->route('tutor.dashboard');
            }
        }
        return redirect()->back();
    }
}
