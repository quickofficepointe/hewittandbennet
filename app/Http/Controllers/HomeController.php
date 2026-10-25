<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Legacy /home URL: send everyone to their portal dashboard. */
    public function index()
    {
        return redirect()->route('portal.dashboard');
    }
}
