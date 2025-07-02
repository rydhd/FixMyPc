<?php

namespace App\Models;

use CodeIgniter\Model;

class AccessCodeModel extends Model
{
    protected $table            = 'access_codes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    // Allowed fields that can be saved to the database
    protected $allowedFields    = ['code', 'is_used', 'created_by', 'used_by', 'used_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // We don't have an 'updated_at' field in the migration
    protected $deletedField  = '';

    // You can add validation rules here if needed
    protected $validationRules = [
        'code'       => 'required|is_unique[access_codes.code]',
        'created_by' => 'required|integer',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}