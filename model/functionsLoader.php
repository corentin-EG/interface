<?php 

require 'sql_connection.php';


function classLoader($class)
{
	require $class.'.class.php';
}

spl_autoload_register('classLoader');
