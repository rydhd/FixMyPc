<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'students';

    /**
     * The table's primary key.
     */
    protected $primaryKey = 'id';

    /**
     * The fields that are allowed to be saved to the database.
     */
    protected $allowedFields = [
        'first_name',
        'middle_name',
        'last_name',
        'section',
        'grade_level',
        'code',
        'password',
        'coc_level', // New field
        'score',     // New field
        'status',     // New field
        'save_data'
    ];

    /**
     * Specifies whether to use the created_at and updated_at timestamps.
     */
    protected $useTimestamps = true;

    /**
     * The name of the database column that contains the creation date.
     */
    protected $createdField = 'created_at';

    /**
     * The name of the database column that contains the update date.
     */
    protected $updatedField = 'updated_at';

    /**
     * Validation rules for the model.
     */
    protected $validationRules = [
        'first_name'  => 'required|alpha_space|max_length[150]',
        'middle_name' => 'permit_empty|alpha_space|max_length[150]',
        'last_name'   => 'required|alpha_space|max_length[150]',
        'section'     => 'required|string|max_length[100]',
        'grade_level' => 'required|string|max_length[50]',
        // 'code' is permit_empty on insert, and required|is_unique on update if changed
        'code'        => 'permit_empty|alpha_numeric_punct|max_length[100]|is_unique[students.code,id,{id}]',
        'password'    => 'permit_empty|min_length[8]'
    ];

    /**
     * Callbacks for automatically generating the student code.
     */
    protected $beforeInsert = ['generateStudentCode'];

    /**
     * Generates a unique student code if not provided.
     * Format: STU-001, STU-002, etc.
     *
     * @param array $data The data array being inserted.
     * @return array The modified data array.
     */
    protected function generateStudentCode(array $data)
    {
        // Only generate code if it's not provided or is empty
        if (!isset($data['data']['code']) || empty($data['data']['code'])) {
            // Find the highest existing student code
            $lastStudent = $this->select('code')
                ->like('code', 'STU-%', 'after')
                ->orderBy('code', 'DESC')
                ->first();

            $newNumber = 1;
            if ($lastStudent && preg_match('/STU-(\d+)/', $lastStudent['code'], $matches)) {
                $lastNumber = (int) $matches[1];
                $newNumber = $lastNumber + 1;
            }

            // Format the new code with leading zeros (e.g., STU-001, STU-010, STU-100)
            $data['data']['code'] = 'STU-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $data;
    }
}