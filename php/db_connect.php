<?php
$host = 'localhost';
$user = 'user553';
$password = 'Tjl3Pf72Ct6HUqvX';
$database = 'Portal';

$connection = mysqli_connect($host, $user, $password, $database);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if (!$connection){
    die("Database Connection Failed");
}
?>