<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
//require_once (__DIR__ . '/../include/class/admin.class.php');
require_once ('head_php.php');

/*
HERE ARE THE CODE SNIPPETS TO DISPLAY USER INFO.
WHAT TO DISPLAY = CODE TO INSERT THE VALUE
USERNAME = <?= $username ?>
ACCESS LEVEL (NUMERIC VALUE) = <?= $access_level ?>
FIRST NAME = <?= $first_name ?>
LAST NAME = <?= $last_name ?>
USER'S EMAIL = <?= $user_email ?>
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ACP | Admin - Projects</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?
// INCLUDE THE JS and CSS files needed on all ADMIN PAGES
include('includes.php');

?>

    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
<!--    <script src="js/admin.js"></script>-->
    <script src="js/printThis.js"></script>
	<script src="bootgrid/jquery.bootgrid.min.js"></script>
	<script src="bootgrid/jquery.bootgrid.fa.min.js"></script>
	<script src="js/projects.js"></script>
	<script src="js/project_edit.js"></script>
	<script src="js/materials.js"></script>
	<script>
<?PHP 

?>
</script>

<?PHP include ('javascript.php'); ?>
<link rel="stylesheet" type="text/css" href="bootgrid/jquery.bootgrid.min.css">
</head>
<body class="metro" style="background-color: rgb(239, 234, 227);" >
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div id="loadOver"></div>
<div class="container ">
		<h1 class="d-print-none"><br>Administrative Tools<br></h1>
		<div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
	</div>
</div>
<!-- START BODY CONTENT AREA -->
<div class="container pageLook">
	<div id="pull_results" class="row">
<?
if(isset($_GET['marble'])){
	require_once ('admin_marbgran.php');
} elseif (isset($_GET['quartz'])) {
	require_once ('admin_quartz.php');
} elseif (isset($_GET['profit'])) {
	require_once ('admin_profloss.php');
} elseif (isset($_GET['stats'])) {
	require_once ('admin_graphs.php');
} elseif (isset($_GET['accessories'])) {
	require_once ('admin_accessories.php');
} elseif (isset($_GET['approval'])) {
	require_once ('admin_approval.php');
}
?>
	</div>
</div>
<!-- END BODY CONTENT AREA -->
<? 
	include ('modal_install_edit.php');
	include ('modal_project_edit.php');
	include ('modal_client_select.php');
	include ('modal_client_add.php');
	include ('modal_comment_add.php');
	include ('modal_email_success.php');
	include ('modal_location.php');
	include ('modal_piece_add.php');
	include ('modal_sink_edit.php');
	//include ('modal_qr_reader.php');
	include ('modal_contact_verif.php');
	include ('modal_user_discount.php');
	include ('modal_entry_reject.php');
	include ('modal_hold_notice.php');
	include ('modal_release_hold.php');
	include ('modal_job_lookup.php');
include ('footer.php'); ?>
<? 
// echo $access_level 
?>

<div aria-hidden="true" aria-labelledby="contact_verificationLabel" class="modal fade" id="contact_verif" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-phone-square h2 text-warning"></i> Has the customer confirmed the <span id="verif_type"></span>? - <span id="verif_date"></span> : <span id="verif_time"></span></h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">Job: <span id="verif_customer"></span></h2>
						<h3 class="col-6">Phone: <span id="verif_phone"></span></h3>
						<h3 class="col-6">Email: <span id="verif_email"></span></h3>
					</div>
					<form id="customer_verif" class="row">
						<input name="action" type="hidden" value="customer_verif"> <input name="cmt_ref_id" type="hidden" value="">
						<fieldset class="form-group col-12">
							<div class="row">
								<legend class="col-form-legend col-12">Job Type:</legend>
								<div class="form-check col-4">
									<label class="w-100" for="not_confirmed">Not Conformed</label>
									<input checked class="form-check-input with-font ml-4" id="not_confirmed" name="type" type="radio" value="0">
									<p class="d-inline ml-4"></p>
								</div>
								<div class="form-check col-4">
									<label class="w-100" for="confirmed">Confirmed</label>
									<input class="form-check-input with-font ml-4" id="confirmed" name="type" type="radio" value="1">
								</div>
								<div class="form-check col-4">
									<label class="w-100" for="reschedule">To be Rescheduled</label>
									<input class="form-check-input with-font ml-4" id="reschedule" name="type" type="radio" value="2">
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-12">
							<label class="w-100" for="confirm_notes">Notes:</label> 
							<textarea class="form-control" id="confirm_notes" name="confirm_notes" rows="4"></textarea>
						</fieldset>
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

<div aria-hidden="true" aria-labelledby="editMarbleLabel" class="modal fade" id="editMarble" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-wrench h2 text-warning"></i> Edit Marble/Granite</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">Edit: <span class="text-primary" id="marbName"></span></h2>
					</div>
					<hr>
					<form id="edit_marble" class=" row">
						<input type="hidden" name="action" value="edit_marble">
						<input type="hidden" id="i-id" name="id" value="">

						<label class="col-12 mb-3" for="name">Marble/Granite Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="i-name" name="name">

						<label class="col-2 mb-3" for="price_0">Amanzi / Remnant:</label>
						<input class="col-2 mb-3 form-control" id="i-price_0" name="price_0" type="number" value="0">

						<label class="col-2 mb-3" for="price_1">AllStone Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_1" name="price_1" type="number" value="0">

						<label class="col-2 mb-3" for="price_2">Bramati Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_2" name="price_2" type="number" value="0">

						<label class="col-2 mb-3" for="price_3">Cosmos Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_3" name="price_3" type="number" value="0">

						<label class="col-2 mb-3" for="price_4">Marva Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_4" name="price_4" type="number" value="0">

						<label class="col-2 mb-3" for="price_5">MSI Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_5" name="price_5" type="number" value="0">

						<label class="col-2 mb-3" for="price_6">OHM Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_6" name="price_6" type="number" value="0">

						<label class="col-2 mb-3" for="price_7">Stone Basyx Price:</label>
						<input class="col-2 mb-3 form-control" id="i-price_7" name="price_7" type="number" value="0">


						<label class="col-12 mb-3" for="notes">Notes on material:</label>
						<textarea class="col-12 mb-3 form-control" id="i-notes" name="notes"></textarea>


						<div class="btn btn-primary col-12" onClick="update_marble()">Update</div>
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

<div class="modal fade" id="materialAddMarble" tabindex="-1" role="dialog" aria-labelledby="materialAddMarbleLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Marble / Granite</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="add_marble" class=" row">
						<input type="hidden" name="action" value="add_marble">

						<label class="col-12 mb-3" for="name">Marble/Granite Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="name" name="name">

						<label class="col-2 mb-3" for="price_0">Amanzi / Remnant:</label>
						<input class="col-2 mb-3 form-control" id="price_0" name="price_0" type="number" value="0">

						<label class="col-2 mb-3" for="price_1">AllStone Price:</label>
						<input class="col-2 mb-3 form-control" id="price_1" name="price_1" type="number" value="0">

						<label class="col-2 mb-3" for="price_2">Bramati Price:</label>
						<input class="col-2 mb-3 form-control" id="price_2" name="price_2" type="number" value="0">

						<label class="col-2 mb-3" for="price_3">Cosmos Price:</label>
						<input class="col-2 mb-3 form-control" id="price_3" name="price_3" type="number" value="0">

						<label class="col-2 mb-3" for="price_4">Marva Price:</label>
						<input class="col-2 mb-3 form-control" id="price_4" name="price_4" type="number" value="0">

						<label class="col-2 mb-3" for="price_5">MSI Price:</label>
						<input class="col-2 mb-3 form-control" id="price_5" name="price_5" type="number" value="0">

						<label class="col-2 mb-3" for="price_6">OHM Price:</label>
						<input class="col-2 mb-3 form-control" id="price_6" name="price_6" type="number" value="0">

						<label class="col-2 mb-3" for="price_7">Stone Basyx Price:</label>
						<input class="col-2 mb-3 form-control" id="price_7" name="price_7" type="number" value="0">


						<label class="col-12 mb-3" for="notes">Notes on material:</label>
						<textarea class="col-12 mb-3 form-control" id="notes" name="notes"></textarea>


						<div class="btn btn-primary ml-3" onClick="add_marble()">Add Marble / Granite</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
	


<div class="modal fade" id="materialAddQuartz" tabindex="-1" role="dialog" aria-labelledby="materialAddQuartzLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Quartz</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="add_quartz" class=" row">
						<input type="hidden" name="action" value="add_quartz">

						<label class="col-12 mb-3" for="name">Quartz Color Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="name" name="name">

						<div class=" col-9">
							<label class="mb-3" for="cat_id">Company &amp; Category:</label>
							<select class="mdb-select" id="cat_id">
<?
	$uOptions = '';
	$salesReps = new project_action;
	$_POST['isSales'] = '1';
	foreach($salesReps->get_quartz_companies($_POST) as $results) {
		$uOptions .= '<option value="' . $results['id'] . '">' . $results['brand'] . ' ' . $results['class'] . ' - Group: ' . $results['group'] . '</option>';
	}
	echo $uOptions;
?>
							</select>
						</div>

						<div class=" col-3">
							<label class="mb-3" for="qPrice_3">Cost per SqFt:</label>
							<input class="mb-3 form-control" id="qPrice_3" name="price_3" type="number" value="0">
						</div>

						<div class=" col-3">
							<label class="mb-3" for="slab_cost">Cost per Slab:</label>
							<input class="mb-3 form-control" id="slab_cost" name="slab_cost" type="number" value="0">
						</div>

						<div class=" col-3">
							<label class="mb-3" for="slab_sqft">Slab SqFt:</label>
							<input class="mb-3 form-control" id="slab_sqft" name="slab_sqft" type="number" value="0">
						</div>

						<div class=" col-3">
							<label class="mb-3" for="quartz_height">Slab Height:</label>
							<input class="mb-3 form-control" id="quartz_height" name="quartz_height" type="number" value="0">
						</div>

						<div class=" col-3">
							<label class="mb-3" for="quartz_width">Slab Width:</label>
							<input class="mb-3 form-control" id="quartz_width" name="quartz_width" type="number" value="0">
						</div>

						<label class="col-12 mb-3" for="qNotes">Notes on material:</label>
						<textarea class="col-12 mb-3 form-control" id="qNotes" name="notes"></textarea>

						<div class="btn btn-primary ml-3" onClick="add_quartz()">Add Quartz</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div aria-hidden="true" aria-labelledby="editQuartzLabel" class="modal fade" id="editQuartz" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-wrench h2 text-warning"></i> Edit Quartz</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">Edit: <span class="text-primary" id="quartzName"></span></h2>
					</div>
					<hr>
					<form id="edit_quartz" class=" row">
						<input type="hidden" name="action" value="edit_quartz">
						<input type="hidden" id="q-id" name="id" value="">
						<label class="col-12 mb-3" for="q-name">Quartz Color Name:</label>
						<input class="col-12 mb-3 form-control" type="text" id="q-name" name="name">
						<div class=" col-9">
							<label class="mb-3" for="q-cat_id">Company &amp; Category:</label>
							<select class="mdb-select" id="q-cat_id" name="cat_id">
<?
	$uOptions = '';
	$salesReps = new project_action;
	$_POST['isSales'] = '1';
	foreach($salesReps->get_quartz_companies($_POST) as $results) {
		$uOptions .= '<option value="' . $results['id'] . '">' . $results['brand'] . ' ' . $results['class'] . ' - Group: ' . $results['group'] . '</option>';
	}
	echo $uOptions;
?>
							</select>
						</div>
						<div class=" col-3">
							<label class="mb-3" for="q-price_3">Cost per SqFt:</label>
							<input class="mb-3 form-control" id="q-price_3" name="price_3" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="q-slab_cost">Cost per Slab:</label>
							<input class="mb-3 form-control" id="q-slab_cost" name="slab_cost" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="q-slab_sqft">Slab SqFt:</label>
							<input class="mb-3 form-control" id="q-slab_sqft" name="slab_sqft" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="q-quartz_height">Slab Height:</label>
							<input class="mb-3 form-control" id="q-quartz_height" name="quartz_height" type="number" value="0">
						</div>
						<div class=" col-3">
							<label class="mb-3" for="q-quartz_width">Slab Width:</label>
							<input class="mb-3 form-control" id="q-quartz_width" name="quartz_width" type="number" value="0">
						</div>
						<label class="col-12 mb-3" for="q-notes">Notes on material:</label>
						<textarea class="col-12 mb-3 form-control" id="q-notes" name="notes"></textarea>

						<div class="btn btn-primary col-12" onClick="update_quartz()">Update</div>
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



<script>
function editQuartzModal(id,name,cat_id,price_3,slab_cost,slab_sqft,quartz_height,quartz_width,notes) {
	$('.mdb-select').material_select('destroy');
	$('#q-id').val(id);
	$('#quartzName').text(name);
	$('#q-name').val(name);
	$('#q-cat_id').val(cat_id);
	$('#q-price_3').val(price_3);
	$('#q-slab_cost').val(slab_cost);
	$('#q-slab_sqft').val(slab_sqft);
	$('#q-quartz_height').val(quartz_height);
	$('#q-quartz_width').val(quartz_width);
	$('#q-notes').val(notes);
	$('.mdb-select').material_select();
	$('#editQuartz').modal('show');
}

function editMarbModal(id,name,p0,p1,p2,p3,p4,p5,p6,p7,notes) {
	$('#i-id').val(id);
	$('#marbName').text(name);
	$('#i-name').val(name);
	$('#i-price_0').val(p0);
	$('#i-price_1').val(p1);
	$('#i-price_2').val(p2);
	$('#i-price_3').val(p3);
	$('#i-price_4').val(p4);
	$('#i-price_5').val(p5);
	$('#i-price_6').val(p6);
	$('#i-price_7').val(p7);
	$('#i-notes').val(notes);
	$('#editMarble').modal('show');
}

function editAccsModal( accs_id, accs_code, accs_model, accs_cost, accs_price, accs_status, accs_width, accs_depth, accs_name) {
	accs_name = unescape(accs_name);
	$('#a-accs_id').val(accs_id);
	$('#a-accs_code').val(accs_code);
	$('#a-accs_model').val(accs_model);
	$('#a-accs_name').val(accs_name);
	$('#a-accs_cost').val(accs_cost);
	$('#a-accs_price').val(accs_price);
	$('#a-accs_status').val(accs_status);
	$('#a-accs_width').val(accs_width);
	$('#a-accs_depth').val(accs_depth);
	$('#editAccs').modal('show');
}

$(document).ready(function(){
	$("#searchBox").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filter").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$('.table').DataTable({
		"pageLength": 50,
		"aoColumnDefs" : [{
			'bSortable' : false,
			'aTargets' : [ -2, -1 ]
		}]
	});
	$('.mdb-select').material_select('destroy');
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
	$('select[name=DataTables_Table_0_length]').addClass('mdb-select');
	$('.mdb-select').material_select();

});
</script></body>
</html>