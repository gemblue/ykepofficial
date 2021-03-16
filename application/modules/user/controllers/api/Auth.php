<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $this->setMethod('post');

        $email = $this->input->post('email', true);
        $password = $this->input->post('password');

        $login = $this->ci_auth->login($email, $password);

        if (in_array($login['status'], ['failed','inactive'])) {
            $login['message'] = strip_tags($login['message']);
            $this->response($login, REST_Controller::HTTP_UNAUTHORIZED);
        }

        $this->response(["token" => $this->ci_auth->getJWT()]);
    }

    public function logout()
    {
        $this->ci_auth->logout();
        $this->response('Loogut success.');
    }

    public function get_jwt()
    {
        $jwt = $this->ci_auth->getJWT();
        if($jwt) $this->response(["token" => $this->ci_auth->getJWT()]);

        $this->response("Session not exists. Please login first.", REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function register()
    {
        $this->setMethod('post');

        $email = $this->input->post('email', true);
        $username = $this->input->post('username') 
                    ?? str_replace(".","",substr($email, 0, strpos($email, '@')));

        $register = $this->ci_auth->register([
            'name' => $this->input->post('name', true),
            'username' => $username,
            'email' => $email,
            'password'  => $this->input->post('password'),
            'confirm_password' => $this->input->post('confirm_password'),
            'role_id' => 3
        ],
        [
            'phone' => $this->input->post('nomorhp', true),
        ]);

        if ($register['status'] == 'failed') {
            $register['message'] = strip_tags($register['message']);
            $this->response($register, REST_Controller::HTTP_UNAUTHORIZED);
        }
        
        $this->response($register);
    }

    public function reset_password()
    {
        $this->setMethod('post');

        $email = $this->input->post('email', true);

        $recovery = $this->ci_auth->recovery($email);

        if ($recovery['status'] == 'failed') {
            $recovery['message'] = strip_tags($recovery['message']);
            $this->response($recovery, REST_Controller::HTTP_UNAUTHORIZED);
        }
        
        $this->response($recovery);
    }

    public function resend_otp($user_id)
    {
        $result = $this->ci_auth->resend_otp($user_id);
        
        $this->response($result);
    }

    public function confirm_otp()
    {
        $this->setMethod('post');

        $otp = $this->input->post('token', true);

        $result = $this->ci_auth->activate($otp);

        $this->response($result);
    }

    public function reset_user_test()
    {
        if($_ENV['CI_ENV'] == 'production')
            $this->response('Not found', self::HTTP_NOT_FOUND);

        $email = $this->input->post('email', true);
        $user = $this->ci_auth->getUser('email', $email);
        
        if(!$user)
            $this->response('User not found', self::HTTP_NOT_FOUND);

        $res = $this->ci_auth->hardDeleteUser($user['id']);
        if($res)
            $this->response('User deleted.');
        else
            $this->response('Fail to delete, probably user not exist.');
    }
}
