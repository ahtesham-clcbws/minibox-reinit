<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FilmzinePost extends Migration
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
            'type_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'type_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
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
            'video' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'topic_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'topic_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'total_likes' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'total_dislikes' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'movie_rating' => [
                'type'           => 'FLOAT',
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
        $this->forge->createTable('filmzine');
    }

    public function down()
    {
        //
    }
}
