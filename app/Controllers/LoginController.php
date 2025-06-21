<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLoginController;
use Config\Auth;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

class LoginController extends ShieldLoginController
{
    /**
     * Authenticates a user and handles the redirect.
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

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get the credentials for login
        $credentials             = $this->request->getPost(['email', 'password']);
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session');

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (! $result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // Get the logged-in user from the main auth service
        $user = auth()->user();

        // ** CUSTOM REDIRECT LOGIC **
        if ($user->inGroup('masteradmin', 'superadmin')) {
            return redirect()->to('/master-dashboard');
        }

        if ($user->inGroup('instructor')) {
            return redirect()->to('/instructor-dashboard');
        }

        // Fallback for any other user roles
        return redirect()->to($config->loginRedirect());
    }
}