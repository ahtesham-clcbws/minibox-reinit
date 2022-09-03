<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Filmfestivalevents extends Migration
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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'date_from' => [
                'type'       => 'DATE',
                'default' => null,
            ],
            'date_to' => [
                'type'       => 'DATE',
                'default' => null,
            ],
            'time_from' => [
                'type'       => 'TIME',
                'default' => null,
            ],
            'time_to' => [
                'type'       => 'TIME',
                'default' => null,
            ],
            'address_full' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'google_map_link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'description' => [
                'type'       => 'text',
                'default' => null,
            ],
            'cover_image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'video_link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'organizer_id' => [
                'type'           => 'INT',
                'constraint'     => 11
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
        $this->forge->createTable('festival_events');
    }

    public function down()
    {
        //
    }
}
