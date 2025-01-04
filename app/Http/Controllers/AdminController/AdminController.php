<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all(); // Retrieve all users from the database
        return view('admin.admindashboard', compact('users')); // Pass the data to the view
    }
}


