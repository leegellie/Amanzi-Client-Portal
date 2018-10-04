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
						<ul class="nav nav-tabs md-tabs nav-justified mdb-color blue">
							<li class="nav-item">
								<a class="nav-link" href="admin_inventory_manager.php">Stock Overview</a>
							</li>
							<li class="nav-item">
								<a class="nav-link active">Inventory Type</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="admin_inventory_purchase_orders.php">Purchase Orders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="admin_inventory_po_items.php">PO Items</a>
							</li>
						</ul>
						<!-- Tab panels -->
						<div class="tab-content px-10">
							<div class="tab-pane fade show active">
								<div class="btn btn-primary" id="type_addbtn" onClick="$('#typeAdd').modal('show');"><i class="fas fa-plus"></i> Add</div>
								<hr>
								<?php 
									$inv_manager_model = new inventory_manager_action;
									foreach($inv_manager_model->get_category_types() as $cat_type) {?>
									<div class="row">
										<div class="col-12 col-md-6 text-primary text-uppercase"><h3><?= $cat_type['type_name'] ?></h3></div>
										<div class="col-6 col-md-3 text-right">
											<div id="<?= $cat_type['type_id'] ?>"  nameAttr="<?= $cat_type['type_name'] ?>" class="btn btn-primary editCatTypeBtn" style="cursor:pointer">Edit <i class="icon-wrench"></i></div>
										</div>
										<div class="col-6 col-md-3 text-right">
											<div class="btn btn-danger deleteCatTypeBtn" uid="<?= $cat_type['type_id'] ?>" style="cursor:pointer">Delete <i class="fas fa-trash"></i></div>
										</div>
									</div>
									<hr>
								<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="modal fade" id="typeAdd" tabindex="-1" role="dialog" aria-labelledby="TypeAddLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Category Type</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<form id="add_cat_type" method="POST">
				<div class="modal-body">
					<div class="container">
							<input type="hidden" name="action" value="add_category_type">
							<div class="row">
								<label class="col-3 mb-3" for="name">Name:</label>
								<input class="col-9 mb-3 form-control" type="text" id="type_name" name="type_name" required>
							</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary ml-3" onclick="add_category_type()">Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
				</div>
			</form>
		</div>
	</div>
</div>	
	
<div aria-hidden="true" aria-labelledby="editTypeLabel" class="modal fade" id="editType" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-wrench h2 text-warning"></i> Edit Category Type</h2>
				</div>
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="edit_cat_type" method="POST" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="container">
									<input type="hidden" name="action" value="edit_category_type">
									<input type="hidden" name="type_id" id="edit_type_id" value="">
									<div class="row">
										<label class="col-3 mb-3" for="name">Category Name:</label>
										<input class="col-9 mb-3 form-control" type="text" id="edit_type_name" name="type_name" required>
									</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="edit_category_type()">UPDATE</button>
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
	
<!-- CONFIRM MODAL FOR PRODUCT DELETE -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="delete_confirm_modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="display:block;">
				<input type="hidden" id="del_type_id">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="myModalLabel">Confirm</h5>
      </div>
			<div class="modal-body">
				<p>Are you sure want to delete?</p>
				<p style="color:red;" id="more_alert">
				</p>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btnDelConfirm" onclick="deleteType()">Yes</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
	
<? 
include ('footer.php');
?>
<script>
function edit_category_type() {
	var data = $('#editType #edit_cat_type').serialize();
	$.ajax({
		url: 'ajax_inv.php',
		data: data,
		type: 'POST',
		success: function(data) {
			if(data === 'success'){
				$('#editType').find('.close').click();
				$('#editType').find('#edit_type_name').val('');
				$('#editType').find('#edit_type_id').val('');
				location.reload();
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}
function add_category_type() {
	var data = $('#typeAdd #add_cat_type').serialize();
	$.ajax({
		url: 'ajax_inv.php',
		data: data,
		type: 'POST',
		success: function(data) {
			if(data === 'success'){
				//close modal
				$('#typeAdd').find('.close').click();
				location.reload();
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}
function deleteType() {
	var id = $('#delete_confirm_modal').find('#del_type_id').val();
	$.ajax({
		url: 'ajax_inv.php',
		data: 'action=del_cat_type&type_id='+id,
		type: 'POST',
		success: function(data) {
			if(data === 'success'){
				//close modal
				$('#delete_confirm_modal').find('.close').click();
				location.reload();
			}
		},
		error: function(data) {
			console.log(data);
		}
	});
}
$(document).ready(function(){
	// edit modal
	$('.editCatTypeBtn').click(function(){
		var id = $(this).attr('id');
		var name = $(this).attr('nameAttr');
		// set name to edit modal
		$('#editType').find('#edit_type_name').val(name);
		$('#editType').find('#edit_type_id').val(id);
		$('#editType').modal();
	});
	
	$('.deleteCatTypeBtn').click(function(){
		var id = $(this).attr('uid');
		$('#delete_confirm_modal').find('#del_type_id').val(id);
		
		$('#delete_confirm_modal').find('#more_alert').html('');
		$('#delete_confirm_modal').find('.btnDelConfirm').removeAttr('disabled');
		//get how many items with this cat type
		$.ajax({
			url: 'ajax_inv.php',
			data: 'action='+'getItemCountWithType'+'&type_id='+id,
			type: 'POST',
			dataType: 'JSON',
			success: function(data) {
				if(data.status === 'success'){
					if(data.count > 0){
						$('#delete_confirm_modal').find('#more_alert').html('There are '+data.count+' items associated with this category. Please delete them or move to a different category type before proceeding.');
						$('#delete_confirm_modal').find('.btnDelConfirm').attr('disabled','disabled');
					}
					$('#delete_confirm_modal').modal();	
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
});
</script>
</body>
</html>
						