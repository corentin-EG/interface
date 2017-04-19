<?php 

class Project
{
	public	$id,
			$name,
			$client,
			$statusId,
			$deadline;

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

	// Getters list

	public function id()
	{
		return $this->id;
	}

	public function name()
	{
		return $this->name;
	}

	public function client()
	{
		return $this->client;
	}

	public function statusId()
	{
		return $this->statusId;
	}

	public function deadline()
	{
		return $this->deadline;
	}


	// Setters list

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		if (is_string($name))
		{
			$this->name = htmlspecialchars($name);
		}
	}

	public function setClient($client)
	{
		if (is_string($client))
		{
			$this->client = htmlspecialchars($client);
		}
	}

	public function setStatusId($id)
	{
		if ($id >= 0 && $id <= 4)
		{
			$this->statusId = $id;
		}
	}

	public function setDeadline($deadline)
	{
		$this->deadline = $deadline;
	}

	public function info() {
		$info = array(
			'id' => $this->id,
			'name' => $this->name,
			'client' => $this->client,
			'statusId' => $this->statusId,
			'deadline' => $this->deadline
		);

		return $info;
	}
}
?>