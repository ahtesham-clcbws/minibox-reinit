<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Filmfestivalawards extends Migration
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
            'year' => [
                'type'       => 'INT',
                'constraint' => '4',
                'default' => null,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'description' => [
                'type'       => 'text',
                'default' => null,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
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
        $this->forge->createTable('festival_awards');
    }

    public function down()
    {
        //
    }
}
