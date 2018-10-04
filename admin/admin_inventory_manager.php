<?
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
require_once (__DIR__ . '/../include/class/materials.class.php');
require_once (__DIR__ . '/../include/class/invest.class.php');
require_once ('head_php.php');
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ACP | Inventory Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?
include('includes.php');
?>

<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<script src="js/inv_manager.js"></script>
<script src="../dymo/jquery.qrcode.min.js"></script>
<style>
	.item_section_header 
	{
    text-align: right;
    width: 100%;
	}	
	.items_section 
	{
    margin-top: 40px;
	}
	.items_section.hide{
		display: none;
	}
</style>
</head>
<body class="inventory" style="background-color: rgb(239, 234, 227);" >
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div id="loadOver"></div>
<div class="container">
	<div class="grid fluid">
		<h1><br>Inventory Manager</h1>
	</div>
</div>
<div class="pageLook mx-4">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 px-0 d-print-none" style="margin-left:0">
				<div id="marbgran-data" class="col-12 px-0">
					<div id="user-block" class="content">
						<div class="col-12 table-responsive px-0" id="tableResults">
							<div id="mdb-lightbox-ui"></div>
							<!-- Nav tabs -->
							<ul class="nav nav-tabs md-tabs nav-justified mdb-color blue">
								<li class="nav-item">
									<a class="nav-link active">Stock Overview</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="admin_inventory_type.php">Inventory Type</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="admin_inventory_purchase_orders.php">Purchase Orders</a>
								</li>
	<!-- 							<li class="nav-item">
									<a class="nav-link" href="admin_inventory_po_items.php">PO Items</a>
								</li> -->
							</ul>
							<!-- Tab panels -->
							<div class="tab-content px-10">
								<div id="aaa" 	class="tab-pane fade show active" role="tabpanel" aria-labelledby="aaa-tab">
									<div id="category_sec">
										<div class="btn btn-primary" id="cur_addbtn" onClick="$('#categoryAdd').modal('show');"><i class="fas fa-plus"></i> Add</div>	
										<div id="inv_table_sec">
											
										</div>					
									</div>
									<input type="hidden" id="sel_type" />
									<div class="items_section hide">
										<div class="row tab-content">
											<div class="col-8">
												<h2 class="item_section_header">
													Items under "<span id="ctg_name" class="text-primary"></span>" Category
												</h2>
											</div>
											<div class="col-4">
												<div class="btn btn-warning float-right" onclick="categoryBack()" style="cursor:pointer"><i class="fas fa-reply"></i>&nbsp;&nbsp; Back</div>
												<div class="btn btn-primary" id="item_addbtn" onClick="edit_item('add');" style="float:right;"><i class="fas fa-plus"></i> Add Item</div>
											</div>
										</div>
										<ul class="nav nav-tabs md-tabs nav-justified mdb-color red lighten-3">
											<li class="nav-item">
												<a class="nav-link active" data-toggle="tab"  aria-controls="slabs_tables" href="#slabs_tables">Stock</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" data-toggle="tab"  aria-controls="remnant_tables" href="#remnant_tables">Remnants</a>
											</li>
										</ul>
										<div class="tab-content px-10">
											<div id="slabs_tables" class="tab-pane fade show active" role="tabpanel" aria-labelledby="slab_tables-tab">
											</div>
											<div id="remnant_tables" class="tab-pane fade" role="tabpanel" aria-labelledby="remnant_tables-tab">
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<? 
include ('footer.php');
?>
<div class="modal fade" id="categoryAdd" tabindex="-1" role="dialog" aria-labelledby="CategoryAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus h2 text-success"></i>
				<div class="modal-title"><h2 class="d-inline text-primary">Add Category</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<form id="add_cat" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="container">
							<input type="hidden" name="action" value="add_category">
							<div class="row">
								<label class="col-3 mb-3" for="name">ID:</label>
								<input class="col-9 mb-3 form-control" type="text" id="category_id" name="category_id" required>
							</div>
							<div class="row">
								<label class="col-3 mb-3" for="name">Name:</label>
								<input class="col-9 mb-3 form-control" type="text" id="category_name" name="category_name" required>
							</div>
							<div class="row">
								<label class="col-3 mb-3" for="partNum">Type:</label>
								<select class="col-9 mb-3 mdb-select" id="category_type" name="category_type" required>
									<option value="" disabled selected>Choose inventory type</option>
<?
	$get_inv_types = new materials_action;
	$rows = $get_inv_types->get_inv_types();
	foreach ($rows as $row) {
		echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
	}
?>
								</select>
							</div>
							<div class="row">
								<label class="col-3 mb-3" for="pdt_label">Prefered Vendor:</label>
<!-- 								<input class="col-9 mb-3 form-control" id="prefered_vendor" name="prefered_vendor" type="text"> -->
								<select class="col-9 mb-3 mdb-select" id="prefered_vendor" name="prefered_vendor">
									<?
									$get_sups = new inventory_manager_action;
									foreach($get_sups->get_supplier() as $sup) {
									?>
										<option value="<?= $sup['id'] ?>"><?= $sup['company'] ?></option>
									<?
									}
									?>
								</select>
							</div>
							<div class="row">
								<div class=" col-4">
									<label class="mb-3" for="pdt-startinv">Min Req:</label>
									<input class="mb-3 form-control" id="min_req" name="min_req" type="number" value="0">
								</div>

								<div class=" col-4">
									<label class="mb-3" for="pdt-startinv">Reorder Amt:</label>
									<input class="mb-3 form-control" id="reorder_amt" name="reorder_amt" type="number" value="0">
								</div>

								<div class=" col-4">
									<label class="mb-3" for="pdt-invreceive">Cost:</label>
									<input class="mb-3 form-control" id="cost" name="cost" type="text" value="0.00">
								</div>
							</div>
							<div class="row">
								
								<div class=" col-4">
									<label class="mb-3" for="pdt-invreceive">Price:</label>
									<input class="mb-3 form-control" id="price" name="price" type="text" value="0.00">
								</div>

								<div class=" col-4">
									<label class="mb-3" for="pdt-invonhand">Lead Time:</label>
									<input class="mb-3 form-control" id="lead_time" name="lead_time" type="number" required>
								</div>
								
							</div>
							<div class="row">

								<div class=" col-4">
									<label class="mb-3" for="pdt-minrequired">Image:</label>
									<input class="mb-3" id="image" name="image" type="file">
								</div>

								<div class=" col-4">
									<label class="mb-3" for="pdt-minrequired">Template:</label>
									<input class="mb-3" id="template" name="template" type="file">
								</div>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary ml-3" onclick="add_category()">Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
				</div>
			</form>
		</div>
	</div>
</div>	
<div class="modal fade" id="inventoryAdd" tabindex="-1" role="dialog" aria-labelledby="inventoryAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Record</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="add_inv" class="">
						<input type="hidden" name="action" value="add_inv">
						<div class="row">
							<label class="col-3 mb-3" for="name">Name:</label>
							<input class="col-9 mb-3 form-control" type="text" id="name" name="name" required>
						</div>
						<div class="row">
							<label class="col-3 mb-3" for="partNum">Part Number:</label>
							<input class="col-9 mb-3 form-control" id="partNum" name="partNum" type="text" required>
						</div>
						<div class="row">
							<label class="col-3 mb-3" for="pdt_label">Label:</label>
							<input class="col-9 mb-3 form-control" id="pdt_label" name="pdt_label" type="text" required>
						</div>
						<div class="row">

							<div class=" col-4">
								<label class="mb-3" for="pdt-startinv">Starting Inventory:</label>
								<input class="mb-3 form-control" id="pdt-startinv" name="pdt-startinv" type="number" value="0">
							</div>

							<div class=" col-4">
								<label class="mb-3" for="pdt-invreceive">Inventory Received:</label>
								<input class="mb-3 form-control" id="pdt-invreceive" name="pdt-invreceive" type="number" value="0">
							</div>

							<div class=" col-4">
								<label class="mb-3" for="pdt-invshipped">Inventory Shipped:</label>
								<input class="mb-3 form-control" id="pdt-invshipped" name="pdt-invshipped" type="number" value="0">
							</div>
						</div>
						<div class="row">

							<div class=" col-4">
								<label class="mb-3" for="pdt-invonhand">Inventory On Hand:</label>
								<input class="mb-3 form-control" id="pdt-invonhand" name="pdt-invonhand" type="number" value="0">
							</div>

							<div class=" col-4">
								<label class="mb-3" for="pdt-minrequired">Minimum Required:</label>
								<input class="mb-3 form-control" id="pdt-minrequired" name="pdt-minrequired" type="number" value="0">
							</div>
						</div>
						<div class="btn btn-primary ml-3" onClick="add_inv()">Add</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>	
	
<div aria-hidden="true" aria-labelledby="editInventoryLabel" class="modal fade" id="editInventory" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-wrench h2 text-warning"></i> Edit </h2>
				</div>
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
<!-- 					<div class="row">
						<h2 class="col-12">Edit: <span class="text-primary" id="productName"></span></h2>
					</div> -->
					<form id="edit_cat" method="POST" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="container">
									<input type="hidden" name="action" value="edit_category">
									<input type="hidden" name="ori_id" id="ori_id">
									<div class="row">
										<label class="col-3 mb-3" for="name">ID:</label>
										<input class="col-9 mb-3 form-control" type="text" id="p-category_id" name="category_id" required>
									</div>
									<div class="row">
										<label class="col-3 mb-3" for="name">Name:</label>
										<input class="col-9 mb-3 form-control" type="text" id="p-category_name" name="category_name" required>
									</div>
									<div class="row" id="cat_edit">
										<label class="col-3 mb-3" for="partNum">Type:</label>
										<select class="col-9 mb-3 mdb-select" id="p-category_type" name="category_type" required>
											<option value="" disabled selected>Choose inventory type</option>
<?
	$get_inv_types = new materials_action;
	$rows = $get_inv_types->get_inv_types();
	foreach ($rows as $row) {
		echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
	}
?>
										</select>
									</div>
									<div class="row">
										<label class="col-3 mb-3" for="pdt_label">Prefered Vendor:</label>
										<input class="col-9 mb-3 form-control" id="p-prefered_vendor" name="prefered_vendor" type="text">
									</div>
									<div class="row">
										<div class=" col-4">
											<label class="mb-3" for="pdt-startinv">Min Req:</label>
											<input class="mb-3 form-control" id="p-min_req" name="min_req" type="number" value="0">
										</div>

										<div class=" col-4">
											<label class="mb-3" for="pdt-startinv">Reorder Amt:</label>
											<input class="mb-3 form-control" id="p-reorder_amt" name="reorder_amt" type="number" value="0">
										</div>

										<div class=" col-4">
											<label class="mb-3" for="pdt-invreceive">Cost:</label>
											<input class="mb-3 form-control" id="p-cost" name="cost" type="text" value="0.00">
										</div>
									</div>
									<div class="row">
										
										<div class=" col-4">
											<label class="mb-3" for="pdt-invreceive">Price:</label>
											<input class="mb-3 form-control" id="p-price" name="price" type="text" value="0.00">
										</div>

										<div class=" col-4">
											<label class="mb-3" for="pdt-invonhand">Lead Time:</label>
											<input class="mb-3 form-control" id="p-lead_time" name="lead_time" type="number" required>
										</div>
									</div>
									<div class="row">
										<div class=" col-4">
											<label class="mb-3" for="pdt-minrequired">Image:</label>
											<input class="mb-3" id="p-image" name="image" type="file">
										</div>

										<div class=" col-4">
											<label class="mb-3" for="pdt-minrequired">Template:</label>
											<input class="mb-3" id="p-template" name="template" type="file">
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											<div class="btn btn-primary" id="update_cat_btn" onclick="update_category()">UPDATE</button>
										</div>
									</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
</div>
	
<!-- CONFIRM MODAL FOR CATEGORY DELETE -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
				<input type="hidden" id="pdt_id" />
				<input type="hidden" id="item_id" />
				<input type="hidden" id="checktype" />
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Confirm</h5>
      </div>
			<div class="modal-body">
				<p>Are you sure want to delete this category(<span id="del_cat_name"></span>)?</p>
				<p class="more_alert" style="color:red">
				</p>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default delConfirmBtn" onclick="confirm_del()">Yes</button>
        <button type="button" class="btn btn-primary" onclick="hide_md()">No</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for add/edit items  -->
<div class="modal fade" id="itemAdd" tabindex="-1" role="dialog" aria-labelledby="ItemAddLabel" aria-hidden="true" data-backdrop="false">
	<div class="modal-dialog modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus h2 text-success"></i>
				<div class="modal-title"><h2 class="d-inline text-primary">Add Item</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<form id="add_item" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="container">  
						<input type="hidden" name="action" value="add_item"> 
						<input type="hidden" name="trid" id="trid" value=""/>
						<div class="row">  
							<label class="col-3 mb-3" for="name">Item Name:</label>  
							<input class="col-9 mb-3 form-control" type="text" id="item_name" name="item_name" required>  
						 </div>  

						 <div class="row" id="itemcate_section">  
						 </div>  

						<div class="row">  
							<div class="col-4">  
								<label class="col-3 mb-3" for="qty">Qty:</label>  
								<div class="mb-3 flex">
									<input class="col-8 form-control" id="item_qty" name="item_qty" type="number" value="0" readonly>  
									<div class="col-4 btn btn-primary adj-btn" onclick="show_adj();">Adjust</div>
								</div>
							</div>  
							<div class=" col-4">  
								<label class="col-3 mb-3" for="lot">Lot:</label>  
								<input class="mb-3 form-control" id="item_lot" name="item_lot" type="text">  
							</div>  
							<div class=" col-4">  
								<label class="col-6 mb-3" for="location">Location:</label>  
								<input class="mb-3 form-control" id="item_location" name="item_location" type="text" required>  
							</div>   
						 </div>

						 <div class="row">  
							<div class=" col-4">  
								<label class="mb-3" for="height">Height:</label>  
								<input class="mb-3 form-control" id="item_height" name="item_height" type="text" value="0.00">  
							</div>  
							<div class=" col-4">  
								<label class="mb-3" for="width">Width:</label>  
								<input class="mb-3 form-control" id="item_width" name="item_width" type="text" value="0.00">  
							</div>  
							<div class=" col-4">  
								<label class="mb-6" for="height-l">Height L:</label>  
								<input class="mb-3 form-control" id="item_height-1" name="item_height-l" type="text" value="0.00">  
							</div>   
						 </div>  

						 <div class="row"> 
							<div class=" col-4">  
								<label class="mb-3" for="width-l">Width L:</label>  
								<input class="mb-3 form-control" id="item_width-l" name="item_width-l" type="text" value="0.00">  
							</div>  
							<div class=" col-4">  
								<label class="mb-3" for="sqft">SqFt:</label>  
								<input class="mb-3 form-control" id="sqft" name="sqft" type="number" value="0">  
							</div>  
							<div class=" col-4">  
								<label class="mb-3" for="cost">Cost:</label>  
								<input class="mb-3 form-control" id="cost" name="cost" type="text" value="0.00" required>  
							</div>
						 </div>  

						 <div class="row"> 
						 	<div class=" col-4">  
								<label class="mb-3" for="cost">Price:</label>  
								<input class="mb-3 form-control" id="price" name="price" type="text" value="0.00" required>  
							</div>  
							<div class=" col-4">  
								<label class="mb-3" for="tiedto">Tied to:</label>  
								<input class="mb-3 form-control" id="tiedto" name="tiedto" type="number">  
							</div>   
							<div class=" col-4">  
								<div class="row" id="supplier_section">  
						 		</div> 
<!-- 								<label class="col-6 mb-3" for="supplier">Supplier:</label>  
								<input class="mb-3 form-control" id="supplier" name="supplier" type="text">   -->
							</div>
						</div>
						<div class="row">
							<div class=" col-4">  
								<label class="col-9 mb-3" for="ordernum">Order Number:</label>  
								<input class="mb-3 form-control" id="ordernum" name="ordernum" type="number" value="0">  
							</div>    
							<div class="col-4">
								<label class="col-9 mb-3" for="orderdate">Date Ordered:</label>  
								<input type="datetime-local" id="orderdate" name="orderdate" class="mb-3 form-control" required>
<!-- 								<input type="text" class="form-control mmm"> -->
							</div>
							<div class="col-4">  
								<label class="col-9 mb-3" for="receivedate">Date Received:</label>  
								<input type="datetime-local" id="receivedate" name="receivedate" class="mb-3 form-control" required>
							</div>  
					 	</div>  
						<div class="row">
							<div class=" col-12">  
								<label class="mb-3" for="image">Image:</label>  
								<input class="mb-3" id="image" name="image" type="file">  
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary ml-3" id="confirm_btn" onclick="add_item()">Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
					<input type="hidden" id="cur_catid" />
				</div>
			</form>
		</div>
	</div>
</div>	
</div>	
	
<!-- ADJUST MODAL FOR UPDATE QTY -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="adjust-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="hide_qty_md()"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Update the QTY</h5>
      </div>
			<div class="modal-body">
				<div class="row">
					<label class="col-3 mb-3" for="ordernum">Qty:</label>  
					<input class="col-8 mb-3" id="qty_update" name="qty" type="number" value="0" data-overlay="false">  
				</div>
				<div class="row">
					<label class="col-3 mb-3" for="orderdate">Reason:</label>  
					<textarea id="qty_reason" name="reason" class="col-8 mb-3" required></textarea>
				</div>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default update_qty_btn" onclick="confirm_update_qty()">Yes</button>
        <button type="button" class="btn btn-primary" onclick="hide_qty_md()">No</button>
      </div>
    </div>
  </div>
</div>
	
<!-- VIEW ITEM MODAL -->
<div class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="view_item-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"  onclick="hide_item_md()"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Preview the Item</h5>
      </div>
			<div class="modal-body">
				<iframe name="frame1" id="qrcode_iframe" src="" width="100%" height="200px"></iframe>
<!-- 				<div id="dymo-editor">
					<div id="barcodeYup"></div>
				</div> -->
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="hide_item_md()"><i class="fas fa-close mr-0 ml-0"></i>Close</button>
				
<!--         <button type="button" class="btn btn-primary" onclick="hide_item_md()">No</button> -->
      </div>
    </div>
  </div>
</div>
<script>
$(document).ready(function(){
	$('iframe').load( function() {
			$('iframe').contents().find("body")
				.append($("<style type='text/css'>  body{overflow:hidden;}  </style>"));
	});
	inv_manager();	
	
	$(document).on('click', '.editCategoryBtn', function(){
// 		$('#p-category_id').val($(this).closet('tr').find('.row_category_id').val());
// 		$('#ori_id').val($(this).find('.row_category_id').val());
// 		$('#p-category_name').val($(this).find('.row_type_name').val());
// 		$('#p-category_type').val($(this).find('.row_category_type').val());
// 		$('#p-prefered_vendor').val($(this).find('.row_company').val());
// 		$('#p-min_req').val($(this).find('.row_min_req').val());
// 		$('#p-reorder_amt').val($(this).find('.row_reorder_amt').val());
// 		$('#p-cost').val($(this).find('.row_cost').val());
// 		$('#p-lead_time').val($(this).find('.row_lead_time').val());
// 		$('#p-image').attr('src', $(this).find('.row_image').val());
// 		$('#p-template').attr('src', $(this).find('.row_template').val());
// 		$('#editInventory').modal('show');
	});
// 	var ctxP = document.getElementById("pieChart").getContext('2d');
// 	var numb = 400;
// 	var data = <?php echo json_encode($get_pdts->get_pdts()); ?>;
// 	var pdt_label = [],
// 			pdt_value = [],
// 			pdt_backgroundColor = [],
// 			pdt_hoverBackgroundColor = [];
// 	data.forEach((value, index) => {
// 		pdt_label[index] = value['ProductLabel'];
// 		pdt_value[index] = value['InventoryReceived'];
// 		pdt_backgroundColor[index] = "#"+((1<<24)*Math.random()|0).toString(16);
// 		pdt_hoverBackgroundColor[index] = "#"+(((1<<24)*Math.random()+1)|0).toString(16);
// 	});	
	
// 	var myPieChart = new Chart(ctxP, {
// 			type: 'pie',
// 			data: {
// 					labels: pdt_label,
// 					datasets: [
// 							{
// 									data: pdt_value,
// 									backgroundColor: pdt_backgroundColor,
// 									hoverBackgroundColor: pdt_backgroundColor
// 							}
// 					]
// 			},
// 			options: {
// 					responsive: true
// 			}
// 	})
	
});
</script>
</body>
</html>
					
