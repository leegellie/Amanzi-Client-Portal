<?
if ($_POST['lname'] != '')
{
	die;
}

$name = filter_input(INPUT_POST,name,FILTER_SANITIZE_STRING);
$company = filter_input(INPUT_POST,company,FILTER_SANITIZE_STRING);
$phone = filter_input(INPUT_POST,phone,FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST,email,FILTER_SANITIZE_EMAIL);

$from = "From: john.rushton@forward4.com";
$body = "
***********************************
QUOTE REQUEST SENT VIA WEBSITE
DO NOT DIRECTLY REPLY TO THIS EMAIL
***********************************

Name: $name
Company: $company;
Email: $email
Phone: $phone";
if ( mail("john.rushton@forward4.com","Website Quote Request",$body,$from) )
{
	echo "1";
} else
{
	echo "Error Sending email";
}
?>