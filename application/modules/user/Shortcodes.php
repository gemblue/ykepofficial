<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *	User Shortcode
 *	
 *  Theme api for User feature
 */
class UserShortcode extends LexCallback {

	public function __construct()
	{
		parent::__construct();
    }

    /**
	 * Get User Detail
	 */
    public function getUser()
	{
        $id = $this->getAttribute('id');
        
        $user = $this->ci_auth->getUser('id', $id);
        
        return $user;
    }

    /**
	 * Get Profile Picture
	 */
    public function getProfilePicture()
	{
        $avatar = $this->getAttribute('avatar');
        $email = $this->getAttribute('email');
        $size = $this->getAttribute('size', 200);
        
        return $this->ci_auth->getProfilePicture($avatar, $email, $size);
    }
}