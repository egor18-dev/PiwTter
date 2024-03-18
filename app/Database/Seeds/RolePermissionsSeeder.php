<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        $this->db->table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 2]);
        $this->db->table('role_permissions')->insert(['role_id' => 3, 'permission_id' => 1]);
        $this->db->table('role_permissions')->insert(['role_id' => 3, 'permission_id' => 2]);
        $this->db->table('role_permissions')->insert(['role_id' => 3, 'permission_id' => 3]);
    }
}
