<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Point to your login view
    }

    /**
     * Handle the login request.
     */
    public function login(LoginRequest $request)
    {
        // Attempt to log in the user with email and password
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();

            // If 2FA is enabled for this user, validate the 2FA code
            if ($user->google2fa_secret) {
                $google2fa = new Google2FA();

                // Check if the 2FA code is provided in the request
                if (!$request->filled('2fa_code')) {
                    return $this->logoutAndRedirect($request, 'Please enter your 2FA code.');
                }

                // Validate the provided 2FA code
                if (!$google2fa->verifyKey($user->google2fa_secret, $request->input('2fa_code'))) {
                    return $this->logoutAndRedirect($request, 'The 2FA code you entered is invalid.');
                }
            }

            // Regenerate the session and redirect based on role
            $request->session()->regenerate();
            return $this->handleRedirect($user);
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log out the user and redirect back with an error message.
     */
    protected function logoutAndRedirect(Request $request, $errorMessage)
    {
        Auth::logout(); // Log out the user
        return back()->withErrors([
            '2fa_code' => $errorMessage,
        ])->withInput($request->except('password'));
    }

    /**
     * Redirect user based on their role.
     */
    protected function handleRedirect($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'staff':
                return redirect()->route('staff.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            default:
                return redirect('/'); // Fallback to home or a default page
        }
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the token to prevent reuse
        $request->session()->regenerateToken();

        return redirect('/login'); // Redirect back to login
    }
}
