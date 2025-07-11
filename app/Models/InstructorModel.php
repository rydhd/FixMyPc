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
            // Get email from `secret` column in auth_identities and rename it to `email`
            ->select('instructors.*, users.username, auth_identities.secret as email')
            ->join('users', 'users.id = instructors.user_id')
            // Join the identities table to find the email address
            ->join('auth_identities', 'auth_identities.user_id = users.id')
            // Specify that we want the email/password identity, not others (like social logins)
            ->where('auth_identities.type', 'email_password')
            ->findAll();
    }
}