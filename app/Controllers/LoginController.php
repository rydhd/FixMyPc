<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;

class LoginController extends ShieldLoginController
{
    /**
     * We no longer need the loginView() method here.
     * The 'guest' filter in the routes file will handle redirecting
     * logged-in users away from the login page.
     */

    /**
     * Handles the login form submission.
     * Overridden to redirect users based on their group after a successful login.
     */
    public function loginAction(): RedirectResponse
    {
        // Run the default login logic from Shield.
        $result = parent::loginAction();

        // Check if the login was successful.
        if (auth()->loggedIn()) {
            $user = auth()->user();

            // Redirect masteradmin and superadmin.
            if ($user->inGroup('masteradmin', 'superadmin')) {
                return redirect()->route('master_dashboard')->withCookies();
            }

            // Redirect instructors.
            if ($user->inGroup('user')) {
                return redirect()->route('instructor_dashboard')->withCookies();
            }

            // Safe fallback for any other authenticated user group.
            return redirect()->to('/')->withCookies();
        }

        // If login failed, return the original response from Shield (which shows errors).
        return $result;
    }
}