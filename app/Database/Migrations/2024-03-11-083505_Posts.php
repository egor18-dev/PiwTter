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
                'type' => 'TEXT', 
                'null' => true,   
            ],
            'parent_id' => [
                'type' => 'VARCHAR',
                'constraint' => 255, 
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATE',
                'default' => date("Y-m-d"),
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('parent_id', 'posts', 'id');

        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropTable('posts');
    }
}
