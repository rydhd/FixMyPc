<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\StudentModel;

class Game extends ResourceController
{
    public function updateProgress()
    {
        $json = $this->request->getJSON();

        if (!$json || !isset($json->code)) {
            return $this->failValidationErrors('Student code is required.');
        }

        $studentModel = new StudentModel();
        $student = $studentModel->where('code', $json->code)->first();

        if ($student) {
            $updateData = [
                'coc_level' => (string)($json->coc_level ?? '1'),
                'score'     => (int)($json->score ?? 0),
                'status'    => (string)($json->status ?? 'Passed'),
                'save_data' => (string)($json->save_data ?? $student['save_data'])
            ];

            // Use skipValidation(true) to prevent unique code validation rules from blocking the update
            if ($studentModel->skipValidation(true)->update($student['id'], $updateData)) {
                return $this->respond([
                    'status'  => 'success',
                    'message' => 'Progress updated successfully!',
                    'data'    => $updateData
                ], 200);
            } else {
                return $this->failServerError('Database update failed: ' . implode(', ', $studentModel->errors()));
            }
        }

        return $this->failNotFound('Student with code "' . $json->code . '" was not found in the database.');
    }
}