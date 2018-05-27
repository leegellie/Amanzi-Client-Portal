<?PHP

	require('db_connect.php');

	//////////////////////////   LOG UPDATE   ////////////////////////////
	$uid = $_POST['uid'];
	try {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$sql = "INSERT INTO comments (cmt_ref_id, cmt_type, cmt_comment, cmt_priority) VALUES (:cmt_ref_id, :cmt_type, :cmt_comment, :cmt_priority)";
		$q = $dbh->prepare($sql);
		$q->bindParam('cmt_ref_id', $uid);
		$q->bindParam('cmt_type', 'usr');
		$q->bindParam('cmt_comment', 'Waiver Signed.');
		$q->bindParam('cmt_priority', 'log');
		$q->execute();
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e->getMessage();
	}
 
?>