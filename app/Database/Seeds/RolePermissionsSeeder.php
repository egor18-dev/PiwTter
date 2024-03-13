<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        $roles = $this->db->table('roles')->select('id')->get()->getResult();
        $permissions = $this->db->table('permissions')->select('id')->get()->getResult();

        $data = [];

        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                $data[] = [
                    'role_id' => $role->id,
                    'permission_id' => $permission->id
                ];
            }
        }

        // Insertar datos en la tabla pivot
        $this->db->table('role_permissions')->insertBatch($data);
    }
}
