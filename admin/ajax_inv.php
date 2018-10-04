<?PHP
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/invest.class.php');
/*
USER AJAX REQUESTS 
*/
$action = trim(htmlspecialchars($_POST['action']));

if ($action=="initial") {
	unset($_POST['action']);
	$get_cats = new inventory_manager_action;

	$tbody_html = '<table class="table table-striped table-hover table-sm dynamic">';
	$tbody_html .= 	'<thead class="mdb-color darken-3 text-white" style="position: sticky">';
	$tbody_html .= 		'<tr>';
	$tbody_html .= 			'<th class="text-left" scope="col">Category ID</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Category Type</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Category Name</th>';
	$tbody_html .=			'<th class="text-center" scope="col">Min Req.</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Reorder Amt.</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Inventory</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Remnant Inventory</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Requested Inventory</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Remaining/Needed</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Ordered</th>';
// 	$tbody_html .=			'<th class="d-none d-md-table-cell hidden">Cost</th>';
// 	$tbody_html .=			'<th class="d-none d-md-table-cell hidden">Price</th>';
// 	$tbody_html .=			'<th class="d-none d-md-table-cell hidden">Prefered Vendor</th>';
// 	$tbody_html .=			'<th class="d-none d-md-table-cell hidden">Lead Time (days)</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">View</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Edit</th>';
	$tbody_html .=			'<th class="d-none d-md-table-cell">Delete</th>';
	$tbody_html .=		'</tr>';
	$tbody_html .=	'</thead>';
	$tbody_html .=	'<tbody>';
	foreach($get_cats->get_categories() as $cat) {
		if($cat['Requested'] == null) $cat['Requested'] = 0;
		$tbody_html .= '<tr class="filter" name="'. $cat['category_id'] .'"  style="cursor:pointer" data-toggle="tooltip" data-html="true" title="<table><thead><tr><th class=\'tip_th\'>Cost</th><th class=\'tip_th\'>Price</th><th class=\'tip_th\'>Prefered Vendor</th><th class=\'tip_th\'>Lead Time (days)</th></tr></thead><tbody><tr><td>'.$cat['cost'].'</td><td>'.$cat['price'].'</td><td>'.$cat['company'].'</td><td>'.$cat['lead_time'].'</td></tr></tbody></table>" >';
		$tbody_html .= '	<td class="text-left row_category_id">'. $cat['category_id'] .'</td>';
		$tbody_html .= '	<td class="text-left row_type_name">'. $cat['type_name'] .'</td>';
		$tbody_html .= '	<td class="text-left row_category_name">'. $cat['category_name'] .'</td>';
		$tbody_html .= '	<td class="text-center row_min_req">'. $cat['min_req'] .'</td>';
		$tbody_html .= '	<td class="text-center row_reorder_amt">'. $cat['reorder_amt'] .'</td>';
		$tbody_html .= '	<td class="text-center row_inventory">'. $cat['inventory'] .'</td>';
		$tbody_html .= '	<td class="text-center row_remnant_inventory">'. $cat['remnant_inventory'] .'</td>';
		
		$tbody_html .= '	<td class="text-center row_order">'. $cat['Requested'] .'</td>';
		$tbody_html .= '	<td class="text-center row_order">'. ($cat['inventory'] - $cat['Requested']) .'</td>';
		
		$tbody_html .= '	<td class="text-center row_order"></td>';
		$tbody_html .= '	<input type="hidden" class="text-center row_cost" value="'. $cat['cost'] .'" />';
		$tbody_html .= '	<input type="hidden" class="text-center row_price" value="'. $cat['price'] .'" />';
		$tbody_html .= '	<input type="hidden" class="text-center row_company" value="'. $cat['company'] .'" />';
		$tbody_html .= '	<input type="hidden" class="text-center row_lead_time" value="'. $cat['lead_time'] .'" />';
		$tbody_html .= '	<td style="padding-right:0px!important"><div class="text-center btn btn-sm btn-primary m-0" style="cursor:pointer" onclick="showdetail(\''.$cat['category_id'] .'\',\''. $cat['category_type'] .'\')"><i class="fas fa-eye"></i></div></td>';
		$tbody_html .= '	<td><div class="text-center btn btn-sm btn-primary m-0 editCategoryBtn" onclick="editInvModal(\''. $cat['category_id'] .'\')"><i class="fas fa-wrench"></i></div></td>';
		$tbody_html .= '	<td style="padding-left:0px!important"><div class="text-center btn btn-sm btn-danger m-0" onClick="delete_category(\''.$cat['category_id'] .'\')"><i class="fas fa-trash"></i></div></td>';
		$tbody_html .= '</tr>';
	}
	$tbody_html .= '</tbody></table>';
	echo $tbody_html;
}

if ($action=="po_initial") {
	unset($_POST['action']);
	$get_pos = new inventory_manager_action;

	$tbody_html = '<table class="table table-striped table-hover table-sm dynamic">';
	$tbody_html .= 	'<thead class="mdb-color darken-3 text-white" style="position: sticky">';
	$tbody_html .= 		'<tr>';
	$tbody_html .= 			'<th class="text-left" scope="col">PO#</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Supplier</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Order Placed</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Expected</th>';
	$tbody_html .=			'<th class="text-left" scope="col">Received</th>';
	$tbody_html .=			'<th class="text-center" scope="col">#Items</th>';
	$tbody_html .=			'<th class="text-right" scope="col">Price</th>';
	$tbody_html .=			'<th class="text-center" scope="col">View</th>';
	$tbody_html .=			'<th class="text-center" scope="col">Edit</th>';
	$tbody_html .=			'<th class="text-center" scope="col">Delete</th>';
	$tbody_html .=		'</tr>';
	$tbody_html .=	'</thead>';
	$tbody_html .=	'<tbody>';
	foreach($get_pos->get_purchase_orders() as $po) {
		$tbody_html .= '<tr class="filter" name="'. $po['po_id'] .'"  style="cursor:pointer" >';
		$tbody_html .= '	<td class="text-left row_po_id">'. $po['po_id'] .'</td>';
		$tbody_html .= '	<td class="text-left row_supplier">'. ucfirst($po['username']) .'</td>';
		$tbody_html .= '	<td class="text-left row_ordered">'. $po['ordered'] .'</td>';
		$tbody_html .= '	<td class="text-left row_expected">'. $po['expected'] .'</td>';
		$tbody_html .= '	<td class="text-left row_received">'. $po['received'] .'</td>';
		$tbody_html .= '	<td class="text-center row_items">'. $po['item_count'] .'</td>';
		$tbody_html .= '	<td class="text-right row_po_cost">$ '. $po['po_cost'] .'</td>';
		$tbody_html .= '	<td class="text-center"><div class="text-center btn btn-sm btn-primary m-0" style="cursor:pointer" onclick="showdetail('.$po['po_id'] .')"><i class="fas fa-eye"></i></div></td>';
		$tbody_html .= '	<td class="text-center"><div class="text-center btn btn-sm btn-success m-0 editPOBtn" onclick="editInvPOModal('. $po['po_id'] .')"><i class="fas fa-wrench"></i></div></td>';
// 		$tbody_html .= '	<td class="text-center"></td>';
		$tbody_html .= '	<td class="text-center"><div class="text-center btn btn-sm btn-danger m-0" onClick="delete_po(\''.$po['po_id'] .'\')"><i class="fas fa-trash"></i></div></td>';
		$tbody_html .= '</tr>';
	}
	$tbody_html .= '</tbody></table>';
	echo $tbody_html;
}

if ($action=="add_category") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	if(array_key_exists("image",$_FILES)){
		$path_parts = pathinfo($_FILES["image"]["name"]);
		$extension = $path_parts['extension'];
		// save image
		$image_name = time().'.'.$extension;
		if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../inventory/images/'.$image_name))
		{
			$_POST['image'] = $image_name;
		}
		else{
			$_POST['image'] = NULL;
		}		
	}else{
		$_POST['image'] = NULL;
	}
	if(array_key_exists("template",$_FILES)){
		$path_parts = pathinfo($_FILES["template"]["name"]);
		$extension = $path_parts['extension'];
		// save image
		$image_name = time().'.'.$extension;
		if(move_uploaded_file($_FILES['template']['tmp_name'], __DIR__.'/../inventory/images/'.$image_name))
		{
			$_POST['template'] = $image_name;
		}
		else{
			$_POST['template'] = NULL;
		}		
	}else{
		$_POST['template'] = NULL;
	}
	
	$result = $pdts -> add_category($_POST);
	if($result == 'success'){
		$description = 'Category ID: '.$_POST['category_id'];
		$log_result = $pdts -> update_stock_log($_SESSION['id'], 2, $description);
	}
	
	echo $result;
	exit;
}
if ($action=="edit_category") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	if(array_key_exists("image",$_FILES)){
		$_POST['image'] = $_FILES["image"]["name"];
	}else{
		$_POST['image'] = NULL;
	}
	if(array_key_exists("template",$_FILES)){
		$_POST['template'] = $_FILES["template"]["name"];
	}else{
		$_POST['template'] = NULL;
	}
	
	$ori_inv = $pdts -> getoriCatebyid($_POST['ori_id']);
	if(count($ori_inv[0]) > 0){
		$result = $pdts -> update_category($_POST);
		if($result == "success"){
			$description = ' ';
			foreach($ori_inv[0] as $ori_key => $ori_value){
				if(array_key_exists($ori_key,$_POST))
					if($_POST[$ori_key] != $ori_value) {
						$description .= str_replace(' ', '_', $ori_key). ': ' . $ori_value . ' -> ' . $_POST[$ori_key] . '|| ' ;
					}
			}
			$log_result = $pdts -> update_stock_log($_SESSION['id'], 1, $description);
			echo $result;
		}
	}
	exit;
}
if ($action=="del_cat_type") {
	unset($_POST['action']);	
	$pdts = new inventory_manager_action;
	$result = $pdts -> del_cat_type($_POST['type_id']);
	echo 'success';
}
if ($action=="del_inv") {
	unset($_POST['action']);	
	$pdts = new inventory_manager_action;
	$result = $pdts -> del_inventory($_POST['id']);
	$description = 'Category ID: '.$_POST['id'];
	$log_result = $pdts -> update_stock_log($_SESSION['id'], 0, $description);
}
if ($action=="del_item") {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$result = $item->del_item_inventoy($_POST['id']);
}
if ($action=="edit_inv") {
	unset($_POST['action']);	
	$pdts = new inventory_manager_action;
	$result = $pdts -> edit_inventory($_POST);
}

if($action=="show_detail") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	if(isset($_POST['id'])){
		$items = $pdts -> getItems_byCatID($_POST['id']);
		$cat_type = $_POST['cat_type'];
		$slabs = '';$remnant = '';
		foreach($items as $inc) {
			$temp = '';
			$temp .= '<tr class="filter" id="tr'.$inc['item_id'].'">';
			$temp .= ' <td class="text-left" id="d_itemid">'.$inc['item_id'].'</td>';
			$temp .= ' <td class="text-left" id="d_catid">'.$inc['category_id'].'</td>';
			if($cat_type != 1 && $cat_type != 2)
				$temp .= ' <td class="text-left" id="d_qty">'.$inc['qty'].'</td>';
			$temp .= ' <td class="text-left" id="d_itemname">'.$inc['item_name'].'</td>';
			if($cat_type == 1 || $cat_type == 2)
				$temp .= ' <td class="text-left" id="d_lot">'.$inc['lot'].'</td>';
			$temp .= ' <td class="text-left" id="d_locat">'.$inc['location'].'</td>';
			if($cat_type == 4)
				$temp .= ' <td class="text-left" id="d_remnant">'.$inc['remnant'].'</td>';
			if($cat_type != 4 && $cat_type != 5){
				$temp .= ' <td class="text-right" id="d_hei">'.$inc['height'].'</td>';
				$temp .= ' <td class="text-right" id="d_wid">'.$inc['width'].'</td>';
			}
// 			if($cat_type == 2){
				$temp .= ' <td class="text-right" id="d_hei_l">'.$inc['height_l'].'</td>';
				$temp .= ' <td class="text-right" id="d_wid_l">'.$inc['width_l'].'</td>';
// 			}
			if($cat_type == 1 || $cat_type == 2)
				$temp .= ' <td class="text-right" id="d_sqft">'.$inc['sqft'].'</td>';
			$temp .= ' <td class="text-right" id="d_cost">'.number_format((float)$inc['cost'], 2, '.', '').'</td>';
			$temp .= ' <td class="text-right" id="d_price">'.number_format((float)$inc['price'], 2, '.', '').'</td>';
// 			$temp .= ' <td class="text-left">'.$inc['image'].'</td>';
			if($cat_type != 5){
				$temp .= ' <td class="text-left" id="d_tied"> <a target="_blank" href="/admin/projects.php?edit&pid='.$inc['id'].'&uid='.$inc['uid'].'">'.$inc['order_num'].'</td>';
			}
			if($cat_type != 1 && $cat_type != 2){
				$temp .= ' <td class="text-left" id="d_sup">'.$inc['username'].'</td>';
			}
			if($cat_type != 1 && $cat_type != 2){
				$temp .= ' <td class="text-left" id="d_ordnum">'.$inc['order_number'].'</td>';
			}
// 			if($cat_type != 2 || $inc['remnant'] != 1){
			if($inc['remnant'] != 1){
				$temp .= ' <td class="text-left" id="d_orddate">'.$inc['date_ordered'].'</td>';
			}
			$temp .= ' <td class="text-left" id="d_recedate">'.$inc['date_received'].'</td>';
			$temp .= ' <td class="text-center"><div class="btn btn-primary btn-sm px-2" onClick="view_item('.$inc['item_id'].')"><i class="fas fa-qrcode ml-0 mr-0"></i><i class="fas fa-arrow-right mx-0"></i><i class="fas fa-print mr-0 ml-0"></i></div></td>';
			$temp .= ' <td class="text-center"><div class="text-center btn btn-sm btn-primary m-0" onClick="edit_item(\'edit\','.$inc['item_id'].')"><i class="fas fa-wrench"></i></div></td>';
			$temp .= ' <td class="text-center"><div class="text-center btn btn-sm btn-primary m-0" onClick="edit_item(\'duplicate\','.$inc['item_id'].')"><i class="fas fa-copy"></i></div></td>';
			$temp .= ' <td class="text-center"><div class="text-center btn btn-sm btn-danger m-0" onClick="delete_item('.$inc['item_id'] .')"><i class="fas fa-trash"></i></div></td>';
			$temp .= '</tr>';
			if($inc['remnant'] == 0){
				$slabs .= $temp;
			}
			elseif($inc['remnant'] != 0) {
				$remnant .= $temp;
			}
		}
// 		$slabs = $temp_header.$slabs.'</tbody></table>';
// 		$remnant = $temp_header.$remnant.'</tbody></table>';
		echo json_encode(array('status'=>true, 'slabs_table'=>$slabs, 'remnant_table'=>$remnant));
	}
	else{
		echo json_encode(array('status'=>false));
	}
}

// ajax section for category type
if($action=="add_category_type") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	$result = $pdts -> add_category_type($_POST);
	echo $result;
}
if($action=="edit_category_type") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	$result = $pdts -> update_category_type($_POST);
	echo $result;
}
if($action=="getItemCountWithType") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	$result = $pdts -> get_itemCount_with_type($_POST);
	echo json_encode(array('status'=>'success', 'count'=>$result));
}
if($action=="getItemCountWithCategory") {
	unset($_POST['action']);
	$pdts = new inventory_manager_action;
	$result = $pdts -> get_itemCount_with_category($_POST);
	echo json_encode(array('status'=>'success', 'count'=>$result));
}
if($action=="add_item") {
	unset($_POST['action']);
	if(array_key_exists("image",$_FILES)){
		$path_parts = pathinfo($_FILES["image"]["name"]);
		$extension = $path_parts['extension'];
		
		// save image
		$image_name = time().'.'.$extension;
		if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../inventory/images/'.$image_name))
		{
			$_POST['image'] = $image_name;
		}
		else{
			$_POST['image'] = NULL;
		}		
	}else{
		$_POST['image'] = NULL;
	}
	$item = new inventory_manager_action;
	if($_POST['item_type'] == 1) {
		$_POST['orderdate'] = date('Y-m-d H:i:s');
	}
	$cat_id_key = $item->get_catIdKeyByCID($_POST['item_category_id']);
	$_POST['item_cat_id_key'] = $cat_id_key[0]['id_key'];
	$result = $item -> add_item_type($_POST);
	echo json_encode(array('status'=>'success', 'count'=>$result));
}
if($action=="get_cat") {
	unset($_POST['action']);	
	$item = new inventory_manager_action;
	$result = $item -> get_categoriyids();
	
	$supplier = $item -> get_supplier();
	
	$cat_ids = array();
	$cat_names = array();
	foreach($result as $res) {
		array_push($cat_ids,$res['id_key']);
		array_push($cat_names,htmlspecialchars(json_encode($res['category_name']), ENT_QUOTES, 'UTF-8'));
	}
	echo json_encode(array('category'=>$cat_ids,'categoryname'=>$cat_names ,'supplier'=>$supplier));
}
if($action=="update_item") {
	unset($_POST['action']);
	if(array_key_exists("image",$_FILES)){
		$path_parts = pathinfo($_FILES["image"]["name"]);
		$extension = $path_parts['extension'];
		
		// save image
		$image_name = time().'.'.$extension;
		if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../inventory/images/'.$image_name))
		{
			$_POST['image'] = $image_name;
		}
		else{
			$_POST['image'] = NULL;
		}		
	}else{
		$_POST['image'] = NULL;
	}
	$item = new inventory_manager_action;
	$cat_id_key = $item->get_catIdKeyByCID($_POST['item_category_id']);
	$_POST['item_cat_id_key'] = $cat_id_key[0]['id_key'];
	$result = $item -> update_item_type($_POST);
	echo json_encode(array('status'=>'success', 'count'=>$result));
}

// ******************* //

if($action == "show_item") {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$result = $item -> getItemById($_POST['item_id']);
	$supplier = $item -> get_supplier();
	echo json_encode(array('status'=>'success', 'data'=>$result, 'supplier'=>$supplier));
}

if($action=="update_item_qty") {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$result = $item -> update_item_qty($_POST);
	echo json_encode(array('status'=>'success'));
}

if($action=="item_update") {
	unset($_POST['action']);
	if(array_key_exists("image",$_FILES)){
		$path_parts = pathinfo($_FILES["image"]["name"]);
		$extension = $path_parts['extension'];
		
		// save image
		$image_name = time().'.'.$extension;
		if(move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/../inventory/images/'.$image_name))
		{
			$_POST['image'] = $image_name;
		}
		else{
			$_POST['image'] = NULL;
		}		
	}else{
		$_POST['image'] = NULL;
	}
	$item = new inventory_manager_action;
	$result = $item -> updateItemByID($_POST);
	echo json_encode(array('status'=>'success'));
}

//********************//
//***Purchase Order***//
//********************//


if($action=="get_po_supplier") {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$result = $item -> get_supplier();
	echo json_encode(array('status'=>'success','supplier'=>$result));
}

if($action=="get_po_suggetions") { //Get the suggestion when adding the PO
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$results_hold = $item -> get_po_hold($_POST['sup_id']);
	$results_restock = $item -> get_po_restock($_POST['sup_id']);
	$result_hold = group_by("category_name", $results_hold);
	$result_restock = array();
	foreach($results_restock as $stock) {
		if(($stock['inventory'] - $stock['Requested']) < $stock['min_req'])
			array_push($result_restock, $stock);
	}
	$index = 0;
	foreach($result_restock as $result) {
		$result_restock[$index]['available'] = $result['inventory'] - $result['Requested'];
		if($result['inventory'] < $result['Requested']) $order_amount = $result['reorder_amt'] - $result_restock[$index]['available'];
		else $order_amount = $result['reorder_amt'];
		$result_restock[$index]['min'] = $result['min_req'];
		$result_restock[$index]['order_qty'] = $order_amount;
		$index++;
	}
	echo json_encode(array('status'=>'success','hold'=>$result_hold,'restock'=>$result_restock));
}

if($action=='save_po_item') {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$cost = 0;
	foreach($_POST['input_qty'] as $ind => $val) {
		$cost = $cost + ((int)$val*(int)($_POST['input_cost'] [$ind]));
	}
	$_POST['po_cost'] = $cost;
// 	Save the PO to the inventory_purchase_orders table and Get the last inserted row Id
	$result = $item -> add_po_item($_POST);
// 	Save the items to the inventory_po_items table
	$count = count($_POST['input_qty']);
	foreach($_POST['input_qty'] as $ind => $val) {
		$item->add_po_each_item($_POST,$ind,$result,$count);
	}
	echo json_encode(array('status'=>'success','result'=>$result));
}

if($action=='view_po') {
	unset($_POST['action']);
	$item = new inventory_manager_action;
	$result = $item->getPObyPOID($_POST['po_id']);
	$supplier = $item -> get_supplier();
	echo json_encode(array('status'=>'success', 'result'=>$result, 'supplier'=>$supplier));
}

function group_by($key, $array) {
    $result = array();

    foreach($array as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}


?>
