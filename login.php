<?php

require_once('system/functions.php');

$credentials = getPostJsonOrDie();

require_once('system/Bootstrap.php');
require_once('system/ServiceException.php');

$service = Bootstrap::getInstance()->getService();
$result = ['success' => false];
try {
	$user = $service->login($credentials);
	$result = ['success' => true, 'user' => $user];
	//~ terminateSession();
	session_start();
	$_SESSION['user'] = $user;
} catch (ServiceException $e) {
	$result['errors'] = $e->getErrors();
}
echo json_encode($result);
