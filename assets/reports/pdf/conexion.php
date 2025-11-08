<?php

$host = 'localhost';
$user = 'root';
$password = '';
$db = 'iglesia';

$conection=new mysqli("localhost", "root", "", "iglesia");
if ($conection->connect_error) {
	die("Connection failed: " . $conection->connect_error);
}

?>