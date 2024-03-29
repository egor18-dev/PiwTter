<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'text', 'parent_id', 'user_ref_id', 'is_public', 'files', 'allowed'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function createPost(array $postData)
    {
        
        return $this->insert($postData);
    }

    public function getPosts() 
    {
        $query = $this->db->table('posts')->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return array();
        }
    }

    public function getPostsById($id)
    {
        $query = $this->where('user_ref_id', $id)->get();

        if($query->getNumRows() > 0){
            return $query->getResult();
        }else{
            return array();
        }
    }

    public function getPostsByAllowedFalse()
    {
        $query = $this->where('allowed', false)->get();

        if($query->getNumRows() > 0){
            return $query->getResult();
        }else{
            return array();
        }
    }

    public function deletePost($uuid)
    {
        $this->db->table('posts')->where('parent_id', $uuid)->delete();
        $this->db->table('posts')->where('id', $uuid)->delete();
    }

    public function getByUuid($uuid)
    {
        $post = $this->where('id', $uuid)->first();
        return $post;
    }

    public function updateByUuid($uuid, array $data)
    {
        return $this->update($uuid, $data);
    }
    
}
