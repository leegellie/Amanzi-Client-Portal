<?PHP
$servername = '172.30.200.249';
$username = 'user001';
$password = 'cL4MpUjCtNdNRoYY';
$database = 'Portal';


$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare("SELECT id, fname, lname, company FROM users WHERE 1 ORDER BY company ASC"); 
	$stmt->execute();
	while ($r = $stmt->fetch(PDO::FETCH_ASSOC)){
		echo '<option value="';
		echo $r['company'];
		echo ' - ';
		echo $r['fname'];
		echo ' ';
		echo $r['lname'];
		echo ' - Company ID:';
		echo $r['id'];
		echo '">';
	}
?>