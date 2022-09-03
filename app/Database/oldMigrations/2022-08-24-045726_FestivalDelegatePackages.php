<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FestivalDelegatePackages extends Migration
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
            'details' => [
                'type'           => 'text',
                'default' => null,
            ],
            'fee_inr' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'default' => null,
            ],
            'fee_eur' => [
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
        $this->forge->createTable('festival_delegate_packages');
    }

    public function down()
    {
        //
    }
}
