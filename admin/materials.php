<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
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
<title>ACP | Admin - Materials</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?
// INCLUDE THE JS and CSS files needed on all ADMIN PAGES
include('includes.php');

?>

    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
    <script src="js/projects.js"></script>
    <script src="js/project_edit.js"></script>
    <script src="js/materials.js"></script>


<?PHP include ('javascript.php'); ?>
</head>
<body class="metro" style="background-color: rgb(239, 234, 227);" >
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div id="loadOver"></div>
<div class="container">
	<div class="grid fluid">
		<h1><br>Materials<br></h1>
        <br>
		<div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
        <br>
	</div>
</div>
<!-- START BODY CONTENT AREA -->
<div class="container pageLook">
	<div class="grid fluid">
    	<div class="row">
<?
require_once ('materials_pull.php');
?>
		</div>
	</div>
</div>
<!-- END BODY CONTENT AREA -->
<? 
include ('footer.php');
include ('modal_install_edit.php');
include ('modal_project_edit.php');
include ('modal_comment_add.php');
include ('modal_email_success.php');
include ('modal_location.php');
include ('modal_piece_add.php');
include ('modal_sink_edit.php');
//include ('modal_qr_reader.php');
include ('modal_contact_verif.php');
include ('modal_user_discount.php');
include ('modal_entry_reject.php');
	
?>

<div class="modal fade" id="materialSelect" tabindex="-1" role="dialog" aria-labelledby="materialSelectLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-paper-plane-o"></i>
				<div class="modal-title">Select Material</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="container">
						<div class="row px-0">
							<select class="levelFilter col-12 mb-3 form-control input-lg">
								<option class="btn btn-lg btn-dark mx-1 px-4" value="0">Filter...</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="1">Level 1</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="2">Level 2</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="3">Level 3</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="4">Level 4</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="5">Level 5</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="6">Level 6</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="7">Level 7</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="8">Level 8</option>
								<option class="btn btn-lg btn-dark mx-1 px-4" value="9">Specialty</option>
							</select>
							<input class="form-control input-lg searchMat col-12 mb-3" placeholder="Search">
						</div>
					</div>
					<div id="matSelectCards" class="row">


					</div>
					<hr>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="materialAssign" tabindex="-1" role="dialog" aria-labelledby="materialAssignLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-paper-plane-o"></i>
				<div class="modal-title">Assign Material to <span class="mAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="assign_material" class="setMaterial row">
						<input type="hidden" name="action" value="assign_material">
						<input type="hidden" name="iid" value="">
						<input type="hidden" name="material_status" value="3">
						<label for="assigned_material" class="col-2">Assign Material:</label>
						<input type="text" name="assigned_material" class="col-4 form-control">
						<button type="submit" class="btn btn-primary ml-3">Assign Material</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="materialOrder" tabindex="-1" role="dialog" aria-labelledby="materialOrderLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-paper-plane-o"></i>
				<div class="modal-title">Ordered Materials for <span class="mAssign"></span></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form id="ordered_material" class="odrerMaterial row">
						<input type="hidden" name="action" value="ordered_material">
						<input type="hidden" name="iid" value="">
						<input type="hidden" name="material_status" value="2">
						<label class="col-2" for="assigned_material">Order Reference:</label>
						<input class="col-3 form-control" type="text" name="assigned_material">
						<label class="col-2" for="material_date">Expected Date:</label>
						<input class="col-3 form-control" id="material_date" name="material_date" type="date">
						<button type="submit" class="btn btn-primary ml-3">Materials Ordered</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<script>
</script>
</body>
</html>