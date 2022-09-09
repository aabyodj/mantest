<?php

require_once('Repository.php');

class RepositoryJson implements Repository {
	
	private string $directory;
	private string $email_index_file_name;
	
	function __construct(string $directory) {
		$this->directory = $directory . DIRECTORY_SEPARATOR;
		$this->email_index_file_name = $directory . DIRECTORY_SEPARATOR . 'email_index.json';
		if (!is_dir($directory)) {
			mkdir($directory);
		}
	}
	
	public function insert(User $user) {
		$login_hash = sha1($user->getLogin());
		$file_name = $this->directory . $login_hash . '.json';
		$email_index_file = fopen($this->email_index_file_name, 'c+');
		flock($email_index_file, LOCK_EX);
		if (is_file($file_name)) {
			throw new Exception('Duplicate login');			
		}
		$email_index = json_decode(file_get_contents($this->email_index_file_name), true);
		if (isset($email_index[$user->getEmail()])) {
			throw new Exception('Duplicate email');
		}
		$email_index[$user->getEmail()] = $login_hash;
		ftruncate($email_index_file, 0);
		fwrite($email_index_file, json_encode($email_index));
		file_put_contents($file_name, json_encode($user));
		fclose($email_index_file);
	}
	
	public function findByLogin(string $login): ?User {		
		$file_name = $this->directory . sha1($login) . '.json';
		return is_file($file_name) ? new User(json_decode(file_get_contents($file_name))) : null;
	}
	
	public function countByEmail(string $email): int {
		$email_index = json_decode(file_get_contents($this->email_index_file_name), true);
		return isset($email_index[$email]) ? 1 : 0;
	}
}
