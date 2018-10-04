<?PHP
if(!session_id()) session_start();
require_once(__DIR__ . '/../config.php');

class inventory_manager_action {

	public function get_categories() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT *, type_name, 
			(select count(*) from inventory_items where inventory_items.category_id = inventory_categories.id_key and inventory_items.remnant = 0) as inventory, 
			(select count(*) from inventory_items where inventory_items.category_id = inventory_categories.id_key and inventory_items.remnant = 1) as remnant_inventory, 
			(SELECT count(*) as rr FROM inventory_tied inv LEFT JOIN (SELECT remnant, item_id FROM inventory_items) b ON b.item_id = inv.tie_item_id where (remnant = 0 or tie_item_id is null) and inv.tie_category = inventory_categories.id_key GROUP BY inv.tie_category) as Requested,
			(select company from users where users.id = inventory_categories.prefered_vendor and users.access_level = 20) as company 
			FROM `inventory_categories` 
			LEFT JOIN `inventory_cat_type` on `inventory_cat_type`.`type_id` = `inventory_categories`.`category_type` 
			where inventory_categories.active = 1 ORDER BY category_name';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_requested($cat_id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT COUNT(*) as Requested FROM inventory_tied JOIN inventory_items ON tie_item_id = item_id WHERE  inventory_tied.tie_category = "'.$cat_id.'" AND tie_item_id > 1 AND tie_status < 6 AND inventory_items.remnant = 0';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function getItems_byCatID($cat_id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'select inventory_items.*,users.username,projects.id,projects.uid, projects.order_num from inventory_items left join users on users.id = inventory_items.supplier left join inventory_tied on inventory_items.item_id = inventory_tied.tie_item_id left join projects on projects.id = inventory_tied.tie_pid where category_id = "'.$cat_id.'";';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_category_types(){
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'select * from inventory_cat_type order by type_name';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_all_purchases() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * FROM purchases
							JOIN suppliers on purchases.SupplierId = suppliers.id
							JOIN products on purchases.ProductId = products.id
							ORDER BY purchases.PurchaseDate';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_orders() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * FROM orders
							JOIN products on orders.ProductId = products.id
							ORDER BY orders.OrderDate ASC';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_category($a) {
		try {
			// save images ?
			
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('INSERT INTO `inventory_categories`
			(`category_id`,`category_type`, `category_name`, `min_req`, `reorder_amt`, `cost`, `price`, `prefered_vendor`, `lead_time`, `image`, `template`, `active`) 
			VALUES ("'.$a['category_id'].'",'.$a['category_type'].',"'.$a['category_name'].'",'.$a['min_req'].','.$a['reorder_amt'].','.$a['cost'].','.$a['price'].',"'.$a['prefered_vendor'].'",'.$a['lead_time'].',"'.$a['image'].'","'.$a['template'].'",1)');
		$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function add_category_type($cat_type) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('INSERT INTO `inventory_cat_type`	(`type_name`) VALUES ("'.$cat_type['type_name'].'")');
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function update_category_type($cat_type) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('UPDATE `inventory_cat_type`	SET `type_name` = "'.$cat_type['type_name'].'" WHERE type_id = '.$cat_type['type_id']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function get_itemCount_with_type($cat_type) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('SELECT count(*)as num FROM `inventory_items` LEFT JOIN `inventory_categories` on inventory_items.category_id = inventory_categories.id_key Left join `inventory_cat_type` on inventory_categories.category_type = inventory_cat_type.type_id where inventory_cat_type.type_id = '.$cat_type['type_id'].' group by inventory_cat_type.type_id');
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			if(isset($row[0]['num']))
			{
				return $row[0]['num'];
			}
			else 
			{
				return 0;
			}
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
	public function get_itemCount_with_category($cat_id) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('SELECT count(*)as num 
			FROM `inventory_items` 
			LEFT JOIN `inventory_categories` on inventory_items.category_id = inventory_categories.id_key 
			where inventory_items.category_id = "'.$cat_id['category_id'].'" 
			group by inventory_items.category_id ');
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			if(isset($row[0]['num']))
			{
				return $row[0]['num'];
			}
			else 
			{
				return 0;
			}
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
	public function del_cat_type($id) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$s = $conn->prepare("DELETE FROM inventory_cat_type WHERE type_id = :id");
		$s->bindParam('id',$id);
		$s->execute();
	}
	
	public function del_inventory($id) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$s = $conn->prepare("DELETE FROM inventory_categories WHERE category_id = :id");
		$s->bindParam('id',$id);
		$s->execute();
	}
	
	public function del_item_inventoy($id) {
		$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$s = $conn->prepare("DELETE FROM inventory_items WHERE item_id = :id");
		$s->bindParam('id',$id);
		$s->execute();
	}
	
	public function update_category($a) {
		try {
			
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$q = $conn->prepare("UPDATE inventory_categories SET category_id = :category_id,category_type = :category_type,category_name = :category_name, min_req = :min_req, reorder_amt = :reorder_amt, cost = :cost, price = :price, prefered_vendor = :prefered_vendor, lead_time = :lead_time,image = :image, template = :template  WHERE category_id = :ori_id");
			$q->bindParam('category_id',$a['category_id']);
			$q->bindParam('category_type',$a['category_type']);
			$q->bindParam('category_name',$a['category_name']);
			$q->bindParam('min_req',$a['min_req']);
			$q->bindParam('reorder_amt',$a['reorder_amt']);
			$q->bindParam('cost',$a['cost']);
			$q->bindParam('price',$a['price']);
			$q->bindParam('prefered_vendor',$a['prefered_vendor']);
			$q->bindParam('lead_time',$a['lead_time']);
			$q->bindParam('image',$a['image']);
			$q->bindParam('template',$a['template']);
			$q->bindParam('ori_id',$a['ori_id']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function edit_inventory($a) {
		try {
			
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$q = $conn->prepare("UPDATE products SET ProductName = :ProductName,PartNumber = :PartNumber,ProductLabel = :ProductLabel, StartingInventory = :StartingInventory, InventoryReceived = :InventoryReceived, InventoryShipped = :InventoryShipped, InventoryOnHand = :InventoryOnHand, MinimumRequired = :MinimumRequired  WHERE id = :pdtid");
			$q->bindParam('ProductName',$a['name']);
			$q->bindParam('PartNumber',$a['part_num']);
			$q->bindParam('ProductLabel',$a['label']);
			$q->bindParam('StartingInventory',$a['start_inv']);
			$q->bindParam('InventoryReceived',$a['inv_received']);
			$q->bindParam('InventoryShipped',$a['inv_shipped']);
			$q->bindParam('InventoryOnHand',$a['inv_onhand']);
			$q->bindParam('MinimumRequired',$a['min_required']);
			$q->bindParam('pdtid',$a['id']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
	public function getIncomebyPdtId($id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * FROM purchases
							JOIN suppliers on purchases.SupplierId = suppliers.id
							JOIN products on purchases.ProductId = products.id
							WHERE purchases.ProductId = '.$id;
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function getOutgoingbyPdtId($id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * FROM orders
							JOIN products on orders.ProductId = products.id
							WHERE orders.ProductId = '. $id ;
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_item_type($a) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			if($a['remnant'] == 'on') $a['remnant'] = 1;
			else $a['remnant'] = 0;
			
			$q = $conn->prepare('INSERT INTO `inventory_items`
			(`category_id`,`qty`, `item_name`, `lot`, `location`, `remnant`, `height`, `width`, `height_l`, `width_l`, `sqft`,`cost`,`price`,`image`,`tied_to`,`supplier`,`order_number`,`date_ordered`,`date_received` ) 
			VALUES ("'.$this->check_val($a,"item_category_id").'",'.(int)$this->check_val($a,"item_qty").',"'.$this->check_val($a,"item_name").'","'.$this->check_val($a,"item_lot").'","'.$this->check_val($a,"item_location").'",'.(int)$this->check_val($a,"remnant").',"'.$this->check_val($a,"item_height").'","'.$this->check_val($a,"item_width").'","'.$this->check_val($a,"item_height-1").'","'.$this->check_val($a,"item_width-l").'","'.$this->check_val($a,"sqft").'",'.(float)$this->check_val($a,"cost").','.(float)$this->check_val($a,"price").',"'.$this->check_val($a,"image").'",'.(int)$this->check_val($a,"tiedto").',"'.$this->check_val($a,"supplier").'",'.(int)$this->check_val($a,"ordernum").',"'.str_replace('T',' ',$this->check_val($a,"orderdate")).'","'.str_replace('T',' ',$this->check_val($a,"receivedate")).'")');
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function update_item_type($a) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if($a['remnant'] == 'on') $a['remnant'] = 1;
			else $a['remnant'] = 0;
			
			$q = $conn->prepare("UPDATE inventory_items SET category_id = :category_id,qty = :qty,item_name = :item_name, lot = :lot, location = :location, remnant = :remnant, height = :height, width = :width, height_l = :height_l, width_l = :width_l, sqft = :sqft, cost = :cost, image = :image, tied_to = :tied_to, supplier = :supplier, order_number = :order_number, date_ordered = :date_ordered, date_received = :date_received WHERE item_id = :itemid");
			$q->bindParam('category_id',$a['item_category_id']);
			$q->bindParam('qty',$a['item_qty']);
			$q->bindParam('item_name',$a['item_name']);
			$q->bindParam('lot',$a['item_lot']);
			$q->bindParam('location',$a['item_location']);
			$q->bindParam('remnant',$a['remnant']);
			$q->bindParam('height',$a['item_height']);
			$q->bindParam('width',$a['item_width']);
			$q->bindParam('height_l',$a['item_height-l']);
			
			$q->bindParam('width_l',$a['item_width-l']);
			$q->bindParam('sqft',$a['sqft']);
			$q->bindParam('cost',$a['cost']);
			$q->bindParam('image',$a['image']);
			
			$tiedto = (int)$a['tiedto'];
			$q->bindParam('tied_to',$tiedto);
			$q->bindParam('order_number',$a['ordernum']);
			$q->bindParam('supplier',$a['supplier']);
			$q->bindParam('date_ordered',$a['orderdate']);
			$q->bindParam('date_received',$a['receivedate']);
			$q->bindParam('itemid',$a['trid']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function get_categoriyids() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT * FROM inventory_categories';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_supplier() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT id, company FROM users where access_level = 20';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function update_stock_log($userid, $action, $desc) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $conn->prepare("INSERT INTO inventory_stock_logs (user_id, description, action) VALUES (:user_id, :description, :action)");
			$q->bindParam('user_id',$userid);
			$q->bindParam('description',$desc);
			$q->bindParam('action',$action);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
	public function getoriCatebyid($id) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $conn->prepare("SELECT * FROM inventory_categories WHERE category_id = '".$id."'");
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
	public function check_val($name, $ind) {
		if(array_key_exists($ind,$name)){
			if($name[$ind] == 'undefined') $name[$ind] = null;
			return $name[$ind];
		}else{
			$name[$ind] = null;
			return $name[$ind];
		}
	}
	
	public function getItemById($id) {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'select * from inventory_items left join users on users.id = inventory_items.supplier where item_id = "'.$id.'";';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	//Update the Item Qty from the Item View Page.
	public function update_item_qty($a) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$q = $conn->prepare('UPDATE `inventory_items`	SET `qty` = "'.$a['item_qty'].'" WHERE item_id = '.$a['item_id']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';
	}
	
	public function updateItemByID($a) {
		try {
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$q = $conn->prepare("UPDATE inventory_items SET category_id = :category_id,qty = :qty,item_name = :item_name, lot = :lot, location = :location, remnant = :remnant, height = :height, width = :width, height_l = :height_l, width_l = :width_l, sqft = :sqft, cost = :cost, image = :image, tied_to = :tied_to, supplier = :supplier, order_number = :order_number, date_ordered = :date_ordered, date_received = :date_received WHERE item_id = :itemid");
			$q->bindParam('category_id',$a['item_category_id']);
			$q->bindParam('qty',$a['item_qty']);
			$q->bindParam('item_name',$a['item_name']);
			$q->bindParam('lot',$a['item_lot']);
			$q->bindParam('location',$a['item_location']);
			$q->bindParam('remnant',$a['item_type']);
			$q->bindParam('height',$a['item_height']);
			$q->bindParam('width',$a['item_width']);
			$q->bindParam('height_l',$a['item_height-l']);
			
			$q->bindParam('width_l',$a['item_width-l']);
			$q->bindParam('sqft',$a['sqft']);
			$q->bindParam('cost',$a['cost']);
			$q->bindParam('image',$a['image']);
			
			$tiedto = (int)$a['tiedto'];
			$q->bindParam('tied_to',$tiedto);
			$q->bindParam('order_number',$a['ordernum']);
			$q->bindParam('supplier',$a['supplier']);
			$q->bindParam('date_ordered',$a['orderdate']);
			$q->bindParam('date_received',$a['receivedate']);
			$q->bindParam('itemid',$a['itemid']);
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
		return 'success';	
	}
	
	//Get all the Purchase Orders
	public function get_purchase_orders() {
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT *, (SELECT count(*) FROM inventory_po_items where inventory_po_items.po_id = inventory_purchase_orders.po_id AND inventory_po_items.charge_type = 1 GROUP BY inventory_po_items.po_id) as item_count, users.username FROM inventory_purchase_orders LEFT JOIN users on users.id = inventory_purchase_orders.supplier';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_po_hold($supplier_id){
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT category_name,tie_category, cost, tie_pid, tie_hold, projects.order_num, COUNT(*) AS Qty FROM `inventory_tied` JOIN inventory_categories ON tie_category = id_key JOIN projects on projects.id = inventory_tied.tie_pid WHERE ( inventory_tied.tie_status < 5 AND inventory_tied.tie_supplier = '. $supplier_id .' ) OR (  tie_supplier IS NULL AND  inventory_categories.min_req = 0 AND prefered_vendor = '. $supplier_id .' ) GROUP BY tie_hold,  category_id, tie_pid';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function get_po_restock($supplier_id){
		try {
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT *, (select count(*) from inventory_items where inventory_items.category_id = inventory_categories.id_key and inventory_items.remnant = 0) as inventory, 
			(SELECT count(*) as rr FROM inventory_tied inv LEFT JOIN (SELECT remnant, item_id FROM inventory_items) b ON b.item_id = inv.tie_item_id where (remnant = 0 or tie_item_id is null) and inv.tie_category = inventory_categories.id_key GROUP BY inv.tie_category) as Requested,
			(select company from users where users.id = inventory_categories.prefered_vendor and users.access_level = 20) as company 
			FROM `inventory_categories`
			where inventory_categories.active = 1 and inventory_categories.prefered_vendor = '.$supplier_id.' ORDER BY category_name';
			$q = $conn->prepare($sql);
			$q->execute();
			$row = $q->fetchAll(PDO::FETCH_ASSOC);
			return $row;
		} catch(PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function add_po_item($a) {
		try {
			$date = date('Y-m-d H:i:s');
			$approved = 1;
			$actual_cost = 0;
			date_default_timezone_set('America/New_York');
			$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

			$q = $conn->prepare("INSERT INTO inventory_purchase_orders (supplier, approved, ordered, expected, received, po_cost, actual_cost, 	fao, po_notes) VALUES (".$a['supplier'].",1,'".$date."','".$a['expected_date']."',NULL,".$a['po_cost'].",0.00,'".$a['fao']."','".$a['note']."')");
			$q->execute();
		} catch(PDOException $e) {
			$this->_message = "ERROR: " . $e->getMessage();
			return $this->_message;
		}
	}
	
}
?>