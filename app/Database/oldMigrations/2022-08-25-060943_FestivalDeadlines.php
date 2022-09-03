<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FestivalDeadlines extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'festival_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint'  => '255',
                'default' => null,
            ],
            'deadline' => [
                'type'       => 'DATE',
                'default' => null,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'default' => null,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'default' => null,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('id', true);
        $this->forge->createTable('festival_deadlines');
    }

    public function down()
    {
        //
    }
}
