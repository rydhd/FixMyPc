<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;

class LoginController extends ShieldLoginController
{
    /**
     * Displays the login form.
     * If the user is already logged in, they will be redirected.
     */
    public function loginView(): string|RedirectResponse
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();

            // Redirect based on group
            if ($user->inGroup('masteradmin', 'superadmin')) {
                return redirect()->route('master_dashboard');
            }

            if ($user->inGroup('instructor')) {
                return redirect()->route('dashboard');
            }

            // Fallback for any other logged-in user
            return redirect()->to(config('Auth')->loginRedirect());
        }

        return view(setting('Auth.views')['login']);
    }

    /**
     * Override the loginAction to redirect users based on their group.
     */
    public function loginAction(): RedirectResponse
    {
        // Run the default login logic from Shield
        // This handles validation, finding the user, and logging them in.
        $result = parent::loginAction();

        // Check if the login was successful and it's a redirect response
        if (auth()->loggedIn() && $result->hasHeader('Location')) {
            $user = auth()->user();

            // Redirect masteradmin and superadmin to the master dashboard
            if ($user->inGroup('masteradmin', 'superadmin')) {
                return redirect()->route('master_dashboard')->withCookies();
            }

            // Redirect instructors to their own dashboard
            if ($user->inGroup('instructor')) {
                // ✅ FIX: Changed 'instructor_dashboard' to 'dashboard' to match Routes.php
                return redirect()->route('dashboard')->withCookies(); //
            }
        }

        // Return the original response if login failed or for other cases
        return $result;
    }
}