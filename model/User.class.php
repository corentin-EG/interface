<?php

class User
{
	private $id,
			$pseudo,
			$firstName,
			$lastName,
			$password,
			$email,
			$role,
			$picLocation,
			$permitedAttemps = 20;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value)
		{
			$key = str_replace('_', '', $key);
			$method = 'set'.$key;
			if (method_exists($this, $method)) $this->$method($value);
		}
	}

	// GETTERS

	public function id() { return $this->id; }

	public function pseudo() { return $this->pseudo; }

	public function firstName() { return $this->firstName; }

	public function lastName() { return $this->lastName; }

	public function password() { return $this->password; }

	public function email() { return $this->email; }

	public function role() { return $this->role; }

	public function picLocation() { return $this->picLocation; }

	// SETTERS

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setPseudo($pseudo)
	{
		if (is_string($pseudo)) $this->pseudo = $pseudo;
	}

	public function setFirstName($firstName)
	{
		if (is_string($firstName)) $this->firstName = $firstName;
	}

	public function setLastName($lastName)
	{
		if (is_string($lastName)) $this->lastName = $lastName;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setRole($role)
	{
		$this->role = $role;
	}

	public function setPicLocation($picLocation)
	{
		if (is_string($picLocation)) $this->picLocation = $picLocation;
	}

	public function info() {
		$info = array(
			'id' => $this->id,
			'pseudo' => $this->pseudo,
			'firstName' => $this->firstName,
			'lastName' => $this->lastName,
			'email' => $this->email,
			'role' => $this->role,
			'picLocation' => $this->piclocation
		);

		return $info;
	}

}