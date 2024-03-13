<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user', 'password'];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function createUser(array $userData)
    {
        $user = $this->insert($userData);
    
        $userRoleData = [
            'user_id' => $user,
            'role_id' => 2, 
        ];
        $this->db->table('user_roles')->insert($userRoleData);

        return $user;
    }

    public function signIn(array $userData)
    {
        $username = $userData['user'] ?? null;
        $password = $userData['password'] ?? null;
    
        if ($username === null || $password === null) {
            return false; 
        }
    
        $user = $this->where('user', $username)->first();

        if ($user === null) {
            return false; 
        }
    
        if (!password_verify($password, $user['password'])) {
            return false;
        }
    
        return $user;

    }

}
