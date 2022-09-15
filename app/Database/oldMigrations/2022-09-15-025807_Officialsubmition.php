<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Officialsubmition extends Migration
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
            'unique_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'project' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default' => null,
            ],
            'film_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default' => null,
            ],
            'film_status_info' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => '4',
                'default' => null,
            ],
            'country' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default' => null,
            ],
            'official_web_link' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'budget_currency' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'default' => null,
            ],
            'budget_amount' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default' => null,
            ],
            'director' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'producer' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'production_company' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'duration' => [
                'type'       => 'INT',
                'constraint' => '11',
                'default' => null,
            ],
            'debut_film' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default' => null,
            ],
            'synopsis' => [
                'type'       => 'text',
                'default' => null,
            ],
            'color' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default' => 1,
            ],
            'genres' => [
                'type'       => 'text',
                'default' => null,
            ],
            'certificates' => [
                'type'       => 'text',
                'default' => null,
            ],

            'banner' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'poster' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'trailer' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'trailer_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default' => 'Youtube',
            ],
            'movie' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'movie_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default' => 'Youtube',
            ],
            'distribution' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'default' => 'No',
            ],
            'rating' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'default' => null,
            ],
            'step1' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],

            'step2' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],

            'step3' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],

            'step4' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],

            'step5' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],

            'step6' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default' => 'open',
            ],
            'reason' => [
                'type'       => 'text',
                'default' => NULL,
            ],
            'user_reason' => [
                'type'       => 'text',
                'default' => NULL,
            ],
            'approved' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default' => 0,
            ],
            'edit_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '30',
                'default' => 'update_needed',
            ],
            'likes' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'dislikes' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'views,'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'default' => 0,
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
        $this->forge->createTable('official_submissions');
    }

    public function down()
    {
        //
    }
}
