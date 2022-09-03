<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Support extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'message' => [
                'type'       => 'text',
                'default' => null,
            ],
            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => 'Mini Box Office Platform',
            ],
            'for_table' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => 'global',
            ],
            'entity_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->createTable('supports');
    }

    public function down()
    {
        //
    }
}
