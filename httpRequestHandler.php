<?php

$url = "http://localhost/interface/api/assets";
// $url = "http://games-brand.com/portal/api/projects";
//$url = "http://localhost/interface/api/users?token=ZXlKMGVYQmxJam9pU2xkVUlpd2lZV3huSWpvaVNGTklRVEkxTmlKOS5leUpsZUhBaU9pSXlNREUzTFRBekxUSTBJREUzT2pBNU9qQTBJaXdpYm1GdFpTSTZJa052Y21WdWRHbHVJRTFoY25ScGJpSXNJbkp2YkdVaU9tNTFiR3dzSW1sa0lqb2lOREFpZlE9PS5ZMkV5TlRFMFpqRTVNakl6WmpSaE9HRTFOR016T0dVd05ESTNNVEppWVRGbE1tWTNaVGhpTWpBNE9UUXlOR1V3TmpGbVpUWXhPVEkwWXpabVlUSXlOZz09";
$pluginFields = array(
	'name' => 'IRQ 2',
	// 'note' => 'Increase Render Quality 2',
	'author' => 'Jeremy',
	'majorVersion' => '5',
	'minorVersion' => '02',
	'unityVersionMinimum' => '5.1p1'
);

$file = realpath('model/Machine.FBX');

// $cfile = new CURLFile($file,'image/png','deliveroo');
$cfile = new CURLFile($file,'application/octet-stream','Machine');

$asset = array(
	'unity_id' => '0215423023698486',
	'object_id' => '5',
	'version' => 0,
	'data' => $cfile
);

$object = array(
	array(
		'project_id' => '122',
		'name' => 'SuperGuigui'
	),
	array(
		'project_id' => '123',
		'name' => 'Le petit doigt d\'Alisson'
	)
);

$userFields = array(
	'jsonPorject' => 'aa',
	'firstName' => 'zz',
	'lastName' => 'ee',
	'email' => 'corentinm@equilibregames.com',
	'password' => 'totoa',
	'company' => 'Equilibre Games'
);

$project = array(
	'name' => 'Testproject',
	'client' => 'clientHasNoName',
	'deadline' => NULL
);

$login = array(
	'email' => 'corentinm@equilibregames.com',
	'password' => 'toto'
);

$ch = curl_init(); // initialisation de la requête
curl_setopt($ch, CURLOPT_URL, $url); // set l'URL cible
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // bloque l'affichage direct de ce que retourne la requête
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $asset); // passe en paramètre un tableau de données
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

$output = curl_exec($ch); // exécute la requête HTTP

// formatte l'affichage d'un tableau
echo '<pre>';
print_r(json_decode($output, true));
echo '</pre>';

var_dump(curl_error($ch), curl_getinfo($ch, CURLINFO_HTTP_CODE)); // affiche les erreurs que la requête génère
curl_close($ch); // ferme la requête http