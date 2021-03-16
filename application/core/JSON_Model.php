<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Nyankod\JsonFileDB;

/**
 * JSON file storage based model
 *
 * mainly using Nyankod\JsonFileDB as driver
 *
 */
class JSON_Model extends CI_Model
{
	// Database object
	private $DB;
	
	// Storage path, i.e. "./data/"
	protected $path = false;

	// Database file name as tablename
	protected $table;

	// Basic data structure
	protected $structure = [ 'id' => null ];

	public function __construct()
	{
		parent::__construct();

		if(! $this->path)
			show_error('Please set database $path first.');

		if(! file_exists($this->path))
			mkdir($this->path, 0775, true);

		$this->init();
	}

	public function __destruct()
	{
		unset($this->DB);
	}

	public function init($path = false)
	{
		if($path) $this->path = trim($path, '/').DIRECTORY_SEPARATOR;
		$this->DB = new JsonFileDB($this->path);

		return $this;
	}

	public function from($table = false)
	{
		if($table) $this->table = $table;
		$this->DB->setTable($this->table);
		return $this;
	}

	// It is just an alias haha
	public function to($table = false)
	{
		return $this->from($table);
	}

	public function get($key, $value)
	{
		return $this->DB->select($key, $value);
	}

	public function get_like($key, $value)
	{
		return $this->DB->like($key, $value);
	}

	public function get_all()
	{
		return $this->DB->selectAll();
	}

	public function get_all_tables()
	{
		$files = directory_map($this->path, 1);
		$data = [];
		foreach ($files as $file) {
			$fileinfo = pathinfo($file);
			if($fileinfo['extension'] == 'json'){
				$data[$fileinfo['filename']] = $this->from($fileinfo['filename'])->get_all();
			}
		}
		return $data;
	}

	public function insert($data)
	{
		$id = uniqid();
		$data = array_merge($this->structure, ['id' => $id], $data);
		if($this->DB->insert($data) === true)
			return $id;

		return false;
	}

	public function update($key, $value, $data)
	{
		return $this->DB->update($key, $value, $data);
	}

	public function update_children($key, $value, $data)
	{
		return $this->DB->update_children($key, $value, $data);
	}

	public function update_all($data)
	{
		return $this->DB->updateAll($data);
	}

	public function delete($key, $value)
	{
		return $this->DB->delete($key, $value);
	}

	public function empty()
	{
		return $this->DB->deleteAll();
	}
}