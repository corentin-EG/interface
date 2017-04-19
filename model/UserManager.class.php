<?php

class UserManager
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

	public function get($id)
	{
		$req = 'SELECT u.id, u.user_name AS userName, u.first_name AS firstName, u.last_name AS lastName, u.email, u.password, u.company, r.name
				FROM users u
				INNER JOIN users_roles ur
					ON u.id = ur.user_id
				INNER JOIN roles r
					ON r.id = ur.role_id
				WHERE u.id = :id';
		$sth = $this->db->prepare($req);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return new User($sth->fetch(PDO::FETCH_ASSOC));
	}

	public function getList()
	{
		$list = [];
		$req = $this->db->query('SELECT * FROM users ORDER BY pseudo');
		while($donnees = $req->fetch(PDO::FETCH_ASSOC))
		{
			$list[] = new User($donnees);
		}
		return $list;
	}

	public function add(User $user)
	{
		$req = $this->db->prepare('INSERT INTO users(pseudo, email, password) VALUES (:pseudo, :email, :password)');
		$req->bindValue(':pseudo', $user->pseudo());
		$req->bindValue(':email', $user->email());
		$req->bindValue(':password', $user->password());
		$req->execute();

		// if ($req)
		// {
		// 	$req = $this->db->query('SELECT LAST_INSERT_ID() FROM user')
		// 	$user->setId($req->fetch()[0]);
		// }
	}



	
}