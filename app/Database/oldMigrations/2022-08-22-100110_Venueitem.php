<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Venueitem extends Migration
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
            'festival_year' => [
                'type'           => 'INT',
                'constraint'     => 4
            ],
            
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'content' => [
                'type'       => 'text',
                'default' => null,
            ],
            'image' => [
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
        $this->forge->createTable('festival_venues_items');
    }

    public function down()
    {
        //
    }
}
