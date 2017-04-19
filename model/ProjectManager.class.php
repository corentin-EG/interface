<?php 

require_once 'functionsLoader.php';

Class ProjectManager
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

	public function add($project)
	{
		$sql = 'TRUNCATE TABLE projects, objects, assets, objects_assets';
		$sth = $this->db->query();


		$sql = 'INSERT INTO projects (name, client, deadline) VALUES (:name, :client, :deadline)';
		
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':name', $project['name']);
		$sth->bindValue(':client', $project['client']);
		$sth->bindValue(':deadline', $project['deadline']);

		return $sth->execute() ? $this->db->lastInsertId() : FALSE;
	}

	// public function i_create() {

	// 	$sql = 'UPDATE project SET name = :name, client = :client, deadline = :deadline WHERE id = 1';

	// 	$sth = $this->db->prepare($sql);
	// 	$sth->bindValue(':name', $project['name']);
	// 	$sth->bindValue(':client', $project['client']);
	// 	$sth->bindValue(':deadline', $project['deadline']);


	// }

	public function remove($id)
	{
		// to do
	}

	// public function countLevel($id, $status = false)
	// {
	// 	$query = (!$status) ? 'SELECT COUNT(*) FROM level WHERE id_game = '.$id : 'SELECT COUNT(*) FROM level WHERE id_game = '.$id.' AND id_status = '.$status;
	// 	$req = $this->db->query($query);
	// 	return $req->fetch()[0];
	// }

	public function get($id)
	{
		$req = $this->db->prepare('SELECT id, name, client, status_id, deadline FROM projects WHERE id = :id');
		$req->bindValue(':id', $id, PDO::PARAM_INT);
		$req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);
		return new Project($donnees);
	}

	public function getAll()
	{
		$list = [];
		$req = $this->db->query('SELECT id, name, client, status_id, deadline FROM projects ORDER BY deadline ASC');
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
			$list[] = New Project($donnees);
		}
		return $list;
	}

	public function exists($id)
	{
		$req = $this->db->prepare('SELECT name FROM projects WHERE id = :id');
		$req->bindValue(':id', $id, PDO::PARAM_INT);
		$req->execute();
		if ($req->fetch())
		{
			return true;
		} else
		{
			return false;
		}
	}

}










$json = [
			['name' => 'Level_01', 
			'items' => [['name' => 'Banc', 'note' => 'blabla', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'idStatus' => 3, 'filetype' => 'image'],
						['name' => 'Table', 'note' => 'efefz', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'idStatus' => 4, 'filetype' => 'image']]],
			['name' => 'Level_02', 
			'items' => [['name' => 'Boutique', 'note' => 'hello world', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'idStatus' => 3, 'filetype' => 'image'],
						['name' => 'Parapluie', 'note' => 'check it boy', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'idStatus' => 4, 'filetype' => 'image'],
						['name' => 'Champagne', 'note' => '', 'location' => 'the/file/path/.png', 'author' => 'Alisson', 'idStatus' => 4, 'filetype' => 'image']]]
		];



function testNewProject($json, $db)
{
	$gameManager = new GameManager($db);
	$game = new Game([
		'name' => 'jeu test',
		'idStatus' => 1,
		'json' => $json
		]);
	$gameManager->add($game);
	$levelManager = new LevelManager($db);
	$ItemManager = new ItemManager($db);

	foreach ($json as $value)
    {
    	$level = new Level([
			'name' => $value['name'],
			'idStatus' => 4,
			'itemsTotal' => count($value['items']),
			'idGame' => $game->id()
		]);
		$levelManager->generate($level);
		if ($value['items'])
		{
			foreach ($value['items'] as $iKey => $iValue)
			{
				$item = new item([
		 			'name' => $iValue['name'],
		 			'note' => $iValue['note'],
		 			'location' => $iValue['location'],
		 			'author' => $iValue['author'],
		 			'idStatus' => $iValue['idStatus'],
		 			'filetype' => $iValue['filetype'],
		 			'idLevel' => $level->id(),
		 			'idGame' => $game->id()
				]);
				$ItemManager->generate($item);
			}
		}	
    }
}

