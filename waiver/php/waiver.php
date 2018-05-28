<?PHP
	$uid ='';
	require('db_connect.php');

	$username = $_POST['record'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$guests = $_POST['guests'];
	$date = date("Y-m-d h:i:s");
	$source = $_POST['source'];
	$signature = 'Signed';
	$access_level = 11;
	$isActive = 1;
	$cmt_type = 'usr';
	$cmt_comment = 'Waiver Signed.';
	$cmt_priority = 'log';

	try {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$sql = "INSERT INTO users (username, fname, lname, email, phone, address1, address2, city, state, zip, guests, date, source, signature, isActive, access_level) VALUES (:username, :fname, :lname, :email, :phone, :address1, :address2, :city, :state, :zip, :guests, :date, :source, :signature, :isActive, :access_level)";

		$stmt = $dbh->prepare($sql);

		$result = $stmt->execute( 
			array( 
				':username'		=> $username,
				':fname'		=> $fname,
				':lname'		=> $lname,
				':email'		=> $email,
				':phone'		=> $phone,
				':address1'		=> $address1,
				':address2'		=> $address2,
				':city'			=> $city,
				':state'		=> $state,
				':zip'			=> $zip,
				':guests'		=> $guests,
				':date'			=> $date,
				':source'		=> $source,
				':signature'	=> $signature,
				':isActive'		=> $isActive,
				':access_level'	=> $access_level
			) 
		);
	} catch(PDOException $e) {
		echo "ERROR: " . $e->getMessage();
	}


	try {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$sql = "INSERT INTO comments (cmt_ref_id, cmt_type, cmt_comment, cmt_priority) VALUES (:cmt_ref_id, :cmt_type, :cmt_comment, :cmt_priority)";
		$q = $dbh->prepare($sql);
		$q->bindParam(':cmt_ref_id', $username);
		$q->bindParam(':cmt_type', $cmt_type);
		$q->bindParam(':cmt_comment', $cmt_comment);
		$q->bindParam(':cmt_priority', $cmt_priority);
		$q->execute();
	} catch(PDOException $e) {
		echo "ERROR: " . $e->getMessage();
	}


	$EmailTo = "frontdesk@amanzigranite.com";
	//$EmailTo = "leegellie@gmail.com";
	$Subject = "Waiver Signed by " . $fname . " " . $lname;
	
	// prepare email body text
	
	$Body = '<br><div style="width: 100%; max-width: 800px; margin: 0 auto;">';
	$Body .= '<div style="display:flex"><div style="width:20%">Name: </div><div style="width:29%"><b>' . $fname . ' '  . $lname . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Phone: </div><div style="width:29%"><b>' . $phone . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Email: </div><div style="width:29%"><b>' . $email . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Source: </div><div style="width:29%"><b>' . $source . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Address: </div><div style="width:79%"><b>' . $address1 . ', ';
	if  ($address2 != '') {
		$Body .= $address2 . ', ';
	}
	$Body .= $city . ', ' . $state . ', ' . $zip . '</b></div></div>';
	$Body .= '<div style="display:flex"><div style="width:20%">Guests: </div><div style="width:79%"><b>' . $guests . '</b></div></div>';

	$Body .= "</div><br><br><p>For visitors to <a href='http://amanzigranite.com'>Amanzi Marble, Granite and Tile</a>. Version 2.0.0</p>";
	
	$headers = "From: Amanzi Client Waiver <waiver@amanziportal.com>\r\n";
	$headers .= "BCC: lee@hallenmedia.net\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";
	$headers .= "Importance: High\r\n";
	
	
	// send email
	$success = mail($EmailTo, $Subject, $Body, $headers);
	 
	$conn = null;

 	//return $lastId;

?>