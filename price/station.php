<?PHP
	echo "<table class='text-dark w-100'><tbody>";
	echo "<tr><th>Date</th><th>First Name</th><th>Last Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Source</th><th>Guests</th><th>Record</th></tr>";

	class TableRows extends RecursiveIteratorIterator { 
		function __construct($it) { 
			parent::__construct($it, self::LEAVES_ONLY); 
		}
	
		function current() {
			return "<td style='border:1px solid black;'>" . parent::current(). "</td>";
		}
	
		function beginChildren() { 
			echo "<tr class='recordSet'>"; 
		} 
	
		function endChildren() { 
			echo "</tr>" . "\n";
		} 
	} 

$servername = 'db708532307.db.1and1.com';
$username = 'dbo708532307';
$password = 'Vannier1!';
$database = 'db708532307';


	try {
		$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$stmt = $conn->prepare("SELECT id, name, price_1, price_2, price_3, price_4, price_5, price_6, price_7, comm_1, comm_2, comm_3, comm_4, comm_5, comm_6, comm_7, notes, image FROM marbgran WHERE 1"); 
		$stmt->execute();

		// set the resulting array to associative
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
		foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
			echo $v;
		}
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$conn = null;

	echo "</tbody></table>";


	
//	$result = mysqli_query($con, "SELECT * FROM user ORDER BY ID DESC LIMIT 1;");
//	while ($row = mysqli_fetch_array($result))
//		{
//		echo "<tr><td><b>" . $row['date'] . "</b></td>";
//		echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
//		echo "<td>" . $row['phone'] . "</td>";
//		echo "<td>" . $row['email'] . "</td>";
//		echo "<td>" . $row['address'] . "</td>";
//		echo "<td>" . $row['source'] . "</td>";
//		echo "<td>" . $row['guests'] . "</td>";
//		echo "<td><img height='70px' src='" . $row['signature'] . "'></td></tr>";
//		}
//	
//	echo "</tbody></table>";
//	mysqli_close($con);


?>