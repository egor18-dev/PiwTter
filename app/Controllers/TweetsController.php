<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\PostModel;

class TweetsController extends BaseController
{
    public function retrieveTweets()
    {
        helper('form');

        $contentPost = new PostModel();

        $data['posts'] = $contentPost->getPosts();
        
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


            if(!$post_id){
                $postData = [
                    'text' => $content
                ];
            }else{
                $postData = [
                    'text' => $content,
                    'parent_id' => $post_id
                ];
            }
            
            $contentPost = new PostModel();
            $contentPost->createPost($postData);
            
            return view('home/home');
        
        }else{
            session()->setFlashData('uploadPostErrors', $this->validator->getErrors());
            return view('home/add');
        }

    }
}
