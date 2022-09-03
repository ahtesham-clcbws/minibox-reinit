<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FestivalVolunteer extends Migration
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
            'whatsapp' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'country' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default' => null,
            ],
            'state' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default' => null,
            ],
            'city' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default' => null,
            ],
            'pin' => [
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
        $this->forge->createTable('festival_volunteers');
    }

    public function down()
    {
        //
    }
}
