<?PHP
	require('db_connect.php');
	$recordName = $_POST['record'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$guests = $_POST['guests'];
	$date = $_POST['date'];
	$source = $_POST['source'];
	$accesslevel = 11;
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q= $conn->query("SELECT signature FROM user WHERE record='".$recordName."'");
		$imgSrc = $q->fetchColumn();


		$sql = "UPDATE user SET firstname=:firstname, lastname=:lastname, email=:email, phone=:phone, address=:address, guests=:guests, date=:date, source=:source, access_level=:accesslevel WHERE record=:recordName";
		$stmt = $conn->prepare($sql);
	
		// execute the query
		// $stmt->execute();

		$result = $stmt->execute( 
			array( 
				':recordName'   => $recordName,
				':firstname'    => $firstname,
				':lastname'    => $lastname,
				':email'    => $email,
				':phone'    => $phone,
				':address'    => $address,
				':guests'    => $guests,
				':date'    => $date,
				':source'    => $source,
				':accesslevel'    => $accesslevel
			) 
		);
		echo $stmt->rowCount() . " records UPDATED successfully";
	}
	catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}

	$EmailFrom = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
	$EmailTo = "frontdesk@amanzigranite.com";
	//$EmailTo = "leegellie@gmail.com";
	$Subject = "Waiver Signed by " . $firstname . " " . $lastname;
	
	// prepare email body text
	
	$Body .= '<br><div style="width: 100%; max-width: 800px; margin: 0 auto;">';
	$Body .= '<div style="display:flex"><div style="width:20%">Name: </div><div style="width:29%"><b>' . $firstname . ' '  . $lastname . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Phone: </div><div style="width:29%"><b>' . $phone . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Email: </div><div style="width:29%"><b>' . $email . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Source: </div><div style="width:29%"><b>' . $source . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Address: </div><div style="width:79%"><b>' . $address . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Guests: </div><div style="width:79%"><b>' . $guests . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Signature: </div><div style="width:79%"><a href="http://waiver.amanzigranite.com/php/' . $recordName . '.svg" target="_blank">View Signature</a></b></div></div>';

	$Body .= "</div>";
	
	$headers = "From: Amanzi Client Waiver <waiver@amanzigranite.com>\r\n";
	$headers .= "Reply-To: " . $firstname . " " . $lastname . " <" . $EmailFrom . ">\r\n";
	$headers .= "BCC: lee@hallenmedia.net\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";
	$headers .= "Importance: High\r\n";
	
	
	// send email
	$success = mail($EmailTo, $Subject, $Body, $headers);
	 
	$conn = null;
 
?>