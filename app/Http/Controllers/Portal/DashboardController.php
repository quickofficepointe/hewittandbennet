<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    /** Sends each user to the dashboard of their role. */
    public function index()
    {
        $route = match (auth()->user()->role) {
            User::DIRECTOR => 'portal.director.dashboard',
            User::ADMIN => 'portal.admin.dashboard',
            User::TRAINER => 'portal.trainer.dashboard',
            User::HR => 'portal.hr.dashboard',
            User::ACCOUNTANT => 'portal.accounts.dashboard',
            default => 'portal.student.dashboard',
        };

        return redirect()->route($route);
    }
}
