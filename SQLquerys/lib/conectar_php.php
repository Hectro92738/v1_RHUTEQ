<?php 

$mysqli = new mysqli("localhost", "admin", "RHUTEQ23", "RHUTEQ");
if ($mysqli->connect_errno) {
    die("error de conexión: " . $mysqli->connect_error);
}

//$mysqli = new mysqli("172.31.192.78", "root", "", "RHUTEQ"); ?>