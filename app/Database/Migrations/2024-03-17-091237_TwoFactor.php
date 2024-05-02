<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSecret2faToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'secret2fa' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
                'default' => null,
                'after' => 'password', 
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'secret2fa');
    }
}
