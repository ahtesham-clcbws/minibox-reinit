<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FestivalPress extends Migration
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
                'constraint'     => 11,
                'default' => null,
            ],
            'festival_year' => [
                'type'           => 'INT',
                'constraint'     => 4,
                'default' => null,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('festival_presses');
    }

    public function down()
    {
        //
    }
}
