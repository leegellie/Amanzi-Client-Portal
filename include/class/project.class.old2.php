<?
require_once(__DIR__ . '/../config.php');

class project_action
{
	private $_error;
	private $_message;
	private $_id;
	private $_parent_id;
	private $_uid;
	
	public function upload_img($a,$uid,$pid,$dir,$name)
	{
		$user_path =  base_dir . "images/projects/" . $uid;
		$path = base_dir . "images/projects/" . $uid . "/" . $pid;
		/*if ($dir != '0') {
			$path = $path . "/" . $dir;
		} */
		if (file_exists($user_path)) 
		{
			//user path already exists. do nothing
		}
		if (file_exists($path))
		{
			//echo "Project directory already exists.";
		} else 
		{
			mkdir($path,0755);
		}
		if ( ($dir == '0' ) || (file_exists($path . "/". $dir)) )
		{
			//Do nothing
		} else
		{
			$dirpath = $path = $path . "/" . $dir;
			mkdir($dirpath,0755);
		}
		
		$check = getimagesize($a["tmp_name"]);
		if($check !== false) 
		{
			$old_name = $a["name"];
			$ext = end((explode(".", $old_name)));
			$target_file = $path . "/" . $name . "." . $ext;
			if (move_uploaded_file($a["tmp_name"], $target_file)) 
			{
				//UPLOADED. SET MESSAGE TO RELATIVE IMAGE PAGTH
			
				$this->_message = "/images/projects/" . $uid . "/" . $pid;
				if ($dir != '0') {
					$this->_message = $this->_message . "/" . $dir;
				}
				$this->_message = $this->_message . "/" . $name . "." . $ext;
				
			} else 
			{
				$this->_message = "Sorry, there was an error uploading the image.";
			}
		} else 
		{
			$this->_message = "Image is not an image.";
		}
		return $this->_message;
	}
	
	public function reArray_files($arr) 
	{
    	foreach( $arr as $key => $all ){
 	       foreach( $all as $i => $val ){
 	           $new[$i][$key] = $val;    
  	      }    
 	   }
  	  return $new;
	}
	
	public function set_uid_from_pid($pid)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("SELECT uid FROM projects WHERE id = :pid"); 
				$q->bindParam(':pid',$pid);
				$q->execute();
				$this->_uid = $q -> fetch();
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function set_ids_from_fpid($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("SELECT a.uid, b.pid
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
	
	public function get_uid()
	{
		return $this->_uid;
	}
	
	public function add_project($a) 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO projects 
				(
				  uid, 
				  co_display_name, 
				  job_name, 
				  project_tagline, 
				  project_address, 
				  project_phone, 
				  project_fax, 
				  project_email, 
				  project_url, 
				  project_theme, 
				  isactive
				) 
				VALUES (
				  :uid, 
				  :co_display_name, 
				  :job_name, 
				  :project_tagline, 
				  :project_address, 
				  :project_phone, 
				  :project_fax, 
				  :project_email, 
				  :project_url, 
				  :project_theme, 
				  :isactive
				)");
			$q->execute($a);
			$this->_message = $dbh->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
	
	public function update_project($s,$id) 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE projects SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('id',$s))
			{
				$s['id'] = $id;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function insert_menu($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_menu 
				(
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
			$menu_id = $dbh->lastInsertId();
			$this->_message = $a['menu_title'] . "::" . $a['menu_type'] . "::" . $menu_id .  ",";
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
	public function insert_home($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_home 
				(
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
			$this->_message = $dbh->lastInsertId();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		return $this->_message;
	}
	public function update_home($s,$pid,$mid) 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE project_menu SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			if (!in_array('pid',$s))
			{
				$s['pid'] = $pid;
			}
			if (!in_array('mid',$s))
			{
				$s['mid'] = $mid;
			}
			$q->execute($s);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	public function insert_areamap($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_areamap 
				(
				  pid, 
				  mid, 
				  area_background, 
				  area_js, 
				  area_css
				) 
				VALUES (
				  :hiddenPID, 
				  :mid, 
				  :area_background, 
				  :area_js, 
				  :area_css 
				)");
			$q->bindParam(':hiddenPID',$a['hiddenPID']);
			$q->bindParam(':mid',$a['mid']);
			$q->bindParam(':area_background',$a['area_background']);
			$q->bindParam(':area_js',$a['area_js']);
			$q->bindParam(':area_css',$a['area_css']);
			$q->execute();
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
		//return $this->_message;
	}
	private function check_areamap_meta_duplicate($aid,$x,$y,$h,$w) {
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT count(id) FROM project_areamap_poi WHERE 
			areamap_id = :aid AND 
			poi_xcord = :x AND 
			poi_ycord = :y AND 
			poi_height = :h AND 
			poi_width = :w
			");
			$q->bindParam(':aid',$aid);
			$q->bindParam(':x',$x);
			$q->bindParam(':y',$y);
			$q->bindParam(':h',$h);
			$q->bindParam(':w',$w);
			$q->execute();
			$row = $q->fetch(PDO::FETCH_NUM);
			
			return $row[0];
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
		}
	}
	public function insert_area_poi($a)
	{
		$aid = $this->_id;
		$dupe_check = new project_action;
		if($dupe_check->check_areamap_meta_duplicate($this->_id,$a['cord_x'],$a['cord_y'],$a['svg_height'],$a['svg_width']) < 1) {
			try {
				$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
					$q = $dbh->prepare("INSERT INTO project_areamap_poi 
					(
					  areamap_id, 
					  poi_type, 
					  poi_xcord, 
					  poi_ycord, 
					  poi_height, 
					  poi_width, 
					  poi_map_link,
					  poi_image,
					  poi_icon,
					  poi_title, 
					  poi_address1,
					  poi_address2, 
					  poi_city, 
					  poi_state, 
					  poi_zip, 
					  poi_notes, 
					  poi_distance
					) 
					VALUES (
					  :areamap_id, 
					  :poi_type, 
					  :poi_xcord, 
					  :poi_ycord, 
					  :poi_height, 
					  :poi_width, 
					  :poi_map_link, 
					  :poi_image,
					  :poi_icon,
					  :poi_title, 
					  :poi_address1, 
					  :poi_address2, 
					  :poi_city, 
					  :poi_state, 
					  :poi_zip, 
					  :poi_notes, 
					  :poi_distance
					)");
				$q->bindParam(':areamap_id',$this->_id);
				$q->bindParam(':poi_type',$a['poi_type']);
				$q->bindParam(':poi_xcord',$a['cord_x']);
				$q->bindParam(':poi_ycord',$a['cord_y']);
				$q->bindParam(':poi_height',$a['svg_height']);
				$q->bindParam(':poi_width',$a['svg_width']);
				$q->bindParam(':poi_map_link',$a['internal_link']);
				$q->bindParam(':poi_image',$a['poi_image']);
				$q->bindParam(':poi_icon',$a['poi_icon']);
				$q->bindParam(':poi_title',$a['poi_title']);
				$q->bindParam(':poi_address1',$a['poi_address1']);
				$q->bindParam(':poi_address2',$a['poi_address2']);
				$q->bindParam(':poi_city',$a['poi_city']);
				$q->bindParam(':poi_state',$a['poi_state']);
				$q->bindParam(':poi_zip',$a['poi_zip']);
				$q->bindParam(':poi_notes',$a['poi_notes']);
				$q->bindParam(':poi_distance',$a['poi_distance']);
				$q->execute();
				return $dbh->lastInsertId();
			} catch(PDOException $e) {
				$this->_message = "ERROR: " . $e->getMessage();
			}
		}
	}
	public function insert_sitemap($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_sitemap 
				(
				  pid, 
				  mid, 
				  site_background, 
				  site_tag,
				  site_ticker,
				  site_js, 
				  site_css
				) 
				VALUES (
				  :hiddenPID, 
				  :mid, 
				  :site_background, 
				  :site_tag,
				  :site_ticker,
				  :site_js, 
				  :site_css 
				)");
			$q->bindParam(':hiddenPID',$a['hiddenPID']);
			$q->bindParam(':mid',$a['mid']);
			$q->bindParam(':site_background',$a['site_background']);
			$q->bindParam(':site_tag',$a['site_tag']);
			$q->bindParam(':site_ticker',$a['site_ticker']);
			$q->bindParam(':site_js',$a['site_js']);
			$q->bindParam(':site_css',$a['site_css']);
			$q->execute();
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	public function insert_sitemap_lots($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_sitemap_lots 
				(
				  pid, 
				  mid, 
				  lot_num, 
				  poly_point,
				  floorplan,
				  sqft, 
				  status,
				  status_other,
				  notes,
				  options,
				  reversed,
				  price
				) 
				VALUES (
				  :pid, 
				  :mid, 
				  :lot_num, 
				  :poly_point,
				  :floorplan,
				  :sqft, 
				  :status, 
				  :status_other, 
				  :notes, 
				  :options, 
				  :reversed, 
				  :price 
				)");
			$q->execute($a);
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	public function insert_floorplan($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_floorplans 
				(
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
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	
	public function insert_floorplan_details($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO installs  
				(
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
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function insert_custompage($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_pages  
				(
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
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_floorplan_ids($a) 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
			$q = $dbh->prepare("SELECT id,fp_floorplan_title FROM installs WHERE pid = :pid"); 
			$q->bindParam(':pid',$a);
			$q -> execute();
			return $q->fetchall(PDO::FETCH_NUM);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_floors($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_floors  
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
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function update_floors($a,$mid) 
	{
	/*	try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "UPDATE project_floors SET";			
			foreach($s as $key1 => $value1) {
				$sql .=" $key1 = :$key1 ,";
			}
			$sql = substr($sql, 0, -2);
			$sql .=" WHERE id = :id";
			$q = $dbh->prepare($sql);
			foreach($s as $key => $value) {
				$q->bindParam("$key",$value);
			}
			$q->execute($a);

		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		} */
	}
	
	public function add_elevations($a)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_elevations
  
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
			$this->_id = $dbh->lastInsertId();
			return $this->_id;
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_floor_alt($a) 
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("INSERT INTO project_elevations
  
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
			$this->_id = $dbh->lastInsertId();
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
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("SELECT * FROM projects WHERE uid = :uid");
			$q->bindParam(':uid',$uid);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}

// SELECT DATA TO BUILD A SITE	
	public function get_floorplan($a,$b)
	{
		try {
			$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
				$q = $dbh->prepare("SELECT * FROM installs WHERE " . $a . " = :b");
			$q->bindParam(':b',$b);
			$q->execute();
			return $q->fetchall(PDO::FETCH_ASSOC);
		} catch(PDOException $e) {
			return $this->_message = "ERROR: " . $e->getMessage();
		}
	}
}
?>