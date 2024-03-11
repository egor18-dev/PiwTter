<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TweetsController extends BaseController
{
    public function retrieveTweets()
    {
        return view('home/home');
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

            echo $content;
            die;
        }else{
            session()->setFlashData('uploadPostErrors', $this->validator->getErrors());
            return view('home/add');
        }

    }
}
