<?php
$version = "v1.3";
$formName = $_POST["form-name"];
$fromName = $_POST["customer-name"];
$EmailFrom = filter_input(INPUT_POST, "customer-email", FILTER_VALIDATE_EMAIL);
$rep = $_POST["repEmail"];
$EmailTo = "afarmer@amanzigranite.com";
$Subject = "Client Portal - " . $_POST['form-name'];
$file = $_FILES;
$filename1 = $file['attachmenta1']['name'];
$path1 = $file['attachmenta1']['tmp_name'];
$filename2 = $file['attachmentb1']['name'];
$path2 = $file['attachmentb1']['tmp_name'];
$filename3 = $file['attachmentc1']['name'];
$path3 = $file['attachmentc1']['tmp_name'];
if (!empty($filename1)) {
	$content1 = file_get_contents($path1);
	$content1 = chunk_split(base64_encode($content1));
}
if (!empty($filename2)) {
	$content2 = file_get_contents($path2);
	$content2 = chunk_split(base64_encode($content2));
}
if (!empty($filename3)) {
	$content3 = file_get_contents($path3);
	$content3 = chunk_split(base64_encode($content3));
}

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (RFC)
$eol = "\r\n";
// prepare email body text
$Body = '<h1>' . $_POST['form-name'] . '</h1>';
$Body .= '<br><div style="width: 100%; max-width: 800px; margin: 0 auto;">';
$Body .= "<h2>Job Details</h2>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Quote Number:</b> ".$_POST['quote-num']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Order Number:</b> ".$_POST['order-num']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Install Date:</b> ".$_POST['install-date']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Template Date:</b> ".$_POST['template-date']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Job Name:</b> ".$_POST['job-name']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Account Rep:</b> ".$_POST['account-rep']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Name:</b> ".$_POST['customer-name']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Builder Name:</b> ".$_POST['builder-name']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Phone:</b> ".$_POST['customer-phone']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Email:</b> ".$_POST['customer-email']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>P.O. Cost:</b> ".$_POST['po-cost']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>P.O. Number:</b> ".$_POST['po-num']."</div>";
$Body .= "<div style='display:inline-block;width:97.5%;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Billing Address:</b> ".$_POST['billing-address']."</div>";

$Body .= "<h2>Site Details</h2>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Contact Name:</b> ".$_POST['contact-name']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Contact Phone:</b> ".$_POST['contact-phone']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Contact 2:</b> ".$_POST['contact-name2']."</div>";
$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Contact 2 Phone:</b> ".$_POST['contact-phone2']."</div>";
$Body .= "<div style='display:inline-block;width:97.5%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Site Address:</b> ".$_POST['site-address']."</div>";


if (!empty($_POST['install1-name'])) {
	$Body .= "<h2>Install 1 Details</h2>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Install Name:</b> ".$_POST['install1-name']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Job Type:</b> ".$_POST['job-type1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Tear Out?</b> ".$_POST['tear-out1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Material:</b> ".$_POST['material1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Color:</b> ".$_POST['color1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Lot Number:</b> ".$_POST['lot1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Selected?</b> ".$_POST['selected1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Edge:</b> ".$_POST['edge1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Back Splash:</b> ".$_POST['bs-detail1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Riser:</b> ".$_POST['rs-detail1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Sink:</b> ".$_POST['sk-detail1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Range:</b> ".$_POST['range1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Model:</b> ".$_POST['model1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Spread:</b> ".$_POST['spread1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Cut-Out:</b> ".$_POST['cutout1']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Holes:</b> ".$_POST['holes1']."</div>";
	$Body .= "<div style='display:inline-block;width:97.5%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Notes:</b> ".$_POST['notes1']."</div>";
}


if (!empty($_POST['install2-name'])) {
	$Body .= "<h2>Install 2 Details</h2>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Install Name:</b> ".$_POST['install2-name']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Job Type:</b> ".$_POST['job-type2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Tear Out?</b> ".$_POST['tear-out2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Material:</b> ".$_POST['material2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Color:</b> ".$_POST['color2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Lot Number:</b> ".$_POST['lot2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Selected?</b> ".$_POST['selected2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Edge:</b> ".$_POST['edge2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Back Splash:</b> ".$_POST['bs-detail2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Riser:</b> ".$_POST['rs-detail2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Sink:</b> ".$_POST['sk-detail2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Range:</b> ".$_POST['range2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Model:</b> ".$_POST['model2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Spread:</b> ".$_POST['spread2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Cut-Out:</b> ".$_POST['cutout2']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Holes:</b> ".$_POST['holes2']."</div>";
	$Body .= "<div style='display:inline-block;width:97.5%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Notes:</b> ".$_POST['notes2']."</div>";
}

if (!empty($_POST['install3-name'])) {
	$Body .= "<h2>Install 3 Details</h2>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Install Name:</b> ".$_POST['install3-name']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Job Type:</b> ".$_POST['job-type3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Tear Out?</b> ".$_POST['tear-out3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Material:</b> ".$_POST['material3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Color:</b> ".$_POST['color3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Lot Number:</b> ".$_POST['lot3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Customer Selected?</b> ".$_POST['selected3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Edge:</b> ".$_POST['edge3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Back Splash:</b> ".$_POST['bs-detail3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Riser:</b> ".$_POST['rs-detail3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Sink:</b> ".$_POST['sk-detail3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Range:</b> ".$_POST['range3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Model:</b> ".$_POST['model3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Spread:</b> ".$_POST['spread3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Cut-Out:</b> ".$_POST['cutout3']."</div>";
	$Body .= "<div style='display:inline-block;width:48%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Holes:</b> ".$_POST['holes3']."</div>";
	$Body .= "<div style='display:inline-block;width:97.5%;min-height:30px;padding:5px;border-width:1px;border-style:solid;border-color:black;'><b>Notes:</b> ".$_POST['notes3']."</div>";
}


if (!empty($_POST['service-report'])) {
	$Body .= "<h2>Service Report</h2>";
	$Body .= "<div style='display:inline-block;width:96%;padding:5px;border-width:1px;border-style:solid;border-color:black;'>Service Report Details:</div><div style='display:inline-block;width:96%;padding:5px;border-width:1px;border-style:solid;border-color:black;'>".$_POST['service-report']."</div>";
}

$Body .= "<div style='width:100%;color:#999'>If you have any problems with this form or the data submitted please contact <a href='mailto:lee@hallenmedia.net'>lee@hallenmedia.net</a> - " .$version . "</div>";
$Body .= "</div>";


// main header (multipart mandatory)
$headers = "From: Amanzi Client Portal <portal@amanzigranite.com>" . $eol;
$headers .= "Reply-To: " . $fromName . "<" . $EmailFrom . ">" . $eol;
$headers .= "CC: " . $rep . $eol;
$headers .= "BCC: lee@hallenmedia.net" . $eol;

$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
// message
$mailbody = 'This is a MIME encoded message.'.$eol.$eol;
$mailbody .= '--'.$separator.$eol;
$mailbody .= 'Content-Type: text/html; charset="iso-8859-1"'.$eol;
$mailbody .= 'Content-Transfer-Encoding: 8bit'.$eol.$eol;
$mailbody .= $Body.$eol.$eol;

// attachment
if (!empty($filename1)) {
	$mailbody .= '--'.$separator.$eol;
	$mailbody .= 'Content-Type: application/octet-stream; name="'.$filename1.'"'.$eol;
	$mailbody .= 'Content-Transfer-Encoding: base64'.$eol;
	$mailbody .= 'Content-Disposition: attachment'.$eol.$eol;
	$mailbody .= $content1.$eol.$eol;
}
if (!empty($filename2)) {
	$mailbody .= '--'.$separator.$eol;
	$mailbody .= 'Content-Type: application/octet-stream; name="'.$filename2.'"'.$eol;
	$mailbody .= 'Content-Transfer-Encoding: base64'.$eol;
	$mailbody .= 'Content-Disposition: attachment'.$eol.$eol;
	$mailbody .= $content2.$eol.$eol;
}
if (!empty($filename1)) {
	$mailbody .= '--'.$separator.$eol;
	$mailbody .= 'Content-Type: application/octet-stream; name="'.$filename3.'"'.$eol;
	$mailbody .= 'Content-Transfer-Encoding: base64'.$eol;
	$mailbody .= 'Content-Disposition: attachment'.$eol.$eol;
	$mailbody .= $content3.$eol.$eol;
}

$mailbody .= '--'.$separator.'--';

// $headers = "From: Amanzi Client Portal <portal@amanzigranite.com>\r\n";
// $headers .= "Reply-To: " . $name . "<" . $EmailFrom . ">\r\n";
// $headers .= "BCC: lee@hallenmedia.net\r\n";
// $headers .= "MIME-Version: 1.0\r\n";
// $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
// $headers .= "X-Priority: 1 (Highest)\r\n";
// $headers .= "X-MSMail-Priority: High\r\n";
// $headers .= "Importance: High\r\n";

//$success = mail($EmailTo, $Subject, $Body, $headers);

$success = mail($EmailTo, $Subject, $mailbody, $headers);
 
if ($success){
   echo "success";
}else{
    echo "invalid";
}
 
?>