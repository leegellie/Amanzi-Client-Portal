<?php
$host = 'localhost';
$user = 'sa';
$password = 'zaq1@WSX';
$database = 'Amanzi_Dashboards';

$conn = new PDO("sqlite:Server=70.63.215.99;Database=AMANZI_Dashboards", 'sa', 'zaq1@WSX');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

if (!$conn){
    die("Database Connection Failed" . $conn);
}
