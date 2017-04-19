<?php 

class AssetManager
{
	private $db;

	public function __construct(PDO $db)
	{
		$this->setDb($db);
	}

	public function setDb(PDO $db)
	{
		$this->db = $db;
	}

	public function add($asset)
	{	
		// echo '2';
		// $strContent = implode('', $asset['data']);
  //       $content = pack('H*', $strContent);
  //       $handle = fopen('../assets/test.png', "r+");
  //       $write = fwrite($handle, $content);
  //       echo '3';

		$sql = 'INSERT INTO assets (unity_id, version, url) VALUES (:unity_id, :version, :url)';

		$req = $this->db->prepare($sql);
		$req->bindValue(':unity_id', $asset['unity_id']);
		$req->bindValue(':version', $asset['version']);
		$req->bindValue(':url', $asset['url']);
		
		$req->execute();
		$lastInsertId = $this->db->lastInsertId();

		$sql = 'INSERT INTO objects_assets (object_id, asset_id) VALUES (:object_id, :asset_id)';

		$req = $this->db->prepare($sql);
		$req->bindValue(':object_id', $asset['object_id']);
		$req->bindValue(':asset_id', $lastInsertId);
		$req->execute();
		// $req->bindValue(':note', $item->note());
		// $req->bindValue(':location', $item->location());
		// $req->bindValue(':author', $item->author());
		// $req->bindValue(':id_status', 4);
		// $req->bindValue(':filetype', $item->filetype());
		// $req->bindValue(':id_level', $item->idLevel());
		// $req->bindValue(':id_game', $item->idGame());
		// $req->bindValue(':extension', $item->extension());
		
		return $lastInsertId;
	}

	public function get($id)
	{
		$sql = 'SELECT id, unity_id, type_id, version, name FROM assets WHERE id = :id';
		$sth = $this->db->prepare($sql);
		$sth->bindValue('id', $id, PDO::PARAM_INT);
		$sth->execute();

		return new Asset($sth->fetch(PDO::FETCH_ASSOC));
	}

	public function getAllFromObject($id)
	{
		$sql = 'SELECT a.id, a.unity_id, a.version, a.name, a.type_id
				FROM assets a
					INNER JOIN objects_assets oa
					ON oa.asset_id = a.id
				WHERE oa.object_id = :id
				ORDER BY id ASC';
		
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':id', $id, PDO::PARAM_INT);
		$sth->execute();
		$list = [];
		while ($donnees = $sth->fetch(PDO::FETCH_ASSOC)) {
			$list[] = New Asset($donnees);
		}
		return $list;
	}

	public function getProgression(array $itemList)
	{
		$nb = count($itemList);
		$nbCompleted = 0;
		foreach ($itemList as $item)
		{
			if ($item->idStatus() == 1) { $nbCompleted ++; }
		}
		return $nb == 0 ? 0 : $nbCompleted * 100 / $nb;
	}

	public function getByStatus($id, $status)
	{
		$req = $this->db->query('SELECT COUNT(*) FROM items WHERE id_game = '.$id.' AND id_status = '.$status);
		return $req->fetch()[0];
	}

	// public function getPath(array $levelList, array $itemList)
	// {
	// 	$itemPathList = [];
	// 	foreach ($itemList as $item)
	// 	{
	// 		$item->
	// 	}
	// }
}

?>