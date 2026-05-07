<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\StudentModel;

class Auth extends ResourceController
{
    /**
     * Handles the login request from the Godot client.
     */
    public function login()
    {
        // 1. Get the JSON payload sent from Godot
        $json = $this->request->getJSON();

        // Ensure the payload is valid
        if (!$json || !isset($json->code) || !isset($json->password)) {
            return $this->failValidationErrors('Student code and password are required.');
        }

        $code = $json->code;
        $password = $json->password;

        // 2. Load the database model
        $studentModel = new StudentModel();

        // 3. Find the student in the database using their code
        $student = $studentModel->where('code', $code)->first();

        // 4. Verify the student exists AND the password matches the hash
        if ($student && password_verify($password, $student['password'])) {

            // Login Successful! Send a 200 response with the user's real data.
            return $this->respond([
                'message' => 'Login Successful',
                'userData' => [
                    'first_name'  => $student['first_name'],
                    'last_name'   => $student['last_name'],
                    'section'     => $student['section'],
                    'grade_level' => $student['grade_level']
                ]
            ], 200);

        } else {
            // Login Failed! Send a 401 Unauthorized response.
            return $this->failUnauthorized('Invalid student code or password.');
        }
    }
}