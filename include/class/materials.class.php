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
	
	// SELECT PROJECT BY QUOTE NUMBER OR ORDER NUMBER FROM SEARCH CRITERIA 
	public function get_materials_needed() {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$q = $conn->prepare("SELECT projects.*, status.name AS status FROM projects JOIN status ON status.id = projects.job_status WHERE projects.job_status > 11 AND projects.job_status < 50 AND isActive = 1 ORDER BY projects.install_date ASC");
		$q->execute();
		return $row = $q->fetchAll();
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

	public function ordered_material($a) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare("UPDATE installs SET assigned_material = :assigned_material, material_date = :material_date, material_status = :material_status WHERE id = :iid");
			$q->bindParam(':iid',$a['iid']);
			$q->bindParam(':assigned_material',$a['assigned_material']);
			$q->bindParam(':material_date',$a['material_date']);
			$q->bindParam(':material_status',$a['material_status']);
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
		$q = $conn->prepare("UPDATE projects SET job_status = 44 WHERE id = :pid");
		$q->bindParam(':pid',$a);
		$q->execute();
	}


}

?>