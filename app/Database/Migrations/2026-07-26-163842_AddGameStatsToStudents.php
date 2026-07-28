<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGameStatsToStudents extends Migration
{
    public function up()
    {
        $fields = [
            'coc_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'default'    => '0',
                'after'      => 'password',
            ],
            'score' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => 0,
                'after'      => 'coc_level',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => 'Not Started',
                'after'      => 'score',
            ],
        ];

        $this->forge->addColumn('students', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('students', ['coc_level', 'score', 'status']);
    }
}