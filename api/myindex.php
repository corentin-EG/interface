<?php

require '../model/sql_connection.php';
require '../model/functionsLoader.php';

$output['content'] = 'null';
$output['error'] = 'null';

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new CustomAPI($_REQUEST['req'], $_SERVER['HTTP_ORIGIN'], $db);
    $output['content'] = $API->processAPI();
    exit(json_encode($output));
} catch (Exception $e) {
	$output['error'] = $e->getMessage();
    exit(json_encode($output));
}

// var_dump($_POST);

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

exit();

if ($method = $_SERVER['REQUEST_METHOD']) {
	if (is_array($request = explode('/', $_REQUEST['req']))) {
		if ($index = array_search('', $request))
			unset($request[$index]);
		// if ($request[0] == 'auth' && $request[1] == 'login') {
		// 	if ($method == 'POST') {
		// 		if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
		// 			$email = htmlentities($_POST['email']);
		// 			$password = htmlentities($_POST['password']);
		// 			$auth = new Auth($db);
		// 			$userId = $auth->verify($email, $password);
		// 			if ($userId) {
		// 				$auth->generateToken();
		// 				$cryptedToken = $auth->cryptToken();
		// 				if ($cryptedToken != false) {
		// 					$auth->checkActiveToken() ? $auth->refreshToken() : $auth->insertToken();
		// 					$output['content']['accessToken'] = $cryptedToken;
		// 					$output['content']['id'] = $auth->user()->id();
		// 					die(json_encode($output));
		// 				} else {
		// 					$output['error'] = "#0";
		// 					die(json_encode($output));
		// 				}
		// 			}
		// 			$output['error'] = "#5";
		// 			die(json_encode($output));
		// 		}
		// 	} else {
		// 		$output['error'] = "#2";
		// 		die(json_encode($output));
		// 	}
		// } else if ($request[0] == 'auth' && $request[1] == 'refreshToken' && isset($_GET['token'])) {
		// 	$auth = new Auth($db);
		// 	$checked = $auth->checkToken($_GET['token']);
		// 	if ($checked == false) {
		// 		$output['error'] = "#6";
		// 		die(json_encode($output));
		// 	}
		// 	$cryptedToken = $auth->refreshToken();
		// 	$output['content']['accessToken'] = $cryptedToken;
		// 	$output['content']['id'] = $auth->user()->id();
		// 	die(json_encode($output));
		// } else if (isset($_GET['token']) && !empty($_GET['token'])) {
		// 	$cryptedToken = $_GET['token'];
		// 	$auth = new Auth($db);
		// 	$checked = $auth->checkToken($cryptedToken);
		// 	if ($checked == false) {
		// 		$output['error'] = "#6";
		// 		die(json_encode($output));
		// 	} else if ($checked == 'expired') {
		// 		$output['error'] = "#7";
		// 		die(json_encode($output));
		// 	}
		// } else {
		// 	$output['error'] = "#6";
		// 	die(json_encode($output));
		// }

		$request = preg_replace('/[^a-z0-9_-]+/i', '', $request);

		switch ($countParam = count($request)) {
			case 1:
				$table = $request[0];
				break;

			case 2:
				$table = $request[0];
				$id = $request[1];
				break;

			case 3:
				$originTable = $request[0];
				$table = $request[2];
				$id = $request[1];
				break;

			case 4:
				$originTable = $request[0];
				$table = $request[2];
				$id = $request[3];
				$originId = $request[1];
				break;

			default:
				$output['error'] = "#2";
				die(json_encode($output));
				break;
		}
	} else {
		$output['error'] = "#2";
		die(json_encode($output));
	}
} else {
	$output['error'] = "#0";
	die(json_encode($output));
}

// var_dump($method, $request, $table);

switch ($table)
{
	case 'users':
		$attrStr = 'id, user_name AS userName, first_name AS firstName, last_name AS lastName, email, password, company';
		break;

	case 'objects':
		$attrStr = 'id, name, note, author, location, id_status AS idStatus, id_game AS idGame';
		break;

	case 'plugins':
		$attrStr = 'id, name, note, author, major_version AS majorVersion, minor_version AS minorVersion, unity_version_minimum AS unityVersionMinimum';
		break;

	case 'projects':
		$attrStr = 'id, name, client, id_status AS idStatus, deadline';
		break;

	case 'assets':
		$attrStr = 'id, url';
		break;

	default:
		$output['error'] = "#2";
		die(json_encode($output));
		break;
}

// var_dump($method, $request);

switch ($method) {
  	case 'GET':
	 	$sql = "SELECT $attrStr FROM $table";
	 	if ($countParam == 1) {
	 		$sth = $db->prepare($sql);
	 	} elseif ($countParam == 2) {
	 		$sql .= " WHERE id = :id";
	 		$sth = $db->prepare($sql);
	 		$sth->bindValue(':id', $id, PDO::PARAM_INT);
	 	} else if ($countParam == 3) {
	 		switch ($originTable) {
	 			case 'projects':
	 				$sql .= " WHERE id_game = :id";
	 				break;

	 			case 'items':
	 				$sql .= " WHERE id_item = :id";
	 				break;

	 			default:
	 				$output['error'] = "#2";
	 				die(json_encode($output));
	 				break;
		 	}
	 		$sth = $db->prepare($sql);
	 		$sth->bindValue(':id', $id, PDO::PARAM_INT);
	 	} else {
	 		$output['error'] = "#2";
	 		die(json_encode($output));
	 	}
		break;

	 // case 'PUT':
	 //    $req = "UPDATE $table SET $attrStr WHERE id = :id";
		// break;

	 case 'POST':
	 	if ($countParam != 1 && $countParam != 3) {
	 		$output['error'] = "#2";
	 		die(json_encode($output));
	 	}
	 	$postFields = [];
	 	$_POST = json_decode($_POST['jsonProject'], true);
		foreach ($_POST as $key => $value) {
			$key = strtolower(preg_replace('/(?<!\ )[A-Z]/', '_$0', $key));
	 		$postFields[htmlspecialchars($key)] = htmlspecialchars($value);
	 	}
	 	if ($table == 'users' && isset($postFields['password'])) {
	 		$postFields['password'] = password_hash($postFields['password'], PASSWORD_DEFAULT);
	 	}

	 	if ($countParam == 3) {
	 		switch ($originTable) {
	 			case 'projects':
	 				
	 				break;

	 			case 'objects':
	 				
	 				break;

	 			default:
	 				$output['error'] = "#2";
	 				die(json_encode($output));
	 				break;
	 		}
	 	}

	 	$attrList = array_keys($postFields);
	 	$attrStr = implode(', ', $attrList);
		$bindedAttrList = array_map(
			function($val) { 
				return ':'.$val;
			},
			$attrList
		);
		$bindedAttrStr = implode(', ', $bindedAttrList);
	   	$sql = "INSERT INTO $table($attrStr) VALUE($bindedAttrStr)";
	    $sth = $db->prepare($sql);
	    foreach ($attrList as $attr) {
	    	foreach ($postFields as $name => $value) {
	    		if ($attr == $name) {
	    			$sth->bindValue(':'.$attr, $value);
	    		}
	    	}
	    }
	    break;

	case 'DELETE':
		$sql = "DELETE FROM $table WHERE id = :id";
		if ($countParam == 2) {
			
		} elseif ($countParam == 4) {
			switch ($originTable) {
				case 'projects':
					$sql .= " AND id_game = :originId";
					break;

				case 'items':
					$sql .= " AND id_item = :originId";
					break;
				
				default:
					$output['error'] = "#2";
	 				die(json_encode($output));
					break;
			}			
		} else {
			$output['error'] = "#2";
	 		die(json_encode($output));
		}
    	$sth = $db->prepare($sql);
    	$sth->bindValue(':id', $id, PDO::PARAM_INT);
    	if (isset($originId)) {
    		$sth->bindValue(":originId", $originId, PDO::PARAM_INT);
    	}
    	break;

	default:
		$output['error'] = "#5";
		die(json_encode($output));
		break;
}

// exit(var_dump($table, $attrStr, $postFields));

if (!empty($sth)) {
	try {
		$handleResponse = $sth->execute();
	} catch (Exception $e) {
		echo $e->getMessage();
		$output['error'] = "#2";
		die(json_encode($output));
	}
	switch ($method) {
		case 'GET':
			$content = $sth->fetchAll(PDO::FETCH_ASSOC);
			if (!empty($content)) {
				$output['content'] = $content;
			} else {
				$output['error'] = "#3";
			}
			break;

		case 'POST':
			$output['content'] = $db->lastInsertId();
			break;

		case 'PUT':
			break;

		case 'DELETE':
			$output['content'] = true;
			break;

		default:
			break;
	}
}

// var_dump($output['content']);
	
echo json_encode($output);