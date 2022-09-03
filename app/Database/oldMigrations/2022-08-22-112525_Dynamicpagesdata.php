<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dynamicpagesdata extends Migration
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

            'team_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'team_content' => ['type'       => 'text', 'default' => null],
            'volunteer_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'volunteer_content' => ['type'       => 'text', 'default' => null],
            'schedule_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'schedule_content' => ['type'       => 'text', 'default' => null],
            'delegate_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'delegate_content' => ['type'       => 'text', 'default' => null],
            'support_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'support_content' => ['type'       => 'text', 'default' => null],
            'winners_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'winners_content' => ['type'       => 'text', 'default' => null],
            'entry_form_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'entry_form_content' => ['type'       => 'text', 'default' => null],
            'official_selection_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'official_selection_content' => ['type'       => 'text', 'default' => null],
            'jury_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'jury_content' => ['type'       => 'text', 'default' => null],
            'gallery_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'gallery_content' => ['type'       => 'text', 'default' => null],
            'filmmakers_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'filmmakers_content' => ['type'       => 'text', 'default' => null],
            'knowledge_center_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'knowledge_center_content' => ['type'       => 'text', 'default' => null],
            'press_title' => ['type'       => 'VARCHAR', 'constraint' => '255', 'default' => null],
            'press_content' => ['type'       => 'text', 'default' => null],

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
        $this->forge->createTable('dynamicpagesdatas');
    }

    public function down()
    {
        //
    }
}
