<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller {

	public function __construct()
	{
        parent::__construct();
        
        $this->load->model('Cmt_reply_model');
        $this->load->model('post/Post_model');
        $this->load->model('user/User_model');
    }
    
    public function debug()
    {
        $disqusFile = file_get_contents('/var/www/html/projects/convertjson.json');
        print_code(json_decode($disqusFile, true));
    }

    public function import_disqus_id()
    {
        $disqusFile = file_get_contents('convertjson.json');
        $imported = json_decode($disqusFile, true);

        foreach ($imported['disqus']['thread'] as $thread)
        {
            $slug = rtrim(str_replace('https://www.codepolitan.com/', '', $thread['link']), '/');
                
            // Find real id ..
            $id = $this->Post_model->getPostField('id', 'slug', $slug);
                
            if (!empty($id))
            {
                $this->db->where('id', $id);
                $this->db->update('mein_posts', ['disqus_id' => $thread['_dsq:id']]);
                
                echo $id . ' updated ' . PHP_EOL;
            }
        }
    }
        
    public function import_comment()
    {
        $disqusFile = file_get_contents('convertjson.json');
        $imported = json_decode($disqusFile, true);
        
        foreach ($imported['disqus']['post'] as $post)
        {
            // Get real user id.
            $user_id = 0;
            
            if (isset($post['author']['username'])) {
                $user = $this->User_model->where('username', $post['author']['username'])->get();
                
                if (!empty($user))
                    $user_id = $user['id'];
            }
            
            // Get real id from disqus id
            $id = $this->Post_model->getPostField('id', 'disqus_id', $post['thread'][0]['_dsq:id']);
            
            if (!empty($id))
            {
                // Ini comment
                if (isset($post['parent']))
                {
                    // Find reply id.
                    $this->db->select('id');
                    $this->db->from('comment_reply');
                    $this->db->where('disqus_id', $post['parent']['_dsq:id']);
                    
                    $row = $this->db->get()->row();

                    if (!empty($row))
                    {
                        // Ini comment
                        $this->db->insert('comment', [
                            'reply_id' => $row->id,
                            'user_id' => $user_id,
                            'optional_name' => $post['author']['name'],
                            'comment_content' => $post['message']['__cdata'],
                            'comment_status' => 'publish',
                            'comment_mark' => null,
                            'created_at' => $post['createdAt']
                        ]);
                            
                        echo 'Comment was imported ..' . PHP_EOL;   
                    }
                }
                else
                {
                    // Ini reply
                    $this->db->insert('comment_reply', [
                        'identity' => $id,
                        'disqus_id' => $post['_dsq:id'],
                        'optional_name' => $post['author']['name'],
                        'user_id' => $user_id,
                        'reply_content' => $post['message']['__cdata'],
                        'reply_status' => 'publish',
                        'reply_mark' => null,
                        'created_at' => $post['createdAt']
                    ]);
                        
                    echo 'Reply was imported ..' . PHP_EOL;
                }
            }
        }
    }
}