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
        $contentPost = new PostModel();
        $data = $contentPost->getByUuid($id);
        return $this->response->setStatusCode(200)->setJson($data);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
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

        if($this->validate($validationRules)){
            $content = $this->request->getPost('data');
            $post_id = $this->request->getPost('post_id');
            $user_id = $this->request->getPost('user_id');
            $files = $this->request->getFiles();
            $uid = UUID::v4();
            $names = "";

            if($files){
                $file = $files["fileInput"][0]->getName();

                if(strlen($file) > 0){
                    $targetDir = WRITEPATH . "uploads/" . $uid;
            
                    if(!is_dir($targetDir))
                    {
                        mkdir($targetDir, 0777, true);
                    }
        
                    foreach($files["fileInput"] as $file)
                    {
                        $newName = $file->getName();
                        $names = $names . " " . $newName;
                        $file->move($targetDir, $newName);
                    }
                }
            }

            if(!$post_id){
                $postData = [
                    'id' =>  $uid,
                    'text' => $content,
                    'user_ref_id' => $user_id,
                    'files' => $names
                ];
            }else{
                $postData = [
                    'id' =>  $uid,
                    'text' => $content,
                    'parent_id' => $post_id,
                    'user_ref_id' => $user_id,
                    'files' => $names
                ];
            }
            
            try{
                $contentPost = new PostModel();
                $contentPost->createPost($postData);
            }catch(Exception $e){
                return $this->response->setStatusCode(500)->setJSON($e);
            }
            

            return $this->response->setStatusCode(200)->setJSON("Publicació pujada");
        }else{
            return $this->response->setStatusCode(400)->setJSON("Camps formulari incorrecte");
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
        //
    }
}
