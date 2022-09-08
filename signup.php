<?php

require_once('system/const.php');

$user = json_decode(file_get_contents('php://input'));
$errors = array();

if (strlen($user->login) < LOGIN_LENGTH) {
	$errors['login'] = 'Login must contain at least ' . LOGIN_LENGTH . ' characters';
}

$password_regex = '/^[0-9]+[0-9a-z]*[a-z]+$|^[a-z]+[0-9a-z]*[0-9]+$/i';

if (strlen($user->password) < PASSWORD_LENGTH or !preg_match($password_regex, $user->password)) {
	$errors['password'] = 'Passwords must contain at least ' . PASSWORD_LENGTH .
		' characters, only letters and digits are allowed, both are required';
}

if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
	$errors['email'] = 'Invalid email';
}

$name_regex = '/^[A-ZА-Яр-ю]{' . NAME_LENGTH . ',}$/i';

if (!preg_match($name_regex, $user->name)) {
	$errors['name'] = 'Name must comprise only letters and be at least '
		. NAME_LENGTH . ' characters long';
}

$result = count($errors) == 0 ? ['success' => true] : ['success' => false, 'errors' => $errors];
echo json_encode($result);
