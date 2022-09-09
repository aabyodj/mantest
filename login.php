<?php

require_once('system/Bootstrap.php');
require_once('system/ServiceException.php');

$service = Bootstrap::getInstance()->getService();
$result = ['success' => false];
try {
	$credentials = json_decode(file_get_contents('php://input'));
	$user = $service->login($credentials);
	$result = ['success' => true, 'user' => $user];
	$_SESSION = array();
	setcookie(session_name(), '', time() - 42000);
	session_destroy();
	session_start();
	$_SESSION['user'] = $user;
} catch (ServiceException $e) {
	$result['errors'] = $e->getErrors();
}
echo json_encode($result);
