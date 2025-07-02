<?php

namespace App\Controllers;

use App\Models\AccessCodeModel; // 👈 Add this line to import the model

class MasterAdminController extends BaseController
{
    public function dashboard()
    {
        return view('master_admin/master_dashboard');
    }

    public function students()
    {
        return view('master_admin/master_students');
    }
    public function instructor()
    {
        return view('master_admin/master_instructor');
    }

    // --- NEW METHODS FOR ACCESS CODES ---

    /**
     * Displays the page to view and manage access codes.
     */
    public function accessCodes()
    {
        $accessCodeModel = new AccessCodeModel();

        // Fetch codes and join with the users table to get creator/user names
        $data['codes'] = $accessCodeModel
            ->select('access_codes.*, creator.username as creator_username, user.username as user_username')
            ->join('users as creator', 'creator.id = access_codes.created_by', 'left')
            ->join('users as user', 'user.id = access_codes.used_by', 'left')
            ->orderBy('access_codes.id', 'DESC')
            ->findAll();

        return view('master_admin/master_access_codes', $data);
    }

    /**
     * Generates a new unique access code.
     */
    public function generateCode()
    {
        // Ensure the user is logged in
        if (!auth()->loggedIn()) {
            return redirect()->to('/login')->with('error', 'You must be logged in to perform this action.');
        }

        $accessCodeModel = new AccessCodeModel();

        // Generate a unique random code
        $newCode = bin2hex(random_bytes(8)); // Creates a 16-character random hex string

        $data = [
            'code'       => $newCode,
            'created_by' => auth()->id(), // Get the logged-in masteradmin's ID
        ];

        // Save the new code to the database
        if ($accessCodeModel->save($data)) {
            return redirect()->to('/master-admin/access-codes')->with('message', 'Successfully generated a new access code!');
        } else {
            return redirect()->back()->with('error', 'Failed to generate access code. Please try again.');
        }
    }
}