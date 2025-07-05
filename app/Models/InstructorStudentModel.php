<?php

namespace App\Models;

use CodeIgniter\Model;

class InstructorStudentModel extends Model
{
    protected $table            = 'instructor_students';
    protected $allowedFields    = ['instructor_id', 'student_id'];
    protected $useTimestamps    = false; // This table doesn't have timestamp fields
}