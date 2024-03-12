<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\PostModel;

use App\Libraries\UUID;

class TweetsController extends BaseController
{
    public function retrieveTweets()
    {
        helper('form');

        $contentPost = new PostModel();

        $data['posts'] = $contentPost->getPosts();
        $data['user_id'] = session()->get('user_id');

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

            if(!$post_id){
                $postData = [
                    'id' =>  UUID::v4(),
                    'text' => $content,
                    'user_ref_id' => $user_id
                ];
            }else{
                $postData = [
                    'id' =>  UUID::v4(),
                    'text' => $content,
                    'parent_id' => $post_id,
                    'user_ref_id' => $user_id
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
        $postModel->deletePost($uuid);

        return redirect()->to('home');
    }

    public function editPost ()
    {
        $postModel = new PostModel();
        
        $uuid = $this->request->getPost('uuid');

        $postModel = new PostModel();
        $post = $postModel->getByUuid($uuid);

        if($post){
            $data["data"] = $post["text"];
            return view('home/add', $data);
        }else{
            return redirect()->to('home');
        }
    }
}
