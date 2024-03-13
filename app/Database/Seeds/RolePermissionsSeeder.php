<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Obtener IDs de roles y permisos desde la base de datos
        $roles = $this->db->table('roles')->select('id')->get()->getResult();
        $permissions = $this->db->table('permissions')->select('id')->get()->getResult();

        // Array para almacenar datos a insertar en la tabla pivot
        $data = [];

        // Iterar sobre los roles y permisos para generar combinaciones
        foreach ($roles as $role) {
            foreach ($permissions as $permission) {
                // Añadir combinación a los datos
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
