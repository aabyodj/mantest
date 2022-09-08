<?php

require_once('system/Bootstrap.php');
require_once('system/Service.php');
require_once('system/ServiceException.php');

$service = Bootstrap::getInstance()->getService();
$result = ['success' => true];
try {
	$userData = json_decode(file_get_contents('php://input'));
	$service->createUser($userData);
} catch (ServiceException $e) {
	$result['success'] = false;
	$result['errors'] = $e->getErrors();
}
echo json_encode($result);
