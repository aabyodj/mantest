<?php

require_once('const.php');
require_once('RepositoryJson.php');
require_once('ServiceImpl.php');

class Bootstrap {
	private static Bootstrap $INSTANCE;
	
	private Repository $repository;
	private Service $service;
	
	private function __construct() {}
	
	public static function getInstance(): Bootstrap {
		if (!isset(self::$INSTANCE)) {
			self::$INSTANCE = new Bootstrap();
		}
		return self::$INSTANCE;
	}
	
	public function getRepository(): Repository {
		if (!isset($this->repository)) {
			$this->repository = new RepositoryJson(JSON_REPO_DIR);
		}
		return $this->repository;
	}
	
	public function getService(): Service {
		if (!isset($this->service)) {
			$this->service = new ServiceImpl($this->getRepository());
		}
		return $this->service;
	}
	
}
