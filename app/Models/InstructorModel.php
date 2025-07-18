<?php

namespace App\Models;

use CodeIgniter\Model;

class InstructorModel extends Model
{
    protected $table = 'instructors';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'last_name',
        'first_name',
        'middle_name',
        'grade_level',
        'code',
        'user_id'
    ];
    protected $useTimestamps = true;

    // Add validation rules directly in the model
    protected $validationRules = [
        'first_name'  => 'required|alpha_space|max_length[100]',
        'last_name'   => 'required|alpha_space|max_length[100]',
        'middle_name' => 'permit_empty|alpha_space|max_length[100]',
        'grade_level' => 'permit_empty|string|max_length[50]',
        'code'        => 'permit_empty|alpha_numeric_punct|max_length[50]|is_unique[instructors.code,id,{id}]', // Make sure permit_empty is here and adjust unique rule
    ];

    protected $validationMessages = [];
    protected $skipValidation = false; // Set to true if you want to skip model validation sometimes

    /**
     * Joins the instructors table with the users table to get combined details.
     *
     * @return array
     */
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