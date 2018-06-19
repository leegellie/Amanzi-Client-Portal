<?PHP
if(!session_id()) session_start();
require_once(__DIR__ . '/../config.php');

class log_action {

	public function pjt_changes($a) {
		date_default_timezone_set('America/New_York');
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$sql='INSERT INTO comments (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
		foreach( $a as $field => $value ) $params[":{$field}"]=$value;
		$q = $conn->prepare($sql);
		$q->execute( $params );
	}

	public function location_log($uid,$lat,$long) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $conn->prepare("INSERT INTO location (uid, latitude, longitude) VALUES (:uid, :lat, :long)");
		$q->bindParam('uid',$uid);
		$q->bindParam('lat',$lat);
		$q->bindParam('long',$long);
		$q->execute();
	}
}


class project_action {
	private $_error;
	private $_message;
	private $_id;
	private $_parent_id;
	private $_uid;
	
	// $a = IMAGE ARRAY
	// $uid = USER ID
 	// $pid = PROJECT ID
	// $dir = OPTIONAL SUBDIRECTORY NAME. 0 = NO SUBDIRECTORY
	// $name = NAME TO GIVE THE IMAGE

	public function loss_approval($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE projects SET mngr_approved = :mngr_approved, mngr_approved_price = :mngr_approved_price, mngr_approved_id = :mngr_approved_id WHERE id = :id");
		$q->bindParam('id',$a['id']);
		$q->bindParam('mngr_approved_id',$a['mngr_approved_id']);
		$q->bindParam('mngr_approved',$a['mngr_approved']);
		$q->bindParam('mngr_approved_price',$a['mngr_approved_price']);
		$q->execute();
	}


	public function db_profit_update($pid,$ePjtCost,$eSqFt,$profit,$project_costs) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE projects SET costs_job = :costs_job, job_price = :job_price, profit = :profit, job_sqft = :job_sqft WHERE id = :id");
		$q->bindParam('id',$pid);
		$q->bindParam('costs_job',$project_costs);
		$q->bindParam('job_price',$ePjtCost);
		$q->bindParam('profit',$profit);
		$q->bindParam('job_sqft',$eSqFt);
		$q->execute();
	}

	public function get_profloss() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT p.*, u.fname FROM projects AS p JOIN users AS u ON u.id = p.acct_rep WHERE p.job_sqft > 0 AND p.costs_job > 0 AND p.job_price > 0");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);

	}

	public function get_sales_stats() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare('SELECT DATE_FORMAT(install_date, "%m-%Y") AS Month, SUM(job_price) AS stat, SUM(costs_job) AS cost, SUM(profit) AS profit
			FROM projects 
			WHERE YEAR(install_date) = YEAR(CURDATE()) 
			AND job_name NOT LIKE "%test %"
			AND job_name NOT LIKE "% test%"
			GROUP BY DATE_FORMAT(install_date, "%m-%Y")');
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);

	}

	public function get_sqft_inst_stats() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare('SELECT DATE(install_date) AS idate, 
									SUM(job_sqft) AS sqft,
									COUNT(*) AS jobs
		FROM projects
		WHERE install_date > NOW() - INTERVAL 30 DAY
		  AND install_date < NOW() + INTERVAL 30 DAY
		  AND job_name NOT LIKE "%test %"
		  AND job_name NOT LIKE "% test%"
		  AND isActive = 1
		GROUP BY idate
		ORDER BY idate ASC');
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_jobs_inst_stats() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT DATE(install_date) AS idate, 
									COUNT(CASE WHEN `order_num` LIKE '%O' THEN 1 ELSE 0 END) AS repairs,
									COUNT(CASE WHEN `order_num` LIKE '%R' THEN 1 ELSE 0 END) AS reworks,
									COUNT(CASE WHEN `order_num` LIKE '%A' THEN 1 ELSE 0 END) AS additions,
									COUNT(*) AS jobs
		FROM projects
		WHERE install_date > NOW() - INTERVAL 30 DAY
		  AND install_date < NOW() + INTERVAL 30 DAY
		  AND isActive = 1
		  AND job_name NOT LIKE '%test '
		  AND job_name NOT LIKE ' test%'
		GROUP BY idate
		ORDER BY idate ASC");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}



	public function get_entry_stats() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare('SELECT FROM_DAYS(TO_DAYS(timestamp) -MOD(TO_DAYS(timestamp) -1, 7)) AS week_beginning, 
			COUNT(CASE WHEN cmt_user = 10 AND cmt_comment LIKE "%Entered in%" THEN 1 ELSE NULL END) AS alex_entered,
			COUNT(CASE WHEN cmt_user = 10 AND cmt_comment LIKE "%Rejected%" THEN 1 ELSE NULL END) AS alex_rejected,
			COUNT(CASE WHEN cmt_user = 985 AND cmt_comment LIKE "%Entered in%" THEN 1 ELSE NULL END) AS anya_entered,
			COUNT(CASE WHEN cmt_user = 985 AND cmt_comment LIKE "%Rejected%" THEN 1 ELSE NULL END) AS anya_rejected
		FROM comments
		GROUP BY FROM_DAYS(TO_DAYS(timestamp) -MOD(TO_DAYS(timestamp) -1, 7))
		ORDER BY FROM_DAYS(TO_DAYS(timestamp) -MOD(TO_DAYS(timestamp) -1, 7))');
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);

	}

//	public function get_entry_stats() {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//		$q = $conn->prepare("SELECT CONCAT(YEAR(timestamp), '/', WEEK(timestamp)) AS week_beginning, YEAR(timestamp), WEEK(timestamp),
//			COUNT(CASE WHEN cmt_user = 10 AND cmt_comment LIKE '%Entered in%' THEN 1 ELSE NULL END) AS alex_entered,
//			COUNT(CASE WHEN cmt_user = 10 AND cmt_comment LIKE '%Rejected%' THEN 1 ELSE NULL END) AS alex_rejected,
//			COUNT(CASE WHEN cmt_user = 985 AND cmt_comment LIKE '%Entered in%' THEN 1 ELSE NULL END) AS anya_entered,
//			COUNT(CASE WHEN cmt_user = 985 AND cmt_comment LIKE '%Rejected%' THEN 1 ELSE NULL END) AS anya_rejected
//		FROM comments
//		GROUP BY week_beginning
//		ORDER BY YEAR(timestamp) ASC, WEEK(timestamp) ASC");
//		$q->execute();
//		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
//	}

	public function get_walkin_stats() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare('SELECT DATE_FORMAT(u.datetime, "%m-%Y") AS Month, COUNT(u.id) AS walkins, COUNT(p.id) AS projects
			FROM users AS u
			LEFT OUTER JOIN projects AS p
			ON p.uid = u.id
			WHERE YEAR(u.datetime) = YEAR(CURDATE())
			AND signature = "Signed"
			GROUP BY DATE_FORMAT(u.datetime, "%m-%Y")');
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);

	}


	public function update_inst_dicounts($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$qry = $conn->prepare("SELECT installs.id, installs.cpSqFt_override, installs.materials_cost, installs.material, installs.SqFt, installs.accs_prices, installs.price_extra, installs.slabs, users.discount, users.discount_quartz FROM installs JOIN users ON installs.uid = users.id WHERE installs.pid = " . $a);
		$qry->execute();
		$row = $qry->fetchAll(PDO::FETCH_ASSOC);
		foreach($row as $r) {
			if ($r['material'] == 'quartz') {
				if ($r['cpSqFt_override'] < 1) {
					$disc = 100 - $r['discount_quartz'];
					$disc = '0.' . $disc;
					$disc = floatval($disc);
					$mc = $r['material'] + 21.5;
					$mc = $mc * 1.45;
					$matPrice = $mc * $disc;
					$cpSqFt = $matPrice / $r['SqFt'];
					$jobPrice = $matPrice + $r['accs_prices'] + $r['price_extra'] - $r['install_discount'];
					$q = $conn->prepare("UPDATE installs SET cpSqFt = :cpSqFt, install_price = :install_price, price_calc = :price_calc WHERE id = :id");
					$q->bindParam('id',$r['id']);
					$q->bindParam('cpSqFt',$r['cpSqFt']);
					$q->bindParam('install_price',$jobPrice);
					$q->bindParam('price_calc',$matPrice);
					$q->execute();
				}
			}
			if ($r['material'] == 'marbgran') {
				if ($r['cpSqFt_override'] < 1) {
					$disc = 100 - $r['discount'];
					$disc = '0.' . $disc;
					$disc = floatval($disc);
					$mc = $r['material'] * 6;
					$matPrice = $mc * $disc;
					$cpSqFt = $matPrice / $r['SqFt'];
					$jobPrice = $matPrice + $r['accs_prices'] + $r['price_extra'] - $r['install_discount'];
					$q = $conn->prepare("UPDATE installs SET cpSqFt = :cpSqFt, install_price = :install_price, price_calc = :price_calc WHERE id = :id");
					$q->bindParam('id',$r['id']);
					$q->bindParam('cpSqFt',$r['cpSqFt']);
					$q->bindParam('install_price',$jobPrice);
					$q->bindParam('price_calc',$matPrice);
					$q->execute();
				}
			}
		}
		return $row;
	}

	public function sum_costs($a) {
		$sumMats = 0;
		$accsCosts = 0;
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$q = $conn->prepare("SELECT SUM(materials_cost) as matCosts FROM installs WHERE pid = " . $a);
		$q->execute();
		$row = $q->fetch(PDO::FETCH_ASSOC);
		$sumMats = $row['matCosts'];

		$q1 = $conn->prepare("SELECT id FROM installs WHERE pid = " . $a);
		$q1->execute();
		$iidList = $q1->fetch();

		if (!empty($iidList)) {
			$sql = "SELECT (SUM(faucet_cost) + SUM(sink_cost)) as accsCosts FROM install_sink WHERE sink_iid IN (" . implode(',', array_map('intval', $iidList)) . ")";
			$q2 = $conn->prepare($sql);
			$q2->execute();
			$row = $q2->fetch(PDO::FETCH_ASSOC);
			$accsCosts = $row['accsCosts'];
			$results = ($sumMats*1) + ($accsCosts*1);
			return $results;
		}


	}

	public function recalculate($a) {
		$sumMats = 0;
		$accsCosts = 0;
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$q = $conn->prepare("SELECT users.discount, users.discount_quartz FROM users WHERE id = :uid");
		$q->execute();
		$row = $q->fetch(PDO::FETCH_ASSOC);
		$sumMats = $row['matCosts'];

		$q1 = $conn->prepare("SELECT id FROM installs WHERE pid = " . $a);
		$q1->execute();
		$iidList = $q1->fetch();

		$sql = "SELECT (SUM(faucet_cost) + SUM(sink_cost)) as accsCosts FROM install_sink WHERE sink_iid IN (" . implode(',', array_map('intval', $iidList)) . ")";
		$q2 = $conn->prepare($sql);
		$q2->execute();
		$row = $q2->fetch(PDO::FETCH_ASSOC);
		$accsCosts = $row['accsCosts'];

		$results = ($sumMats*1) + ($accsCosts*1);

		return $results;

	}

	public function update_discounts($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE users SET discount = :discount, discount_quartz = :discount_quartz  WHERE id = :uid";
		$q = $conn->prepare($sql);
		$q->bindParam('uid',$a['uid']);
		$q->bindParam('discount',$a['discount']);
		$q->bindParam('discount_quartz',$a['discount_quartz']);
		$q->execute();
	}

	public function mat_price_recalc($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE installs SET cpSqFt = :cpSqFt WHERE pid = :pid AND color LIKE :color";
		$sqFt = $conn->prepare($sql);
		$sqFt->bindParam('cpSqFt',$a['cpSqFt']);
		$sqFt->bindParam('pid',$a['pid']);
		$sqFt->bindParam('color',$a['color']);
		$sqFt->execute();

		$sql2 = "UPDATE installs SET price_calc = SqFt*cpSqFt WHERE pid = :pid AND color LIKE :color";
		$cpSqFt = $conn->prepare($sql2);
		$cpSqFt->bindParam('pid',$a['pid']);
		$cpSqFt->bindParam('color',$a['color']);
		$cpSqFt->execute();

		$q = $conn->prepare("SELECT id, price_extra, cpSqFt, SqFt, accs_prices, install_discount FROM installs WHERE pid = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->execute();
		$row = $q->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $r) {
			$iid = $r['cpSqFt'];
			$matPrice = $r['cpSqFt'] * $r['SqFt'];
			if ($matPrice < 1) {
				$matPrice = 0;
			}
			$price_extra = $r['price_extra'];
			$install_discount = $r['install_discount'];
			$finalPrice = ($matPrice + $price_extra + $r['accs_prices']) - $install_discount;
			if ($finalPrice < 1) {
				$finalPrice = 0.00;
			}
			$f = $conn->prepare("UPDATE installs SET install_price = :install_price WHERE id = :id");
			$f->bindParam('id',$r['id']);
			$f->bindParam('install_price',$finalPrice);
			$f->execute();
		}
	}

	public function quartz_sqft_calc($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sqFt = $conn->prepare("SELECT SUM(SqFt) AS sumSqFt, SUM(slabs) AS slabs FROM installs WHERE pid = :pid AND color LIKE :color");
		$sqFt->bindParam('pid',$a['pid']);
		$sqFt->bindParam('color',$a['color']);
		$sqFt->execute();
		return $row = $sqFt->fetchAll();

	}
	public function quartz_sqft_calc_update($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sqFt = $conn->prepare("SELECT SUM(SqFt) AS sumSqFt, SUM(slabs) AS slabs FROM installs WHERE pid = :pid AND color LIKE :color AND id <> :iid");
		$sqFt->bindParam('iid',$a['iid']);
		$sqFt->bindParam('pid',$a['pid']);
		$sqFt->bindParam('color',$a['color']);
		$sqFt->execute();
		return $row = $sqFt->fetchAll();

	}


	public function compile_install_price($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sqFt = $conn->prepare("SELECT SUM(SqFt) AS sumSqFt FROM install_pieces WHERE iid = :iid AND piece_active = 1");
		$sqFt->bindParam('iid',$a['iid']);
		$sqFt->execute();

		$sumSqFt = $sqFt->fetch();
		$sumSqFt = $sumSqFt[0];

		if (!(is_numeric($sumSqFt))) {
			$sumSqFt = 0;
		}
		if ($sumSqFt < 1) {
			$sumSqFt = 0;
		}

		$sink = $conn->prepare("SELECT (SUM(cutout_price) + SUM(faucet_price) + SUM(sink_price)) as sinkTotal FROM install_sink WHERE sink_iid = :iid");
		$sink->bindParam('iid',$a['iid']);
		$sink->execute();

		$sinkPrice = $sink->fetch();
		$sinkPrice = $sinkPrice['sinkTotal'];

		if (!(is_numeric($sinkPrice))) {
			$sinkPrice = 0;
		}
		if ($sinkPrice < 1) {
			$sinkPrice = 0.00;
		}

		$price_extra = 0;
		$matPrice = 0;
		$install_discount = 0.00;
		$price_tearout = 0.00;

		$q = $conn->prepare("SELECT price_extra, cpSqFt, SqFt, install_discount, tear_out, tearout_sqft FROM installs WHERE id = :iid");
		$q->bindParam('iid',$a['iid']);
		$q->execute();
		$row = $q->fetchAll(PDO::FETCH_ASSOC);

		foreach($row as $r) {
//			if(!($sumSqFt > 1)) {
//				$sumSqFt = $r['SqFt'];
//			}

			$matPrice = $r['cpSqFt'] * $sumSqFt;
			if ($matPrice < 1) {
				$matPrice = 0;
			}
			$price_extra = $r['price_extra'];
			$install_discount = $r['install_discount'];
			if ($r['tear_out'] == "Yes") {
				$price_tearout = $r['tearout_sqft'] * 7.5;
			}
		}

		$finalPrice = ($matPrice + $price_extra + $sinkPrice) - $install_discount + $price_tearout;

		if ($finalPrice < 1) {
			$finalPrice = 0.00;
		}

		$f = $conn->prepare("UPDATE installs SET install_price = :install_price, accs_prices = :accs_prices, SqFt = :SqFt, price_calc = :price_calc, tearout_cost = :tearout_cost WHERE id = :id");
		$f->bindParam('id',$a['iid']);
		$f->bindParam('price_calc',$matPrice);
		$f->bindParam('accs_prices',$sinkPrice);
		$f->bindParam('SqFt',$sumSqFt);
		$f->bindParam('install_price',$finalPrice);
		$f->bindParam('tearout_cost',$price_tearout);
		$f->execute();

	}

	public function get_edges() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM edges WHERE 1");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_quartz_companies() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM category WHERE 1 ORDER BY id ASC");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

//	public function get_accs($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//		$q = $conn->prepare("SELECT * FROM accessories WHERE accs_code = :accs_code");
//		$q->bindParam('accs_code',$a);
//		$q->execute();
//		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
//	}
	public function get_accs() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM accessories WHERE 1 ORDER BY accs_name ASC");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function delete_piece($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("DELETE FROM install_pieces WHERE piece_id = :id");
		$q->bindParam('id',$a['id']);
		$q->execute();

		$s = $conn->prepare("DELETE FROM install_sink WHERE sink_part = :id");
		$s->bindParam('id',$a['id']);
		$s->execute();

	}

	public function delete_sink($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$s = $conn->prepare("DELETE FROM install_sink WHERE sink_id = :isid");
		$s->bindParam('isid',$a['isid']);
		$s->execute();

	}

	public function delete_install($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$i = $conn->prepare("DELETE FROM install_pieces WHERE iid = :id");
		$i->bindParam('id',$a['id']);
		$i->execute();

		$q = $conn->prepare("DELETE FROM installs WHERE id = :id");
		$q->bindParam('id',$a['id']);
		$q->execute();

		$q = $conn->prepare("DELETE FROM install_sink WHERE sink_iid = :id");
		$q->bindParam('id',$a['id']);
		$q->execute();

	}

	public function get_inst_sqft($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT SUM(SqFt) AS sumSqFt FROM install_pieces WHERE iid = :iid AND piece_active = 1");
		$q->bindParam('iid',$a['iid']);
		$q->execute();
		return $row = $q->fetch(PDO::FETCH_ASSOC);
	}

	public function get_cp_sqft($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT cpSqFt FROM installs WHERE id = :iid");
		$q->bindParam('iid',$a['iid']);
		$q->execute();
		return $row = $q->fetch(PDO::FETCH_ASSOC);
	}


	public function set_inst_sqft($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE installs SET SqFt = :SqFt WHERE id = :iid");
		$q->bindParam('iid',$a['iid']);
		$q->bindParam('SqFt',$a['SqFt']);
		$q->execute();
	}

	public function add_piece($a) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "INSERT INTO install_pieces (iid, pid, piece_name, shape, size_a, size_b, size_c, size_d, size_e, size_f, piece_edge, edge_length, bs_height, bs_length, rs_height, rs_length, piece_active, SqFt) VALUES (:iid, :pid, :piece_name, :shape, :size_a, :size_b, :size_c, :size_d, :size_e, :size_f, :piece_edge, :edge_length, :bs_height, :bs_length, :rs_height, :rs_length, :piece_active, :SqFt)";
			$q = $dbh->prepare($sql);
			$q->execute($a);
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function get_piece_data($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("SELECT * FROM install_pieces WHERE piece_id = :piece_id");
		$q->bindParam('piece_id',$a['piece_id']);
			$q->execute();
			return $this->_uid = $q -> fetchAll();

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function update_piece($s) {
		$piece_id = $s['piece_id'];
		unset($s['piece_id']);
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$sql = "UPDATE install_pieces SET
			iid = :iid, 
			pid = :pid, 
			piece_name = :piece_name, 
			shape = :shape, 
			size_a = :size_a, 
			size_b = :size_b, 
			size_c = :size_c, 
			size_d = :size_d, 
			size_e = :size_e, 
			size_f = :size_f, 
			piece_edge = :piece_edge, 
			edge_length = :edge_length, 
			bs_height = :bs_height, 
			bs_length = :bs_length, 
			rs_height = :rs_height, 
			rs_length = :rs_length, 
			piece_active = :piece_active, 
			SqFt = :SqFt
			WHERE piece_id = $piece_id";

			$q = $conn->prepare($sql);

			$q->bindParam("iid",$s['iid']);
			$q->bindParam("pid",$s['pid']);
			$q->bindParam("piece_name",$s['piece_name']);
			$q->bindParam("shape",$s['shape']);
			$q->bindParam("size_a",$s['size_a']);
			$q->bindParam("size_b",$s['size_b']);
			$q->bindParam("size_c",$s['size_c']);
			$q->bindParam("size_d",$s['size_d']);
			$q->bindParam("size_e",$s['size_e']);
			$q->bindParam("size_f",$s['size_f']);
			$q->bindParam("piece_edge",$s['piece_edge']);
			$q->bindParam("edge_length",$s['edge_length']);
			$q->bindParam("bs_height",$s['bs_height']);
			$q->bindParam("bs_length",$s['bs_length']);
			$q->bindParam("rs_height",$s['rs_height']);
			$q->bindParam("rs_length",$s['rs_length']);
			$q->bindParam("piece_active",$s['piece_active']);
			$q->bindParam("SqFt",$s['SqFt']);
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function set_entry($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $conn->prepare("UPDATE projects SET entry = :entry WHERE id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->bindParam('entry',$a['entry']);
		$q->execute();

		$s = $conn->prepare("SELECT job_name, quote_num, order_num FROM projects WHERE id = :pid");
		$s->bindParam('pid',$a['pid']);
		$s->execute();
		return $row = $s->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_job_status($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT status.id AS sid, status.name AS sname FROM status JOIN projects ON status.id = projects.job_status WHERE projects.id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_hold_user() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT status.id AS sid, status.name AS sname FROM status JOIN projects ON status.id = projects.job_status WHERE projects.id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

//	public function update_job_status($a) {
//		try {
//			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//			$sql = "UPDATE projects SET job_status = :status";
//			if ($a['status'] == 86 || $a['status'] == 26) {
//				$sql .= ", isActive = 0";
//			}
//			$sql .= " WHERE id = :id";
//			$q = $conn->prepare($sql);
//			$q->bindParam('id',$a['pid']);
//			$q->bindParam('status',$a['status']);
//			$q->execute();
//
//		} catch(PDOException $e) {
//			echo "ERROR: " . $e->getMessage();
//		}
//	}

	public function change_status($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE projects SET job_status = :status";
			if ($a['status'] == 86 || $a['status'] == 26) {
				$sql .= ", isActive = 0";
			}
			$sql .= " WHERE id = :id";
			$q = $conn->prepare($sql);
			$q->bindParam('id',$a['pid']);
			$q->bindParam('status',$a['status']);
			$q->execute();

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function get_status_update($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "UPDATE projects SET job_status = :status";
		if ($a['status'] == 86 || $a['status'] == 26) {
			$sql .= ", isActive = 0";
		}
		$sql .= " WHERE id = :id";
		$q = $conn->prepare($sql);
		$q->bindParam('id',$a['pid']);
		$q->bindParam('status',$a['status']);
		$q->execute();


		$q = $conn->prepare("
			SELECT projects.order_num,
				   projects.quote_num,
				   projects.job_name,
				   status.name AS status_name,
				   users.fname,
				   users.email
			  FROM projects
			  JOIN status
				ON status.id = :status
			  JOIN users
				ON users.id = projects.acct_rep
			 WHERE projects.id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->bindParam('status',$a['status']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_material_update($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "UPDATE installs SET mat_hold = 1 WHERE id = :id";
		$q = $conn->prepare($sql);
		$q->bindParam('id',$a['iid']);
		$q->execute();


		$q = $conn->prepare("
			SELECT projects.order_num,
				   projects.quote_num,
				   projects.job_name,
				   projects.uid,
				   rep.fname AS rep_name,
				   rep.email AS rep_email,
				   mat.fname AS mat_name,
				   mat.email AS mat_email
			  FROM projects
			  JOIN users rep
				ON rep.id = :user
			  JOIN users mat
				ON mat.id = projects.acct_rep
			 WHERE projects.id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->bindParam('user',$a['user']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_material_release($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "UPDATE installs SET mat_hold = 0 WHERE id = :id";
		$q = $conn->prepare($sql);
		$q->bindParam('id',$a['iid']);
		$q->execute();


		$q = $conn->prepare("
			SELECT projects.order_num,
				   projects.quote_num,
				   projects.job_name,
				   projects.uid,
				   rep.fname AS rep_name,
				   rep.email AS rep_email,
				   mat.fname AS mat_name,
				   mat.email AS mat_email
			  FROM projects
			  JOIN users rep
				ON rep.id = :user
			  JOIN users mat
				ON mat.id = projects.acct_rep
			 WHERE projects.id = :pid");
		$q->bindParam('pid',$a['pid']);
		$q->bindParam('user',$a['user']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_material_status($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT id, install_name, material_status, material_date FROM installs WHERE id = :id");
		$q->bindParam('pid',$a['pid']);
		$q->bindParam('id',$a['iid']);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update_material_status($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE projects SET job_status = :status";
			if ($a['status'] == 86 || $a['status'] == 26) {
				$sql .= ", isActive = 0";
			}
			$sql .= " WHERE id = :id";
			$q = $conn->prepare($sql);
			$q->bindParam('id',$a['pid']);
			$q->bindParam('status',$a['status']);
			$q->execute();

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}

	}


	public function get_status_list() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT id, short_name, name, stage FROM status WHERE 1");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_price_levels() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT id, shortname, name, min_price, max_price FROM price_levels WHERE 1");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_marble() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM marbgran WHERE 1 ORDER BY name ASC");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_quartz() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT quartz2.*, category.price_3 AS cat_price, category.brand, category.class, category.group FROM quartz2 JOIN category ON quartz2.cat_id = category.id WHERE 1 ORDER BY quartz2.name");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}


//	public function get_price_levels($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//		$q = $conn->prepare("SELECT multiplier, extra FROM user_price WHERE id = :id");
//		$q->bindParam('id',$a['user_level']);
//		$q->execute();
//		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
//
//	}

	public function get_price_multiplier($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT M.multiplier, M.extra FROM users U JOIN user_price M ON U.access_level = M.id WHERE U.id = :id");
		$q->bindParam('id',$a['uid']);
		$q->execute();
		return $row = $q->fetchAll();
		//return var_dump($row);

	}


	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_sales_reps($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $conn->prepare("SELECT id,fname,lname FROM users WHERE sales = :sales");
		$q->bindParam('sales',$a['isSales']);
		$q->execute();
		return $row = $q->fetchAll();
	}



	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_reps() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT id,fname,lname FROM users WHERE sales = 1");
		$q->execute();
		return $row = $q->fetchAll();
	}


	// GET SALES REP'S NAME FOR PROJECT VIEW 
	public function get_rep_name($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $conn->prepare("SELECT fname,lname FROM users WHERE id = :id");
		$q->bindParam('id',$a['repID']);
		$q->execute();
		return $row = $q->fetchAll();
	}
	// GET CLIENT NAME FOR PROJECT VIEW 
	public function get_client_name($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $conn->prepare("SELECT company,fname,lname FROM users WHERE id = :id");
		$q->bindParam('id',$a['getUname']);
		$q->execute();
		return $row = $q->fetchAll();
	}

//	// GET EDGE NAME FOR INSTALL VIEW 
//	public function get_edge_name($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//		$q = $conn->prepare("SELECT edge_name FROM edges WHERE id = :id");
//		$q->bindParam('id',$a['getEdge']);
//		$q->execute();
//		return $row = $q->fetchAll();
//	}
//
//	// GET HOLES NAME FOR INSTALL VIEW 
//	public function get_holes_name($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//		$q = $conn->prepare("SELECT hole_name FROM holes WHERE id = :id");
//		$q->bindParam('id',$a['getHoles']);
//		$q->execute();
//		return $row = $q->fetchAll();
//	}
//
//	// GET RANGE TYPE FOR INSTALL VIEW 
//	public function get_range_type($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//		$q = $conn->prepare("SELECT range_type FROM range_type WHERE id = :id");
//		$q->bindParam('id',$a['getRange']);
//		$q->execute();
//		return $row = $q->fetchAll();
//	}


	public function upload_img($a,$uid,$pid,$dir,$name) {
		$user_path =  base_dir . "images/projects/" . $uid;
		$path = base_dir . "images/projects/" . $uid . "/" . $pid;
		/*if ($dir != '0') {
			$path = $path . "/" . $dir;
		} */
		if (file_exists($user_path)) {
			//user path already exists. do nothing
		}
		if (file_exists($path)) {
			//Project directory already exists;
		} else {
			mkdir($path,0755,true);
		}
		if ($dir == '0' ) {
			//Do nothing
		} else {
			if ( !file_exists($path . "/". $dir) ) {
				mkdir($dirpath,0755,true);
			}
			$dirpath = $path = $path . "/" . $dir;
		}

		$check = getimagesize($a["tmp_name"]);
		if($check !== false) {
			$old_name = $a["name"];
			$ext = end((explode(".", $old_name)));
			$target_file = $path . "/" . $name . "." . $ext;
			if (move_uploaded_file($a["tmp_name"], $target_file)) {
				//UPLOADED. SET MESSAGE TO RELATIVE IMAGE PATH
				$this->_message = "/images/projects/" . $uid . "/" . $pid;
				if ($dir != '0') {
					$this->_message = $this->_message . "/" . $dir;
				}
				$this->_message = $this->_message . "/" . $name . "." . $ext;
			} else {
				$this->_message = "Sorry, there was an error uploading the image.";
			}
		} else {
			$this->_message = "Image is not an image.";
		}
		return $this->_message;
	}

	public function reArray_files($arr) {
    	foreach( $arr as $key => $all ){
 	       foreach( $all as $i => $val ){
 	           $new[$i][$key] = $val;
  	      }
 	   }
  	  return $new;
	}

	public function set_uid_from_pid($pid) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$q = $conn->prepare("SELECT uid FROM projects WHERE id = :pid");
			$q->bindParam(':pid',$pid);
			$q->execute();
			$this->_uid = $q -> fetch();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function set_ids_from_fpid($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("SELECT a.uid, b.pid
				FROM projects a,
				installs b  
				WHERE a.id = b.pid AND b.id = :fpid"
				); 
			$q->bindParam(':fpid',$a);
			$q->execute();
			$this->_uid = $q -> fetch();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function get_uid() {
		return $this->_uid;
	}


	// again where clause is left optional
	public function dbRowUpdate($table_name, $form_data, $where_clause='')
	{
		// check for optional where clause
		$whereSQL = '';
		if(!empty($where_clause))
		{
			// check to see if the 'where' keyword exists
			if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
			{
				// not found, add key word
				$whereSQL = " WHERE ".$where_clause;
			} else
			{
				$whereSQL = " ".trim($where_clause);
			}
		}
		// start the actual SQL statement
		$sql = "UPDATE ".$table_name." SET ";
	
		// loop and build the column /
		$sets = array();
		foreach($form_data as $column => $value)
		{
			 $sets[] = "`".$column."` = '".$value."'";
		}
		$sql .= implode(', ', $sets);
	
		// append the where statement
		$sql .= $whereSQL;
	
		// run and return the query result
		return mysql_query($sql);
	}


	public function add_project($a) {
		try {
       
      $conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$sql='INSERT INTO projects (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
			foreach( $a as $field => $value ) $params[":{$field}"]=$value;
			$q = $conn->prepare($sql);
			$q->execute( $params );

//			$q = $conn->prepare("INSERT INTO projects (
//					uid,
//					job_name,
//					acct_rep,
//					builder,
//					quote_num,
//					order_num,
//					install_date,
//					template_date,
//					po_cost,
//					po_num,
//					contact_name,
//					contact_number,
//					contact_email,
//					alternate_name,
//					alternate_number,
//					alternate_email,
//					address_1,
//					address_2,
//					city,
//					state,
//					zip,
//					job_notes,
//					isActive,
//					urgent,
//					tax_free,
//					job_tax,
//					am,
//					first_stop,
//					pm,
//					temp_am,
//					temp_first_stop,
//					temp_pm,
//					job_discount,
//					address_notes,
//					job_lat,
//					job_long
//				)
//				VALUES (
//					:uid,
//					:job_name,
//					:acct_rep,
//					:builder,
//					:quote_num,
//					:order_num,
//					:install_date,
//					:template_date,
//					:po_cost,
//					:po_num,
//					:contact_name,
//					:contact_number,
//					:contact_email,
//					:alternate_name,
//					:alternate_number,
//					:alternate_email,
//					:address_1,
//					:address_2,
//					:city,
//					:state,
//					:zip,
//					:job_notes,
//					:isActive,
//					:urgent,
//					:tax_free,
//					:job_tax,
//					:am,
//					:first_stop,
//					:pm,
//					:temp_am,
//					:temp_first_stop,
//					:temp_pm,
//					:job_discount,
//					:address_notes,
//					:job_lat,
//					:job_long
//				)");


//			$q->execute($a);
			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}


	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function project_data_search($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$search_string = "SELECT projects.id, projects.job_name, projects.quote_num, projects.order_num, projects.uid, projects.job_status, projects.entry, status.name AS status FROM projects JOIN status ON projects.job_status = status.id WHERE projects." . $a['user_find'] . " LIKE :search AND projects.isActive = :isActive";


		if ($a['mine'] > 0) {
			$search_string .= " AND acct_rep = :acct_rep";
		}

		$search_string .= " ORDER BY projects.last_modified DESC";

		$q = $conn->prepare($search_string);
		$q->bindParam('search',$a['search']);
		$q->bindParam('isActive',$a['isActive']);
		if ($a['mine'] > 0) {
			$q->bindParam('acct_rep',$a['mine']);
		}
		$q->execute();
		return $row = $q->fetchAll();
	}



	public function update_project($s,$id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE projects SET";
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $conn->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('id',$s))	{
				$s['id'] = $id;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}




	public function insert_menu($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("INSERT INTO project_menu (
				pid, 
				menu_title, 
				menu_type, 
				sort_order 
			) 
			VALUES (
				:pid, 
				:menu_title, 
				:menu_type, 
				:sort_order 
			)");
			$q->execute($a);
			$menu_id = $conn->lastInsertId();
			$this->_message = $a['menu_title'] . "::" . $a['menu_type'] . "::" . $menu_id .  ",";
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
	public function insert_home($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$q = $conn->prepare("INSERT INTO project_home (
				pid, 
				mid, 
				home_background, 
				home_tagline, 
				home_ticker, 
				home_js, 
				home_css
			) 
			VALUES (
				:hiddenPID, 
				:mid, 
				:home_background, 
				:home_tagline, 
				:home_ticker, 
				:home_js, 
				:home_css 
			)");
			$q->execute($a);
			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
	public function update_home($s,$pid,$mid) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE project_menu SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $conn->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('pid',$s)) {
				$s['pid'] = $pid;
			}
			if (!in_array('mid',$s)) {
				$s['mid'] = $mid;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function insert_install($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$sql='INSERT INTO installs (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
			foreach( $a as $field => $value ) $params[":{$field}"]=$value;
			$q = $conn->prepare($sql);
			$q->execute( $params );

			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function install_template($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $conn->prepare('
				INSERT INTO installs 
					(
						pid, 
						install_room, 
						install_name, 
						type, 
						tear_out,
						selected,
						edge,
						range_type,
						holes,
						SqFt
					) values (
						:pid, 
						:install_room, 
						:install_name, 
						"New", 
						"No",
						"no",
						0,
						0,
						0,
						0
					)');
			$q->bindParam(':pid',$a['pid']);
			$q->bindParam(':install_room',$a['install_room']);
			$q->bindParam(':install_name',$a['install_name']);
			$q->execute();

			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	// SELECT PROJECT LIST BASED ON USER CRITERIA 
	public function project_list_search($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $conn->prepare("SELECT id, uid, job_name, quote_num, order_num FROM projects WHERE uid = " . $a['userID'] . " ORDER BY last_modified DESC");
		$q->execute();
		return $row = $q->fetchAll();
	}

	// SELECT PROJECT LIST BASED ON USER CRITERIA 
	public function get_entries($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT projects.id, projects.uid, projects.job_name, projects.quote_num, projects.order_num, projects.job_status, status.name AS status FROM projects JOIN status ON status.id = projects.job_status WHERE entry = 1";
		if ($a == 10){
			$sql .= " AND (acct_rep = 8 OR acct_rep = 7)";
		} if ($a == 985) {
			$sql .= " AND NOT acct_rep = 8 AND NOT acct_rep = 7";
		}
		$sql .= " ORDER BY job_status DESC";
		$q = $conn->prepare($sql);
		$q->execute();
		return $row = $q->fetchAll();
	}


	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE

	public function get_temp_teams() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT *, 
			FROM template_teams 
			WHERE tem_team_active = 1";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}

	// SELECT PROJECT LIST BASED ON USER CRITERIA 
	public function get_templates($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "
			SELECT 	projects.*, 
					status.name AS status, 
					template_teams.temp_team_name AS team, 
					template_teams.temp_user_id,
					users.access_level AS ual
			 FROM projects 
			 JOIN status 
			   ON status.id = projects.job_status 
			 JOIN template_teams 
			   ON template_teams.temp_team_id = projects.template_team 
			 JOIN users 
			   ON users.id = projects.uid 
			WHERE template_date >= CURDATE() 
			  AND template_date < '2200-01-01' 
			  AND projects.isActive = 1 ";
			if ($a > 0) {
				$sql .= "AND template_teams.temp_user_id = " . $a;
			}
			$sql .= "
			ORDER BY 
				  team ASC, 
				  temp_first_stop DESC, 
				  temp_am DESC,
				  temp_pm ASC,
				  zip ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}

	public function incomplete_templates() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT projects.*, 
				   status.name AS status, 
				   install_teams.inst_team_name AS team,
				   install_teams.inst_lead_id,
				   users.access_level AS ual
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			  JOIN install_teams 
				ON install_teams.inst_team_id = projects.install_team 
			  JOIN users 
			    ON users.id = projects.uid 
			 WHERE template_date < CURDATE() 
			   AND job_status < 84
			   AND projects.isActive = 1";
			if ($a > 0) {
				$sql .= "AND template_teams.temp_user_id = " . $a;
			}
			$sql .= "
			ORDER BY install_date ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}



	public function get_programming() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "
			SELECT projects.*, 
				   status.name AS status
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			 WHERE install_date < '2200-01-01' 
			   AND job_status > 24
			   AND job_status < 40
			   AND NOT job_status = 26
			   AND NOT job_status = 29
			   AND projects.isActive = 1
			 ORDER BY 
				   install_date ASC, 
				   first_stop DESC, 
				   am DESC,
				   pm ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}


	public function get_saw() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "
			SELECT projects.*, 
				   status.name AS status
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			 WHERE install_date < '2200-01-01' 
			   AND job_status > 43
			   AND job_status < 60
			   AND NOT job_status = 49
			   AND projects.isActive = 1
			 ORDER BY 
				   install_date ASC, 
				   first_stop DESC, 
				   am DESC,
				   pm ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}

	public function get_cnc() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "
			SELECT projects.*, 
				   status.name AS status
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			 WHERE install_date < '2200-01-01' 
			   AND job_status > 52
			   AND job_status < 70
			   AND NOT job_status = 59
			   AND projects.isActive = 1
			 ORDER BY 
				   install_date ASC, 
				   first_stop DESC, 
				   am DESC,
				   pm ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}

	public function get_polishing() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "
			SELECT projects.*, 
				   status.name AS status
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			 WHERE install_date < '2200-01-01' 
			   AND job_status > 63
			   AND job_status < 80
			   AND NOT job_status = 79
			   AND projects.isActive = 1
			 ORDER BY 
				   install_date ASC, 
				   first_stop DESC, 
				   am DESC,
				   pm ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}


	// SELECT PROJECT LIST BASED ON USER CRITERIA 
	public function get_installs($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT 
				projects.*, 
				status.name AS status, 
				install_teams.inst_team_name AS team,
				install_teams.inst_lead_id,
				users.access_level AS ual
			FROM projects 
			JOIN status 
				ON status.id = projects.job_status 
			JOIN install_teams 
				ON install_teams.inst_team_id = projects.install_team 
			 JOIN users 
			   ON users.id = projects.uid 
			WHERE 
				install_date >= CURDATE() 
			AND install_date < '2200-01-01' 
			  AND projects.isActive = 1 ";
			if ($a > 0) {
				$sql .= "AND install_teams.inst_lead_id = " . $a;
			}
			$sql .= "
			ORDER BY 
				team ASC, 
				first_stop DESC, 
				am DESC,
				pm ASC,
				zip ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
  
	public function incomplete_installs($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT projects.*, 
				   status.name AS status, 
				   install_teams.inst_team_name AS team,
				   install_teams.inst_lead_id,
				   users.access_level AS ual
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			  JOIN install_teams 
				ON install_teams.inst_team_id = projects.install_team 
			  JOIN users 
			    ON users.id = projects.uid 
			 WHERE install_date < CURDATE() 
			   AND job_status < 84
			   AND projects.isActive = 1";
			if ($a > 0) {
				$sql .= "AND install_teams.inst_lead_id = " . $a;
			}
			$sql .= "
			ORDER BY install_date ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			return $row = $q->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}

	//SELECT PROJECT LIST BASED ON STATUS
  public function get_templates_timeline($a) {
    try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
			$sql = "
			SELECT 	*, projects.id AS pid, status.name, status.stage, status.short_name, status.name AS status_name, status.id AS status
				FROM projects 
			  	JOIN status 
				  ON status.id = projects.job_status 
			   WHERE (projects.template_date < '2200-01-01' 
			   	 AND projects.install_date > CURDATE()
			   	 AND projects.isActive = 1) 
			      OR (projects.template_date < '2200-01-01' 
			   	 AND projects.template_date > CURDATE()
				 AND projects.isActive = 1)
			ORDER BY projects.install_date ASC,
					 projects.urgent DESC,
					 projects.am DESC,
					 projects.first_stop DESC,
					 projects.pm ASC,
					 projects.temp_am DESC,
					 projects.temp_first_stop DESC,
					 projects.temp_pm ASC";
			$q = $conn->prepare($sql);
			$q->execute();
			$rows = $q->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
//      $tmp = array();
//
//      foreach($rows as $row)
//      {
//          //$tmp[$job['install_date']][] = $job['job_name'];
//          $tmp[$row['short_name']][] = $row;
//      }
//      $output = array();
//
//      foreach($tmp as $type => $labels)
//      {
//          $output[] = array(
//              'short_name' => $type,
//              'detail' => $labels
//          );
//      }
//      return $output;
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}  
  }

	// SELECT PROJECT DATA BASED ON LIST SELECT 
	public function project_data_fetch($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $conn->prepare("
		SELECT projects.*, 
			   rep.fname AS repFname, 
			   rep.lname AS repLname, 
			   rep.email AS repEmail, 
			   clients.company AS clientCompany, 
			   clients.fname AS clientFname, 
			   clients.lname AS clientLname, 
			   clients.discount AS clientDiscount, 
			   clients.discount_quartz AS discount_quartz, 
			   clients.address1 AS cAdd1, 
			   clients.address2 AS cAdd2, 
			   clients.city AS cCity, 
			   clients.state AS cState, 
			   clients.zip AS cZip, 
			   clients.email AS cEmail, 
			   clients.phone AS cPhone 
		  FROM projects 
		  JOIN users rep 
		    ON rep.id = projects.acct_rep 
		  JOIN users clients 
		    ON projects.uid = clients.id 
		 WHERE projects.uid = " . $a['userID'] . " AND projects.id = " . $a['pjtID']);
		$q->execute();
		
		return $row = $q->fetchAll();
	}

	public function sum_sqft($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$q = $conn->prepare("SELECT SUM(SqFt) FROM installs WHERE pid = " . $a);
		$q->execute();

		return $row = $q->fetch();
	}

	public function sum_sinks($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$q = $conn->prepare("SELECT (SUM(cutout_price) + SUM(faucet_price) + SUM(sink_price))  as sinkTotal FROM install_sink WHERE sink_iid = " . $a['iid']);
		$q->execute();

		return $row = $q->fetch();
	}

	public function set_sinks_price($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE installs SET accs_prices = :accs_prices WHERE id = :iid");
		$q->bindParam('iid',$a['iid']);
		$q->bindParam('accs_prices',$a['accs_prices']);
		$q->execute();
	}

	public function sumPjtCost($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$x = $conn->prepare("SELECT (ROUND(SUM(install_price),2)) FROM installs WHERE pid = " . $a);
		$x->execute();

		return $row = $x->fetch();
	}

	// SELECT INSTALL DATA BASED ON LIST SELECT 
	public function install_data_fetch($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $conn->prepare("SELECT 
								installs.*, 
								holes.hole_name, 
								range_type.range_type AS rangeT, 
								edges.edge_name, 
								install_types.type_name, 
								install_types.type_cost 
							FROM installs 
							JOIN holes 
								ON holes.id = installs.holes 
							JOIN range_type 
								ON range_type.id = installs.range_type 
							JOIN edges 
								ON edges.id = installs.edge 
							JOIN install_types 
								ON install_types.type_id = installs.install_room 
							WHERE installs.id = " . $a['instID']);
		$q->execute();
		return $row = $q->fetchAll();
	}

	// SELECT ROOMS FOR INSTALL 
	public function get_rooms() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("SELECT * FROM install_types WHERE 1");
		$q->execute();
		return $row = $q->fetchAll();
	}

	// SELECT PIECE DATA BASED ON LIST SELECT 
	public function pieces_data_fetch($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("SELECT install_pieces.*, edges.edge_name FROM install_pieces JOIN edges ON edges.id = install_pieces.piece_edge WHERE install_pieces.iid = " . $a['instID'] . " ORDER BY install_pieces.piece_name");
		$q->execute();
		return $row = $q->fetchAll();
	}


	// SELECT ACCESSORIES DATA BASED ON LIST SELECT 
	public function sink_data_fetch($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$sql = "
			SELECT 	install_sink.*, 
					install_pieces.piece_name, 
					holes.hole_name,
					mounting.mount_name
			FROM install_sink 
			JOIN install_pieces 
				ON install_pieces.piece_id = install_sink.sink_part 
			JOIN holes 
				ON holes.id = install_sink.sink_holes 
			JOIN mounting 
				ON mounting.mount_id = install_sink.sink_mount 
			WHERE install_sink.sink_iid = " . $a['instID'] . "";
		$q = $conn->prepare($sql);
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function add_sink($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$sql='INSERT INTO install_sink (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
		foreach( $a as $field => $value ) $params[":{$field}"]=$value;
		$q = $conn->prepare($sql);
		$q->execute( $params );
	}

	public function update_sink($s,$id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE install_sink SET";
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE sink_id = $id";
			$q = $conn->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			$q->execute($s);
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function add_faucet($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$sql='INSERT INTO install_sink (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
		foreach( $a as $field => $value ) $params[":{$field}"]=$value;
		$q = $conn->prepare($sql);
		$q->execute( $params );


	}

	// SELECT ACCESSORIES DATA BASED ON LIST SELECT 
	public function get_pieces($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("SELECT * FROM install_pieces WHERE iid = " . $a['iid']);
		$q->execute();
		return $row = $q->fetchAll();
	}


	// SELECT INSTALL DATA BASED ON SEARCH CRITERIA 
	public function install_data_search($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$q = $conn->prepare("SELECT 
				installs.*, 
				edges.edge_name,
				install_types.type_name
			FROM installs 
			JOIN edges ON installs.edge = edges.id 
			JOIN install_types ON install_types.type_id = installs.install_room 
			WHERE installs.pid = " . $a['pjtID']);
//		$q = $conn->prepare("SELECT * FROM installs WHERE pid = " . $a['pjtID']);
		$q->execute();
		return $row = $q->fetchAll();
	}


	public function update_install($s,$pid,$mid) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE installs SET";
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $conn->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('pid',$s)) {
				$s['pid'] = $pid;
			}
			if (!in_array('iid',$s)) {
				$s['iid'] = $mid;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}


// CLIENT PROJECT ACTIONS

// GET LIST OF PROJECTS
	public function client_get_projects($uid) 
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("SELECT * FROM projects WHERE uid = :uid");
			$q->bindParam(':uid',$uid);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

	public function project_edit_data($id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$q = $conn->prepare("SELECT * FROM projects WHERE id = :id"); 
			$q->bindParam(':id',$id);
			$q->execute();
			//return $this->_uid = $q -> fetchAll();
			return $q->fetchall(PDO::FETCH_ASSOC);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function install_edit_data($id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$q = $conn->prepare("SELECT * FROM installs WHERE id = :id");
			$q->bindParam(':id',$id);
			$q->execute();
			return $this->_uid = $q -> fetchAll();

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
  
  public function mysql_escape($inp){ 
      if(is_array($inp)) return array_map(__METHOD__, $inp);
      
      if(!empty($inp) && is_string($inp)) { 
          return str_replace(array('\\', "\0", "\n", "\r", "'", '"', '`',"\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\`','\\Z'), $inp); 
      } 
      return $inp; 
    
  }

}
?>