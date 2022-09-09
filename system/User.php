<?php

class User implements JsonSerializable {
	private string $login;
	private string $passwordHash;
	private string $email;
	private string $name;
	
	public function __construct(object $origin) {
		$this->login = $origin->login;
		$this->passwordHash = $origin->passwordHash;
		$this->email = $origin->email;
		$this->name = $origin->name;
	}
	
	public function getLogin(): string {
		return $this->login;
	}
	
	public function getPasswordHash(): string {
		return $this->passwordHash;
	}
	
	public function setPasswordHash(string $passwordHash) {
		$this->passwordHash = $passwordHash;
	}
	
	public function getEmail(): string {
		return $this->email;
	}
	
	public function getName(): string {
		return $this->name;
	}
	
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
	
}
