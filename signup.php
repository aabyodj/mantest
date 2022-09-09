<?php

require_once('system/Bootstrap.php');
require_once('system/ServiceException.php');

$service = Bootstrap::getInstance()->getService();
$result = ['success' => false];
try {
	$userData = json_decode(file_get_contents('php://input'));
	$service->createUser($userData);
	$result['success'] = true;
} catch (ServiceException $e) {
	$result['errors'] = $e->getErrors();
}
echo json_encode($result);
