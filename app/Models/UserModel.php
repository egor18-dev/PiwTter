<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'user', 'password', 'secret2fa', 'url'];

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
            'role_id' => 2, // Usuari normal
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

    public function get_permissions_by_role_id() {
        $builder = $this->db->table('permissions');
        $builder->select('permissions.name');
        $builder->join('role_permissions', 'role_permissions.permission_id = permissions.id');
        $builder->join('roles', 'roles.id = role_permissions.role_id');
        $builder->join('user_roles', 'user_roles.role_id = roles.id');
        $builder->where('user_roles.user_id', session()->get('user_id'));
    
        $query = $builder->get();
    
        $arr = $query->getResultArray();
        $names = [];

        for($i = 0; $i < count($arr); $i++)
        {
            array_push($names, $arr[$i]["name"]);
        }

        return $names;

    }
    
    public function updateUser ($user_id, $data)
    {
        $this->update(["user_id" => $user_id], $data);

        return true;
    }

    public function updateUrlUser($user_id, $data)
    {
        $user = $this->where('url', $data["url"])->first();
        
        if($user){
            return false;
        }else{
            $this->update(["user_id" => $user_id], $data);
            return true;
        }

    }

    public function twoFactorConfirm () 
    {
        return view('home/twoFactorConfirm');
    }

    public function getBiUserId ($userId)
    {
        $user = $this->where('user_id', $userId)->first();
        return $user;
    }
    
    public function getByUserUrl($url)
    {
        $url = $this->where('url', $url)->first();
        return $url;
    }

}
