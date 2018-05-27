<?PHP
	require('db_connect.php');
	$recordName = $_POST['SigName'];
	$data = $_POST['SigData'];
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		// set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully"; 
		$sql = "INSERT INTO users (username, signature, record) VALUES ('".$recordName."','".$data."','".$recordName."')";
		$conn->exec($sql);
		echo "New record created successfully";
	}
	catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}

	$conn = null;

	$filedir = '../signature/signed/';
	//$my_file = $filedir . $fileName . '1-sig.txt';

    $img = $data;
    $img = str_replace('data:image/svg+xml;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $newData = base64_decode($img);


	$my_file = $filedir . $recordName . '.svg';


	$fn = fopen($my_file, 'a+');
	if (false === $fn) {
		throw new RuntimeException('Unable to open log file for writing');
	}
	chmod($my_file, 0777);
	sleep(2);
	$fw = fwrite($fn, $newData);
	if (false === $fw) {
		throw new RuntimeException('Unable to write to file');
	}
	fclose($my_file);


?>