<?php

require_once('User.php');

interface Repository {
	public function insert(User $user);
	public function findByLogin(string $login): ?User;
	public function countByEmail(string $email): int;
}
