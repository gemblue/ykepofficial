<?php namespace App\modules\files\libraries;

interface FileManagerInterface {

	public function list($path);
	public function upload($file, $destination, $mode = 'public');
	public function delete($file);

}