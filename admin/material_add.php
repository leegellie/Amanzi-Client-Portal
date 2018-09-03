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

    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
	    	<div class="col-md-6">
				<div class="dark-stone m-4">
					<div class="text-white text-left pt-4 px-4" >
						<h1 class="pt-2 text-uppercase">Add Materials</h1>
					</div>
					<div class="row w-100 m-0">
						<div class="col-md-6">
							<div class="text-center">
								<a class="block" onClick="$('#materialAddMarble').modal('show')"><h1 class="text-white py-4">Marb/Gran</h1></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-center">
								<a class="block" onClick="$('#materialAddQuartz').modal('show')"><h1 class="text-white py-4">Quartz</h1></a>
							</div>
						</div>
					</div>
				</div>
            </div>
	    	<div class="col-md-6">
				<div class="dark-stone m-4">
					<div class="text-white text-left pt-4 px-4">
						<h1 class="pt-2 text-uppercase">Add Accessories</h1>
					</div>
					<div class="row w-100 m-0">
						<div class="col-md-6">
							<div class="text-center">
								<a class="block" onClick="$('#materialAddSink').modal('show')"><h1 class="text-white py-4">Sink</h1></a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-center">
								<a class="block" onClick="$('#materialAddFaucet').modal('show')"><h1 class="text-white py-4">Faucet</h1></a>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<!-- END BODY CONTENT AREA -->
<? include ('footer.php'); ?>
<? echo $access_level ?>

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


<div class="modal fade" id="materialAddSink" tabindex="-1" role="dialog" aria-labelledby="materialAddSinkLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Sink</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
                <h2>Coming soon...</h2>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="materialAddFaucet" tabindex="-1" role="dialog" aria-labelledby="materialAddFaucetLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fas fa-plus"></i>
				<div class="modal-title">Add Faucet</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
                <h2>Coming soon...</h2>
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