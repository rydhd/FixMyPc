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
        'password' // Add this line
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
        'code' => 'required|alpha_numeric_punct|max_length[100]|is_unique[students.code,id,{id}]',
        'password' => 'permit_empty|min_length[8]'
    ];
}