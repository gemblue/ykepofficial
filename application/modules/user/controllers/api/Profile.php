<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Profile
 * 
 * Profile API handler
 * 
 * @author Gemblue
 */

use \Firebase\JWT\JWT;

class Profile extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('point/Point_model');
        $this->load->model('point/Rank_model');
        $this->load->model('course/Course_model');
        $this->load->model('certificate/Log_model');
    }

    /**
     * Sync Google with internal account
     */
    public function sync()
	{
        $input = file_get_contents("php://input");
        $post = json_decode($input, true);
        
        // Cari email dari google apakah sudah terdaftar? jika sudah balikan data user tersebut
        $user = $this->ci_auth->getUser('email', $post['email']);
        
        if ($user) 
        {
            $jwt = $this->generateJWT([
                'logged_in' => true,
                'user_id' => $user['user_id'],
                'email' =>  $user['email'],
                'username' =>  $user['username'],
                'fullname' =>  $user['name'],
                'role_name' =>  $user['role_name'],
                'role_id' =>  $user['role_id'],
                'timestamp' => time()
            ]);

            $this->response(['status' => 'success', 'token' => $jwt]);
        } 
        else 
        {
            // Jika gak ada, bikinkan akun otomatis! lalu loginkan JWT nya.
            $username = str_replace([".","@"],"", $post['email']);
            $password = $this->randomPassword();

            $register = $this->ci_auth->register([
                'name' => htmlspecialchars($post['name']),
                'username' => htmlspecialchars($username),
                'email' => htmlspecialchars($post['email']),
                'password' => $password,
                'confirm_password' => $password,
                'role_id' => 3
            ], [
                'phone' => null,
            ]);
            
            if ($register['status'] == 'success') {
                
                $jwt = $this->generateJWT([
                    'logged_in' => true,
                    'user_id' => $register['id'],
                    'email' => $register['email'],
                    'username' => $username,
                    'fullname' => $register['name'],
                    'role_name' => 'Member',
                    'role_id' => 3,
                    'timestamp' => time()
                ]);

                $this->response(['status' => 'success', 'token' => $jwt]);
            
            } else {

                $this->response(['status' => 'failed', 'message' => 'Terdapat kesalahan teknis, hubungi admin.']);
            
            }
        }
    }
    
    public function detail($username = null)
    {
        $user = $this->ci_auth->getUser('username', $username);
        $point = $this->Point_model->getTotal($user['id']);
        $rank = $this->Rank_model->getRank($point);
        $courses = $this->Course_model->getCompletedCoursesID($user['id']);
        $certificates = $this->Log_model->getLogsByUser($user['id']);
        
        // Just get yang dibutuhin aja
        $result = [
            'name' => $user['name'],
            'username' => $user['username'],
            'avatar' => $this->ci_auth->getProfilePicture(null, $user['email'], 300),
            'short_description' => $user['short_description'],
            'portfolio' => $user['portfolio'],
            'user_url' => $user['user_url'],
            'interest' => $user['interest'],
            'point' => $point,
            'rank' => $rank,
            'courses' => $courses,
            'certificates' => $certificates,
        ];

        $this->response($result);
    }

    public function update()
    {
        $this->setMethod('post');

        // Check JWT.
        $this->user =  $this->checkToken();
        
        // Find current data.
        $user = $this->ci_auth->getUser('id', $this->user->user_id);

        $input = file_get_contents("php://input");
        $post = json_decode($input, true);

        $data['user'] = [
            'user_id' => $this->user->user_id,
            'avatar' => htmlspecialchars($post['profile_picture']),
            'name' => htmlspecialchars($post['name']),
            'username' => htmlspecialchars($post['username']),
            'email' => $user['email'],
            'password' => null,
            'confirm_password' => null,
            'role_id' => $user['role_id'],
            'status' => 'active'
        ];

        $data['profile'] = [
            'birthday' => $post['birthday'],
            'description' => $post['description'],
            'jobs' => $post['jobs'],
            'profile_picture' => $post['profile_picture'],
            'phone' => $post['phone'],
            'address' => $post['address']
        ];

        $update = $this->ci_auth->updateUser(['id' => $this->user->user_id], $data['user'], $data['profile']);
        
        if ($update['status'] == 'failed') {
            $this->response(['status' => 'failed', 'message' => $update['message']]);
        } 
        
        $this->response(['status' => 'success', 'message' => 'Successfully updated']);
    }

    private function generateJWT($payload) {
        
        /** Generate JWT */
        ci()->event->trigger('Ci_auth.setJWTSession', $payload);
        ci()->session->set_userdata($payload);
        $jwt = JWT::encode($payload, config_item('jwt_key'), 'HS256');
        $this->ci_auth->updateUser(['id' => $payload['user_id']], ['session_id' => $jwt], null, true);
        ci()->session->set_userdata('session_token_id', $jwt);
        set_cookie('cdplusertoken', $jwt, 3600);
        
        if ($jwt) {
            return $jwt;
        }

        return null;
    }

    private function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        
        return implode($pass); //turn the array into a string
    } 
}