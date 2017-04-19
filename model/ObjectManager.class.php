<?php 


Class ObjectManager
{
	private $db;

	public function __construct(PDO $db)
	{
		$this->setDb($db);
	}

	public function setDb($db)
	{
		$this->db = $db;
	}

	public function add($object)
	{
		$sql = 'INSERT INTO objects (name, project_id) VALUES (:name, :project_id)';

		$req = $this->db->prepare($sql);

		$req->bindValue(':name', $object['name']);
		$req->bindValue(':project_id', $object['project_id']);

		return $req->execute() ? $this->db->lastInsertId() : FALSE;
	}

	public function get($id)
	{
		$sql = 'SELECT id, name, project_id, status_id FROM objects WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$donnees = $sth->fetch(PDO::FETCH_ASSOC);
		return new Object($donnees);
	}

	public function getAllFromProject($id)
	{
		$sql = 'SELECT id, name, project_id, status_id FROM objects WHERE project_id = :id ORDER BY id ASC';
		
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$list = [];
		while ($donnees = $sth->fetch(PDO::FETCH_ASSOC))
		{
			$list[] = new Object($donnees);
		}
		return $list;
	}
}

?>