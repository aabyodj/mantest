<?php

function getPostJsonOrDie(): object {	
	$result = json_decode(file_get_contents('php://input'));
	if (null == $result) {
		http_response_code(400);
		exit();
	}
	return $result;
}

function terminateSession(): void {	
	$_SESSION = array();
	setcookie(session_name(), '', time() - 42000);
	session_destroy();
}
