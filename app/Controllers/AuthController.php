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
}
