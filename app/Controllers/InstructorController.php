<?php

namespace App\Controllers;

use App\Models\AccessCodeModel;
use App\Models\InstructorModel;
use App\Models\StudentModel;
use App\Models\InstructorStudentModel;
use CodeIgniter\Shield\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class InstructorController extends BaseController
{
    public function dashboard()
    {
        // Initialize the model that links instructors to students
        $instructorStudentModel = new InstructorStudentModel();

        // Get the ID of the currently logged-in instructor
        $instructorId = auth()->id();

        // Count all students where the 'instructor_id' matches
        $data['student_count'] = $instructorStudentModel
            ->where('instructor_id', $instructorId)
            ->countAllResults();

        // Load the dashboard view and pass the student count to it
        return view('instructor/dashboard', $data);
    }
    public function profile()
    {

        $instructorModel = new InstructorModel();
        $accessCodeModel = new AccessCodeModel();
        $userId = auth()->id();

        // Find the instructor profile linked to the logged-in user
        $data['instructor'] = $instructorModel->where('user_id', $userId)->first();

        // Fetch the access code from the `access_codes` table where `used_by` matches the user's ID
        $data['access_code'] = $accessCodeModel->where('used_by', $userId)->first();

        return view('instructor/profile', $data);
    }
    public function updateProfile()
    {
        $instructorModel = new InstructorModel();
        $userId = auth()->id();

        // Find the existing instructor profile to get its ID. This is still useful
        // to determine if we are updating or creating.
        $existingInstructor = $instructorModel->where('user_id', $userId)->first();

        // 1. Define Validation Rules (simplified as code validation is now in model)
        $rules = [
            'first_name' => 'required|alpha_space|max_length[100]',
            'last_name'  => 'required|alpha_space|max_length[100]',
            'middle_name'=> 'permit_empty|alpha_space|max_length[100]',
            'grade_level'=> 'permit_empty|string|max_length[50]',
            // 'code' validation is now handled in the InstructorModel
            'password'   => 'permit_empty|strong_password',
            'password_confirm' => 'matches[password]',
        ];

        // If you still want client-side validation or basic validation here,
        // you can keep a simpler rule for 'code' like 'permit_empty|alpha_numeric_punct|max_length[50]',
        // but the 'is_unique' part will be handled by the model.
        // Or remove 'code' from here entirely if the model handles it sufficiently.

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Get validated data
        $postData = $this->validator->getValidated();

        // START: Password Update Logic
        if (!empty($postData['password'])) {
            $users = new UserModel();
            $user = auth()->user();

            $user->fill(['password' => $postData['password']]);
            $users->save($user);
        }
        // END: Password Update Logic

        // Remove password fields so they aren't saved to the instructor profile
        unset($postData['password'], $postData['password_confirm']);

        if ($existingInstructor) {
            // UPDATE existing profile
            // The model's validation rules will be applied here automatically
            if (!$instructorModel->update($existingInstructor['id'], $postData)) {
                return redirect()->back()->withInput()->with('errors', $instructorModel->errors());
            }
        } else {
            // CREATE new profile, adding the user_id
            $postData['user_id'] = $userId;
            // The model's validation rules will be applied here automatically
            if (!$instructorModel->save($postData)) {
                return redirect()->back()->withInput()->with('errors', $instructorModel->errors());
            }
        }

        return redirect()->to('instructor/profile')->with('message', 'Profile updated successfully!');
    }

    /**
     * Fetches and displays students associated with the logged-in instructor.
     */
    public function students()
    {
        $studentModel = new StudentModel();
        $instructorId = auth()->id();

        $data['students'] = $studentModel
            ->select('students.*')
            ->join('instructor_students', 'instructor_students.student_id = students.id')
            ->where('instructor_students.instructor_id', $instructorId)
            ->findAll();

        return view('instructor/students', $data);
    }

    /**
     * Handles the addition of a single student via modal form.
     */
    public function addStudent()
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();
        $instructorId = auth()->id();

        // Ensure the instructor is logged in
        if (!$instructorId) {
            return redirect()->to('/login')->with('error', 'You must be logged in to perform this action.');
        }

        // Define validation rules for individual student addition
        $rules = [
            'first_name'       => 'required|alpha_space|max_length[150]',
            'middle_name'      => 'permit_empty|alpha_space|max_length[150]',
            'last_name'        => 'required|alpha_space|max_length[150]',
            'section'          => 'required|string|max_length[100]',
            'grade_level'      => 'required|string|max_length[50]',
            'password'         => 'permit_empty|min_length[8]',
            'password_confirm' => 'matches[password]',
        ];

        if (!$this->validate($rules)) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()
                ->withInput()
                ->with('add_student_error', 'Please correct the errors below.')
                ->with('add_student_validation_errors', $this->validator->getErrors());
        }

        // Get validated data
        $postData = $this->validator->getValidated();

        // Hash password if provided
        if (!empty($postData['password'])) {
            $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
        } else {
            // Remove password field if empty to prevent saving an empty password
            unset($postData['password']);
        }

        // Remove password_confirm as it's not a database field
        unset($postData['password_confirm']);

        // Save the student
        if ($studentModel->save($postData)) {
            $studentId = $studentModel->getInsertID();

            // Link the new student to the current instructor
            $instructorStudentModel->save([
                'instructor_id' => $instructorId,
                'student_id'    => $studentId
            ]);

            return redirect()->to('/instructor/students')->with('add_student_message', 'Student added successfully!');
        } else {
            // This case should ideally be caught by the model's validation
            // but is here as a fallback for database-level errors
            return redirect()->back()
                ->withInput()
                ->with('add_student_error', 'Could not add student. Please try again.')
                ->with('add_student_validation_errors', $studentModel->errors());
        }
    }


    /**
     * Displays the form to edit a specific student's details.
     * It verifies that the student belongs to the logged-in instructor before showing the form.
     */
    public function edit(int $studentId)
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();
        $instructorId = auth()->id();

        // First, verify this student belongs to the logged-in instructor
        $link = $instructorStudentModel
            ->where('student_id', $studentId)
            ->where('instructor_id', $instructorId)
            ->first();

        // If no link exists, they do not have permission
        if (!$link) {
            return redirect()->to('/instructor/students')->with('error', 'You do not have permission to edit this student.');
        }

        // Fetch the student data and pass it to the view
        $data['student'] = $studentModel->find($studentId);

        if (empty($data['student'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found with ID: ' . $studentId);
        }

        return view('instructor/edit_student', $data);
    }

    /**
     * Processes the form submission for updating a student's details.
     * It re-validates ownership and then updates the database.
     */
    public function update(int $studentId)
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();
        $instructorId = auth()->id();

        // Security check: Re-verify ownership before processing the update
        $link = $instructorStudentModel
            ->where('student_id', $studentId)
            ->where('instructor_id', $instructorId)
            ->first();

        if (!$link) {
            return redirect()->to('/instructor/students')->with('error', 'You do not have permission to edit this student.');
        }

        // Get the POST data
        $postData = $this->request->getPost();

        // Handle password update
        if (!empty($postData['password'])) {
            $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
        } else {
            // If password is not set or empty, remove it from the update array
            unset($postData['password']);
        }

        // This manually builds the validation rule, forcing it to ignore the current student's ID.
        // This is still correct for students.
        $studentModel->setValidationRule('code', "required|alpha_numeric_punct|max_length[100]|is_unique[students.code,id,{$studentId}]");

        // Update the student in the database
        if ($studentModel->update($studentId, $postData)) {
            return redirect()->to('/instructor/students')->with('message', 'Student details updated successfully.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Could not update student details.')->with('errors', $studentModel->errors());
        }
    }

    /**
     * Processes the uploaded Excel file from the modal to add students.
     */
    public function uploadClasslist()
    {
        // Validate the uploaded file
        $file = $this->request->getFile('classlist_file');

        $validationRule = [
            'classlist_file' => [
                'label' => 'Excel File',
                'rules' => 'uploaded[classlist_file]'
                    . '|ext_in[classlist_file,xlsx,xls]'
                    . '|max_size[classlist_file,5000]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->with('error', $this->validator->getErrors()['classlist_file']);
        }

        // Initialize Models and the Excel Reader
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();

        $extension = $file->getClientExtension();
        if ($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        $spreadsheet = $reader->load($file->getTempName());
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        $studentsAdded = 0;
        $errors = [];

        $instructorId = auth()->id();
        if (!$instructorId) {
            return redirect()->to('/login')->with('error', 'You must be logged in to perform this action.');
        }

        foreach (array_slice($sheet, 1) as $rowIndex => $row) {
            if (empty(implode('', $row))) {
                continue;
            }

            $studentData = [
                'last_name'   => $row[0] ?? null,
                'first_name'  => $row[1] ?? null,
                'middle_name' => $row[2] ?? null,
                'section'     => $row[3] ?? null,
                'grade_level' => $row[4] ?? null,
                'code'        => $row[5] ?? null,
                'password'    => isset($row[6]) ? password_hash($row[6], PASSWORD_DEFAULT) : null,
            ];

            if ($studentModel->save($studentData)) {
                $studentId = $studentModel->getInsertID();
                $instructorStudentModel->save([
                    'instructor_id' => $instructorId,
                    'student_id'    => $studentId
                ]);
                $studentsAdded++;
            } else {
                $rowNumber = $rowIndex + 2;
                $errors[] = "Row {$rowNumber}: " . implode(', ', $studentModel->errors());
            }
        }

        if (empty($errors)) {
            return redirect()->to('/instructor/students')->with('message', "Success! {$studentsAdded} students were added to your class list.");
        } else {
            return redirect()->to('/instructor/students')->with('error', 'Some students could not be added.')->with('validation_errors', $errors);
        }
    }

    /**
     * Deletes a single student after verifying ownership.
     */
    public function deleteStudent(int $studentId)
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();
        $instructorId = auth()->id();

        // First, verify the student exists and belongs to this instructor
        $link = $instructorStudentModel
            ->where('student_id', $studentId)
            ->where('instructor_id', $instructorId)
            ->first();

        // If no link is found, they don't have permission to delete this student
        if (!$link) {
            return redirect()->to('/instructor/students')->with('error', 'You do not have permission to delete this student or the student does not exist.');
        }

        // Proceed with deletion
        // We'll wrap this in a transaction to ensure both operations succeed or fail together.
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Delete the link in the pivot table
        $instructorStudentModel->where('student_id', $studentId)->where('instructor_id', $instructorId)->delete();

        // 2. Delete the student from the main students table
        $studentModel->delete($studentId);

        $db->transComplete();

        if ($db->transStatus() === false) {
            // If the transaction failed
            return redirect()->to('/instructor/students')->with('error', 'Failed to delete the student. Please try again.');
        } else {
            // If the transaction was successful
            return redirect()->to('/instructor/students')->with('message', 'Student successfully deleted.');
        }
    }

    /**
     * Deletes all students associated with the logged-in instructor.
     */
    public function deleteAllStudents()
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();
        $instructorId = auth()->id();

        // 1. Find all student IDs linked to this instructor
        $links = $instructorStudentModel->where('instructor_id', $instructorId)->findAll();

        // If there are no students to delete, just redirect back.
        if (empty($links)) {
            return redirect()->to('/instructor/students')->with('message', 'There were no students to delete.');
        }

        // Extract just the student IDs into a simple array
        $studentIdsToDelete = array_column($links, 'student_id');

        // 2. Use a database transaction for safety
        $db = \Config\Database::connect();
        $db->transStart();

        // 3. Delete all links from the pivot table for this instructor
        $instructorStudentModel->where('instructor_id', $instructorId)->delete();

        // 4. Delete all the actual student records from the students table
        $studentModel->whereIn('id', $studentIdsToDelete)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            // If the transaction failed
            return redirect()->to('/instructor/students')->with('error', 'An error occurred while deleting the students. Please try again.');
        } else {
            // If the transaction was successful
            return redirect()->to('/instructor/students')->with('message', 'All students have been successfully deleted.');
        }
    }
}