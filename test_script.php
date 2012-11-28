<?php

define('USER', 'nhs2_hcc');
define('PWORD', 'hcc321');
define('DB', 'nhs2_hcc');
define('HOST', 'localhost');

$mysqli = new mysqli(HOST, USER, PWORD, DB);
if($mysqli->connect_errno){
	echo "Error! Could not connect to database!";
}
else{
	echo "Connected successfully!";
}
?>