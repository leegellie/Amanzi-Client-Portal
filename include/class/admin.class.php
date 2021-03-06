<?PHP
if(!session_id()) session_start();
require_once(__DIR__ . '/../config.php');

class log_action {

	public function pjt_changes($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $conn->prepare("INSERT INTO comments (cmt_ref_id, cmt_type, cmt_user, cmt_comment, cmt_priority) VALUES (:cmt_ref_id, :cmt_type, :cmt_user, :cmt_comment, :cmt_priority)");
		$q->bindParam('cmt_ref_id',$a['cmt_ref_id']);
		$q->bindParam('cmt_type',$a['cmt_type']);
		$q->bindParam('cmt_user',$a['cmt_user']);
		$q->bindParam('cmt_comment',$a['cmt_comment']);
		$q->bindParam('cmt_priority',$a['cmt_priority']);
		$q->execute();
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

		$q = $conn->prepare("SELECT price_extra, cpSqFt, SqFt, install_discount FROM installs WHERE id = :iid");
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
		}

		
		$finalPrice = ($matPrice + $price_extra + $sinkPrice) - $install_discount;
		if ($finalPrice < 1) {
			$finalPrice = 0.00;
		}

		$f = $conn->prepare("UPDATE installs SET install_price = :install_price, accs_prices = :accs_prices, SqFt = :SqFt, price_calc = :price_calc WHERE id = :id");
		$f->bindParam('id',$a['iid']);
		$f->bindParam('price_calc',$matPrice);
		$f->bindParam('accs_prices',$sinkPrice);
		$f->bindParam('SqFt',$sumSqFt);
		$f->bindParam('install_price',$finalPrice);
		$f->execute();

	}

	public function get_edges() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM edges WHERE 1");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}

	public function get_accs($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM accessories WHERE accs_code = :accs_code");
		$q->bindParam('accs_code',$a);
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





















	public function set_entry($pid,$entry) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE projects SET entry = :entry WHERE id = :pid";
		$q = $conn->prepare($sql);
		$q->bindParam('pid',$pid);
		$q->bindParam('entry',$entry);
		$q->execute();
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

	public function update_job_status($a) {
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
		$q = $conn->prepare("SELECT * FROM marbgran WHERE 1");
		$q->execute();
		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
	}


	public function get_quartz() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT quartz2.id, quartz2.name, quartz2.price_2, quartz2.price_3, quartz2.notes, quartz2.image, category.price_3 AS cat_price FROM quartz2 JOIN category ON quartz2.cat_id = category.id WHERE 1 ORDER BY quartz2.name");
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

	public function add_project($a) {
    try {
      $a['job_name'] = $this->mysql_escape($a['job_name']);
      $a['job_notes'] = $this->mysql_escape($a['job_notes']);
      $a['acct_rep'] = $this->mysql_escape($a['acct_rep']);
      $a['builder'] = $this->mysql_escape($a['builder']);
      $a['address_1'] = $this->mysql_escape($a['address_1']);
      $a['address_2'] = $this->mysql_escape($a['address_2']);
      $a['city'] = $this->mysql_escape($a['city']);
      $a['state'] = $this->mysql_escape($a['state']);
      $a['contact_name'] = $this->mysql_escape($a['contact_name']);
      
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$q = $conn->prepare("INSERT INTO projects (
					uid,
					job_name,
					acct_rep,
					builder,
					quote_num,
					order_num,
					install_date,
					template_date,
					po_cost,
					po_num,
					contact_name,
					contact_number,
					contact_email,
					alternate_name,
					alternate_number,
					alternate_email,
					address_1,
					address_2,
					city,
					state,
					zip,
					job_notes,
					isActive,
					urgent,
					tax_free,
					job_tax,
					am,
					first_stop,
					pm,
					temp_am,
					temp_first_stop,
					temp_pm,
					job_discount
				)
				VALUES (
					:uid,
					:job_name,
					:acct_rep,
					:builder,
					:quote_num,
					:order_num,
					:install_date,
					:template_date,
					:po_cost,
					:po_num,
					:contact_name,
					:contact_number,
					:contact_email,
					:alternate_name,
					:alternate_number,
					:alternate_email,
					:address_1,
					:address_2,
					:city,
					:state,
					:zip,
					:job_notes,
					:isActive,
					:urgent,
					:tax_free,
					:job_tax,
					:am,
					:first_stop,
					:pm,
					:temp_am,
					:temp_first_stop,
					:temp_pm,
					:job_discount
				)");
			$q->execute($a);
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

			$q = $conn->prepare("INSERT INTO installs (
				pid,
				cpSqFt,
				install_room,
				install_name,
				type,
				tear_out,
				material,
				color,
				lot,
				selected,
				edge,
				bs_detail,
				rs_detail,
				sk_detail,
				range_type,
				cutout,
				range_model,
				holes,
				holes_other,
				install_notes,
				SqFt,
				price_extra,
				price_calc
			) 
			VALUES (
				:pid,
				:cpSqFt,
				:install_room,
				:install_name,
				:type,
				:tear_out,
				:material,
				:color,
				:lot,
				:selected,
				:edge,
				:bs_detail,
				:rs_detail,
				:sk_detail,
				:range_type,
				:cutout,
				:range_model,
				:holes,
				:holes_other,
				:install_notes,
				:SqFt,
				:price_extra,
				:price_calc
			)");
			$q->execute($a);
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
	public function get_templates() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT 	projects.*, 
					status.name AS status, 
					template_teams.temp_team_name AS team 
			FROM projects 
			JOIN status 
				ON status.id = projects.job_status 
			JOIN template_teams 
				ON template_teams.temp_team_id = projects.template_team 
			WHERE template_date >= CURDATE() 
				AND template_date < '2200-01-01' 
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

	// SELECT PROJECT LIST BASED ON USER CRITERIA 
	public function get_installs() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "
			SELECT 
				projects.*, 
				status.name AS status, 
				install_teams.inst_team_name AS team 
			FROM projects 
			JOIN status 
				ON status.id = projects.job_status 
			JOIN install_teams 
				ON install_teams.inst_team_id = projects.install_team 
			WHERE 
				install_date >= CURDATE() 
			AND 
				install_date < '2200-01-01' 
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



	// SELECT PROJECT DATA BASED ON LIST SELECT 
	public function project_data_fetch($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		$q = $conn->prepare("SELECT projects.*, rep.fname AS repFname, rep.lname AS repLname, rep.email AS repEmail, clients.company AS clientCompany, clients.fname AS clientFname, clients.lname AS clientLname, clients.discount AS clientDiscount, clients.address1 AS cAdd1, clients.address2 AS cAdd2, clients.city AS cCity, clients.state AS cState, clients.zip AS cZip, clients.email AS cEmail, clients.phone AS cPhone FROM projects JOIN users rep ON rep.id = projects.acct_rep JOIN users clients ON projects.uid = clients.id WHERE projects.uid = " . $a['userID'] . " AND projects.id = " . $a['pjtID']);
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


//	// SELECT ACCESSORIES DATA BASED ON LIST SELECT 
//	public function sink_data_fetch($a) {
//		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
//		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
//		$sql = "
//			SELECT 	install_sink.*, 
//					install_pieces.piece_name, 
//					accessories.accs_code, 
//					accessories.accs_model, 
//					accessories.accs_name, 
//					holes.hole_name,
//					mounting.mount_name
//			FROM install_sink 
//			JOIN install_pieces 
//				ON install_pieces.piece_id = install_sink.sink_part 
//			JOIN accessories 
//				ON accessories.accs_id = install_sink.sink_model 
//			JOIN holes 
//				ON holes.id = install_sink.sink_holes 
//			JOIN mounting 
//				ON mounting.mount_id = install_sink.sink_mount 
//			WHERE install_sink.sink_iid = " . $a['instID'] . "
//			UNION
//			SELECT 	install_sink.*, 
//					install_pieces.piece_name, 
//					accessories.accs_code, 
//					accessories.accs_model, 
//					accessories.accs_name, 
//					holes.hole_name,
//					mounting.mount_name
//			FROM install_sink 
//			JOIN install_pieces 
//				ON install_pieces.piece_id = install_sink.sink_part 
//			JOIN accessories 
//				ON accessories.accs_id = install_sink.sink_faucet 
//			JOIN holes 
//				ON holes.id = install_sink.sink_holes 
//			JOIN mounting 
//				ON mounting.mount_id = install_sink.sink_mount 
//			WHERE install_sink.sink_iid = " . $a['instID'] . "
//			ORDER BY piece_name";
//
//		$q = $conn->prepare($sql);
//		$q->execute();
//		return $row = $q->fetchAll(PDO::FETCH_ASSOC);
//	}


	public function add_sink($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("INSERT INTO install_sink (
					 sink_iid,
					 sink_part,
					 sink_provided,
					 sink_model,
					 sink_mount,
					 sink_holes,
					 sink_holes_other,
					 sink_soap,
					 cutout_width,
					 cutout_depth,
					 sink_price,
					 cutout_price,
					 sink_cost,
					 sink_name
			) 
			VALUES (
					 :sink_iid,
					 :sink_part,
					 :sink_provided,
					 :sink_model,
					 :sink_mount,
					 :sink_holes,
					 :sink_holes_other,
					 :sink_soap,
					 :cutout_width,
					 :cutout_depth,
					 :sink_price,
					 :cutout_price,
					 :sink_cost,
					 :sink_name
			)");
		$q->bindParam('sink_iid',$a['sink_iid']);
		$q->bindParam('sink_part',$a['sink_part']);
		$q->bindParam('sink_provided',$a['sink_provided']);
		$q->bindParam('sink_model',$a['sink_model']);
		$q->bindParam('sink_mount',$a['sink_mount']);
		$q->bindParam('sink_holes',$a['sink_holes']);
		$q->bindParam('sink_holes_other',$a['sink_holes_other']);
		$q->bindParam('sink_soap',$a['sink_soap']);
		$q->bindParam('cutout_width',$a['cutout_width']);
		$q->bindParam('cutout_depth',$a['cutout_depth']);
		$q->bindParam('sink_price',$a['sink_price']);
		$q->bindParam('cutout_price',$a['cutout_price']);
		$q->bindParam('sink_cost',$a['sink_cost']);
		$q->bindParam('sink_name',$a['sink_name']);
		$q->execute();
	}

	public function add_faucet($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("INSERT INTO install_sink (
					 sink_iid,
					 sink_part,
					 sink_provided,
					 sink_faucet,
					 faucet_price,
					 faucet_cost,
					 faucet_name,
					 sink_model,
					 sink_mount
			) 
			VALUES (
					 :sink_iid,
					 :sink_part,
					 :sink_provided,
					 :sink_faucet,
					 :faucet_price,
					 :faucet_cost,
					 :faucet_name,
					 0,
					 0
			)");
		$q->bindParam('sink_iid',$a['sink_iid']);
		$q->bindParam('sink_part',$a['sink_part']);
		$q->bindParam('sink_provided',$a['sink_provided']);
		$q->bindParam('sink_faucet',$a['sink_faucet']);
		$q->bindParam('faucet_price',$a['faucet_price']);
		$q->bindParam('faucet_cost',$a['faucet_cost']);
		$q->bindParam('faucet_name',$a['faucet_name']);
		$q->execute();
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


	public function insert_floorplan($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$q = $conn->prepare("INSERT INTO project_floorplans (
				pid, 
				mid, 
				floorp_tag, 
				floorp_ticker,
				floorp_js, 
				floorp_css
			) 
			VALUES (
				:pid, 
				:mid, 
				:floorp_tag, 
				:floorp_ticker,
				:floorp_js,
				:floorp_css 
			)");
			$q->bindParam(':pid',$a['hiddenPID']);
			$q->bindParam(':mid',$a['mid']);
			$q->bindParam(':floorp_tag',$a['floorp_tag']);
			$q->bindParam(':floorp_ticker',$a['floorp_ticker']);
			$q->bindParam(':floorp_js',$a['floorp_js']);
			$q->bindParam(':floorp_css',$a['floorp_css']);
			$q->execute();
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

	public function insert_floorplan_details($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("INSERT INTO installs (
				pid,
				mid,
				fp_floorplan_image,
				fp_floorplan_title,
				fp_floorplan_beds, 
				fp_floorplan_baths,
				fp_floorplan_sqft,
				fp_floorplan_price,
				active
			) 
			VALUES (
				:pid, 
				:mid, 
				:fp_floorplan_image, 
				:fp_floorplan_title,
				:fp_floorplan_beds,
				:fp_floorplan_baths, 
				:fp_floorplan_sqft, 
				:fp_floorplan_price, 
				:active 
			)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

	public function insert_custompage($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $conn->prepare("INSERT INTO project_pages (
				pid, 
				mid, 
				external_link,
				custom_title,
				page_js, 
				page_css,
				page_background,
				page_html,
				hide,
				isActive
			) 
			VALUES (
				:pid, 
				:mid, 
				:external_link, 
				:custom_title,
				:page_js,
				:page_css, 
				:page_background, 
				:page_html, 
				:hide,
				:isActive
			)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}




	
	public function get_floorplan_ids($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $conn->prepare("SELECT id,fp_floorplan_title FROM installs WHERE pid = :pid"); 
			$q->bindParam(':pid',$a);
			$q -> execute();
			return $q->fetchall(PDO::FETCH_NUM);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_floors($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("INSERT INTO project_floors  
				(
				  fdid, 
				  floor_title, 
				  floor_base_image, 
				  floor_reversed_image
				) 
				VALUES (
				  :fpid, 
				  :floor_title,
				  :floor_base_image,
				  :floor_reversed_image 
				)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}



	public function update_floors($a,$mid) {
	/*	try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE project_floors SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $conn->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			$q->execute($a);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		} */
	}
	
	// GET FLOOR DATA
	public function get_floors($a) 
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $conn->prepare("SELECT * FROM project_floors WHERE fdid = :pid"); 
			$q->bindParam(':pid',$a);
			$q -> execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_elevations($a)
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("INSERT INTO project_elevations
  
				(
				  fdid, 
				  elev_title, 
				  elev_image
				) 
				VALUES (
				  :fpid, 
				  :elev_title,
				  :elev_image
				)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_floor_alt($a) 
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("INSERT INTO project_elevations
  
				(
				  fdid, 
				  fdid, 
				  eid,
				  floor_img_alt,
				  floor_img_revalt
				) 
				VALUES (
				  :fpid, 
				  :eid,
				  :elev_fp_image,
				  :elev_fpr_image
				)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	public function add_styles($a)
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("INSERT INTO project_styles
				(
				  fdid, 
				  elevation_id, 
				  style_img,
				  style_title
				) 
				VALUES (
				  :fdid, 
				  :elevation_id, 
				  :style_img,
				  :style_title
				)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	public function add_options($a)
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("INSERT INTO project_options 
				(
				  fdid, 
				  option_title, 
				  option_image,
				  option_button
				) 
				VALUES (
				  :fdid, 
				  :option_title, 
				  :option_image,
				  :option_button
				)");
			$q->execute($a);
			$this->_id = $conn->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
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


// SELECT DATA TO BUILD A SITE	
	public function get_floorplan($a,$b)
	{
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $conn->prepare("SELECT * FROM installs WHERE " . $a . " = :b");
			$q->bindParam(':b',$b);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
  
  public function mysql_escape($inp){ 
    if(is_array($inp)) return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
  }
}
?>