<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 255, 
            ],
            'text' => [
                'type' => 'LONGTEXT', 
                'null' => true,   
            ],
            'parent_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255, 
                'null' => true,
            ],
            'is_public' => [
                'type' => 'BOOLEAN',
                'default' => true
            ],
            'created_at' => [
                'type' => 'DATE',
                'default' => date("Y-m-d H:i:s"),
            ],
            'user_ref_id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned' => true,
                'null' => false
            ],
            'files' => [
                'type' => 'TEXT',
                'default' => null
            ],
            'allowed' => [
                'type' => 'BOOLEAN',
                'default' => true
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('parent_id', 'posts', 'id');
        $this->forge->addForeignKey('user_ref_id', 'users', 'user_id');

        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
