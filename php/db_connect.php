<?php
$host = 'localhost';
$user = 'user001';
$password = 'cL4MpUjCtNdNRoYY!';
$database = 'Portal';

$connection = mysqli_connect($host, $user, $password, $database);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if (!$connection){
    die("Database Connection Failed");
}
?>