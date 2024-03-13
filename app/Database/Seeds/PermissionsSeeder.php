<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'delete_all_posts'],
            ['name' => 'see_all_posts'],
        ];

        $this->db->table('permissions')->insertBatch($data);
    }
}
