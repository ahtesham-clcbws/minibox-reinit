<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AwardsInFestival extends Migration
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
            'award_cat_id' => [
                'type'           => 'INT',
                'constraint'     => 11
            ],
            'awards' => [
                'type'           => 'text',
                'constraint'     => '255',
                'default' => null,
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
        $this->forge->createTable('awards_in_festivals');
    }

    public function down()
    {
        //
    }
}
