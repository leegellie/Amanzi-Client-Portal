<?PHP
	require('db_connect.php');
	$recordName = $_POST['record'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address1 = $_POST['address1'];
	$guests = $_POST['guests'];
	$date = $_POST['date'];
	$source = $_POST['source'];
	$isActive = $_POST['isActive'];

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q= $conn->query("SELECT signature FROM users WHERE record='".$recordName."'");
		$imgSrc = $q->fetchColumn();


		$sql = "UPDATE users SET fname=:fname, lname=:lname, email=:email, phone=:phone, address1=:address1, guests=:guests, date=:date, source=:source, isActive=:isActive WHERE record=:recordName";
		$stmt = $conn->prepare($sql);
	
		// execute the query
		// $stmt->execute();

		$result = $stmt->execute( 
			array( 
				':recordName'	=> $recordName,
				':fname'		=> $fname,
				':lname'		=> $lname,
				':email'		=> $email,
				':phone'		=> $phone,
				':address1'		=> $address1,
				':guests'		=> $guests,
				':date'			=> $date,
				':source'		=> $source,
				':isActive'		=> $isActive
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
	$Subject = "Waiver Signed by " . $fname . " " . $lname;
	
	// prepare email body text
	
	$Body .= '<br><div style="width: 100%; max-width: 800px; margin: 0 auto;">';
	$Body .= '<div style="display:flex"><div style="width:20%">Name: </div><div style="width:29%"><b>' . $fname . ' '  . $lname . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Phone: </div><div style="width:29%"><b>' . $phone . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Email: </div><div style="width:29%"><b>' . $email . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Source: </div><div style="width:29%"><b>' . $source . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Address: </div><div style="width:79%"><b>' . $address1 . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Guests: </div><div style="width:79%"><b>' . $guests . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Signature: </div><div style="width:79%"><a href="https://amanziportal.com/waiver/signature/signed/' . $recordName . '.svg" target="_blank">View Signature</a></b></div></div>';

	$Body .= "</div><br><br><p>For visitors to <a href='http://amanzigranite.com'>Amanzi Marble, Granite and Tile</a>. Version 1.4</p>";
	
	$headers = "From: Amanzi Client Waiver <waiver@amanzigranite.com>\r\n";
	$headers .= "Reply-To: " . $fname . " " . $lname . " <" . $EmailFrom . ">\r\n";
	//$headers .= "BCC: lee@hallenmedia.net\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";
	$headers .= "Importance: High\r\n";
	
	
	// send email
	$success = mail($EmailTo, $Subject, $Body, $headers);
	 
	$conn = null;
 
?>