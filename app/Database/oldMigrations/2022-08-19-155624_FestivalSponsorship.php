<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FestivalSponsorship extends Migration
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
            
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'content' => [
                'type'       => 'text',
                'default' => null,
            ],
            
            'icon1' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_title1' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_content1' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            
            'icon2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_title2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_content2' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            
            'icon3' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_title3' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_content3' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            
            'icon4' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_title4' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'icon_content4' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('festival_sponsorship');
    }

    public function down()
    {
        //
    }
}
