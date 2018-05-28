<?PHP
if(!session_id()) session_start();

define('db_host','172.30.200.249');
define('db_user','user001');
define('db_password','cL4MpUjCtNdNRoYY');
define('db_name','Portal');

if (!isset($_SESSION['old_id'])) {
	$_SESSION['old_id'] = '';
};

class signed {
	public function get_signed_list() {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT 
				client.datetime, 
				client.fname, 
				client.lname, 
				client.phone, 
				client.email, 
				client.address1, 
				client.source, 
				client.guests, 
				client.id, 
				client.acct_rep,
				rep.id AS rep_id,
				rep.fname AS rep_fname,
				rep.lname AS rep_lname
			FROM users AS client 
			LEFT JOIN users AS rep 
			  ON rep.id = client.acct_rep
			WHERE client.fname <> '' AND client.signature <> '' ORDER BY client.id DESC");
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

	public function get_sales_reps($a) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT id,fname,lname FROM users WHERE sales = :sales");
		$q->bindParam('sales',$a['isSales']);
		$q->execute();
		return $row = $q->fetchAll();
	}
}

$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
$tId = $dbh->query("SELECT id FROM users ORDER BY id DESC");
$_SESSION['last_id'] = $tId->fetchColumn();

//if ($_SESSION['old_id'] != $_SESSION['last_id']) {
	$sList = '';
	$pullResults = new signed;
	
	$sList .= '<div class="row text-dark text-left">';
	$sList .= '<div class="col-1"><b>Date</b></div>';
	$sList .= '<div class="col-1"><b>Name</b></div>';
	$sList .= '<div class="col-1"><b>Phone:</b></div>';
	$sList .= '<div class="col-3"><b>Address:</b></div>';
	$sList .= '<div class="col-3"><b>email:</b></div>';
	$sList .= '<div class="col-1"><b>Source:</b></div>';
	$sList .= '<div class="col-1"><b>Guests:</b></div>';
	$sList .= '<div class="col-1"><b>Rep:</b></div>';
	$sList .= '</div><hr>';
	
	foreach($pullResults->get_signed_list() as $results) {
		$datetime = explode(' ',$results['datetime']);
		$dateUF = $datetime[0];
		$dateAF = explode('-',$dateUF);
		$dateY = (string)$dateAF[0];
		$dateY = substr($dateY,-2);
		$dateM = $dateAF[1];
		$dateD = $dateAF[2];
		$datePF = $dateM . '/' . $dateD . '/' . $dateY;

		$timeUF = $datetime[1];
		$timeAF = explode(':',$timeUF);
		$timeAF[0] = $timeAF[0] - 5;
		if ($timeAF[0] > 12) {
			$timeAF[0] = $timeAF[0] - 12;
			$timePF = $timeAF[0] . ':' . $timeAF[1] . 'pm';
		} else {
			$timePF = $timeAF[0] . ':' . $timeAF[1];
			if ($timeAF[0] == 12) {
				$timePF .= 'pm';
			} else {
				$timePF .= 'am';
			}
		}

		$sList .= '<div class="row text-dark text-left" id="' . $results['id'] . '">';
		$sList .= '<div class="col-1">' . $datePF . ' ' . $timePF . '</div>';
		$sList .= '<div class="col-1">' . $results['fname'] . ' ' . $results['lname']  . '</div>';
		$sList .= '<div class="col-1">' . $results['phone'] . '</div>';
		$sList .= '<div class="col-3">' . $results['address1'] . '</div>';
		$sList .= '<div class="col-3">' . $results['email'] . '</div>';
		$sList .= '<div class="col-1">' . $results['source'] . '</div>';
		$sList .= '<div class="col-1">' . $results['guests'] . '</div>';
		if ($results['acct_rep']<1) {
			$rep = 'Select';
		} else {

			$rep = $results['rep_fname'] . ' ' . $results['rep_lname'];

		}
		$sList .= '<div class="col-1"><div id="btn-' . $results['id'] . '" class="repBtn btn btn-success" rep="' . $rep . '" onClick="selectRep(' . $results['id'] . ');">' . $rep . '</div></div>';
		$sList .= '</div><hr>';
	}
	echo $sList;
	$_SESSION['old_id'] = $_SESSION['last_id'];
//}
?>