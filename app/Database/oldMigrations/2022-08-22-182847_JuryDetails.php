<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JuryDetails extends Migration
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
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'team_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'bio' => [
                'type'       => 'text',
                'default' => null,
            ],

            'facebook' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'twitter' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'instagram' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'whatsapp' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'bio' => [
                'type'       => 'text',
                'default' => null,
            ],
            'video' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'gallery' => [
                'type'       => 'text',
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
        $this->forge->createTable('jury_details');
    }

    public function down()
    {
        //
    }
}
