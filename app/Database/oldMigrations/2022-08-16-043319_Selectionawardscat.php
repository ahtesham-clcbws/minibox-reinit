<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Selectionawardscat extends Migration
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
                'type'           => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'sort' => [
                'type'       => 'INT',
                'constraint' => '2',
                'default' => '0',
            ],
            'usd' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default' => null,
            ],
            'inr' => [
                'type'       => 'INT',
                'constraint' => '11',
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
        $this->forge->createTable('award_categories');
    }

    public function down()
    {
        //
    }
}
