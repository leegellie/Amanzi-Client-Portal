<?PHP
if(!session_id()) session_start();
require_once(__DIR__ . '/../config.php');

class materials_action {

	public function add_marble($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("INSERT INTO marbgran (name, price_1, price_2, price_3, price_4, price_5, price_6, price_7, notes) VALUES (:name, :price_1, :price_2, :price_3, :price_4, :price_5, :price_6, :price_7, :notes)");
		$q->bindParam(':name',$a['name']);
		$q->bindParam(':price_1',$a['price_1']);
		$q->bindParam(':price_2',$a['price_2']);
		$q->bindParam(':price_3',$a['price_3']);
		$q->bindParam(':price_4',$a['price_4']);
		$q->bindParam(':price_5',$a['price_5']);
		$q->bindParam(':price_6',$a['price_6']);
		$q->bindParam(':price_7',$a['price_7']);
		$q->bindParam(':notes',$a['notes']);
		$q->execute();
	}

	public function delete_marble($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("DELETE FROM marbgran WHERE id = :id");
		$q->bindParam(':id',$a['id']);
		$q->execute();
	}

	public function update_marble($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
		UPDATE marbgran 
		   SET `name` = :mname, 
		       price_0 = :price_0, 
			   price_1 = :price_1, 
			   price_2 = :price_2, 
			   price_3 = :price_3, 
			   price_4 = :price_4, 
			   price_5 = :price_5, 
			   price_6 = :price_6, 
			   price_7 = :price_7, 
			   notes = :notes 
		 WHERE id = :id
		 ");
		$q->bindParam(':id',$a['mid']);
		$q->bindParam(':mname',$a['mname']);
		$q->bindParam(':price_0',$a['price_0']);
		$q->bindParam(':price_1',$a['price_1']);
		$q->bindParam(':price_2',$a['price_2']);
		$q->bindParam(':price_3',$a['price_3']);
		$q->bindParam(':price_4',$a['price_4']);
		$q->bindParam(':price_5',$a['price_5']);
		$q->bindParam(':price_6',$a['price_6']);
		$q->bindParam(':price_7',$a['price_7']);
		$q->bindParam(':notes',$a['notes']);
		$q->execute();
	}

	public function add_quartz($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("INSERT INTO quartz2 (name, slab_cost, slab_sqft, price_3, quartz_height, quartz_width, cat_id, notes, status) VALUES (:name, :slab_cost, :slab_sqft, :price_3, :quartz_height, :quartz_width, :cat_id, :notes, 1)");
		$q->bindParam(':name',$a['name']);
		$q->bindParam(':slab_cost',$a['slab_cost']);
		$q->bindParam(':slab_sqft',$a['slab_sqft']);
		$q->bindParam(':price_3',$a['price_3']);
		$q->bindParam(':quartz_height',$a['quartz_height']);
		$q->bindParam(':quartz_width',$a['quartz_width']);
		$q->bindParam(':cat_id',$a['cat_id']);
		$q->bindParam(':notes',$a['notes']);
		$q->execute();
	}

	public function delete_quartz($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("DELETE FROM quartz2 WHERE id = :id");
		$q->bindParam(':id',$a['id']);
		$q->execute();
	}

	public function update_quartz($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
		UPDATE quartz2 
		   SET `name` = :mname, 
		       slab_cost = :slab_cost, 
			   slab_sqft = :slab_sqft, 
			   cat_id = :cat_id, 
			   price_3 = :price_3, 
			   quartz_height = :quartz_height, 
			   quartz_width = :quartz_width, 
			   notes = :notes 
		 WHERE id = :id
		 ");
		$q->bindParam(':id',$a['mid']);
		$q->bindParam(':mname',$a['mname']);
		$q->bindParam(':slab_cost',$a['slab_cost']);
		$q->bindParam(':slab_sqft',$a['slab_sqft']);
		$q->bindParam(':cat_id',$a['cat_id']);
		$q->bindParam(':price_3',$a['price_3']);
		$q->bindParam(':quartz_height',$a['quartz_height']);
		$q->bindParam(':quartz_width',$a['quartz_width']);
		$q->bindParam(':notes',$a['notes']);
		$q->execute();
	}


	public function add_accs($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql='INSERT INTO accessories (`'.implode( '`,`', array_keys( $a ) ) .'`) values (:'.implode(',:',array_keys( $a ) ).');';
			foreach( $a as $field => $value ) $params[":{$field}"]=$value;
			$q = $conn->prepare($sql);
			$q->execute( $params );
			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function delete_accs($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("DELETE FROM accessories WHERE accs_id = :accs_id");
		$q->bindParam(':accs_id',$a['accs_id']);
		$q->execute();
	}

	public function update_accs($a,$id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE accessories SET";
			foreach($a as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE accs_id = $id";
			$q = $conn->prepare($sql);
			foreach($a as $key => $value) {
				$q->bindParam("$key",$value);
			}
			$q->execute($a);
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}


	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_materials_needed() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
			SELECT projects.*, 
				   status.name AS status 
			  FROM projects 
			  JOIN status 
				ON status.id = projects.job_status 
			 WHERE projects.job_status > 11 
			   AND projects.job_status < 50 
			   AND (!(install_date = '2200-01-01' AND template_date = '2200-01-01') OR projects.pre_order = 1)
			   AND isActive = 1 
		  ORDER BY projects.install_date ASC
		  ");
		$q->execute();
		return $row = $q->fetchAll();
	}

	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_accessories_needed() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
			SELECT *, 
					 status.name AS status
				FROM projects 
				JOIN status ON status.id = projects.job_status 
				JOIN installs ON installs.pid = projects.id 
				JOIN install_sink ON install_sink.sink_iid = installs.id 
			   WHERE ( (pre_order = 1
				 AND projects.job_status < 50 
				 AND projects.job_status <> 44 )
			   OR
			   (projects.job_status > 24 
				 AND projects.job_status < 50 
				 AND projects.job_status <> 44 
				 AND isActive = 1 
			ORDER BY projects.install_date ASC
		");
		$q->execute();
		return $row = $q->fetchAll();
	}

	//SELECT ACCESSORIES BY "TODAY" AND "TOMORROW"(ACTUALLY, NEXT BUSINESS DAY)
	public function get_accessories_ttday() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		$q = $conn->prepare("
	  	 SELECT install_sink.*, 
				projects.* 
		   FROM projects
		   JOIN installs ON projects.id = installs.pid
		   JOIN install_sink on install_sink.sink_iid = installs.id
		  WHERE install_date >= CURDATE() 
			AND !(install_date = '2200-01-01')
			AND job_status > 24
			AND install_sink.pull_status = 0
			AND sink_onsite = 0 
	   ORDER BY install_date ASC,
	   			sink_name ASC,
				faucet_name ASC
		 ");
		$q->execute();
		return $row = $q->fetchAll();
	}

	//SELECT MATERIAL FOR PURCHASE
	public function get_po_mats_needed() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		$q = $conn->prepare("
	  	 SELECT SUM(slabs) AS slab_count, color, job_status
		   FROM installs
		   JOIN projects ON projects.id = installs.pid
		  WHERE install_date >= CURDATE() 
			AND ((!(install_date = '2200-01-01') AND job_status > 24) OR pre_order = 1)
			AND installs.material_status < 2
			AND installs.color > ''
			AND remnant = 0
			AND mat_hold = 0
            GROUP BY color
	   ORDER BY slab_count DESC, color 
		 ");
		$q->execute();
		return $row = $q->fetchAll();
	}

	//SELECT MATERIAL FOR PURCHASE
	public function get_po_mats_jobs($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		$sql = '
	  	 SELECT lot, order_num, pid, projects.uid, profit, installs.id AS iid, install_name, job_status
		   FROM installs
		   JOIN projects ON projects.id = installs.pid
		  WHERE color LIKE "' . $a . '"
			AND install_date >= CURDATE() 
			AND ((!(install_date = "2200-01-01") AND job_status > 24) OR pre_order = 1)
			AND installs.material_status < 2
			AND installs.color > ""
			AND remnant = 0
			AND mat_hold = 0
       GROUP BY order_num, lot 
	   ORDER BY installs.color, order_num, lot, profit
		 ';
		$q = $conn->prepare($sql);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function update_pullstatus($a){
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("UPDATE install_sink SET pull_status = 2 WHERE sink_id IN (".$a.")");
			//       $q->bindParam(':iid', $a);
			$q->execute();
			$this->_message = "SUCCESS";
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
  
	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_install_materials($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT * FROM installs WHERE pid = :pid");
		$q->bindParam(':pid',$a);
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_materials() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
			SELECT *, 
				     status.name AS status
      FROM projects 
      JOIN status ON status.id = projects.job_status 
      JOIN installs ON installs.pid = projects.id
      WHERE ((pre_order = 1 
        AND projects.job_status < 50 
        AND projects.job_status <> 44)
	  OR (projects.job_status > 23 
        AND projects.job_status < 50 
        AND projects.job_status <> 44 
        AND !(install_date = '2200-01-01' AND template_date = '2200-01-01')))
        AND isActive = 1 
      ORDER BY projects.install_date ASC
		  ");
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_accessories() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("
			SELECT *, 
					 status.name AS status
				FROM projects 
				JOIN status ON status.id = projects.job_status 
				JOIN installs ON installs.pid = projects.id 
				JOIN install_sink ON install_sink.sink_iid = installs.id 
			   WHERE ( (pre_order = 1
				 AND projects.job_status < 50 
				 AND projects.job_status <> 44 )
			   OR
			   (projects.job_status > 24 
				 AND projects.job_status < 50 
				 AND projects.job_status <> 44 
				 AND !(install_date = '2200-01-01' AND template_date = '2200-01-01')))
				 AND isActive = 1 
			ORDER BY projects.install_date ASC
		");
		$q->execute();
		return $row = $q->fetchAll();
	}

	public function get_pull_list() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("
				SELECT *,
					   status.name AS status
				  FROM projects 
				  JOIN status ON status.id = projects.job_status 
				  JOIN (	SELECT pid, color, lot, mat_hold, assigned_material, material_status, SUM(slabs) AS mat_slabs
							  FROM installs 
						  GROUP BY pid, color, lot, mat_hold, assigned_material, material_status,slabs) 
					AS materials
					ON materials.pid = projects.id
				 WHERE projects.job_status > 11 
				   AND projects.job_status < 50 
				   AND projects.job_status <> 44
				   AND !(projects.install_date = '2200-01-01' AND projects.template_date = '2200-01-01')
				   AND projects.isActive = 1 
			  ORDER BY projects.install_date ASC,
                 projects.first_stop DESC,
                 projects.am DESC,
                 projects.pm DESC
				");
			$q->execute();
			return $row = $q->fetchAll();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function ordered_material($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("UPDATE installs SET assigned_material = :assigned_material, material_date = :material_date, material_status = :material_status WHERE id = :iid");
			$q->bindParam(':iid', $a['iid']);
			$q->bindParam(':assigned_material', $a['assigned_material']);
			$q->bindParam(':material_date', $a['material_date']);
			$q->bindParam(':material_status', $a['material_status']);
			$q->execute();
			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function assign_material($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE installs SET assigned_material = :assigned_material, material_status = :material_status WHERE id = :iid");
		$q->bindParam(':iid',$a['iid']);
		$q->bindParam(':assigned_material',$a['assigned_material']);
		$q->bindParam(':material_status',$a['material_status']);
		$q->execute();
	}

	public function ordered_material_bulk($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE installs SET assigned_material = '" . $a['assigned_material'] . "', material_date = '" . $a['material_date'] . "', material_status = " . $a['material_status'] . " WHERE pid IN (" . $a['pids'] . ') AND color LIKE "' . $a['material_color'] . '" AND remnant = 0';
			$q = $conn->prepare($sql);
			$q->execute();
			$this->_message = "SUCCESS";
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function assign_material_bulk($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE installs SET assigned_material = '" . $a['assigned_material'] . "', material_status = " . $a['material_status'] . " WHERE pid IN (" . $a['pids'] . ') AND color LIKE "' . $a['material_color'] . '" AND remnant = 0';
      var_dump($sql);
			$q = $conn->prepare($sql);
			$q->execute();
			$this->_message = "SUCCESS";
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function no_material($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE installs SET material_status = :material_status WHERE id = :iid");
		$q->bindParam(':iid',$a['iid']);
		$q->bindParam(':material_status',$a['material_status']);
		$q->execute();
	}

	public function material_delivered($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE projects SET job_status = 44, mat_ready = 1 WHERE id = :pid");
		$q->bindParam(':pid',$a);
		$q->execute();
	}

	public function material_delivered_prog($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE projects SET mat_ready = 1 WHERE id = :pid");
		$q->bindParam(':pid',$a);
		$q->execute();
	}

	public function material_selected($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE projects SET mat_selected = 1 WHERE id = :pid");
		$q->bindParam(':pid',$a);
		$q->execute();
	}

	public function material_reset($a) { 
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("UPDATE installs SET material_status = 1 WHERE id = :id"); 
		$q->bindParam(':id',$a['iid']); 
		$q->execute(); 
	}

// SINKS

	public function ordered_sink($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("UPDATE install_sink SET assigned_sink = :assigned_sink, sink_date = :sink_date, sink_status = :sink_status WHERE sink_id = :sink_id");
			$q->bindParam(':sink_id', $a['sink_id']);
			$q->bindParam(':assigned_sink', $a['assigned_sink']);
			$q->bindParam(':sink_date', $a['sink_date']);
			$q->bindParam(':sink_status', $a['sink_status']);
			$q->execute();
			$this->_message = $conn->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}

	public function assign_sink($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE install_sink SET assigned_sink = :assigned_sink, sink_status = :sink_status WHERE sink_id = :sink_id");
		$q->bindParam(':sink_id',$a['sink_id']);
		$q->bindParam(':assigned_sink',$a['assigned_sink']);
		$q->bindParam(':sink_status',$a['sink_status']);
		$q->execute();
	}

	public function no_sink($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE install_sink SET sink_status = :sink_status WHERE sink_id = :sink_id");
		$q->bindParam(':sink_id',$a['sink_id']);
		$q->bindParam(':sink_status',$a['sink_status']);
		$q->execute();
	}

	public function sink_selected($a) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("UPDATE install_sink SET sink_selected = 1 WHERE sink_id = :sink_id");
		$q->bindParam(':sink_id',$a);
		$q->execute();
	}

	public function sink_reset($a) { 
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password); 
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		$q = $conn->prepare("UPDATE install_sink SET sink_status = 1 WHERE sink_id = :sink_id"); 
		$q->bindParam(':sink_id',$a['sink_id']); 
		$q->execute(); 
	}

}

?>