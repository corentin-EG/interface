<?php 

class Object
{
	public 	$id,
			$name,
			$statusId,
			$projectId;

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

	public function statusId()
	{
		return $this->statusId;
	}

	public function projectId()
	{
		return $this->projectId;
	}

	public function assets()
	{
		return $this->assets;
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
			$this->name = $name;
		}
	}

	public function setStatusId($status)
	{
		$this->statusId = $status;
	}

	public function setProjectId($project)
	{
		$this->projectId = $project;
	}

	public function setAssets($assets)
	{
		$this->assets = $assets;
	}

	public function info() {
		$info = array(
			'id' => $this->id,
			'name' => $this->name,
			'statusId' => $this->statusId,
			'projectId' => $this->projectId,
			'assets' => $this->assets
		);

		return $info;
	}
}

 ?>