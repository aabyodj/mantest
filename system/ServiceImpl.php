<?php

require_once('const.php');
require_once('Service.php');
require_once('ServiceException.php');
require_once('Repository.php');
require_once('User.php');

class ServiceImpl implements Service {
	private const PASSWORD_REGEX = '/^[0-9]+[0-9a-z]*[a-z]+$|^[a-z]+[0-9a-z]*[0-9]+$/i';
	private const NAME_REGEX = '/^[A-ZА-Яр-ю]{' . NAME_LENGTH . ',}$/i';
	
	private Repository $repository;
	
	public function __construct(Repository $repository) {
		$this->repository = $repository;
	}
		
	public function createUser(object $userData) {		
		$errors = [];
		if (strlen($userData->login) < LOGIN_LENGTH) {
			$errors['login'] = true;
		}
		if (strlen($userData->password) < PASSWORD_LENGTH or !preg_match(self::PASSWORD_REGEX, $userData->password)) {
			$errors['password'] = true;
		}
		if (!filter_var($userData->email, FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Invalid email';
		}
		if (!preg_match(self::NAME_REGEX, $userData->name)) {
			$errors['name'] = true;
		}
		if (count($errors) > 0) {
			$e = new ServiceException('Invalid user data');
			$e->setErrors((object) $errors);
			throw $e;
		}
		$userData->passwordHash = crypt($userData->password, SALT);
		$user = new User($userData);
		try {
			$this->repository->insert($user);		
		} catch (Exception $e) {
			switch ($e->getMessage()) {
				case 'Duplicate login':
					$errors['login'] = 'This login is already in use';
					break;
				case 'Duplicate email':
					$errors['email'] = 'This email is already registered';
					break;
				default:
					throw $e;				
			}
			$e = new ServiceException($e->getMessage(), 0, $e);
			$e->setErrors((object) $errors);
			throw $e;
		}
	}	
	
	public function login(object $credentials): User {
		$user = $this->repository->findByLogin($credentials->login);
		$knownHash = $user != null ? $user->getPasswordHash() : '';
		if (!password_verify($credentials->password, $knownHash) or null == $user) {
			$e = new ServiceException('Login or password is incorrect');
			$e->setErrors((object) ['login' => 'Login or password is incorrect']);
			throw $e;
		}
		$user->setPasswordHash('');
		return $user;
	}
}
