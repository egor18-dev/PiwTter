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

use App\Libraries\UUID;

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
            
            $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
            $recaptchaSecret = '6LebK5wpAAAAAJuijkotEMpYdOtV6WRjaEqbwPJN'; // Aquí deberías poner tu Secret Key
            $remoteIp = "127.0.0.1";
            $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse . '&remoteip=' . $remoteIp;
            $recaptcha = json_decode(file_get_contents($recaptchaUrl));

            $uuid = UUID::v4();

            if ($recaptcha->success) {
                $userData = [
                    'user' => $user,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'url' => $uuid 
                ];
            
                $userModel = new UserModel();
                $userModel->createUser($userData);
            }else{
                session()->setFlashdata('signUpErrors', ["Verifica que no ets un robot"]);
                return view('auth/signUp');
            }

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
                    return redirect()->to('twoFactorConfirm');
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
        $data['title'] = 'Two factor authentication';

        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey(32);

        $data['inlineUrl'] = $google2fa->getQRCodeUrl(
            'DAW',
            'egor.hd16@gmail.com',
            $secretKey
        );

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd()
            )
        );

        $data['qrcode_image'] = base64_encode($writer->writeString($data['inlineUrl']));
        session()->setFlashdata('secretKey', $secretKey);

        return view('home/twoFactor', $data);
    }

    public function add2fa_post()
    {
        $txt2FA = $this->request->getPost('txt2FA');
        $secretKey = session()->getFlashdata('secretKey');

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secretKey, $txt2FA);


        if ($valid){
            $model = new UserModel();

            $data['secret2fa'] = $secretKey;

            $model->updateUser(session()->get('user_id'), $data);

            return redirect()->to(base_url('home'));
        } else{
            session()->setFlashdata('faError', ['Codi incorrecte, no hem activat el 2fa.']);
            return redirect()->to(base_url('twoFactor'));
        }
    }

    public function twoFactorConfirm ()
    {
        return view('home/twoFactorConfirm');
    }

    public function twoFactorConfirmPost()
    {
        $txt2FA = $this->request->getPost('txt2FA');
        $userid = session()->get('user_id');
        
        if ($userid != null) {
            $model = new UserModel();
            $user = $model->getBiUserId($userid);
            if ($user != null) {
                $secretKey = $user['secret2fa'];
                $google2fa = new Google2FA();
                $valid = $google2fa->verifyKey($secretKey, $txt2FA);
                if ($valid) { 
                    return redirect()->to('home');
                } else {
                    session()->setFlashdata('faError', ['Codi incorrecte, no hem activat el 2fa.']);
                    return redirect()->to(base_url('twoFactor'));
                }
            } 
        } 
    }

    public function urlVerification ()
    {
        $model = new UserModel();

        $user = $model->getBiUserId(session()->get('user_id'));

        $data['url'] = $user['url'];

        return view('home/url', $data);
    }

    public function updateUrlVerification ()
    {
        $urlUser = $this->request->getPost('url');

        if ($urlUser){
            $model = new UserModel();

            $data['url'] = $urlUser;

            $model->updateUser(session()->get('user_id'), $data);

            return redirect()->to('urlView');
        }
    }
}
