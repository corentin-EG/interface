<?php session_start(); 

if (!isset($_SESSION['connected']) || !is_numeric($_SESSION['connected'])) {
	if (basename($_SERVER["SCRIPT_FILENAME"], '.php') != 'login') { 
		header('Location: http://localhost/interface/login.php');
		exit;
	}
}

?>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="styles/main.css" type="text/css">
	<link rel="stylesheet" href="styles/popup.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>

