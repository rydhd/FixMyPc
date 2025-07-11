<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;

class LoginController extends ShieldLoginController
{
    /**
     * Override the loginAction to redirect users based on their group.
     */
    public function loginAction(): RedirectResponse
    {
        // Run the default login logic from Shield
        $result = parent::loginAction();

        // If the login was successful and it's a redirect response
        if (auth()->loggedIn() && $result->hasHeader('Location')) {
            $user = auth()->user();

            // Redirect masteradmin and superadmin to the master dashboard
            if ($user->inGroup('masteradmin', 'superadmin')) {
                return redirect()->route('master_dashboard')->withCookies();
            }

            // Redirect instructors to their own dashboard
            if ($user->inGroup('instructor')) {
                // Assuming you have a route named 'instructor_dashboard'
                return redirect()->route('instructor_dashboard')->withCookies();
            }

            // For any other logged-in user (e.g., students), redirect to a general dashboard.
            return redirect()->route('dashboard')->withCookies();
        }

        // Return the original response if login failed or it wasn't a standard redirect
        return $result;
    }
}