<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PostModel;
use App\Libraries\UUID;

class ApiController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $contentPost = new PostModel();
        return $this->response->setStatusCode(200)->setJSON($contentPost->getPosts());
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        try {
            $contentPost = new PostModel();
            $data = $contentPost->getByUuid($id);
            return $this->response->setStatusCode(200)->setJson($data);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        helper('form_validation');
    
        $validationRules = [
            'data' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON("Camps formulari incorrecte");
        }

        $content = $this->request->getPost('data');
        $post_id = $this->request->getPost('post_id');
        $user_id = $this->request->getPost('user_id');
        $files = $this->request->getFiles();
        $uid = UUID::v4();
        $names = "";

        if ($files) {
            $targetDir = WRITEPATH . "uploads/" . $uid;
        
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            foreach ($files["fileInput"] as $file) {
                $newName = $file->getName();
                $names .= " " . $newName;
                $file->move($targetDir, $newName);
            }
        }

        try {
            if (!$post_id) {
                $postData = [
                    'id' =>  $uid,
                    'text' => $content,
                    'user_ref_id' => $user_id,
                    'files' => $names
                ];
            } else {
                $postData = [
                    'id' =>  $uid,
                    'text' => $content,
                    'parent_id' => $post_id,
                    'user_ref_id' => $user_id,
                    'files' => $names
                ];
            }
            
            $contentPost = new PostModel();
            $contentPost->createPost($postData);

            return $this->response->setStatusCode(200)->setJSON("Publicació pujada");
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        try {
            $content = $this->request->getVar('data');
            $uuid = $id;
            $is_public = $this->request->getVar('is_public') ?? "";
            $action = $this->request->getVar('action') ?? "";

            if ($action !== "") {
                $postData = [
                    'is_public' => !intval($is_public)
                ];
            } else {
                $postData = [
                    'text' => $content,
                ];
            }

            $postModel = new PostModel();
            $postModel->updateByUuid($uuid, $postData);
            return $this->response->setStatusCode(200)->setJSON($postData);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        try {
            $content = $this->request->getVar('data');
            $uuid = $id;
            $is_public = $this->request->getVar('is_public') ?? "";
            $action = $this->request->getVar('action') ?? "";

            if ($action !== "") {
                $postData = [
                    'is_public' => !intval($is_public)
                ];
            } else {
                $postData = [
                    'text' => $content,
                ];
            }

            $postModel = new PostModel();
            $postModel->updateByUuid($uuid, $postData);
            return $this->response->setStatusCode(200)->setJSON($postData);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        try {
            $postModel = new PostModel();
            $postModel->deletePost($id);
            return $this->response->setStatusCode(200)->setJson("Deleted");
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }
}
