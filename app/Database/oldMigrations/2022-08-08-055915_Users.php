<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'last_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default' => null,
            ],
            'device' => [
                'type'       => 'ENUM',
                'constraint' => ['web', 'android', 'ios', 'others'],
                'default'    => 'web',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['user', 'admin', 'staff'],
                'default'    => 'user',
            ],
            'module' => [
                'type'       => 'ENUM',
                'constraint' => ['default', 'super', 'festival', 'market', 'incubator', 'filmzine', 'primewatch',  'primekids',  'store', 'management'],
                'default'    => 'default',
            ],
            'permissions' => [
                'type'       => 'ENUM',
                'constraint' => ['view', 'add', 'edit', 'delete', 'all'],
                'default'    => 'view',
            ],
            'email_status' => [
                'type'       => 'ENUM',
                'constraint' => ['verified', 'pending', 'rejected'],
                'default'    => 'pending',
            ],
            'mobile_status' => [
                'type'       => 'ENUM',
                'constraint' => ['verified', 'pending', 'rejected'],
                'default'    => 'pending',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['verified', 'pending', 'rejected'],
                'default'    => 'pending',
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
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}
