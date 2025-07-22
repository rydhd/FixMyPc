<?php

namespace App\Controllers;

use App\Models\InstructorModel;
use App\Models\StudentModel;

class InstructorController extends BaseController
{
    // ... dashboard() and profile() methods remain the same ...
    public function dashboard()
    {
        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();

        $data['student_count'] = $instructorModel->countStudents($instructorId);

        return view('instructor/dashboard', $data);
    }

    public function profile()
    {
        $instructorModel = new InstructorModel();
        $userId = auth()->id();

        $data['instructor'] = $instructorModel->getProfile($userId);
        return view('instructor/profile', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'first_name' => 'required|alpha_space|max_length[100]',
            'last_name'  => 'required|alpha_space|max_length[100]',
            'password'   => 'permit_empty|strong_password',
            'password_confirm' => 'matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('toast_error', 'Profile update failed. Please check the errors.')
                ->with('validation_errors', $this->validator->getErrors());
        }

        $instructorModel = new InstructorModel();
        $userId = auth()->id();
        $postData = $this->validator->getValidated();

        if ($instructorModel->updateProfile($userId, $postData)) {
            return redirect()->to('instructor/profile')->with('toast_success', 'Profile updated successfully!');
        } else {
            return redirect()->back()->withInput()
                ->with('toast_error', 'Profile update failed.')
                ->with('validation_errors', $instructorModel->errors());
        }
    }


    public function students()
    {
        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();

        $students = $instructorModel->getStudents($instructorId);
        $sections = array_unique(array_column($students, 'section'));
        sort($sections);

        $data = [
            'students' => $students,
            'sections' => $sections,
        ];

        return view('instructor/students', $data);
    }

    public function addStudent()
    {
        // ✅ VALIDATION FIX: Removed the 'password_confirm' rule since it's not in the form.
        // ✅ IMPROVEMENT: Added a validation rule for 'middle_name' for consistency.
        $rules = [
            'first_name'  => 'required|alpha_space|max_length[150]',
            'last_name'   => 'required|alpha_space|max_length[150]',
            'middle_name' => 'permit_empty|alpha_space|max_length[150]',
            'section'     => 'required|string|max_length[100]',
            'grade_level' => 'required|string|max_length[50]',
            'password'    => 'permit_empty|min_length[8]',
        ];

        // The 'password_confirm' => 'matches[password]' rule was removed from here.

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('toast_error', 'Could not add student. Please correct the errors below.')
                ->with('validation_errors', $this->validator->getErrors());
        }

        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();
        $studentData = $this->validator->getValidated();

        // The rest of the function remains the same, as the logic for adding
        // the student in the InstructorModel is correct.
        if ($instructorModel->addStudent($instructorId, $studentData)) {
            return redirect()->to('/instructor/students')->with('toast_success', 'Student added successfully!');
        } else {
            return redirect()->back()->withInput()
                ->with('toast_error', 'Could not add student.')
                ->with('validation_errors', $instructorModel->errors());
        }
    }

    public function edit(int $studentId)
    {
        $instructorModel = new InstructorModel();
        $studentModel = new StudentModel();
        $instructorId = auth()->id();

        if (!$instructorModel->isStudentOfInstructor($studentId, $instructorId)) {
            return redirect()->to('/instructor/students')->with('toast_error', 'You do not have permission to edit this student.');
        }

        $data['student'] = $studentModel->find($studentId);
        if (empty($data['student'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Student not found.');
        }

        return view('instructor/edit_student', $data);
    }

    public function update(int $studentId)
    {
        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();
        $postData = $this->request->getPost();

        if ($instructorModel->updateStudent($studentId, $instructorId, $postData)) {
            return redirect()->to('/instructor/students')->with('toast_success', 'Student updated successfully.');
        } else {
            return redirect()->back()->withInput()
                ->with('toast_error', 'Could not update student.')
                ->with('validation_errors', $instructorModel->errors());
        }
    }

    public function uploadClasslist()
    {
        $file = $this->request->getFile('classlist_file');

        $validationRule = [
            'classlist_file' => 'uploaded[classlist_file]|ext_in[classlist_file,xlsx,xls]|max_size[classlist_file,5000]',
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->with('toast_error', $this->validator->getError('classlist_file'));
        }

        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();

        $result = $instructorModel->importClasslist(
            $instructorId,
            $file->getTempName(),
            $file->getClientExtension()
        );

        if ($result['status'] === 'success') {
            return redirect()->to('/instructor/students')->with('toast_success', "Success! {$result['count']} students were added.");
        } else {
            return redirect()->to('/instructor/students')
                ->with('toast_error', 'Some students could not be added from the file.')
                ->with('validation_errors', $result['errors']);
        }
    }

    public function deleteStudent(int $studentId)
    {
        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();

        if ($instructorModel->deleteStudent($studentId, $instructorId)) {
            return redirect()->to('/instructor/students')->with('toast_success', 'Student successfully deleted.');
        } else {
            return redirect()->to('/instructor/students')->with('toast_error', $instructorModel->errors()['database'] ?? 'Failed to delete the student.');
        }
    }

    public function deleteAllStudents()
    {
        $instructorModel = new InstructorModel();
        $instructorId = auth()->id();

        if ($instructorModel->deleteAllStudents($instructorId)) {
            return redirect()->to('/instructor/students')->with('toast_success', 'All students have been successfully deleted.');
        } else {
            return redirect()->to('/instructor/students')->with('toast_error', $instructorModel->errors()['database'] ?? 'An error occurred.');
        }
    }
}