<?php

namespace App\Controllers;

use App\Models\AccessCodeModel;
use App\Models\InstructorStudentModel;
use App\Models\StudentModel;
// You'll need to import the InstructorModel at the top of the file
use App\Models\InstructorModel;

// 👈 Add this line to import the model

class MasterAdminController extends BaseController
{
    public function dashboard()
    {
        $studentModel = new StudentModel();
        // Count all students where the 'instructor_id' matches
        $data['student_count'] = $studentModel
            ->countAllResults();

        return view('master_admin/master_dashboard',$data);
    }

    public function students()
    {
        // 1. Create a new instance of the StudentModel.
        // This object gives us access to the 'students' database table.
        $studentModel = new StudentModel();

        // 2. Prepare an array to hold the data we'll pass to the view.
        $data = [
            // 3. Fetch all student records from the database using the findAll() method
            // and assign them to the 'students' key.
            'students' => $studentModel->orderBy('last_name', 'ASC')->findAll()
        ];

        // 4. Load the view file and pass the $data array to it.
        // The view can now access the list of students via a $students variable.
        return view('master_admin/master_students', $data);
    }

    public function instructor()
    {
        // 1. Create an instance of the InstructorModel
        $instructorModel = new \App\Models\InstructorModel();

        // 2. Prepare the data for the view
        $data = [
            // 3. Call the new custom method to get the joined data
            'instructors' => $instructorModel->getInstructorsWithUserDetails()
        ];

        // 4. Load the view and pass the data to it
        return view('master_admin/master_instructor', $data);
    }

    public function edit(int $studentId)
    {
        $studentModel = new StudentModel();

        // Fetch the student data directly without the incorrect permission check.
        $data['student'] = $studentModel->find($studentId);

        // If the student doesn't exist, show a 404 error.
        if (empty($data['student'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found with ID: ' . $studentId);
        }

        // Load the view and pass the student data to it.
        return view('master_admin/edit_student', $data);
    }

    /**
     * Handles the submission of the student edit form.
     */
    public function update(int $studentId)
    {
        $studentModel = new StudentModel();

        // Prepare the data from the form POST request
        $data = [
            'first_name'  => $this->request->getPost('first_name'),
            'last_name'   => $this->request->getPost('last_name'),
            'middle_name' => $this->request->getPost('middle_name'),
            'grade_level' => $this->request->getPost('grade_level'),
            'section'     => $this->request->getPost('section'),
            'code'        => $this->request->getPost('code'),
        ];

        // Only update the password if a new one was provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            // It's crucial to hash passwords before saving them!
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update the student record in the database
        if ($studentModel->update($studentId, $data)) {
            return redirect()->to('/master/students')->with('message', 'Student updated successfully.');
        }

        // If the update fails, redirect back with the errors
        return redirect()->back()->withInput()->with('errors', $studentModel->errors());
    }
    public function deleteStudent(int $studentId)
    {
        $studentModel = new StudentModel();

        // Find the student to ensure it exists before trying to delete
        if ($studentModel->find($studentId)) {
            // Delete the student record
            $studentModel->delete($studentId);
            // Redirect back to the student list with a success message
            return redirect()->to('/master/students')->with('message', 'Student successfully deleted.');
        }

        // If the student wasn't found, redirect with an error
        return redirect()->to('/master/students')->with('error', 'Student not found or could not be deleted.');
    }
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
            // For an AJAX request, return a JSON error
            return $this->response->setStatusCode(401)->setJSON([
                    'success' => false,
                    'message' => 'You must be logged in to perform this action.'
            ]);
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
            // On success, return the new code in a JSON response
            return $this->response->setJSON([
                    'success' => true,
                    'code'    => $newCode
            ]);
        } else {
            // On failure, return a JSON error
            return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to generate access code. Please try again.'
            ]);
        }
    }
}