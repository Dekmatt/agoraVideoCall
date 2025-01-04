<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        // Return the view for the dashboard
        return view('user.dashboard');
    }
}
