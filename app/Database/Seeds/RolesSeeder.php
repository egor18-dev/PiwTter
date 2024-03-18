<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'admin'],
            ['name' => 'normal'],
            ['name' => 'moderador']
        ];

        $this->db->table('roles')->insertBatch($data);
    }
}
