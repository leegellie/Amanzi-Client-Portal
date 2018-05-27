<?PHP
if(!session_id()) session_start();

define('db_host','172.30.200.249');
define('db_user','user001');
define('db_password','cL4MpUjCtNdNRoYY');
define('db_name','Portal');

class rep_action {
	public function assign_rep() {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE users SET acct_rep = :acct_rep WHERE id = :id";
			$q = $dbh->prepare($sql);
			$q->bindParam("acct_rep",$_POST['acct_rep']);
			$q->bindParam("id",$_POST['id']);
			$q->execute();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
}

$update_rep = new rep_action;
$update_rep -> assign_rep($_POST);
echo '1';



?>