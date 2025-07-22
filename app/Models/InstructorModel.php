<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Shield\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

class InstructorModel extends Model
{
    protected $table = 'instructors';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'last_name', 'first_name', 'middle_name', 'grade_level', 'code', 'user_id'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'first_name'  => 'required|alpha_space|max_length[100]',
        'last_name'   => 'required|alpha_space|max_length[100]',
        'middle_name' => 'permit_empty|alpha_space|max_length[100]',
        'grade_level' => 'permit_empty|string|max_length[50]',
        'code'        => 'permit_empty|alpha_numeric_punct|max_length[50]|is_unique[instructors.code,id,{id}]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Fetches the instructor's profile along with their email and access code.
     */
    public function getProfile(int $userId): ?array
    {
        $profile = $this
            ->select('instructors.*, users.username, auth_identities.secret as email, access_codes.code as access_code')
            ->join('users', 'users.id = instructors.user_id')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            ->join('access_codes', 'access_codes.used_by = users.id', 'left')
            ->where('auth_identities.type', 'email_password')
            ->where('instructors.user_id', $userId)
            ->first();

        return $profile;
    }

    /**
     * Updates an instructor's profile and, optionally, their password.
     */
    public function updateProfile(int $userId, array $data): bool
    {
        // 1. Update password if provided
        if (!empty($data['password'])) {
            $userModel = new UserModel();
            $user = $userModel->findById($userId);
            $user->fill(['password' => $data['password']]);

            if ($user->hasChanged() && !$userModel->save($user)) {
                $this->errors = $userModel->errors();
                return false;
            }
        }

        // 2. Unset password fields so they are not sent to the instructor model
        unset($data['password'], $data['password_confirm']);

        // 3. Find existing instructor profile
        $instructor = $this->where('user_id', $userId)->first();

        if ($instructor) {
            // Update existing profile
            if (!$this->update($instructor['id'], $data)) {
                return false; // Errors will be set by the model
            }
        } else {
            // Create new profile
            $data['user_id'] = $userId;
            if (!$this->save($data)) {
                return false; // Errors will be set by the model
            }
        }

        return true;
    }

    /**
     * Counts the number of students assigned to a specific instructor.
     */
    public function countStudents(int $instructorId): int
    {
        $instructorStudentModel = new InstructorStudentModel();
        return $instructorStudentModel
            ->where('instructor_id', $instructorId)
            ->countAllResults();
    }

    /**
     * Fetches all students for a given instructor.
     */
    public function getStudents(int $instructorId): array
    {
        $studentModel = new StudentModel();
        return $studentModel
            ->select('students.*')
            ->join('instructor_students', 'instructor_students.student_id = students.id')
            ->where('instructor_students.instructor_id', $instructorId)
            ->findAll();
    }

    /**
     * Adds a new student and links them to the instructor.
     */
    public function addStudent(int $instructorId, array $studentData): bool
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();

        // Hash password if provided
        if (!empty($studentData['password'])) {
            $studentData['password'] = password_hash($studentData['password'], PASSWORD_DEFAULT);
        }

        $this->db->transStart();

        if ($studentModel->save($studentData)) {
            $studentId = $studentModel->getInsertID();
            $instructorStudentModel->save([
                'instructor_id' => $instructorId,
                'student_id'    => $studentId
            ]);
        } else {
            // If student save fails, capture errors
            $this->errors = $studentModel->errors();
            $this->db->transRollback();
            return false;
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }

    /**
     * Checks if a student belongs to a specific instructor.
     */
    public function isStudentOfInstructor(int $studentId, int $instructorId): bool
    {
        $instructorStudentModel = new InstructorStudentModel();
        $link = $instructorStudentModel
            ->where('student_id', $studentId)
            ->where('instructor_id', $instructorId)
            ->first();

        return $link !== null;
    }

    /**
     * Updates a student's record after verifying ownership by the instructor.
     */
    public function updateStudent(int $studentId, int $instructorId, array $data): bool
    {
        if (!$this->isStudentOfInstructor($studentId, $instructorId)) {
            $this->errors = ['auth' => 'You do not have permission to edit this student.'];
            return false;
        }

        $studentModel = new StudentModel();

        // Handle password update
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }

        // The unique validation rule needs to ignore the current student
        $studentModel->setValidationRule('code', "required|alpha_numeric_punct|max_length[100]|is_unique[students.code,id,{$studentId}]");

        if (!$studentModel->update($studentId, $data)) {
            $this->errors = $studentModel->errors();
            return false;
        }

        return true;
    }

    /**
     * Deletes a student record and its link to the instructor after verifying ownership.
     */
    public function deleteStudent(int $studentId, int $instructorId): bool
    {
        if (!$this->isStudentOfInstructor($studentId, $instructorId)) {
            $this->errors = ['auth' => 'You do not have permission to delete this student.'];
            return false;
        }

        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();

        $this->db->transStart();

        $instructorStudentModel->where('student_id', $studentId)->where('instructor_id', $instructorId)->delete();
        $studentModel->delete($studentId);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            $this->errors = ['database' => 'Failed to delete the student due to a database error.'];
            return false;
        }

        return true;
    }

    /**
     * Deletes all students associated with an instructor.
     */
    public function deleteAllStudents(int $instructorId): bool
    {
        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();

        $links = $instructorStudentModel->where('instructor_id', $instructorId)->findAll();
        if (empty($links)) {
            return true; // Nothing to delete
        }

        $studentIds = array_column($links, 'student_id');

        $this->db->transStart();

        $instructorStudentModel->where('instructor_id', $instructorId)->delete();
        $studentModel->whereIn('id', $studentIds)->delete();

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            $this->errors = ['database' => 'An error occurred while deleting students.'];
            return false;
        }

        return true;
    }

    /**
     * Imports students from an Excel file and links them to the instructor.
     */
    public function importClasslist(int $instructorId, string $filePath, string $fileExtension): array
    {
        if ($fileExtension === 'xlsx') {
            $reader = new Xlsx();
        } else {
            $reader = new Xls();
        }

        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        $studentModel = new StudentModel();
        $instructorStudentModel = new InstructorStudentModel();

        $addedCount = 0;
        $errors = [];

        $this->db->transStart();

        foreach (array_slice($sheet, 1) as $rowIndex => $row) {
            if (empty(implode('', $row))) continue; // Skip empty rows

            $studentData = [
                'last_name'   => $row[0] ?? null,
                'first_name'  => $row[1] ?? null,
                'middle_name' => $row[2] ?? null,
                'section'     => $row[3] ?? null,
                'grade_level' => $row[4] ?? null,
                'code'        => $row[5] ?? null,
                'password'    => isset($row[6]) && !empty($row[6]) ? password_hash($row[6], PASSWORD_DEFAULT) : null,
            ];

            if ($studentModel->save($studentData)) {
                $studentId = $studentModel->getInsertID();
                $instructorStudentModel->insert([
                    'instructor_id' => $instructorId,
                    'student_id'    => $studentId
                ]);
                $addedCount++;
            } else {
                $rowNumber = $rowIndex + 2;
                $errors[] = "Row {$rowNumber}: " . implode(', ', $studentModel->errors());
            }
        }

        if (empty($errors)) {
            $this->db->transComplete();
            return ['status' => 'success', 'count' => $addedCount];
        } else {
            $this->db->transRollback();
            return ['status' => 'error', 'errors' => $errors];
        }
    }
    public function getInstructorsWithUserDetails(): array
    {
        return $this
            // ✅ Select the access code and alias it
            ->select('instructors.*, users.username, auth_identities.secret as email, access_codes.code as access_code')
            ->join('users', 'users.id = instructors.user_id')
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            // ✅ Add a LEFT JOIN to the access_codes table
            ->join('access_codes', 'access_codes.used_by = users.id', 'left')
            ->where('auth_identities.type', 'email_password')
            ->findAll();
    }
}