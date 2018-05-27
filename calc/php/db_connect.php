<?php
$servername = 'localhost';
$username = 'user001';
$password = 'cL4MpUjCtNdNRoYY!';
$database = 'Portal';

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo "ERROR: " . $e->getMessage();
	}
?>