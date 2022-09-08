<?php

class ServiceException extends Exception {
	private object $errors;
	
	public function getErrors(): object {
		return $this->errors;
	}
	
	public function setErrors(object $errors) {
		$this->errors = $errors;
	}
}
