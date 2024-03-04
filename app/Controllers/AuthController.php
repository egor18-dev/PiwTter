<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function signIn()
    {
        helper('form');
        return view('auth/signIn');
    }

    public function signUp()
    {   
        helper('form');

        return view('auth/signUp');
    }

    public function registerUser () {
        helper('form_validation');

        $validationRules = [
            'user' => 'required',
            'password' => 'required|min_length[8]',
        ];

        $validationMessages = [
            'user' => [
                'required' => 'Introdueix un nom.',
            ],
            'password' => [
                'required' => 'Introdueix una contrasenya.',
                'min_length' => 'La contrasenya ha de tenir 8 caràcters.',
            ],
        ];

        if($this->validate($validationRules, $validationMessages)){

            $user = $this->request->getPost('user');
            $password = $this->request->getPost('password');

            echo "Valid";
            die;
        }else{
            echo "No valid";
            die;
            return view('auth/signUp');
        }
    }
}
