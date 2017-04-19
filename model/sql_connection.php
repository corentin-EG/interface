<?php 

$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // display errors
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
);

try
{
    $db = new PDO('mysql:host=localhost;dbname=gamesbrand_portal', 'root', '', $opt);
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

?>