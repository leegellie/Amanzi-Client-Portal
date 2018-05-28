<?php
	$uploads_dir = ""; /* local path */
	if(isset($_FILES['file']) && ($_FILES['file']['error'] == 0) ) {
		$tmp_name = $_FILES["file"]["tmp_name"];
		$name = $_FILES["file"]["name"];
		move_uploaded_file($tmp_name, "{$uploads_dir}{$name}");
	}

	$name = $_POST["customername"];
	$email = $_POST["customeremail"];
	$message = $_POST["htmla"];
	//$sendto = $_POST["sendto"];
	
	$sendto = 'leegellie@gmail.com';

	$headers = "From: " . $email . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body><strong>From: </strong>' . $name . '<br /><strong>Email: </strong>' . $email . '<br /><br /><strong>Message: </strong><br />' . $message . '</body></html>';

	mail($sendto, $subject, $message, $headers);
?>
