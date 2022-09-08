<?php

require_once('system/const.php');
require_once('system/RepositoryJson.php');
require_once('system/User.php');

$repository = new RepositoryJson('system/json');

$user = json_decode(file_get_contents('php://input'));
$errors = array();

if (strlen($user->login) < LOGIN_LENGTH) {
	$errors['login'] = true;
}

$password_regex = '/^[0-9]+[0-9a-z]*[a-z]+$|^[a-z]+[0-9a-z]*[0-9]+$/i';

if (strlen($user->password) < PASSWORD_LENGTH or !preg_match($password_regex, $user->password)) {
	$errors['password'] = true;
}

if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
	$errors['email'] = 'Invalid email';
}

$name_regex = '/^[A-ZА-Яр-ю]{' . NAME_LENGTH . ',}$/i';

if (!preg_match($name_regex, $user->name)) {
	$errors['name'] = true;
}

$result = count($errors) == 0 ? ['success' => true] : ['success' => false, 'errors' => $errors];

if ($result['success']) {
	$user->passwordHash = sha1($user->password);
	$user = new User($user);
	try {
		$repository->insert($user);		
	} catch (Exception $e) {
		$result['success'] = false;
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
		$result['errors'] = $errors;
	}
}

echo json_encode($result);
