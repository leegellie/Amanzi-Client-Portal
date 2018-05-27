<?
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

class logging 
{
	private $_results;
	private $_error;
	private $_ip;
	
	//ERROR HANDLING
	private function clear_errors() 
	{
		$this->_error = "";
	}
	public function get_errors()
	{
		return $this->_error;
		$this->clear_errors();
	}
	
	//RETURN NUMBER FOR A/B TESTING ASSOCIATED TO IP ADDRESS IN DATABASE
	private function get_ab() 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT ab_assoc FROM iplist WHERE user_ip = :a");
			$q->bindParam('a', $this->_ip);
			$q->execute();
			$results = $q->fetch(PDO::FETCH_ASSOC);
			$this->_results = $results['ab_assoc'];
		} catch(PDOException $e) {
			$this->_error = $this->_error . $e->getMessage();
		}
		return $this->_results;
	}
	
	//LOG NEW IPs INTO THE DB
	private function insert_new()
	{
		$b = mt_rand(1,2);
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("INSERT INTO iplist (user_ip, ab_assoc) VALUES (:a, :b)");
			$q->bindParam('a', $this->_ip);
			$q->bindParam('b', $b);
			$q->execute();
			$this->_results = $b;
		} catch(PDOException $e) {
			$this->_error = $this->_error . $e->getMessage();
		}
	}
	
	//CHECKS IF IP IS LOGGED INTO THE DB
	//IF YES, RETURNS THE A/B NUMBER ASSOCIATED WITH THE IP
	//IF NO, ENTERS THE IP INTO THE DB AND RETURNS THE A/B NUMBER ASSOCIATED
	public function log_user($a)
	{
		$this->_ip = $a;
		$results = $this->get_ab();
		
		if ($results == "") 
		{
			$this->insert_new();
		}
		return $this->_results;
	}
}
?>