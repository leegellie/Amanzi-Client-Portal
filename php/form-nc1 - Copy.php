<?php
$name = $_POST["customername"];
$EmailFrom = filter_input(INPUT_POST, 'customeremail', FILTER_VALIDATE_EMAIL);
$EmailTo = "leegellie@gmail.com";
$Subject = "Client Portal Message";

// prepare email body text

$Body .= '<br><div style="width: 100%; max-width: 800px; margin: 0 auto;">';

foreach($_POST as $key => $value) {
	$Body .= $value;
	$Body .= "\r\n";
}

$Body .= "</div>";

$headers = "From: Amanzi Client Portal <portal@amanzigranite.com>\r\n";
$headers .= "Reply-To: " . $name . "<" . $EmailFrom . ">\r\n";
$headers .= "BCC: lee@hallenmedia.net\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$headers .= "X-Priority: 1 (Highest)\r\n";
$headers .= "X-MSMail-Priority: High\r\n";
$headers .= "Importance: High\r\n";

$success = mail($EmailTo, $Subject, $Body, $headers);
 
if ($success){
   echo "success";
}else{
    echo "invalid";
}
 
?>