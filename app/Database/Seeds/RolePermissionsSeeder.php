<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'role_id' => 1,
                'permission_id' => 1
            ],
            [
                'id' => 2,
                'role_id' => 1,
                'permission_id' => 2
            ]
        ];

        $this->db->table('role_permissions')->insertBatch($data);
    }
}
