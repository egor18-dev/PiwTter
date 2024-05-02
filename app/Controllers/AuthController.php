<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use PragmaRX\Google2FA\Google2FA;

use App\Models\UserModel;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRendererConfig;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Encoder\QrCodeEncoder;
use Endroid\QrCode\QrCode;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function signIn()
    {
        helper('form');
        return view('auth/signIn');
    }

    public function signUp()
    {   
        helper(['form']); 

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
            
            $userData = [
                'user' => $user,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
        
            $userModel = new UserModel();
            $userModel->createUser($userData);
            return redirect()->to('/sign-in');
        }else{
            session()->setFlashdata('signUpErrors', $this->validator->getErrors());
            return view('auth/signUp');
        }
    }

    public function login () 
    {
        helper('form_validation');
        $session = \Config\Services::session();

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
            
            $userData = [
                'user' => $user,
                'password' => $password
            ];
        
            $userModel = new UserModel();
            $user = $userModel->signIn($userData);

            if(!$user){
                session()->setFlashdata('signInErrors', ["Usuari o contrasenya incorrecta"]);
                return view('auth/signIn');
            }else{
                session()->set(['user_id' => $user['user_id']]);

                if($user["secret2fa"]){
                    return redirect()->to('twoFactor');
                }else{
                    return redirect()->to('home');
                }
                
            }
        }else{
            session()->setFlashdata('signInErrors', $this->validator->getErrors());
            return view('auth/signIn');
        }
    }

    public function logout () 
    {
        session()->set(['user_id' => null]);

        return redirect()->to('sign-in');
    }

    public function twoFactor()
    {
        
    }
}
