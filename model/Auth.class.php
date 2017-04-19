<?php

class Auth {

	private $db,
			$user;

	private $alg = "HSHA256",
			$type = "JWT",
			$epx,
			$name,
			$role,
			$secret;

	private $config = 	array(
							"digest_alg" => "sha256"
						);

	private $header,
			$payload,
			$signature,
			$token,
			$privatekey;

	public function __construct(PDO $db) {
		$this->db = $db;
	}

	public function token() { return $this->token; }

	public function user() { return $this->user; }

	public function verify($email, $password) {
		$sql = "SELECT id, password FROM users WHERE email = :email";
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':email', $email);
		if ($sth->execute()) {
			while ($data = $sth->fetch(PDO::FETCH_ASSOC)) {
				if (password_verify($password, $data['password'])) {
					$userManager = new UserManager($this->db);
					$this->user = $userManager->get($data['id']);
					return $data['id'];
				}
			}
			return false;
		}
	}

	public function generateToken() {
		$this->name = $this->user->firstname().' '.$this->user->lastname();
		$this->role = $this->user->role();
		$this->secret = base64_encode(file_get_contents('http://localhost/interface/model/secret.txt'));
		$curDate = new DateTime();
		$expTimestamp = $curDate->getTimestamp() + (60*10);
		$this->exp = date("Y-m-d H:i:s", $expTimestamp);
		var_dump($this->exp);

		$this->header = base64_encode(json_encode(array(
			"type" => $this->type,
			"alg" => $this->alg,
		)));

		$this->payload = base64_encode(json_encode(array(
			"exp" => $this->exp,
			"name" => $this->name,
			"role" => $this->role,
			"id" => $this->user->id()
		)));

		$this->signature = base64_encode(hash_hmac(
			'sha256',
			$this->header.'.'.$this->payload.$this->secret,
			$this->secret
		));

		$token = $this->header.'.'.$this->payload.'.'.$this->signature;
		$this->token = base64_encode($token);

		return true;
	}

	public function cryptToken() {

		$res = openssl_pkey_new($this->config);
		openssl_pkey_export($res, $privatekey);
		$this->privatekey = $privatekey;
		$publickey = openssl_pkey_get_details($res);
		$publickey = $publickey["key"];
		
		$crypted = openssl_public_encrypt($this->token, $cryptedToken, $publickey);

		echo $cryptedToken;

		return $crypted ? base64_encode($cryptedToken) : false;
	}

	public function checkToken($cryptedToken) {
		$cryptedToken = str_replace(' ', '+', $cryptedToken);

		$sql = "SELECT user_id, token, privatekey, exp FROM users_tokens";
		$sth = $this->db->query($sql);

		$data = $sth->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($data as $auth) {
			openssl_private_decrypt(base64_decode($cryptedToken), $decryptedToken, $auth['privatekey']);

			if (($auth['token']) == base64_encode($decryptedToken)) {
				$userManager = new UserManager($this->db);
				$this->user = $userManager->get($auth['user_id']);
				return true;
			}
		}
		return false;
	}

	public function refreshToken() {
		$this->generateToken();
		$cryptedToken = $this->cryptToken();
		if ($cryptedToken == false)
			return false;

		$sql = "UPDATE users_tokens
					SET token = :token,
						privatekey = :privatekey,
						exp = :exp
					WHERE user_id = :id";

		$sth = $this->db->prepare($sql);
		$sth->bindValue(':token', $this->token);
		$sth->bindValue(':privatekey', $this->privatekey);
		$sth->bindValue(':exp', $this->exp);
		$sth->bindValue(':id', $this->user->id(), PDO::PARAM_INT);

		return $sth->execute() ? $cryptedToken : false;
	}

	public function insertToken() {
		$sql = "INSERT INTO users_tokens (user_id, token, privatekey, exp) VALUES (:user_id, :token, :privatekey, :exp)";
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':user_id', $this->user->id());
		$sth->bindValue(':token', $this->token);
		$sth->bindValue(':privatekey', $this->privatekey);
		$sth->bindValue(':exp', $this->exp);
		
		return $sth->execute() ? true : false;
	}

	public function checkActiveToken() {
		$sql = "SELECT id FROM users_tokens WHERE user_id = :id";
		$sth = $this->db->prepare($sql);
		$sth->bindValue(':id', $this->user->id());

		$sth->execute();
		$active = $sth->fetch();
		return $active == null ? false : true;
	}

}