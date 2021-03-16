<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Backend_Controller {

	public function __construct()
	{
		parent::__construct();

        $this->load->library('pagination');
        $this->load->model('User_model');

        $this->shared['entry_profile'] = get_entry_config('user_profile');
        $this->Profile_model = setup_entry_model('user_profile');

        $this->shared['submodule'] = 'user';
	}
	
	public function index($pagenum = 1)
	{
        $data['page_title'] = 'Users';
		
        $perPage = 10;
		$uri = 'admin/user/index/';

        $filter = $this->input->get(null, true);
        
		$data['results'] = $this->User_model->with_role()->getUsers($perPage, $pagenum, $filter, $uri);
        $data['status'] = ['' => 'all', 'active' => 'active','inactive' => 'inactive'];
        $data['roles'] = [''=>'all'] + $this->Role_model->as_dropdown('role_name')->get_all();
        $data['pagination'] = $this->User_model->all_pages;
        
        $data['stat'] = [
            'all' => $this->User_model->set_cache('totalUsers')->count_rows(),
            'active' => $this->User_model->where('status', 'active')->set_cache('totalActiveUsers')->count_rows(),
            'inactive' => $this->User_model->where('status', 'inactive')->set_cache('totalInactiveUsers')->count_rows()
        ];

        $this->view('admin/user', $data);
    }

	public function edit($user_id)
	{
		$data['page_title'] = 'Edit User';
		$data['form_type'] = 'edit';
		$data['result'] = $this->ci_auth->getUser('id', $user_id);
		$data['avatar'] = $this->ci_auth->getProfilePicture($data['result']['avatar'], $data['result']['email']);
		$data['roles'] = $this->ci_auth->getRoles();
		
		if (empty($data['result'])) {
			show_404();
		}

		$this->view('admin/form', $data);
	}

	public function update()
	{
        $post = $this->input->post();

        $profileField = array_keys($this->shared['entry_profile']['fields']);
        $userValue = [];
        $profileValue = [];

        foreach($post as $p => $value){
            $this->session->set_flashdata($p, $value);
            if(in_array($p, $profileField)){
	            $profileValue[$p] = $value;
            } else {
	            $userValue[$p] = $value;
            }
        }

        // Update user
		$update = $this->ci_auth->updateUser(['id' => $post['user_id']], $userValue, $profileValue);
        
        // Redirect
        if ($update['status'] == 'success') 
		    $this->session->set_flashdata('message', $this->lang->line('mein_success_update'));
        else
            $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $update['message'] .'</div>');
        
		redirect('admin/user/edit/' . $post['user_id']);
	}

	public function activate($id)
	{
		$this->ci_auth->changeUserStatus($id, 'active');
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
		
		redirect(getenv('HTTP_REFERER'));
	}

	public function block($id)
	{
		$this->ci_auth->changeUserStatus($id, 'inactive');
        
		$this->session->set_flashdata('message', $this->lang->line('mein_success_global'));
		 
		redirect(getenv('HTTP_REFERER'));
	}

	public function search($status = 'all')
	{
        $post = $this->input->post();
        
		$config = [
            'base_url' => site_url('admin/user/' . $status),
		    'total_rows' => $this->ci_auth->searchUser('total', $status, $post['keyword']),
		    'per_page' => 10,
            'uri_segment' => 5
        ];
        
		$this->pagination->initialize($config);
        
        $data['page_title'] = 'Search User';
        $data['pagination'] = $this->pagination->create_links();
		$data['results'] = $this->ci_auth->searchUser('list', $status, $post['keyword'], $config['per_page'], $this->uri->segment(5));
        $data['keyword'] = $post['keyword'];
        
		$this->view('admin/user', $data);
    }
    
    public function checkUser($username)
	{
        $user = $this->User_model->where('username', $username)->get();

        if ($user)
            json_response(['status' => 'success', 'data' => $user]);
        
        json_response(['status' => 'failed']);
    }

	public function add()
	{
	 	$data['page_title'] = 'New User';
		$data['form_type'] = 'new';
		$data['roles'] = $this->ci_auth->getRoles();
        
		$this->view('admin/form', $data);
	}

	public function insert()
	{
        $post = $this->input->post();

        $profileField = array_keys($this->shared['entry_profile']['fields']);
        $userValue = [];
        $profileValue = [];

        foreach($post as $p => $value){
            $this->session->set_flashdata($p, $value);
            if(in_array($p, $profileField)){
	            $profileValue[$p] = $value;
            } else {
	            $userValue[$p] = $value;
            }
        }
        
        $insert = $this->ci_auth->insertUser($userValue, $profileValue);
        
        if ($insert['status'] == 'success') 
        {
            $this->session->set_flashdata('message', '<div class="alert alert-success">'. $insert['message'] . '</div>');
            redirect('admin/user/edit/' . $insert['user_id']);
        }
        
        $this->session->set_flashdata('message', '<div class="alert alert-danger">'. $insert['message'] .'</div>');
        redirect('admin/user/add');
	}

	public function delete($id)
	{
		$this->ci_auth->changeUserStatus($id, 'deleted');
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_delete'));
		
		redirect(getenv('HTTP_REFERER'));
	}

	public function purge($id)
	{
		$this->ci_auth->hardDeleteUser($id);
		
		$this->session->set_flashdata('message', $this->lang->line('mein_success_delete'));
		
		redirect(getenv('HTTP_REFERER'));
	}

	public function export()
	{
		$filename = 'uploads/users.csv';

		$filter = $this->input->get(null, true);
        
        $this->User_model->_setFilter($filter);
		$results = $this->User_model->join_profile()->getAll();
		
		$headers = array_keys($results[0]);

		$fp = fopen($filename, 'w');
		fputcsv($fp, $headers);

		foreach ($results as $row) {
			$row['phone'] = substr($row['phone'], 0, 1) == '0' ? substr_replace($row['phone'], '62', 0, 1) : $row['phone'];
		    fputcsv($fp, $row);
		}

		fclose($fp);

		redirect($filename);
	}
}
