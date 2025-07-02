<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use Config\Auth;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class LoginController extends ShieldLoginController
{
    /**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
        /** @var Auth $config */
        $config = config(Auth::class);

        // Manually define validation rules
        $rules = [
            'email' => [
                'label' => 'Auth.email',
                'rules' => 'required|max_length[254]|valid_email',
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required',
            ],
        ];

        // Validate the incoming data
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get the credentials for login
        // Use the fields defined in Auth.validFields setting for credentials
        $credentials = $this->request->getPost(setting('Auth.validFields'));
        // Ensure password is included as it's not always in validFields
        $credentials['password'] = $this->request->getPost('password');

        $remember = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator(); // Get the authenticator instance

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);

        // If login failed, redirect back with an error
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // If an action has been defined for login (e.g., email verification), start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        // Get the logged-in user
        $user = auth()->user();

        // Redirect based on user group
        if ($user->inGroup('masteradmin', 'superadmin')) {
            return redirect()->route('master_dashboard')->withCookies();
        }

        // For all other users, send them to the general dashboard.
        return redirect()->route('dashboard')->withCookies();
    }
}