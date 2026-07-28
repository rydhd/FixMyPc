<?php

namespace App\Controllers;

use App\Models\AccessCodeModel;
use App\Models\InstructorModel; // <--- NEW: Import the InstructorModel
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;

class RegisterController extends \CodeIgniter\Shield\Controllers\RegisterController
{
    use Viewable;

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validate here first
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // ❗ Custom logic starts here
        $accessCodeModel = new AccessCodeModel();
        $accessCode = $this->request->getPost('access_code');

        // Mark the access code as used
        $accessCodeModel->where('code', $accessCode)
            ->set([
                'is_used' => 1,
                'used_by' => $user->id,
                'used_at' => date('Y-m-d H:i:s')
            ])
            ->update();

        // Add user to the 'instructor' group
        $user->addGroup('user');

        // ---> NEW FIX: Create the initial instructor profile in the database <---
        $instructorModel = new InstructorModel();
        $instructorModel->skipValidation(true)->insert([
            'user_id'    => $user->id,
            'first_name' => 'New',
            'last_name'  => 'Instructor'
        ]);
        // -------------------------------------------------------------------------

        // ❗ Custom logic ends here

        Events::trigger('register', $user);

        /** @var \CodeIgniter\Shield\Authentication\Authenticators\Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined for registration, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        // Set the user active
        $user->activate();

        // Success! Redirect to the login page.
        return redirect()->route('login')
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        // Get default registration rules from Shield
        $rules = parent::getValidationRules();

        // Add our custom access code rule
        $rules['access_code'] = [
            'label' => 'Access Code',
            'rules' => 'required|is_not_unique[access_codes.code,is_used,0]',
            'errors' => [
                'is_not_unique' => 'The provided Access Code is invalid or has already been used.'
            ]
        ];

        return $rules;
    }
}