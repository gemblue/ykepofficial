<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Comment
 *	
 * Shortcode for Comment Module
 * 
 * @author Oriza
 */
class CommentShortcode extends LexCallback 
{
    public function getComments()
    {
        $reply_id = $this->getAttribute('reply_id', false);
        
        $results = $this->Cmt_model->getComments($reply_id);
        
        return $results;
    }
}