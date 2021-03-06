<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
require_once (__DIR__ . '/../include/class/materials.class.php');
require_once ('head_php.php');

/*
GET THE INSTALLED JOBS BETWEEN TOADY AND 30 DAYS LATER.
*/
$conn = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$startDate = date("Y-m-d");
$instStartDate = date("Y-m-d");

//	$instStartDate = date('Y-m-d', strtotime($startDate. ' + 7 days'));

$limitDate = date('Y-m-d', strtotime($startDate. ' + 60 days'));

//Get the template date
$q = $conn->prepare("SELECT * FROM projects 
					WHERE template_date >= :startDate and template_date <= :limitDate
					ORDER BY template_date");
$q->bindParam('startDate', $startDate);
$q->bindParam('limitDate', $limitDate);
$q->execute();
$jobs = $q->fetchAll(PDO::FETCH_ASSOC);
$tmp = array();

foreach($jobs as $job){
	$tmp[$job['template_date']][] = $job;
}
$output = array();

foreach($tmp as $type => $labels){
	$output[] = array(
		'template_date' => $type,
		'detail' => $labels
	);
}


//Get the projects by install date

$q = $conn->prepare("SELECT * FROM projects 
					WHERE install_date >= :startDate and install_date <= :limitDate
					ORDER BY install_date");
$q->bindParam('startDate', $instStartDate);
$q->bindParam('limitDate', $limitDate);
$q->execute();
$jobs = $q->fetchAll(PDO::FETCH_ASSOC);
$tmp = array();
foreach($jobs as $job){
	$tmp[$job['install_date']][] = $job;
}
$outputforinstall = array();

foreach($tmp as $type => $labels){
	$outputforinstall[] = array(
		'install_date' => $type,
		'detail' => $labels
	);
}

$q = $conn->prepare("SELECT * FROM holidays");
$q->execute();
$holidays = $q->fetchAll(PDO::FETCH_ASSOC);

$id = 1;
$q = $conn->prepare("SELECT * FROM prod_limits where id = :id");
$q->bindParam('id',$id);
$q->execute();
$limitinfo = $q->fetchAll(PDO::FETCH_ASSOC); // get the currently sqft and projects limit
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

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
<!--    <script src="js/admin.js"></script>-->
    <script src="js/printThis.js"></script>
	<script src="bootgrid/jquery.bootgrid.min.js"></script>
	<script src="bootgrid/jquery.bootgrid.fa.min.js"></script>
	<script src="js/projects.js?<?= $version ?>"></script>
	<script src="js/project_edit.js?<?= $version ?>"></script>
	<script src="js/materials.js?<?= $version ?>"></script>
	<link rel="stylesheet" href="css/pikaday.css">
	<link rel="stylesheet" href="css/site.css">
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
} elseif (isset($_GET['holds'])) {
	require_once ('admin_hold.php');
} elseif (isset($_GET['precall'])) {
	require_once ('admin_precall.php');
} elseif (isset($_GET['precalltemp'])) {
	require_once ('admin_precall_temp.php');
} elseif (isset($_GET['invoices'])) {
	require_once ('admin_invoicing.php');
} elseif (isset($_GET['pay'])) {
	require_once ('admin_inst_pay.php');
} elseif (isset($_GET['order'])) {
	require_once ('admin_order_station.php');
} 
?>
	</div>
</div>
<!-- END BODY CONTENT AREA -->
<? 
include ('footer.php');
include ('modal_accessory_assign.php');
include ('modal_accs_add.php');
include ('modal_adjust_material.php');
include ('modal_approval_reject.php');
include ('modal_client_add.php');
include ('modal_client_select.php');
include ('modal_comment_add.php');
include ('modal_contact_verif.php');
include ('modal_email_success.php');
include ('modal_entry_reject.php');
include ('modal_hold_notice.php');
include ('modal_install_edit.php');
include ('modal_job_lookup.php');
// include ('modal_job_material.php');
include ('modal_location.php');
include ('modal_mat_hold.php');
include ('modal_material_assign.php');
include ('modal_material_assign_bulk.php');
include ('modal_material_order.php');
include ('modal_material_order_bulk.php');
include ('modal_material_select.php');
include ('modal_piece_add.php');
include ('modal_project_edit.php');
include ('modal_release_hold.php');
include ('modal_select_installers.php');
include ('modal_shape_info.php');
include ('modal_sink_add.php');
include ('modal_sink_edit.php');
include ('modal_sink_hold.php');
include ('modal_sink_order.php');
include ('modal_sink_release_hold.php');
include ('modal_user_discount.php');
?>

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
							<select class="mdb-select md-form colorful-select dropdown-primary" id="cat_id">
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
							<select class="mdb-select md-form colorful-select dropdown-primary" id="q-cat_id" name="cat_id">
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

<div id="mdb-lightbox-ui"></div>


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

function editAccsModal(string) {
	$('.mdb-select').material_select('destroy'); 
	var res = string.split('::');
	var accs_name = unescape(res[0]);
	var accs_id = res[1];
	var accs_code = res[2];
	var accs_model = res[3];
	var accs_cost = res[4];
	var accs_price = res[5];
	var accs_status = res[6];
	var accs_width = res[7];
	var accs_depth = res[8];
	var accs_count = res[9];

	$('#add_accs input[name=action]').val('update_accs');
	$('#edit-text').show();
	$('#accsName').text(accs_name);
	$('#accs_id').val(accs_id);
	$('#accs_code').val(accs_code);
	$('#accs_model').val(accs_model);
	$('#accs_name').val(accs_name);
	$('#accs_cost').val(accs_cost);
	$('#accs_price').val(accs_price);
	if (accs_status == 1) {
		$('#accs_status').prop('checked',true);
	} else {
		$('#accs_status').prop('checked',false);
	}
	$('#accs_width').val(accs_width);
	$('#accs_depth').val(accs_depth);
	$('#accs_count').val(accs_count);
	$('#addAccsBtn').text('Update Database');
	$('.mdb-select').material_select(); 
	$('#addAccs').modal('show');
}

function delete_accessory(accs_id) {
	if (confirm('Are you sure you want to delete this from the database?')) {
		var datastring = 'action=delete_accs&accs_id=' + accs_id;
		$.ajax({
			type: "POST",
			url: "ajax.php",
			data: datastring,
			success: function(data) {
				//console.log(data);
				console.log(data);
				location.reload();
			},
			error: function(data) {
				console.log(data);
			}
		});
	} else {
		return;
	}
}

function addAccs() {
	$('#add_accs input[name=action]').val('add_accs');
	$('#edit-text').hide();
	$('#accsName').text('accs_name');
	$('#accs_id').val(0);
	$('#accs_code').val('');
	$('#accs_model').val('');
	$('#accs_name').val('');
	$('#accs_cost').val(0.00);
	$('#accs_price').val(0.00);
	$('#accs_status').prop('checked',true);
	$('#accs_width').val(0);
	$('#accs_depth').val(0);
	$('#accs_count').val(0);
	$('#addAccsBtn').text('Add to Database');
	$('#addAccs').modal('show');
}

function update_accs(){
	$('.is-invalid').removeClass('.is-invalid');
	if ($('#add_accs #accs_name').val() == '') {
		alert("Accessory must have a name.");
		$('#add_accs #accs_name').addClass('.is-invalid');
		$('#add_accs #accs_name').focus();
		return;
	}
	if ($('#add_accs #accs_cost').val() < 1) {
		$('#add_accs #accs_cost').val(0);
	}
	if ($('#add_accs #accs_price').val() < 1) {
		alert("A selling price must be entered.");
		$('#add_accs #accs_price').addClass('.is-invalid');
		return;
	}
	if ($('#add_accs #accs_width').val() < 1) {
		$('#add_accs #accs_width').val(0);
	}
	if ($('#add_accs #accs_width').val() < 1) {
		$('#add_accs #accs_width').val(0);
	}
	if ($('#add_accs #accs_depth').val() < 1) {
		$('#add_accs #accs_depth').val(0);
	}
	if ($('#add_accs #accs_count').val() < 1) {
		$('#add_accs #accs_count').val(0);
	}
	var accs_status;
	if ($('#accs_status').prop('checked') == true) {
		accs_status = 1;
	} else {
		accs_status = 0;
	}
	if (isNaN($('#add_accs #accs_code option:selected').val()) || $('#add_accs #accs_code option:selected').val() < 1) {
		alert("You must select which type of Accesseory it is.");
		$('#add_accs #accs_code').addClass('.is-invalid');
		return;
	}
	var datastring = 'action=' + $('#add_accs input[name=action]').val() + '&accs_id=' + $('#add_accs #accs_id').val() + '&accs_name=' + $('#add_accs #accs_name').val() + '&accs_code=' + $('#add_accs #accs_code option:selected').val() + '&accs_model=' + $('#add_accs #accs_model').val() + '&accs_cost=' + $('#add_accs #accs_cost').val() + '&accs_price=' + $('#add_accs #accs_price').val() + '&accs_width=' + $('#add_accs #accs_width').val() + '&accs_depth=' + $('#add_accs #accs_depth').val() + '&accs_count=' + $('#add_accs #accs_count').val() + '&accs_status=' + accs_status;

	console.log(datastring);
	$.ajax({
		url: 'ajax.php',
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


</script>
</body>
</html>