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
        'section',
        'grade_level',
        'code',
        'user_id' // 👈 Make sure user_id is in allowedFields
    ];
    protected $useTimestamps = true;

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