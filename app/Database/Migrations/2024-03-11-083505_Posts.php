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
                'constraint' => 36, 
            ],
            'text' => [
                'type' => 'VARCHAR',
                'constraint' => 255, 
            ],
            'parent_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36, 
                'null' => true,
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
