<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FilmzineToModule extends Migration
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
            'news_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default' => null,
            ],
            'data_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->createTable('filmzinetomodules');
    }

    public function down()
    {
        //
    }
}
