<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\PostModel;
use App\Models\UserModel;

use App\Libraries\UUID;

class TweetsController extends BaseController
{
    public function retrieveTweets()
    {
        helper('form');

        $contentPost = new PostModel();
        $contentUser = new UserModel();

        $permissions = $contentUser->get_permissions_by_role_id();

        $data['posts'] = $contentPost->getPosts();
        $data['user_id'] = session()->get('user_id');
        $data['permissions'] = $permissions;

        return view('home/home', $data);
    }

    public function addTweet() {
        helper('form');
        
        return view('home/add');
    }

    public function addPost() {
        helper('form_validation');
    
        $validationRules = [
            'data' => 'required'
        ];

        $validationMessages = [
            'data' => [
                'required' => 'Introdueix informació'
            ]
        ];

        if($this->validate($validationRules, $validationMessages)){
            $content = $this->request->getPost('data');
            $post_id = $this->request->getPost('post_id');
            $user_id = intval(session()->get('user_id'));
            $uuid = $this->request->getPost('uuid');

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
            
            $contentPost = new PostModel();
            $contentPost->createPost($postData);
            
            return redirect()->to('home');
        }else{
            session()->setFlashData('uploadPostErrors', $this->validator->getErrors());
            return view('home/add');
        }
    }


    public function removePost () 
    {
        $postModel = new PostModel();
        
        $uuid = $this->request->getPost('uuid');

        $directory = WRITEPATH . "uploads/" . $uuid;

        if (is_dir($directory)) {
            $files = glob($directory . '/*');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

        }

        $postModel->deletePost($uuid);

        return redirect()->to('home');
    }

    public function editPostView ()
    {
        $postModel = new PostModel();
        
        $uuid = $this->request->getPost('uuid');

        $postModel = new PostModel();
        $post = $postModel->getByUuid($uuid);

        if($post){
            $data["data"] = $post["text"];
            $data["uuid"] = $uuid;
            return view('home/add', $data);
        }else{
            return redirect()->to('home');
        }
    }

    public function editPost() 
    {
        $content = $this->request->getPost('data');
        $uuid = $this->request->getPost('uuid');
        $is_public = $this->request->getPost('is_public')??"";
        $action = $this->request->getPost('action')??"";

        if($action !== ""){
            $postData = [
                'is_public' => !intval($is_public)
            ];
        }else{
            $postData = [
                'text' => $content,
            ];
        }
            
        $contentPost = new PostModel();
        $contentPost->updateByUuid($uuid, $postData);
            
        return redirect()->to('home');
    }

    public function view ($uuid) 
    {
        $contentPost = new PostModel();
        $post = $contentPost->getByUuid($uuid);

        $data['post'] = $post["text"]??"<p class='text-danger'>No existeix aquesta publicació</p>";

        return view('home/view', $data);
    }

    public function download() 
    {
        $file = $this->request->getPost('file');
        $uuid = $this->request->getPost('uuid');
    
        $filePath = WRITEPATH . "uploads/" . $uuid . "/" . $file;
    
        if (file_exists($filePath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Content-Length: ' . filesize($filePath));
    
            readfile($filePath);
        }
    }
    
}
