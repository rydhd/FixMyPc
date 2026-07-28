<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSaveDataToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'save_data' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'save_data');
    }
}