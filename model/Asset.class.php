<?php 

class Asset
{
	public 	$id,
			$unityId,
			$targetUrl = null,
			$sourceUrl = null,
			$typeId,
			$version,
			$name,
			$file = null;

	

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
			if (method_exists($this, $method)) 
				$this->$method($value);
		}
	}

	// Getters list

	public function id() { return $this->id; }

	public function unityId() { return $this->unityId; }

	public function sourceUrl() { return isset($this->sourceUrl) ? $this->sourceUrl : false; }

	public function targetUrl() { return isset($this->targetUrl) ? $this->targetUrl : false; }

	public function typeId() { return $this->typeId; }

	public function version() { return $this->version; }

	public function name() { return $this->name; }

	public function file() { return $this->file; }

	// Setters list

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setUnityId($id)
	{
		$this->unityId = $id;
	}

	public function setTypeId($id) {
		$this->typeId = $id;
	}

	public function setVersion($version)
	{
		$this->version = $version;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setFile(File $file)
	{
		$this->file = $file;
	}

	public function info() {
		$info = array(
			'id' => $this->id,
			'unityId' => $this->unityId,
			'name' => $this->name,
			'targetUrl' => $this->targetUrl,
			'sourceUrl' => $this->sourceUrl,
			'version' => $this->version
		);

		return $info;
	}

	public function buildUrl() {
		include 'sql_connection.php';
		$sql = 'SELECT hierarchy FROM filetype WHERE id = :id';

		$sth = $db->prepare($sql);
		$sth->bindValue('id', $this->typeId, PDO::PARAM_INT);
		$sth->execute();
		$data = $sth->fetch(PDO::FETCH_ASSOC);

		$basename = 'http://localhost/interface/uploads';
		$this->targetUrl = $basename.'/target/'.$data['hierarchy'].'/'.$this->name;
		$this->sourceUrl = $basename.'/source/'.$data['hierarchy'].'/'.$this->name;
	}
}