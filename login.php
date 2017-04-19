<?php

$title = 'Connexion - GamesBrand Portal';
include 'header.php';
include 'model/functionsLoader.php';

if (isset($_SESSION['connected']) && is_numeric($_SESSION['connected'])) {
	echo 'Vous êtes déjà connecté !<br>';
	echo '<a href="disconnect.php">Déconnexion<a>';
	exit;
}

if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
	$email = htmlentities($_POST['email']);
	$password = htmlentities($_POST['password']);
	$sql = "SELECT id, password FROM users WHERE email = :email";
	$sth = $db->prepare($sql);
	$sth->bindValue(':email', $email);
	if ($sth->execute()) {
		while ($data = $sth->fetch(PDO::FETCH_ASSOC)) {
			if (password_verify($password, $data['password'])) {
				$_SESSION['connected'] = $data['id'];
				header('Location: /interface/?id=121');
				exit;
			}
		}
		$message = 'Le mot de passe ne correspond pas à l\'adresse email';
	} else {
		$message = 'Cette adresse email n\'appartient à aucun utilisateur';
	}
}

?>
<form action="" method="POST">
	<label for="email">Adresse e-mail:</label><br>
	<input type="email" name="email" id="email"><br><br>
	<label for="password">Mot de passe</label><br>
	<input type="text" name="password" id="password"><br><br>
	<input type="submit">
</form>
<?php

if (isset($message)) {
	echo '<p class="formError">'.$message.'</p>';
}

include 'footer.php';