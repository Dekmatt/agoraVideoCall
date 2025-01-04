<?php

namespace App\Http\Controllers\StaffController;

use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    public function dashboard()
    {
        return view('staff.staffdashboard'); // Make sure this view exists
    }

    // Other staff-related methods
}
