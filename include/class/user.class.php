<?PHP
if(!session_id()) session_start();
require_once(__DIR__ . '/../config.php');


class comment_action {

	public function get_user_name() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT fname, lname FROM users WHERE id = :id");
		$q->bindParam('id',$_POST['id']);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_NUM);
		return $row[0] . ' ' . $row[1];	
	}


	// ADD COMMENT
	public function add_comment($a) {

		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("INSERT INTO comments (
				cmt_ref_id, 
				cmt_type, 
				cmt_user, 
				cmt_priority, 
				cmt_comment
			) VALUES (
				:cmt_ref_id, 
				:cmt_type, 
				:cmt_user, 
				:cmt_priority, 
				:cmt_comment
			)");

			$q->execute($a);
			$this->_message = $dbh->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	// GET LIST OF COMMENTS
	public function get_comments($id,$type) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT comments.id, comments.timestamp, comments.cmt_priority, comments.cmt_user, comments.cmt_comment, users.id AS uid, users.fname, users.lname FROM comments JOIN users ON users.id = comments.cmt_user WHERE cmt_ref_id = :cmt_ref_id AND cmt_type = :cmt_type ORDER BY id DESC");
			$q->bindParam(':cmt_ref_id',$id);
			$q->bindParam(':cmt_type',$type);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

}



class userData {

//RETURNS SINGLE USER INFO DATA IN DB BASED
	private $results;
	private $raw_results;
	private $error;
	
	// RETURNS RESULTS OF PRIVATE FUNCTION set_results. $a IS COLUMN NAME
	public function get_results($a) {
		return $this->results[$a];
	}


	// SETS $raw_results TO BE ARRAY OF USER DATA.
	public function set_selection($s,$id) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT " . $s . " FROM users WHERE id = :id");
			$q->bindParam('id', $id, PDO::PARAM_INT);
			$q->execute();
			$this->results = $q->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function set_billing_selection($s,$id) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT " . $s . " FROM user_billing_info WHERE uid = :id");
			$q->bindParam('id', $id, PDO::PARAM_INT);
			$q->execute();
			$this->results = $q->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function update_user_data($s,$id) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE users SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('id',$s)) {
				$s['id'] = $id;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function update_pw_data($s,$id) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE users SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('id',$s)) {
				$s['id'] = $id;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
}

class login {
	/*
	Step 1: set _token & compare the submitted token with the session token
	Step 2: set the uname, pass, and token. 
	Step 3: query username if login_attempts are > 4. 
	
	If login_attempts > 5
	Step 4: Exit with error
	
	If login_attempts < 5
	Step 4: query username/password match
	
	If user/pass match
	Step 5: update db to update failed_logins = 0, login time = time(), session_token = _token, user_ip = ip
	Step 6: add uid to session
	Step 7: read user level and update header with URL appropriate to access level 
	
	If user/pass mismatch
	Step 5: add 1 to failed_logins, exit with error	
	*/
	private $_id;
	public $_username;
	private $_password;
	private $_token;
	private $_matches;
	private $_attempts;
	private $_errors;
	
	function __construct() {
		//$this->_token = $_POST['token'];
		//$this->_username = (isset($_POST['uname']))? strtolower($_POST['uname']) : strtolower($_SESSION['username']);
		if (isset($_POST['token'])) {
			$this->_token = $_POST['token'];
		}
		if (isset($_POST['uname'])) {
			$_username = $_POST['uname'];
			$this->_username = (isset($_POST['uname']))? strtolower($_POST['uname']) : strtolower($_SESSION['username']);
		}
	}
	
	//Checks that the passed $data is equal to the _token
	private function verify_login_token($data) {
		if($data == $this->_token) {
			return 1;
		} else {
			$this->_errors = "Token verification failed. Please contact support to log into your account.";
			return false;
		}
	}
	
	//query failed logins via username. If failed login time > 1 hour, remove failed logins from db, else echo failed login count
	public function get_failed_logins() {
		$count;
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $dbh->prepare("SELECT attempts,last_attempt FROM user_login_attempts WHERE username = :user");
			$q->execute(array('user' => $this->_username)); 
			$count = $q->fetch();
			$this->_attempts = $count[0];

			$future = new DateTime();
			$future->setTimestamp($count['last_attempt']+3600);
			$future->format('U = Y-m-d H:i:s');

			$now = new DateTime();
			$now->format('U = Y-m-d H:i:s');

			//DELECT LOGIN_ATTEMPTS BECAUSE ITS BEEN OVER AN HOUR
			if (($future < $now) && ($count[0] > 4)) {
				$this->delete_failed_logins();
				$this->get_failed_logins();
			} else {
				return $count[0];
			}

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	//DELETE FAILED LOGIN_ATTEMPTS
	private function delete_failed_logins() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
				
		$q= $dbh->prepare("DELETE FROM user_login_attempts WHERE username = :user");
		$q->execute(array(':user' => "$this->_username"));
	}

	//either adds username and data or updates the login attemts
	private function update_login_attempts() {
		$currentTime = time();
		$this->_attempts++;
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			//If no prior attempts found, INSERT user login attempt data
			if ($this->_attempts == '1') {
				$q = $dbh->prepare("INSERT INTO user_login_attempts (id, username, attempts, last_attempt) VALUES ('', :username, :attempts, :last_attempt)");
			} else {
				$q = $dbh->prepare("UPDATE user_login_attempts SET attempts = :attempts, last_attempt = :last_attempt WHERE username = :username");
			}
			$q->bindParam(':username',$this->_username);
			$q->bindParam(':attempts',$this->_attempts);
			$q->bindParam(':last_attempt',$currentTime);
			$q->execute();
		} catch(PDOException $e) {
			echo "ERROR on update_login_attempts: " . $e->getMessage();
		}
	}

	//Checks if an active username exists and then if password verification is true for the attributed hased password
	public function verify_login_match() {	
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		
		$q = $dbh->prepare("SELECT count(id) FROM users WHERE username = :user AND isActive = 1");
		$q->execute(array(":user" => "$this->_username"));
		$row = $q->fetch(PDO::FETCH_NUM);
		
		if (($row[0]==0)||($row[0]=='')) {
			$this->_errors = "Invalid username or password.";
			return false;
		} elseif ($row[0]==1) {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		
			$q = $dbh->prepare("SELECT id, password FROM users WHERE username = :user");
			$q->execute(array(":user" => "$this->_username"));
			$row = $q->fetch(PDO::FETCH_NUM);
			
			if (password_verify($this->_password,$row[1])) {
				$this->_id = $_SESSION['id'] = $row[0];
				$_SESSION['username'] = $this->_username;
				session_regenerate_id(true);
				return 1;
			} else {
				$this->_errors = "Invalid username or password.";
				return false;
			}
		} else {
			$this->_errors = "Username authentication error. Multiple users found. Please contact support for help logging into your account.";
			return false;
		}

	}

	/* Gets the access level from the db based on id and write the appropriate header

	INTERNAL ROLES:
	1: Admin
	2: Employee
	
	EXTERNAL ROLES:
	3: Reseller
	4: Master Client
	5: Manager
	6: Sales Agent
	*/
	public function set_access_headers() {
		$accessLevel = new userData;
		$accessLevel->set_selection('access_level',$_SESSION['id']);
		if ( ($accessLevel->get_results('access_level') < 4) && ($accessLevel->get_results('access_level') != "")) {
			header('Location: /admin/projects.php?timeline');
		} elseif ($accessLevel->get_results('access_level') == 4) {
			header('Location: /admin/projects.php?templates');
		} elseif ($accessLevel->get_results('access_level') == 5) {
			header('Location: /admin/projects.php?programming');
		} elseif ($accessLevel->get_results('access_level') == 6) {
			header('Location: /admin/materials.php');
		} elseif ($accessLevel->get_results('access_level') == 7) {
			header('Location: /admin/projects.php?saw');
		} elseif ($accessLevel->get_results('access_level') == 8) {
			header('Location: /admin/projects.php?cnc');
		} elseif ($accessLevel->get_results('access_level') == 9) {
			header('Location: /admin/projects.php?polishing');
		} elseif ($accessLevel->get_results('access_level') == 10) {
			header('Location: /admin/projects.php?installs');
		} else {
			header('Location: /admin/projects.php?timeline');
		}
	}


//	public function set_access_headers() {
//		$accessLevel = new userData;
//		$accessLevel->set_selection('access_level',$_SESSION['id']);
//		if (($accessLevel->get_results('access_level') < 3) && ($accessLevel->get_results('access_level') != "")) {
//			header('Location: /admin/dashboard.php');
//		} elseif (($accessLevel->get_results('access_level') > 3) && ($accessLevel->get_results('access_level') < 11)) {
//			header('Location: /admin/dashboard.php');
//		} else {
//			header('Location: /user/dashboard.php');
//		}
//	}



	//CHECKS THAT THE TOKENS MATCH AND THEN SETS THE USENAME & PASSWORD VARIABLES
	public function set_user_login() {
		if($this->verify_login_token($_SESSION['token'])) {
			$this->_username = strtolower($_POST['uname']);
			$this->_password = $_POST['upass'];
		} else {
			echo $this->_errors;
			die;
		}
	}
	
	//MAIN LOGIN FORM AUTHENTICATION
	public function get_user_login() {
		// query db if username failed logins > 4	
		if ($this->get_failed_logins($this->_username) > 4) {
			$this->_errors = "Maximum login attempts exceeded. Your acount has been locked for 1 hour.";
			return false;
		} else {
			//Verify that the posted username / password match
			if($this->verify_login_match()) {
				$this->delete_failed_logins();
				$update_user_login = new userData;
				$user_ip = $_SERVER['REMOTE_ADDR'];
				$array = array(
					"session_token" => "$this->_token",
					"user_ip" => "$user_ip",
				);
				$update_user_login->update_user_data($array,$_SESSION['id']);
				$this->set_access_headers();
				return 1;
			} else {
				$this->update_login_attempts();
				return false;
			}
		}
	}
	
	public function user_session_exist() {
		if ((isset($_SESSION['id'])) && (isset($_SESSION['username']))) {
			return 1;
		} else {
			return false;
		}
	}
	
	//CHECK IF ALREADY LOGGED IN
	public function is_logged_in() {
		if ($this->user_session_exist()) {
			$get_db_token = new userData;
			$get_db_token->set_selection('username,session_token,user_ip,isActive',$_SESSION['id']);
			if (($get_db_token->get_results('session_token') == $_SESSION['token']) && ($get_db_token->get_results('username') == $_SESSION['username']) && ($get_db_token->get_results('user_ip') == $_SERVER['REMOTE_ADDR']) && ($get_db_token->get_results('isActive') == '1')) {
				return 1;
			} else {
				//echo "Sessions found but doesn't match";
				//return false;
				return 1;
			}
		} else {
			//echo "Sessions aren't found";
			return false;
		}
	}
	
	public function dashboard_access($operator,$level) {
		if (!$this->is_logged_in()) {
			header('Location: /logout.php');
		} else {
			$access_check = new userData;
			$access_check->set_selection("*",$_SESSION['id']);
			switch ($operator) {
				case "<":
					$results = ($access_check->get_results("access_level") < $level)? 1 : false;
					break;
				case ">":
					$results = ($access_check->get_results("access_level") > $level)? 1 : false;
					break;
				case "==":
					$results = ($access_check->get_results("access_level") == $level)? 1 : false;
					break;
			}
			if ($results) {
				return 1;
			} else {
				$this->set_access_headers();
			}
		}
	}
	
	//RETURNS TRIGGERED ERROR MESSAGES
	public function get_error_message() {
		return $this->_errors;
	}
}




class user_action {
	private $_message;
	
	private $_username_count;
	private $_email_count;
	private $_uid;


	public function get_holidays() {

		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$sql = "SELECT start_date, end_date FROM holidays WHERE 1";
		$q = $dbh->prepare($sql);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_rtos($a) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	
			$sql = "SELECT time_off.*, staff.fname AS sFname, staff.lname AS sLname, staff.division, staff.department, manager.fname AS mFname, manager.lname AS mLname FROM time_off LEFT JOIN users staff ON time_off.staff = staff.id LEFT JOIN users manager ON time_off.approval = 1 AND time_off.approval_id = manager.id WHERE";

			if ( $a['type'] == 'personal' ) {
				$sql .= " time_off.staff = " . $a['pull'];
			} elseif ( $a['type'] == 'manager' ) {
				if ( $a['department'] == 0 ) {
					$sql .= " staff.division LIKE '" . $a['pull'] . "'";
				} else {
					$sql .= ' staff.department = ' . $a['department'];
				}
			} else {
				$sql .= " 1";
			}
			$sql .= " ORDER BY time_off.start_date ASC, time_off.staff ASC";
	
			$q = $dbh->prepare($sql);
			$q->execute();

			return $row = $q->fetchAll();

		} catch(PDOException $e) {
			return $this->_error = "ERROR: " . $e->getMessage();
		}
	}


	public function staff_summary($a) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$sql = "SELECT id, fname, lname, hire_date, fulltime, pto_override FROM users WHERE company LIKE '%Amanzi%'";
	
			if ( $a['user'] == 'manager' ){
				if ( $a['department'] == 0 ) {
					$sql .= " AND division LIKE '" . $a['division'] . "'";
				} else {
					$sql .= " AND department LIKE '" . $a['department'] . "'";
				}
			} else {
				$sql .= "";
			}
			$sql .= " ORDER BY lname ASC, fname ASC";
	
			$q = $dbh->prepare($sql);
			$q->execute();

			return $row = $q->fetchAll();

		} catch(PDOException $e) {
			return $this->_error = "ERROR: " . $e->getMessage();
		}
	}

	public function used_vacation($id,$year) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $dbh->prepare("SELECT sum(hours_paid) AS used_vacation FROM time_off WHERE staff = :id AND time_off.start_date <= DATE(NOW()) AND YEAR(start_date) = :year AND type LIKE '%Vacation%'");
		$q->bindParam('id', $id);
		$q->bindParam('year', $year);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function sick_days($id,$year) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $dbh->prepare("SELECT sum(hours_paid) AS sick_days FROM time_off WHERE staff = :id AND time_off.start_date <= DATE(NOW()) AND YEAR(start_date) = :year AND type LIKE '%Sick%'");
		$q->bindParam('id', $id);
		$q->bindParam('year', $year);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function scheduled_vaca($id,$year) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $dbh->prepare("SELECT sum(hours_paid) AS scheduled_vaca FROM time_off WHERE staff = :id AND time_off.start_date > DATE(NOW()) AND YEAR(start_date) = :year");
		$q->bindParam('id', $id);
		$q->bindParam('year', $year);
		$q->execute();
		return $row = $q->fetchAll();
	}







	public function submit_rto($a) {

		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		if ( $a['approval'] == 1 ) {
			$sql = "INSERT INTO time_off (staff, start_date, end_date, hours_paid, hours_unpaid, approval, approval_id, notes, respond_email, approval_date, type) VALUES (:staff, :start_date, :end_date, :hours_paid, :hours_unpaid, :approval, :approval_id, :notes, :respond_email, :approval_date, :type)";
		} else {
			$sql = "INSERT INTO time_off (staff, start_date, end_date, hours_paid, hours_unpaid, approval, notes, respond_email, type) VALUES (:staff, :start_date, :end_date, :hours_paid, :hours_unpaid, :approval, :notes, :respond_email, :type)";
		}
		$q = $dbh->prepare($sql);
		$q->execute($a);

	}



	public function get_staff_names($a) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$sql = 'SELECT id, username, fname, lname, email FROM users WHERE company LIKE "Amanzi"';
		if ( $a['user'] == 'manager' ) {
			if ( $a['department'] == 0 ) {
				$sql .= ' AND division LIKE ' . $a['division'];
			} else {
				$sql .= ' AND department = ' . $a['department'];
			}
		}
		$sql .= " ORDER BY username ASC";
		$q = $dbh->prepare($sql);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_staff_name() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $dbh->prepare("SELECT id, username, fname, lname, email FROM users WHERE id = :id");
		$q->bindParam('id',$_SESSION['id']);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_staff_level() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $dbh->prepare("SELECT division, department, isManager FROM users WHERE id = :id");
		$q->bindParam('id',$_SESSION['id']);
		$q->execute();
		return $row = $q->fetchAll();
	}


	public function get_new_user_name() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT fname, lname, company FROM users WHERE id = :id");
		$q->bindParam('id',$_POST['id']);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_NUM);
		return $row;	
	}


	// SET THE DESIRED USERNAME. QUERY DB IF USERNAME EXISTS. SETS VALUE OF _username_count
	public function set_username_check($i) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT count(id) FROM users WHERE username = :username");
		$q->bindParam('username', $i);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_NUM);
		return $this->_username_count = $row[0];
	}
	// SET THE DESIRED USERNAME. QUERY DB IF EMAIL ADDRESS EXISTS.
	public function set_email_check($i) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT count(id) FROM users WHERE email = :email");
		$q->bindParam('email', $i);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_NUM);
		return $this->_email_count = $row[0];
	}

	// RESURNS A LIST OF USER LEVELS FROM DB (user_levels) BASED ON isINTERNAL, SORTED BY sort_order
	public function get_user_roles($a,$i) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT id,isInternal,name FROM user_levels WHERE isInternal = :internal AND masterAccount = :masterAccount AND name != ''  ORDER BY sort_order ASC");
		$q->bindParam('internal', $a);
		$q->bindParam('masterAccount', $i);
		$q->execute();
		return $q->fetchAll(PDO::FETCH_NUM);
	}
	
	// ADD A NEW USER
	public function add_internal_user($a) {
		if ($this->set_username_check($_POST['username']) > '0') {
			$this->_message = "Username exists. " . $this->_username_count . "matches found.";
		} else {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("INSERT INTO users (discount_quartz, discount, access_level, username, password, fname, lname, company, email, phone, address1, address2, city, state, zip, acct_rep, isActive) VALUES (:discount_quartz, :discount, :user_type, :username, :password, :fname, :lname, :company, :email, :phone, :address1, :address2, :city, :state, :zip, :acct_rep, '1')");
			$q->execute($a);
			$this->_message = $dbh->lastInsertId();
		}
		return $this->_message;
	}
	
	// CHECK FOR DUPLICATE uid IN BILLING INFO
	private function check_user_billing() {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT count(id) FROM user_billing_info WHERE uid = :user");
		$q->bindParam('user',$this->_uid);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_NUM);
		return $row[0];	
	}
	
	// ADD A NEW USER BILLING DATA
	public function add_internal_billing($a) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$this->_uid = $a['uid'];
		if ($this->check_user_billing() < '1') {
			$q = $dbh->prepare("INSERT INTO user_billing_info(
				uid, 
				billing_name, 
				billing_company, 
				billing_address1, 
				billing_address2, 
				billing_city, 
				billing_state, 
				billing_zip
			) VALUES (
				:uid, 
				:billing_name, 
				:billing_company, 
				:billing_address1, 
				:billing_address2, 
				:billing_city, 
				:billing_state, 
				:billing_zip
			)");
			$q->execute($a);
			$this->_message = "1";
		} elseif ($this->check_user_billing() > '0') {
			$q = $dbh->prepare("UPDATE user_billing_info SET billing_name=:billing_name,billing_company=:billing_company,billing_address1=:billing_address1,billing_address2=:billing_address2,billing_city=:billing_city,billing_state=:billing_state,billing_zip=:billing_zip WHERE uid = :uid");
			$q->execute($a);
			$this->_message = "1";
		} else {
			$this->_message = "Error with duplicate user id check. ";
		}
		return $this->_message;
	}
	
	// SELECT USER DATA BASED ON SEARCH CRITERIA 
	public function user_data_search($a) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 


		$search_string = "
			SELECT 
				id,
				company,
				username,
				email,
				fname,
				lname,
				access_level,
				parent_id 
			FROM users 
			WHERE " . $a['user_find'] . " LIKE :search AND isActive = :isActive ";
		if ($a['mine'] > 0) {
			$search_string .= " AND acct_rep = :acct_rep";
		}
		$search_string .= " ORDER BY company ASC, lname ASC, fname ASC";
		$q = $dbh->prepare($search_string);


		if ($a['mine'] > 0) {
			$q->bindParam('acct_rep',$a['mine']);
		}
		$q->bindParam('search',$a['search']);
		$q->bindParam('isActive',$a['isActive']);
		$q->execute();
		return $row = $q->fetchAll();
	}
	public function update_user_billing($s,$uid) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE user_billing_info SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE uid = :uid";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('id',$s)) {
				$s['id'] = $id;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
}

// CLIENT USER ACTIONS
class clientUserAction {
// GET LIST OF SUBUSERS UNDER PARENT USER
	public function get_use_list($uid) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("SELECT * FROM users WHERE parent_id = :uid AND is_internal = 1");
			$q->bindParam(':uid',$uid);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
}
?>