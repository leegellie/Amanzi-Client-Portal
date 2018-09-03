<?
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
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
<div class="container pageLook">
	<div class="row">
		<div class="col-12 px-0 d-print-none" style="margin-left:0">
			<div id="marbgran-data" class="col-12 px-0">
				<div id="user-block" class="content">
					<div class="col-12 table-responsive px-0" id="tableResults">
						<div id="mdb-lightbox-ui"></div>
						<!-- Nav tabs -->
						<ul class="nav nav-tabs md-tabs nav-justified mdb-color darken-3" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#panel_current" role="tab">Current Inventory</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#panel_incoming" role="tab">Incoming Purchases</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#panel_outgoing" role="tab">Outgoing Orders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#panel_report" role="tab">Reports</a>
							</li>
						</ul>
						<!-- Tab panels -->
						<div class="tab-content px-10" id="myTabContent">
							<div id="panel_current" class="tab-pane fade show active" role="tabpanel" aria-labelledby="panel_current-tab">
								<div class="btn btn-primary" id="cur_addbtn" onClick="$('#inventoryAdd').modal('show');"><i class="fas fa-plus"></i> Add</div>
								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-center" scope="col">Name</th>
											<th scope="col">Part Number</th>
											<th class="text-center" scope="col">Label</th>
											<th class="d-none d-md-table-cell">Starting Inventory</th>
											<th class="d-none d-md-table-cell">Inventory Received</th>
											<th class="d-none d-md-table-cell">Inventory Shipped</th>
											<th class="d-none d-md-table-cell">Inventory On Hand</th>
											<th class="d-none d-md-table-cell">Minimum Required</th>
											<th class="d-none d-md-table-cell">Edit</th>
											<th class="d-none d-md-table-cell">Delete</th>
										</tr>
									</thead>
									<tbody>
									<?
									$get_pdts = new inventory_manager_action;
									foreach($get_pdts->get_pdts() as $pdt) {
										
										$editString = $pdt['id'] . ",'" . $pdt['ProductName'] . "','" . $pdt['PartNumber'] . "','" . $pdt['ProductLabel'] . "'," . $pdt['StartingInventory'] . ',' . $pdt['InventoryReceived'] . ',' . $pdt['InventoryShipped'] . ',' . $pdt['InventoryOnHand'] . ',' . $pdt['MinimumRequired'];
									?>
										<tr class="filter" onClick="showdetail(<?= $pdt['id'] ?>)">
											<td class="text-left"><?= $pdt['ProductName'] ?></td>
											<td class="text-left"><?= $pdt['PartNumber'] ?></td>
											<td class="text-left"><?= $pdt['ProductLabel'] ?></td>
											<td class="text-left"><?= $pdt['StartingInventory'] ?></td>
											<td class="text-left"><?= $pdt['InventoryReceived'] ?></td>
											<td class="text-left"><?= $pdt['InventoryShipped'] ?></td>
											<td class="text-left"><?= $pdt['InventoryOnHand'] ?></td>
											<td class="text-left"><?= $pdt['MinimumRequired'] ?></td>
											<td><div class="text-center btn-sm btn-primary m-0" onClick="editInvModal(<?= $editString ?>)"><i class="fas fa-wrench"></i></div></td>
											<td><div class="text-center btn-sm btn-danger m-0" onClick="delete_inventory(<?= $pdt['id'] ?>)"><i class="fas fa-trash"></i></div></td>
										</tr>
									<?
									}
									?>
									</tbody>
								</table>
								<div class="row">
									<div class="col-8 income_f">
										<table class="table table-striped table-hover table-sm">
											<thead class="mdb-color darken-3 text-white" style="position: sticky">
												<tr>
													<th class="text-center" scope="col">PurchaseDate</th>
													<th scope="col">ProductId</th>
													<th class="text-center" scope="col">NumberReceived</th>
													<th class="d-none d-md-table-cell">SupplierId</th>
												</tr>
											</thead>
											<tbody id="incoming_ftb"></tbody>
										</table>	
									</div>	
								</div>
								<div class="row">
									<div class="col-8 outgoing_f">
										<table class="table table-striped table-hover table-sm">
											<thead class="mdb-color darken-3 text-white" style="position: sticky">
												<tr>
													<th class="text-center" scope="col">OrderDate</th>
													<th scope="col">ProductId</th>
													<th class="text-center" scope="col">NumberShipped</th>
													<th class="d-none d-md-table-cell">First</th>
													<th class="d-none d-md-table-cell">Last</th>
												</tr>
											</thead>
											<tbody id="outgoing_ftb"></tbody>
										</table>
									</div>
								</div>
							</div>
							<div id="panel_incoming" class="tab-pane fade" role="tabpanel" aria-labelledby="panel_incoming-tab">
								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-center" scope="col">Date Of Purchase</th>
											<th scope="col">Product</th>
											<th class="text-center" scope="col">Number Received</th>
											<th class="d-none d-md-table-cell">Supplier</th>
										</tr>
									</thead>
									<tbody>
								<?
										$pdts = new inventory_manager_action;
										$tmp = array();
										$all_purchases= $pdts -> get_all_purchases();
										foreach($all_purchases as $purchase) {
											$tmp[$purchase['ProductLabel']][] = $purchase;
										}
										$purchases = array();
										foreach($tmp as $type => $labels) {
											$purchases[] = array(
												'ProductLabel' => $type,
												'detail' => $labels
											);
										}
										foreach($purchases as $purchase) {											
								?>
										<tr class="filter">	
											<td class="text-left"><?= $purchase['ProductLabel'] ?>  -  <?= count($purchase['detail']) ?> items(s)</td>
										</tr>
								<?
									foreach($purchase['detail'] as $pch){
								?>
										<tr>
											<td><?= $pch['PurchaseDate'] ?></td>
											<td><?= $pch['ProductLabel'] ?></td>
											<td><?= $pch['NumberReceived'] ?></td>
											<td><?= $pch['supplier'] ?></td>
										</tr>
								<?
									}
								?>
										<tr><td></td><td></td><td><?= $purchase['detail'][0]['InventoryReceived'] ?></td><td></td></tr>
								<?
									}
								?>
									</tbody>
								</table>
							</div>
							<div id="panel_outgoing" class="tab-pane fade" role="tabpanel" aria-labelledby="panel_outgoing-tab">
								<table class="table table-striped table-hover table-sm">
									<thead class="mdb-color darken-3 text-white" style="position: sticky">
										<tr>
											<th class="text-left" scope="col">Order Date</th>
											<th scope="col">Product</th>
											<th class="d-none d-md-table-cell">Number Shipped</th>
											<th class="d-none d-md-table-cell">First</th>
											<th class="d-none d-md-table-cell">Last</th>
										</tr>
									</thead>
									<tbody>
									<?
									foreach($get_pdts->get_orders() as $ord) {
									?>
										<tr class="filter">
											<td class="text-left"><?= $ord['OrderDate'] ?></td>
											<td class="text-left"><?= $ord['ProductLabel'] ?></td>
											<td class="text-left"><?= $ord['NumberShipped'] ?></td>
											<td class="text-left"><?= $ord['First'] ?></td>
											<td class="text-left"><?= $ord['Last'] ?></td>
										</tr>
									<?
									}
									?>
									</tbody>
								</table>
							</div>
							<div id="panel_report" 	class="tab-pane fade" role="tabpanel" aria-labelledby="panel_report-tab">
								<div class="row">
									<div class="col-8 chartsec">
										<canvas id="pieChart"></canvas>
									</div>
									<div class="col-3">
									<table class="table table-striped table-hover table-sm">
										<thead class="mdb-color darken-3 text-white" style="position: sticky">
											<tr>
												<th class="text-center" scope="col">ProductLabel</th>
												<th scope="text-center col">InventoryReceived</th>
											</tr>
										</thead>
										<tbody>
										<?
										foreach($get_pdts->get_pdts() as $pdt) {
										?>
											<tr class="filter">
												<td class="text-left"><?= $pdt['ProductLabel'] ?></td>
												<td class="text-left"><?= $pdt['InventoryReceived'] ?></td>
											</tr>
										<?
										}
										?>
										</tbody>
									</table>	
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
					<div class="row">
						<h2 class="col-12">Edit: <span class="text-primary" id="productName"></span></h2>
					</div>
					<hr>
					<form id="edit_inv" class=" row">
						<input type="hidden" name="action" value="edit_inv">
						<input type="hidden" id="q-id" name="id" value="">
						<label class="col-12 mb-3" for="q-name">Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="pdt-name" name="name">
						
						<div class=" col-3">
							<label class="mb-3" for="pdt-partnum">Part Number:</label>
							<input class="mb-3 form-control" id="pdt-partnum" name="pdt-partnum" type="text">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-label">Label:</label>
							<input class="mb-3 form-control" id="pdt-label" name="pdt-label" type="text" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-start_inv">Starting Inventory:</label>
							<input class="mb-3 form-control" id="pdt-start_inv" name="pdt-start_inv" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-inv_received">Inventory Received:</label>
							<input class="mb-3 form-control" id="pdt-inv_received" name="pdt-inv_received" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-inv_shipped">Inventory Shipped:</label>
							<input class="mb-3 form-control" id="pdt-inv_shipped" name="pdt-inv_shipped" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-inv_onhand">Inventory On Hand:</label>
							<input class="mb-3 form-control" id="pdt-inv_onhand" name="pdt-inv_onhand" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="pdt-min_required">Minimum Required:</label>
							<input class="mb-3 form-control" id="pdt-min_required" name="pdt-min_required" type="number" value="0">
						</div>
						<div class="btn btn-primary col-12" onClick="update_inv()">Update</div>
					</form>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
	
<!-- CONFIRM MODAL FOR PRODUCT DELETE -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
				<input type="hidden" id="pdt_id">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Confirm</h5>
      </div>
			<div class="modal-body">
				<p>Are you sure want to delete?</p>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="confirm_del()">Yes</button>
        <button type="button" class="btn btn-primary" onclick="hide_md()">No</button>
      </div>
    </div>
  </div>
</div>
	
<? 
include ('footer.php');
?>
<script>
$(document).ready(function(){
	inv_manager();
	var ctxP = document.getElementById("pieChart").getContext('2d');
	var numb = 400;
	var data = <?php echo json_encode($get_pdts->get_pdts()); ?>;
	var pdt_label = [],
			pdt_value = [],
			pdt_backgroundColor = [],
			pdt_hoverBackgroundColor = [];
	data.forEach((value, index) => {
		pdt_label[index] = value['ProductLabel'];
		pdt_value[index] = value['InventoryReceived'];
		pdt_backgroundColor[index] = "#"+((1<<24)*Math.random()|0).toString(16);
		pdt_hoverBackgroundColor[index] = "#"+(((1<<24)*Math.random()+1)|0).toString(16);
	});	
	
	var myPieChart = new Chart(ctxP, {
			type: 'pie',
			data: {
					labels: pdt_label,
					datasets: [
							{
									data: pdt_value,
									backgroundColor: pdt_backgroundColor,
									hoverBackgroundColor: pdt_backgroundColor
							}
					]
			},
			options: {
					responsive: true
			}
	})
	
});
function editInvModal(id,name,num,label,start_inv,inv_received,inv_shipped,inv_onhand,min_required) {
	$('#q-id').val(id);
	$('#productName').text(name);
	$('#pdt-name').val(name);
	$('#pdt-label').val(label);
	$('#pdt-partnum').val(num);
	$('#pdt-start_inv').val(start_inv);
	$('#pdt-inv_received').val(inv_received);
	$('#pdt-inv_shipped').val(inv_shipped);
	$('#pdt-inv_onhand').val(inv_onhand);
	$('#pdt-min_required').val(min_required);
	$('#editInventory').modal('show');
}
	
function hide_md() {
	$("#mi-modal").modal('hide');
}
	
function confirm_del() {
	var pdtid = $('#pdt_id').val();
	var datastring = 'action=del_inv' + '&id=' + pdtid;
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log('done - ' + data);
			$("#mi-modal").modal('hide');
			location.reload();
		},
		error: function(data) {
			console.log(data);
		}
	});
}
	
function update_inv() {
	var datastring = 'action=edit_inv' + '&id=' + $('#editInventory #q-id').val() + '&name=' + $('#editInventory #pdt-name').val() + '&part_num=' + $('#editInventory #pdt-partnum').val() + '&label=' + $('#editInventory #pdt-label').val() + '&start_inv=' + $('#editInventory #pdt-start_inv').val() + '&inv_received=' + $('#editInventory #pdt-inv_received').val() + '&inv_shipped=' + $('#editInventory #pdt-inv_shipped').val() + '&inv_onhand=' + $('#editInventory #pdt-inv_onhand').val() + '&min_required=' + $('#editInventory #pdt-min_required').val();	
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log('done - ' + data);
			location.reload();
		},
		error: function(data) {
			console.log(data);
		}
	});
}
	
function showdetail(id) {
	var datastring = 'action=show_detail' + '&id=' + id;
	$.ajax({
		url: 'ajax_inv.php',
		data: datastring,
		type: 'POST',
		success: function(data) {
			console.log('detail - ' + data);
			var res = data.split("::");
			$('#incoming_ftb').html(res[0]);
			$('#outgoing_ftb').html(res[1]);
		},
		error: function(data) {
			console.log(data);
		}
	});
}
	
</script>
</body>
</html>
						