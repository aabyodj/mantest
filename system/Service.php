<?php

require_once('User.php');

interface Service {
	public function createUser(object $userData);
	public function login(object $credentials): User;
}
