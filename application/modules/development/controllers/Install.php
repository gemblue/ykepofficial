<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public $module_location;

	function __construct()
	{
		parent::__construct();
		
		$this->load->library('migration');

		if($_ENV['CI_ENV'] == 'production')
			if($this->input->get('key') != '1234567890qwertyuiop')
				show_404();
	}

	public function index()
	{
		redirect('development/install/migrateAllToLatest');
	}

	function runSeeder($module)
	{
		if(modules_list()[$module] ?? null){
			$classname = ucfirst($module).'Seeder';
			$path = modules_list()[$module]['path'].'seeds/'.$classname.'.php';
			if(! file_exists($path))
				show_error('Seeder file not found');

			require_once($path);
			$seeder = new $classname;
			$seeder->run();

			$this->session->set_flashdata('message', '<div class="alert alert-success">Seeder run successfully.</div>');
			redirect('admin/development/migration/index/'.$module);
		}

		show_error('Module not found');
	}

	public function migrateAllToLatest($enabled_module_only = true)
	{
		$this->migration->migrate_all_modules('latest', $enabled_module_only);

		echo "All ".($enabled_module_only?"enabled":"")." modules migrated to latest version.";
	}

	public function cloneMasterDB($confirm = false)
	{
		if(!$confirm)
			show_error('Operasi ini akan mengganti semua data dan skema dari database yang aktif ('.$_ENV['DBNAME'].') dan diganti dengan hasil duplikasi dari database master ('.$_ENV['DBNAME_MASTER'].').<br>Pastikan Kamu tidak salah mengeset nama database (jangan sampai database Master yang kehapus!). <strong id="txtProses">Untuk melanjutkan klik <a href="'.site_url('development/install/cloneMasterDB/true').'" onclick="document.getElementById(\'txtProses\').innerHTML = \'Memproses..\';">DISINI</a></strong>');

		if(! file_exists('env.json')) die('env.json tidak ditemukan.');
		$env = json_decode(file_get_contents('env.json'), true);
		foreach ($env as $key => $value) $_ENV[$key] = $value;

		if(!isset($_ENV['DBNAME_MASTER']))
			die("DBNAME_MASTER belum diset. Silakan set dengan nama database yang ingin diclone.");

		if($_ENV['DBNAME'] == $_ENV['DBNAME_MASTER'])
			die("DBNAME harus berbeda dari DBNAME_MASTER bila hendak clone.");

		if($_ENV['CI_ENV'] == 'production')
			die("Database Production tidak boleh diganggu!");

		$query = 'mysql -u'.$_ENV['DBUSER'].' -p"'.$_ENV['DBPASS'].'" -e "drop database '.$_ENV['DBNAME'].';" --force && mysql -u'.$_ENV['DBUSER'].' -p"'.$_ENV['DBPASS'].'" -e "create database '.$_ENV['DBNAME'].';" && mysqldump --force --log-error=/tmp/duplicate_mysql_error.log -u'.$_ENV['DBUSER'].' -p"'.$_ENV['DBPASS'].'" '.$_ENV['DBNAME_MASTER'].' | mysql -u'.$_ENV['DBUSER'].' -p"'.$_ENV['DBPASS'].'" '.$_ENV['DBNAME'];
		shell_exec($query);
		echo "Done";
	}

	public function export_wordpress($dbname = false)
	{
		if(! $dbname) 
			show_error('Please provide database name in segment 4, i.e '.site_url('development/install/export_wordpress/').'<strong>dbname</strong>');

		// Connect database
		$dsn = 'mysqli://root:root@localhost/'.$dbname;
		$DB = $this->load->database($dsn, true);

		// Get posts data
		$post_query = $DB->get('wp_posts');

		$posts = [];
		if($post_query->num_rows() > 0)
		{
			foreach ($post_query->result_array() as $post_result) 
			{
				$posts[$post_result['post_type']][$post_result['ID']] = $post_result;

				// Get post metadata
				$metas = $DB->where('post_id', $post_result['ID'])->get('wp_postmeta');
				if($metas->num_rows() < 1) continue;

				foreach ($metas->result_array() as $meta) {
					$posts[$post_result['post_type']][$post_result['ID']]['metas'][$meta['meta_key']] = $meta['meta_value'];
				}
			}
		}

		// Process post and page posttype
		$postdata = [];
		foreach ($posts['post'] as $post) {
			$postdata[$post['ID']] = [
				'id' => $post['ID'],
				'author' => $post['post_author'],
				'content' => $post['post_content'],
				'intro' => $post['post_excerpt'],
				'title' => $post['post_title'],
				'slug' => $post['post_name'],
				'status' => $post['post_status'],
				'type' => $post['post_type'],
				'template' => null,
				'published_at' => $post['post_date'],
				'created_at' => $post['post_date'],
				'updated_at' => $post['post_modified'],
				'featured_image' => null
			];
			if(isset($post['metas']['_thumbnail_id']))
				$postdata[$post['ID']]['featured_image'] = 'uploads/'.$posts['attachment'][$post['metas']['_thumbnail_id']]['metas']['_wp_attached_file'];
		}
		foreach ($posts['page'] as $post) {
			$postdata[$post['ID']] = [
				'id' => $post['ID'],
				'author' => $post['post_author'],
				'content' => $post['post_content'],
				'intro' => $post['post_excerpt'],
				'title' => $post['post_title'],
				'slug' => $post['post_name'],
				'status' => $post['post_status'],
				'type' => $post['post_type'],
				'template' => null,
				'published_at' => $post['post_date'],
				'created_at' => $post['post_date'],
				'updated_at' => $post['post_modified'],
				'featured_image' => null
			];
			if(isset($post['metas']['_thumbnail_id']))
				$postdata[$post['ID']]['featured_image'] = 'uploads/'.$posts['attachment'][$post['metas']['_thumbnail_id']]['metas']['_wp_attached_file'];
		}

		// print_r($postdata);

		// Import wp_posts to mein_posts
		$this->db->insert_batch('mein_posts', $postdata);



	}

	function getTaxonomies($DB, $ids = [])
	{
		$data = $DB->from('wp_term_taxonomy tt')
					->join('wp_terms t', 't.term_id = tt.term_id')
					->join('wp_term_relationships tr', 'tr.term_taxonomy_id = tt.term_taxonomy_id')
					->where_in('tt.taxonomy', ['category','post_tag'])
					->where_in('tr.object_id', $ids)
				  	->get();

		if($data->num_rows() < 1)
			return null;

		$result = [];
		foreach ($data->result_array() as $taxonomy) {
			$result[$taxonomy['object_id']][$taxonomy['term_id']] = $taxonomy;
		}

		return $result;
	}

	public function pull()
	{
		$this->load->view('migration/pull');
	}
}
