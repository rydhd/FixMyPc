<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterStudentsTable extends Migration
{
    /**
     * This method contains the changes to apply to the database.
     */
    public function up()
    {
        // 1. Drop the old columns that are no longer needed
        $this->forge->dropColumn('students', ['student_number', 'email']);

        // 2. Define the new columns to add
        $newFields = [
            'middle_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true, // Middle name can be optional
                'after'      => 'first_name', // Place it after the first_name column
            ],
            'section' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'last_name',
            ],
            'grade_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'after'      => 'section',
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // Assuming 'Code' should be a unique identifier
                'after'      => 'grade_level',
            ],
        ];

        // 3. Add the new columns to the 'students' table
        $this->forge->addColumn('students', $newFields);
    }

    /**
     * This method contains the logic to revert the changes made in the up() method.
     */
    public function down()
    {
        // 1. Drop the columns we added in the up() method
        $this->forge->dropColumn('students', ['middle_name', 'section', 'grade_level', 'code']);

        // 2. Re-add the columns we removed, to restore the previous state
        $oldFields = [
            'student_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
        ];

        $this->forge->addColumn('students', $oldFields);
    }
}