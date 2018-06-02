<?
if(!session_id()) session_start();
//ini_set('session.gc_maxlifetime', 0);
//ini_set('cookie_secure','1');
//session_set_cookie_params(0,'/','',true,true);
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
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

    foreach($jobs as $job)
    {
        $tmp[$job['template_date']][] = $job;
    }
    $output = array();
    
    foreach($tmp as $type => $labels)
    {
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
    foreach($jobs as $job)
    {
        $tmp[$job['install_date']][] = $job;
    }
    $outputforinstall = array();
    
    foreach($tmp as $type => $labels)
    {
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

    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
    <script src="js/projects.js"></script>
    <script src="js/printThis.js"></script>
    <link rel="stylesheet" href="css/pikaday.css">
    <link rel="stylesheet" href="css/site.css">

<script>
<?PHP 
if(isset($_GET['add'])){
	require_once ('js/project_add.js');
}else{
	require_once ('js/project_edit.js');
}
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
		<h1 class="d-print-none"><br>Client Projects<br></h1>
		<div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
	</div>
</div>
<!-- START BODY CONTENT AREA -->
<?
if(isset($_GET['add'])){
	require_once ('project_add.php');
}elseif(isset($_GET['entry'])){
	require_once ('project_entry.php');
}elseif(isset($_GET['templates'])){
	require_once ('project_templates.php');
}elseif(isset($_GET['installs'])){
	require_once ('project_installs.php');
}elseif(isset($_GET['edit'])){
	require_once ('project_edit.php');
}elseif(isset($_GET['marbgran'])){
	require_once ('project_marbgran.php');
}elseif(isset($_GET['quartz'])){
	require_once ('project_quartz.php');
}elseif(isset($_GET['timeline'])){
  require_once('project_timeline.php');
}
?>
<!-- END BODY CONTENT AREA -->
<? include ('footer.php'); ?>
<? 
// echo $access_level 
?>
<div class="modal fade" id="editPjt">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="pjt_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">

					<form id="editPjtOne" class="row">
						<input type="hidden" id="p-pid" name="id" value="">
						<input type="hidden" id="p-uid" name="uid" value="">
						<input type="hidden" id="p-job_lat" name="job_lat">
						<input type="hidden" id="p-job_long" name="job_long">

						<input type="hidden" id="p-job_sqft">


						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-md-4">
									<label for="job-name">Job Name:</label>
									<input required class="form-control" id="p-job_name" name="job_name" type="text" data-required="true">
                  <input type="text" class="form-control" id="p-geo-lat" hidden>
                  <input type="text" class="form-control" id="p-geo-long" hidden>
                  <input type="text" class="form-control" id="p-job-sqft" hidden>
								</fieldset>
								<fieldset class="form-group col-md-3">
									<label for="account-rep">Account Rep:</label>
									<select class="mdb-select" id="p-acct_rep" name="acct_rep">
										<option value="0">Unspecified</option>
<?
	$uOptions = '';
	$salesReps = new project_action;
	foreach($salesReps->get_reps() as $results) {
		$uOptions .= '<option value="' . $results['id'] . '">' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	}
	echo $uOptions;
?>
									</select>
								</fieldset>

								<fieldset class="form-group col-6 col-md-2">
									<label for="quote-num">Quote #:</label>
									<input class="form-control text-center" id="p-quote_num" name="quote_num" type="text">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="order-num">Order #:</label>
									<input class="form-control text-center" id="p-order_num" name="order_num" type="text">
								</fieldset>
								<fieldset class="form-check col-4 col-md-1">
									<input id="p-isActive" class="form-check-input filled-in" name="isActive" type="checkbox" value="1">
									<label for="p-isActive" class="w-100">Active?</label>
								</fieldset>




							</div>
						</div>

						<div class="container pt-3 mb-3">
							<div class="row">
								<fieldset class="form-group col-4 col-md-2 ">
									<input class="filled-in mr-4" name="urgent" id="p-urgent" type="checkbox" value="1">
									<label for="p-urgent" class="w-100 ">911?:</label>
									<input class="filled-in mr-4" name="tax_free" id="p-tax_free" type="checkbox" value="1">
									<label for="p-tax_free" class="w-100 ">No Tax:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<label class="w-100" for="job_tax">Tax Rate:</label>
									<input class="form-control text-center" name="job_tax" id="p-job_tax" type="text">
								</fieldset>
								<fieldset class="form-group col-md-2">
									<label for="builder-name">Company:</label>
									<input class="form-control" id="p-builder" name="builder" type="text">
								</fieldset>
								<fieldset class="form-check col-md-2">
									<label for="p-job_discount" class="w-100">Job Discount:</label>
									<input id="p-job_discount" class="form-control text-center" name="job_discount" type="text" value="0">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="po-cost">P.O. Cost:</label>
									<input class="form-control currency" id="p-po_cost" name="po_cost" type="text">
								</fieldset>
								<fieldset class="form-group col-6 col-md-2">
									<label for="po-num">P.O. #:</label>
									<input class="form-control" id="p-po_num" name="po_num" type="text">
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="site-address">Site Address:</label>
									<input class="form-control addChg" id="p-address_1" name="address_1" type="text">
								</fieldset>
								<fieldset class="form-group col-12">
									<input class="form-control addChg" id="p-address_2" name="address_2" type="text">
								</fieldset>
								<fieldset class="form-group col-md-4">
									<label for="site-address">City:</label>
									<input class="form-control addChg" id="p-city" name="city" type="text">
								</fieldset>
								<fieldset class="form-group col-8 col-md-3">
									<label for="site-address">State:</label>
									<select class="mdb-select addChg" id="p-state" name="state">
										<option value="AL">Alabama</option>
										<option value="AK">Alaska</option>
										<option value="AZ">Arizona</option>
										<option value="AR">Arkansas</option>
										<option value="CA">California</option>
										<option value="CO">Colorado</option>
										<option value="CT">Connecticut</option>
										<option value="DE">Delaware</option>
										<option value="DC">District Of Columbia</option>
										<option value="FL">Florida</option>
										<option value="GA">Georgia</option>
										<option value="HI">Hawaii</option>
										<option value="ID">Idaho</option>
										<option value="IL">Illinois</option>
										<option value="IN">Indiana</option>
										<option value="IA">Iowa</option>
										<option value="KS">Kansas</option>
										<option value="KY">Kentucky</option>
										<option value="LA">Louisiana</option>
										<option value="ME">Maine</option>
										<option value="MD">Maryland</option>
										<option value="MA">Massachusetts</option>
										<option value="MI">Michigan</option>
										<option value="MN">Minnesota</option>
										<option value="MS">Mississippi</option>
										<option value="MO">Missouri</option>
										<option value="MT">Montana</option>
										<option value="NE">Nebraska</option>
										<option value="NV">Nevada</option>
										<option value="NH">New Hampshire</option>
										<option value="NJ">New Jersey</option>
										<option value="NM">New Mexico</option>
										<option value="NY">New York</option>
										<option value="NC">North Carolina</option>
										<option value="ND">North Dakota</option>
										<option value="OH">Ohio</option>
										<option value="OK">Oklahoma</option>
										<option value="OR">Oregon</option>
										<option value="PA">Pennsylvania</option>
										<option value="RI">Rhode Island</option>
										<option value="SC">South Carolina</option>
										<option value="SD">South Dakota</option>
										<option value="TN">Tennessee</option>
										<option value="TX">Texas</option>
										<option value="UT">Utah</option>
										<option value="VT">Vermont</option>
		
										<option value="VA">Virginia</option>
										<option value="WA">Washington</option>
										<option value="WV">West Virginia</option>
										<option value="WI">Wisconsin</option>
										<option value="WY">Wyoming</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<label for="site-address">Zip:</label>
									<input class="form-control addChg" id="p-zip" name="zip" type="text">
								</fieldset>
								<div class="col-3">
									<div class="w-100 btn btn-primary addLU" onClick="check_address()">Address Lookup <i class="fas fa-search"></i></div>
									<div class="w-100 btn btn-success addVF hidden">Address Located <i class="fas fa-check"></i></div>
									<div class="w-100 btn btn-danger addFA hidden">Address Failed <i class="fas fa-times"></i></div>
								</div>
								<fieldset class="form-group col-12">
									<label for="address_notes"><b>Address Notes:</b></label>
									<textarea class="form-control" id="p-address_notes" name="address_notes" type="text" rows="2"></textarea>
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3">
							<div class="row">
								<fieldset class="form-group col-6 col-md-6">
									<div class="container">
										<div class="row">
											<label class="col-md-5" for="template-date">Template Date:</label>
											<!--<input class="col-md-7 form-control" id="p-template_date" name="template_date" type="date">-->
											<input class="col-md-7 form-control datepicker" type="text" id="p-template_date" name="template_date">
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" id="p-temp_am" name="temp_am" type="checkbox" value="1">
									<label for="p-temp_am">AM?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" id="p-temp_first_stop" name="temp_first_stop" type="checkbox" value="1">
									<label for="p-temp_first_stop">1st Stop?:</label>
								</fieldset>
		
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" id="p-temp_pm" name="temp_pm" type="checkbox" value="1">
									<label for="p-temp_pm">PM?:</label>
								</fieldset>
								<hr>
								<fieldset class="form-group col-6 col-md-6">
									<div class="container">
										<div class="row">
											<label class="col-md-5" for="install-date">Install Date:</label>
											<input class="col-md-7 form-control datepicker1" type="text" id="p-install_date" name="install_date">
											<!--<input class="col-md-7 form-control" id="p-install_date" name="install_date" type="date">-->
										</div>
									</div>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" name="am" id="p-am" type="checkbox" value="1">
									<label for="p-am">AM?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" name="first_stop" id="p-first_stop" type="checkbox" value="1">
									<label for="p-first_stop">1st Stop?:</label>
								</fieldset>
								<fieldset class="form-group col-4 col-md-2">
									<input class="filled-in" name="pm" id="p-pm" type="checkbox" value="1">
									<label for="p-pm">PM?:</label>
								</fieldset>
							</div>
						</div>

						<div class="container pt-3 mb-3 border border-light border-right-0 border-left-0 blue lighten-5">
							<div class="row">
								<fieldset class="form-group col-md-6">
									<label for="contact-name">Site Contact:</label>
									<input class="form-control" id="p-contact_name" name="contact_name" type="text" placeholder="Name">
									<!--<label for="contact-phone">Contact Telephone:</label>-->
									<input class="form-control" id="p-contact_number" name="contact_number" type="tel" placeholder="phone">
									<!--<label for="contact-phone">Contact Email:</label>-->
									<input class="form-control" id="p-contact_email" name="contact_email" type="email" placeholder="email">
								</fieldset>
								<fieldset class="form-group col-md-6">
									<label for="contact-name2">Alternative Contact:</label>
									<input class="form-control" id="p-alternate_name" name="alternate_name" type="text" placeholder="Name">
									<!--<label for="contact-phone2">Alternative Telephone:</label>-->
									<input class="form-control" id="p-alternate_number" name="alternate_number" type="tel" placeholder="phone">
									<!--<label for="contact-phone2">Alternative Email:</label>-->
									<input class="form-control" id="p-alternate_email" name="alternate_email" type="email" placeholder="email">
								</fieldset>
							</div>
						</div>


						<fieldset class="form-group col-12">
							<label for="site-address">Job Notes:</label>
							<textarea class="form-control" id="p-job_notes" name="job_notes" type="text" rows="4"></textarea>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
							</label>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
								<input class="col-6 mb-2" onChange="addUpload(this);" name="imgUploads[]" type="file">
							</label>
						</fieldset>
						<div class="col-12 mt-2 form-box">
							<div class="row">
								<input id="p-action" name="action" type="hidden" value="update_project_data"><br>
								<div class="btn btn-primary" name="pjtUpdate" id="pjtUpdate" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Update Project</div>
							</div>
						</div>
					</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editInstall">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="inst_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<form id="updateInstall" class="row">
					<input type="hidden" id="i-iid" name="id" value="">
					<input type="hidden" id="i-pid" name="pid" value="">
					<input type="hidden" id="i-cpSqFt" name="cpSqFt" value="0">
					<input type="hidden" id="i-materials_cost" name="materials_cost" value="0">

					<div class="container">
						<div class="row">
					<fieldset class="form-group col-3">
						<label for="install_room">Room Type:</label>
						<select class="mdb-select" id="i-install_room" name="install_room" type="text" data-required="true">
						<?
							$get_rooms = new project_action;
							$rows = $get_rooms->get_rooms();
							foreach ($rows as $row) {
								echo "<option value='" . $row['type_id'] . "'>" . $row['type_name'] . "</option>";
							}
						?>
						</select>
					</fieldset>
					<fieldset class="form-group col-9">
						<label for="install1-name">Area/Install Name:</label>
						<input class="form-control" id="i-install_name" name="install_name" type="text" data-required="true" required>
					</fieldset>
					</div>
					</div>

					<div class="container pt-3  border border-light border-right-0 border-left-0 blue lighten-5">
						<div class="row">

					<fieldset class="form-group col-12 col-md-6 col-lg-3">
						<div class="row">
							<legend class="col-form-legend col-12">Job Type:</legend>
							<div class="col-12">
								<div class="form-check form-check-inline col-12">
										<input checked="" class="form-check-input with-gap" id="i-typea" name="type" type="radio" value="New">
									<label for="i-typea">
										<p class="d-inline ml-4">New Install</p>
									</label>
								</div>
								<div class="form-check form-check-inline">
										<input class="form-check-input with-gap" id="i-typeb" name="type" type="radio" value="Remodel">
									<label for="i-typeb">
										<p class="d-inline ml-4">Remodel</p>
									</label>

								</div>
							</div>
						</div>
					</fieldset>
					<fieldset class="form-group col-12 col-md-6 col-lg-3">
						<div class="row">
							<legend class="col-form-legend col-12">Tear Out:</legend>
							<div class="col-12">
								<div class="form-check form-check-inline col-12">
										<input class="form-check-input with-gap" id="i-tear_outa" name="tear_out" type="radio" value="Yes">
									<label for="i-tear_outa">
										<p class="d-inline ml-4">Yes</p>
									</label>
								</div>
								<div class="form-check form-check-inline">
										<input checked="" class="form-check-input with-gap" id="i-tear_outb" name="tear_out" type="radio" value="No">
									<label for="i-tear_outb">
										<p class="d-inline ml-4">No</p>
									</label>
								</div>
							</div>
						</div>
					</fieldset>



					<fieldset class="form-group col-12 col-lg-6">
						<label for="i-material">Material:</label>
						<select class="mdb-select" id="i-material" name="material">
							<option value="0">Not Selected</option>
							<option value="marbgran">Marble/Granite</option>
							<option value="quartz">Quartz/Quartzite</option>
						</select>
					</fieldset>
					</div>
					</div>





					<div class="container pt-3 ">
						<div class="row">

							<fieldset class="form-group col-12 col-md-6">
		
								<label for="color">Color:</label>
								<input class="form-control matControl" list="i-color" id="i-color-box" name="color" type="text">
								<div class="btn btn-sm btn-danger input-group-addon float-right" onClick="$('#i-color-box').val('')"><i class="fas fa-times"></i></div>
								<div class="btn btn-sm btn-primary input-group-addon float-right matPickerBtn" onClick="matModalOpen(this);"><i class="fa fa-eye"></i></div>
								<datalist id="i-color" class="colorChoose">
								</datalist>
							</fieldset>
							<div class="col-3">
								<div class="row">
									<fieldset class="form-group col-4 col-md-12">
										<label for="lot">Lot #:</label>
										<input class="form-control matControl" id="i-lot" name="lot" type="text">
									</fieldset>
									<fieldset class="form-group col-4 col-md-12">
										<label for="i-tearout_sqft">Tear-out SqFt:</label>
										<input class="form-control matControl" id="i-tearout_sqft" name="tearout_sqft" type="number">
									</fieldset>
								</div>
							</div>
							<div class="col-3">
								<div class="row">
									<fieldset class="form-group col-4 col-lg-6">
										<label for="SqFt">SqFt:</label>
										<input class="form-control matControl px-0 text-center" id="i-SqFt" name="SqFt" type="number" value="0" readonly>
									</fieldset>
									<fieldset class="form-group col-4 col-lg-6">
										<label for="slabs">Slabs:</label>
										<input class="form-control matControl px-0 text-center" id="i-slabs" name="slabs" type="number" value="0">
									</fieldset>
									<fieldset class="form-group col-4 col-lg-12">
										<label for="cpSqFt_override">Overide SqFt Price:</label>
										<input class="form-control matControl px-0 text-center" id="i-cpSqFt_override" name="cpSqFt_override" type="number" value="0">
									</fieldset>
								</div>
							</div>
						</div>
					</div>

					<div class="container matHolder hidden border pt-2">
						<div class="row">
							<div class="col-12 col-md-5">
								<select class="levelFilter mdb-select">
									<option value="0">Filter...</option>
									<option value="1">Level 1</option>
									<option value="2">Level 2</option>
									<option value="3">Level 3</option>
									<option value="4">Level 4</option>
									<option value="5">Level 5</option>
									<option value="6">Level 6</option>
									<option value="7">Level 7</option>
									<option value="8">Level 8</option>
									<option value="9">Specialty</option>
								</select>
							</div>
							<div class="col-12 col-md-5 pt-2">
								<input class="form-control searchMat" placeholder="Search...">
							</div>
							<div class="col-12 col-md-2 pt-1">
								<div class="btn btn-danger btn-sm w-100" onClick="$('.matHolder').addClass('hidden')"><i class="fas fa-times"></i></div>
							</div>
						</div>
						<hr>
						<div class="matSelectCards row"></div>
						<hr>
					</div>



					<div class="container pt-3  border border-light border-right-0 border-left-0 blue lighten-5">
						<div class="row">
							<fieldset class="form-group col-6 col-md-3">
								<div class="row">
									<legend class="col-form-legend col-12">Customer Selected?</legend>
									<div class="col-12">
										<div class="form-check form-check-inline col-6">
											<input class="form-check-input with-gap" id="i-selecteda" name="selected" type="radio" value="Yes">
											<label for="i-selecteda" class="form-check-label">Yes</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input with-gap" id="i-selectedb" name="selected" type="radio" value="No">
											<label for="i-selectedb" class="form-check-label">No</label>
										</div>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-price_calc">Material Price:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-price_calc" name="price_calc" type="number" value="0" readonly>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-accs_prices">Sinks &amp; Faucets Prices:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-accs_prices" name="accs_prices" type="number" value="0" readonly>
								</div>
							</fieldset>
							<fieldset class="form-group col-6 col-lg-3">
								<label for="i-price_extra">Extra Prices:</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
									</div>
									<input class="form-control" id="i-price_extra" name="price_extra" type="number" value="0">
								</div>
							</fieldset>
						</div>
					</div>

					<div class="container pt-3  ">
						<div class="row">
							<fieldset class="form-group col-3">
								<label for="edge">Default Edge:</label>
								<select class="mdb-select" id="i-edge" name="edge">
<?
	$get_accs = new project_action;
	$rows = $get_accs->get_edges();
	foreach ($rows as $row) {
		echo "<option value='" . $row['id'] . "' price='" . $row['edge_price'] . "'>" . $row['edge_name'] . "</option>";
	}
?>
								</select>
							</fieldset>
							<fieldset class="form-group col-3">
								<label for="range_type">Range Type:</label>
								<select class="mdb-select" id="i-range_type" name="range_type">
									<option value="0">None</option>
									<option value="1">Free Standing</option>
									<option value="2">Cooktop</option>
									<option value="3">Slide-In</option>
								</select>
							</fieldset>
							<fieldset class="form-group col-md-3">
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="model">Model #:</label>
										<input class="form-control" id="i-range_model" name="range_model" type="text">
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-3">
								<div class="row">
									<fieldset class="form-group col-12">
										<label for="cutout">Cooktop Cutout:</label>
										<input class="form-control" id="i-cutout" name="cutout" type="text">
									</fieldset>
								</div>
							</fieldset>
						</div>
					</div>

					<div class="container pt-3  border border-light border-right-0 border-left-0 red lighten-4">
						<div class="row">
							<h3 class="d-inline text-muted w-100 pl-3">To be discontinued</h3>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="backsplash">Backsplash</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right bs_detail" id="i-bs_detail" name="bs_detail" placeholder="Details" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="riser">Riser</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right rs_detail" id="i-rs_detail" name="rs_detail" placeholder="Details" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-4">
								<div class="row">
									<fieldset class="form-group col-12">
										<label class="form-check-label container" for="sinks">Sinks</label>
										<input class="form-control form-inline col-9 col-lg-12 float-right sk_detail" id="i-sk_detail" name="sk_detail" placeholder="Details/Model" type="text" readonly>
									</fieldset>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<div class="form-group col-12">
										<label for="holes">Faucet Spread / Holes:</label>
										<select class="mdb-select holeOpt" id="i-holes" name="holes" readonly>
											<option value="0">None</option>
											<option disabled value="1">1 Hole - Center</option>
											<option disabled value="2">3 Hole - 4"</option>
											<option disabled value="3">3 Hole - 8"</option>
											<option disabled class="controller" data-control="holes_other" value="99">Other Holes</option>
										</select>
									</div>
								</div>
							</fieldset>
							<fieldset class="form-group col-12 col-md-4">
								<div class="row">
									<div class="form-group col-12">
										<label for="holes">Specify other holes needed:</label>
										<input class="form-control" id="i-holes_other" name="holes_other" type="text" readonly>
									</div>
								</div>
							</fieldset>
						</div>
					</div>

					<fieldset class="form-group col-12">
						<label for="install_notes">Install Notes:</label>
						<textarea class="form-control" id="i-install_notes" name="install_notes" rows="3"></textarea>
					</fieldset>
					<fieldset class="form-group container">
						<label id="uploadContain2" class="row" for="imgUploads">
							<input class="col-6 mb-2" onChange="addUpload(this);" name="imgUploads[]" type="file">
						</label>
					</fieldset>
					<input id="isActive" name="isActive" type="hidden" value="1">
					<input id="i-instUID" name="instUID" type="hidden" value="">
					<input id="i-action" name="action" type="hidden" value="update_install_data"><br>
					<div class="btn btn-primary" name="instUpdate" id="instUpdate" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Update Install</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="selectCompany" tabindex="-1" role="dialog" aria-labelledby="selectCompanyLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title"><h3>Search Project Owners</h3></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<form name="findToAdd" id="findToAdd" action="#" class="AdvancedForm row">
						<fieldset class="col-6 col-md-3">
							<div id="user_infoDIV" class="input-control text input-box" data-role="input-control">
								<input class="form-control" name="search" id="search" type="text" placeholder="Search Term" value="" />
							</div>
						</fieldset>
						<fieldset class="col-6 col-md-2">
							<div id="user_infoDIV" class="input-control select" data-role="input-control">
								<select class="mdb-select" name="user_find" id="user_find" data-transform="input-control">
									<option value="username">Username</option>
									<option value="email">Email</option>
									<option value="company" selected>Company</option> 
									<option value="fname">First Name</option>
									<option value="lname">Last Name</option>   
								</select>
							</div>
						</fieldset>
						<fieldset class="col-3 col-md-2">
							<div id="user_infoDIV" class="form-check" data-role="input-control">
								
								<input class="filled-in" type="checkbox" name="isActive" id="s-isActive" value="1" checked >
								<label style="padding-bottom:9px;" for="s-isActive">Active?</label>
							</div>
						</fieldset>
						<fieldset class="col-3 col-md-2">
							<div id="user_infoDIV" class="form-check" data-role="input-control">
								<input class="filled-in" type="checkbox" name="mine" id="mine" value="1" <? if (!in_array($_SESSION['id'],array('1','13','14','985'),true)) {echo 'checked';}; ?> >
								<label style="padding-bottom:9px;" for="mine">My Clients</label>
							</div>
						</fieldset>
						<fieldset class="col-6 col-md-3">
							<input name="action" id="action" type="hidden" value="user_project_user_search" />
							<input name="searchChild" id="searchChild" type="hidden" value="0" />
							<div id="submitForm" class="btn btn-primary" style="height: 36px; width: 100%; padding-top: 14px;">
								<h3 style="line-height: .1;font-weight:400">Search</h3>
							</div>
						</fieldset>
					</form>
					<div id="tableHolder" style="overflow-y:scroll;overflow-x: hidden; max-height:380px; margin-bottom:5px">
						<div id="tableResults"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onClick="addClient();">Add Client <i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="addClientLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title">Add New Client</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h1>Add New User</h1>
					</div>
					<form name="user_data" id="user_data" action="#" class="AdvancedForm row">
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>User Role:</p>
								</div>
								<div class="col-7 p-0">
									<div id="user_typeDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="user_type" id="user_type" data-transform="input-control">
											<option value="0" selected>Select User Type</option> 
	
											<?
												if ($_SESSION['access_level'] == 1) {
					
													echo '<option value="0" disabled>&nbsp;&nbsp;Internal Employees</option>';
													$internal_user_roles = new user_action;
													$rows = $internal_role_rows = $internal_user_roles->get_user_roles("1","0");
													foreach ($rows as $row) {
														echo "<option value='$row[0]'>$row[2]</option>";
													}
													echo '<option value="0" disabled></option>';
													echo '<option value="0" disabled>&nbsp;&nbsp;External Customers</option>';
												}
												$internal_user_roles = new user_action;
												$rows = $internal_role_rows = $internal_user_roles->get_user_roles("0","1");
												foreach ($rows as $row) {
													echo "<option value='$row[0]'>$row[2]</option>";
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Username: </p>
								</div>
								<div class="col-7 p-0">
									<div id="usernameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="username" id="username" type="text" value="" data-transform="input-control"> <span id="usernameError"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-3 ">
									<p>Discount %: </p>
								</div>
								<div class="col-3 ">
									<input class="form-control" name="discount" id="discount"  type='number' step='0.01' value='0.00' data-transform="input-control">
									<span id="usernameError"></span>
								</div>
								<div class="col-3 ">
									<p>Qtz Disc. %: </p>
								</div>
								<div class="col-3 ">
									<input class="form-control" name="discount_quartz" id="discount_quartz" step='0.01' value='0.00' data-transform="input-control">
									<span id="usernameError"></span>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Password: </p>
								</div>
								<div class="col-7 p-0">
									<div id="passwordDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="password" id="password" type="password" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Verify Password: </p>
								</div>
								<div class="col-7 p-0">
									<div id="v_passwordDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="v_password" id="v_password" type="password" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 p-0">
							<h4>Contact Info:</h4>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>First Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="fnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="fname" id="fname" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Last Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="lnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="lname" id="lname" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Company: </p>
								</div>
								<div class="col-7 p-0">
									<div id="companyDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="company" id="company" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Email: </p>
								</div>
								<div class="col-7 p-0">
									<div id="emailDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="email" id="email" value="" data-transform="input-control">
										<span id="emailError"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Phone: </p>
								</div>
								<div class="col-7 p-0">
									<div id="phoneDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="phone" id="phone" value="" data-transform="input-control" placeholder="Just number, no spaces or format">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Address:</p>
								</div>
								<div class="col-7 p-0">
									<div id="address1DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="address1" id="address1" value="" data-transform="input-control">
									</div>
									<div id="address2DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="address2" id="address2" value="" placeholder="Optional" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>City: </p>
								</div>
								<div class="col-7 p-0">
									<div id="cityDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="city" id="city" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>State: </p>
								</div>
								<div class="col-7 p-0">
									<div id="stateDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="state" id="state" value="" data-transform="input-control">
											<option value="" selected>Choose a State</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC" selected>North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Zip: </p>
								</div>
								<div class="col-7 p-0">
									<div id="zipDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="zip" id="zip" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<input name="action" id="action" type="hidden" value="add_user_data">
							<input name="submit" class="btn btn-primary float-right" id="FormSubmit" type="submit" value="Add User" data-transform="input-control">
							<span id="user_email_error"></span>
						</div>
					</form>
					<form name="user_billing" id="user_billing" action="#" class="row pl-3" style="display: none">
						<div class="col-12 p-0">
							<h4>Billing Information:</h4>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-7 p-0">
									<p style="font-weight:bold">Same as User Account?</p>
								</div>
								<div class="col-5 p-0">
									<div style="display:inline-block" class="input-control switch margin10" data-role="input-control">
										<label style="display:inline-block">
											<input class="with-font" style="display:inline-block" id="sameAdd" name="sameAdd" type="checkbox" value="sameAs" data-transform="input-control" data-transform-type="switch" onChange="autoFillBilling()">
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Name: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_fnameDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_name" id="billing_name" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Company: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_companyDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_company" id="billing_company" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Address: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_address1DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_address1" id="billing_address1" value="" data-transform="input-control">
									</div>
									<div id="billing_address2DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_address2" id="billing_address2" placeholder="Optional" value="" data-transform="input-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>City: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_cityDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_city" id="billing_city" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>State: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_stateDIV" class="input-control select" data-role="input-control">
										<select class="mdb-select" name="billing_state" id="billing_state" value="" data-transform="input-control">
											<option value="" selected>Choose a State</option>
											<option value="AL">Alabama</option>
											<option value="AK">Alaska</option>
											<option value="AZ">Arizona</option>
											<option value="AR">Arkansas</option>
											<option value="CA">California</option>
											<option value="CO">Colorado</option>
											<option value="CT">Connecticut</option>
											<option value="DE">Delaware</option>
											<option value="DC">District Of Columbia</option>
											<option value="FL">Florida</option>
											<option value="GA">Georgia</option>
											<option value="HI">Hawaii</option>
											<option value="ID">Idaho</option>
											<option value="IL">Illinois</option>
											<option value="IN">Indiana</option>
											<option value="IA">Iowa</option>
											<option value="KS">Kansas</option>
											<option value="KY">Kentucky</option>
											<option value="LA">Louisiana</option>
											<option value="ME">Maine</option>
											<option value="MD">Maryland</option>
											<option value="MA">Massachusetts</option>
											<option value="MI">Michigan</option>
											<option value="MN">Minnesota</option>
											<option value="MS">Mississippi</option>
											<option value="MO">Missouri</option>
											<option value="MT">Montana</option>
											<option value="NE">Nebraska</option>
											<option value="NV">Nevada</option>
											<option value="NH">New Hampshire</option>
											<option value="NJ">New Jersey</option>
											<option value="NM">New Mexico</option>
											<option value="NY">New York</option>
											<option value="NC" selected>North Carolina</option>
											<option value="ND">North Dakota</option>
											<option value="OH">Ohio</option>
											<option value="OK">Oklahoma</option>
											<option value="OR">Oregon</option>
											<option value="PA">Pennsylvania</option>
											<option value="RI">Rhode Island</option>
											<option value="SC">South Carolina</option>
											<option value="SD">South Dakota</option>
											<option value="TN">Tennessee</option>
											<option value="TX">Texas</option>
											<option value="UT">Utah</option>
											<option value="VT">Vermont</option>
											<option value="VA">Virginia</option>
											<option value="WA">Washington</option>
											<option value="WV">West Virginia</option>
											<option value="WI">Wisconsin</option>
											<option value="WY">Wyoming</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<div class="row p-0">
								<div class="col-5 p-0">
									<p>Zip: </p>
								</div>
								<div class="col-7 p-0">
									<div id="billing_zipDIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_zip" id="billing_zip" value="" data-transform="input-control">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-6">
							<input name="action" id="action" type="hidden" value="add_user_billing">
							<input name="uid" id="uid" type="hidden" value="">
							<input name="submit" class="btn btn-primary float-right" id="BillingSubmit" type="submit" value="Save Billing Data" data-transform="input-control">
						</div>
					</form>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="addCommentLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-comment"></i>
				<div class="modal-title">Add Comment</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h3>Add Comment to <span class="text-primary" id="cmt_name"></span></h3>
						<p class="col-12">Commenting as <span id="commentor" class="text-primary"></span> - Not you? <a href="/logout.php" class="text-primary">Log Out</a></p>
					</div>
					<hr>
					<form id="commentForm" class="row">
						<input type="hidden" name="action" value="submit_comment">
						<input type="hidden" id="cmt_ref_id" name="cmt_ref_id" value="">
						<input type="hidden" id="cmt_type" name="cmt_type" value="">
						<input type="hidden" id="cmt_user" name="cmt_user" value="">
						<label for="cmt_priority" class="form-label col-12 col-md-4">Priority: </label>
						<select name="cmt_priority" id="cmt_priority" class="mdb-select col-12 col-md-8">
							<option value="Normal" selected>Regular</option>
							<option value="911">Important</option>
						</select>
						<label class="form-label col-12 col-md-4">Comment: </label>
						<textarea class="form-control" id="cmt_comment" name="cmt_comment" rows="5"></textarea>
						<hr>
						<div id="submitComments" class="btn btn-lg btn-primary col-12">Submit Comments <i class="fa fa-paper-plane-o"></i></div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>





<div class="modal fade" id="email-success" tabindex="-1" role="dialog" aria-labelledby="email-successLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-paper-plane-o"></i>
				<div class="modal-title">Success</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h3 class="text-success">Data successfully sent to Entry.</h3>
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


<div class="modal fade" id="location" tabindex="-1" role="dialog" aria-labelledby="locationLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-paper-plane-o"></i>
				<div class="modal-title">User Location</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="container">aaa
						<div id="location-div" class="row">
							<div id="mapholder"></div>

						</div>
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


<div class="modal fade" id="add_piece" tabindex="-1" role="dialog" aria-labelledby="locationLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  <span id="piece_title">Add Pieces</span></h2> <div class="btn btn-circle btn-warning ml-2" onClick="$('#shape_info').modal('show')"><i class="fas fa-info"></i></div></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="add_piece">
							<input type="hidden" name="action" value="add_piece">
							<input type="hidden" id="piece_id" name="piece_id" value="0">
							<input type="hidden" id="iid" name="iid" value="">
							<input type="hidden" id="pid" name="pid" value="">
							<input type="hidden" id="pcPriceExtra" name="price_extra" value="">
							<input type="hidden" id="pcSqFt" name="cpSqFt" value="">
							<input type="hidden" name="piece_active" value="1">
							<div class="row">
								<fieldset class="form-group col-12 d-inline">
									<label>Name: </label>
									<input class="form-control" id="piece_name" name="piece_name">
								</fieldset>
		<!--
								<fieldset class="form-group form-check col-2 text-right d-inline">
									<label for="piece_active" class="pr-4">Is active?</label>
									<input id="piece_active" class="form-check-input with-font" name="piece_active" type="checkbox" value="1" checked>
								</fieldset>
		-->

								<fieldset class="form-group col-3 d-inline">
									<label>Shape: </label>
									<select class="mdb-select" id="shape" name="shape">
										<option value="1">Rectangle</option>
										<option value="2">L-Shape</option>
										<option value="3" disabled>Beveled L</option>
										<option value="1">Odd Shape</option>
										<option value="4">SqFt</option>
									</select>
								</fieldset>
								<div class="col-2 rect_shape">
									<div class="row">
										<fieldset class="form-group col-6 d-inline-block">
											<label class="">x: </label>
											<input class="form-control" id="size_x" name="size_x">
										</fieldset>
										<fieldset class="form-group col-6 d-inline-block">
											<label class="">y: </label>
											<input class="form-control" id="size_y" name="size_y">
										</fieldset>
									</div>
								</div>
								<div class="col-6 rect_shape">
									<div class="row">
										<img class="col-6" src="../images/shape-Rect.jpg">
										<img class="col-6" src="../images/shape-Odd.jpg">
									</div>
								</div>



								<div class="col-6 l_shape d-none">
									<div class="row">
										<fieldset class="form-group col-2">
											<label class="">a: </label>
											<input class="form-control cInside cOutside" id="size_a" name="size_a">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">b: </label>
											<input class="form-control cInside" id="size_b" name="size_b">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">c: </label>
											<input class="form-control cInside" id="size_c" name="size_c">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">d: </label>
											<input class="form-control cVariable" id="size_d" name="size_d">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">e: </label>
											<input class="form-control cOutside" id="size_e" name="size_e">
										</fieldset>
										<fieldset class="form-group col-2">
											<label  class="">f: </label>
											<input class="form-control cOutside" id="size_f" name="size_f">
										</fieldset>
										<div class="btn btn-primary calcOutside col-6" onClick="calcOutside()">Calculate From Outside</div>
										<div class="btn btn-primary calcInside col-6" onClick="calcInside()">Calculate From Inside</div>
									</div>
								</div>
								<div class="col-3 l_shape d-none">
									<img class="w-100" src="../images/shape-L2.jpg">
								</div>

								<div class="col-6 bevel_shape d-none">
									<div class="row">
									</div>
								</div>
								<div class="col-3 bevel_shape d-none">
									<img class="w-100" src="../images/shape-L2.jpg">
								</div>

								<div class="col-2 sqft_shape d-none">
									<div class="row">
										<fieldset class="form-group col-12 d-inline-block">
											<label class="">SqFt: </label>
											<input class="form-control type="number" id="SqFt" name="SqFt">
										</fieldset>
									</div>
								</div>
							
							</div>





							<hr class="w-100">
							<div class="container">
								<div class="row">
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Edging</u></label>
											<select class="mdb-select col-6" id="piece_edge" name="piece_edge">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_edges();
										foreach ($rows as $row) {
											echo "<option value='" . $row['id'] . "' price='" . $row['edge_price'] . "'>" . $row['edge_name'] . "</option>";
										}
									?>
											</select>
											<label class="col-3">Length: </label>
											<input class="form-control col-3" id="edge_length" name="edge_length" value="0">
										</div>
									</fieldset>
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Backsplash</u></label>
											<label class="col-3">Height: </label>
											<input class="form-control col-3" id="bs_height" name="bs_height" value="0">
											<label class="col-3">Length: </label>
											<input class="form-control col-3" id="bs_length" name="bs_length" value="0">
										</div>
									</fieldset>
									<fieldset class="form-group col-4 px-4 py-2 border-bottom border-right rounded border-primary">
										<div class="row">
											<label class="col-12"><u>Riser</u></label>
											<label class="col-3">Height: </label>
											<input class="col-3 form-control" id="rs_height" name="rs_height" value="0">
											<label class="col-3">Length: </label>
											<input class="col-3 form-control" id="rs_length" name="rs_length" value="0">
										</div>
									</fieldset>
								</div>
							</div>
						</form>
						<div class="btn btn-lg btn-primary mt-3 w-100" onClick="addPiece('add_piece')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="shape_info" tabindex="-1" role="dialog" aria-labelledby="locationLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-info h2 text-warning"></i>  Entering Shapes</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<h2>Recatanguar Shapes</h2>
					<p>Rectangular shapes just need to have the width (<em>x</em>) and depth/height (<em>y</em>) entered. The square footage will be calculated from this.</p>
					<div class="w-100 text-center"><img src="../images/shape-Rect.jpg" width="300" height="250"></div>
					<hr>
					<h2>L Shapes</h2>
					<p>L-shaped pieces need to have all sides entered. See lableing in diagram A for each shape. If piece has beveled angles inside or on the back side of the L-shape, you must include the distance of this bevel in the dimensions. See diagram B.</p>
					<p>The length of <em><strong>a</strong></em> and <em><strong>c</strong></em> will be matched against <em><strong>e</strong></em> and the lenght of <em><strong>b</strong></em> and <em><strong>d</strong></em> will be matched against <em><strong>f</strong></em> to ensure there are no errors in the calculations.</p>
					<div class="w-100 text-center"><img src="../images/shape-L.jpg" width="300" height="250"><img src="../images/shape-L2.jpg" width="300" height="250"></div>

					<hr>
					<h2>Odd Shapes</h2>
					<p>Odd shapes that do not easily fall into the other 2 categories will just need the overall width (<em>x</em>) and overall depth/height (<em>y</em>) as cut off remainders are not usable remnants.</p>
					<div class="w-100 text-center"><img src="../images/shape-Odd.jpg" width="300" height="250"></div>
					<hr>
					<h2>Wrap Around Pieces</h2>
					<p>Pieces that are larger and will wrap around an area will classify as an "Odd Shape" unless it will need two slabs and then the piece can be divided into 2 or more "L-Shapes" and "Rectangle" shapes at your discression. It is not of vital importance that the seem would be in the correct place, this is just for calculating the square footage.</p>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add_sink" tabindex="-1" role="dialog" aria-labelledby="add_sinkLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  Add Sink / Cutout</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="add_sink">
							<input type="hidden" name="action" value="add_sink">
							<input type="hidden" id="sink_iid" name="sink_iid" value="">
							<input type="hidden" id="sink_price" name="sink_price" value="">
							<input type="hidden" id="faucet_price" name="faucet_price" value="">
							<input type="hidden" id="cutout_price" name="cutout_price" value="">

							<div class="row">
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_part"><u>To which piece does the sink belong</u>: </label>
									<select class="mdb-select" id="sink_part" name="sink_part">
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_provided"><u>Customer provided</u>? </label>
									<select class="mdb-select" id="sink_provided" name="sink_provided">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-5 d-inline">
									<label for="sink_faucet"><u>Faucet</u>: </label>
                                    <div class="input-group">
										<input type="text" list="faucets" class="form-control" id="sink_faucet" name="sink_faucet">
                                    	<div class="input-group-append">
	                                        <button type="button" class="btn btn-muted" onClick="$('#sink_faucet').val('')"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
									<datalist id="faucets">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_accs(2);
										foreach ($rows as $row) {
											echo "<option accs_id='" . $row['accs_id'] . "' price='" . $row['accs_price'] . "' cost='" . $row['accs_cost'] . "'>" . $row['accs_model'] . " - " . $row['accs_name'] . "</option>";
										}
									?>
									</datalist>
								</fieldset>
							</div>

							<hr class="w-100">
							<div class="row">
<!--								<fieldset class="form-group col-3 d-inline">
									<label for="sink_style"><u>Sink Type</u>: </label>
									<select class="mdb-select" id="sink_style" name="sink_style">
										<option value="None">None</option>
										<option value="Drop-In">Drop-In</option>
										<option value="Undermount">Undermount</option>
										<option value="Vessel">Vessel</option>
										<option value="Apron/Farm Style">Apron/Farm Style</option>
										<option value="Top Zero">Top Zero</option>
									</select>
								</fieldset>
-->								<fieldset class="form-group col-9 d-inline">
									<label for="sink_model"><u>Sink Model</u>: </label>
                                    <div class="input-group">
										<input class="form-control" list="sinks" type="text" id="sink_model" name="sink_model">
                                    	<div class="input-group-append">
	                                        <button type="button" class="btn btn-muted" onClick="$('#sink_model').val('')"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
									<datalist id="sinks">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_accs(1);
										foreach ($rows as $row) {
											echo "<option accs_id='" . $row['accs_id'] . "'  width='" . $row['accs_width'] . "'  depth='" . $row['accs_depth'] . "' price='" . $row['accs_price'] . "' cost='" . $row['accs_cost'] . "'>" . $row['accs_model'] . " - " . $row['accs_name'] . "</option>";
										}
									?>
									</datalist>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_mount"><u>Cutout</u>: </label>
									<select class="mdb-select" id="sink_mount" name="sink_mount">
										<option value="0">None</option>
										<option value="1">Undermount</option>
										<option value="2">Drop-In</option>
										<option value="3">Vessel</option>
										<option value="4">Apron/Farm Style</option>
										<option value="5">Top Zero</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes"><u>Faucet Spread / Holes</u>:</label>
									<select class="mdb-select holeOpt" id="sink_holes" name="sink_holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="sink_holes_other" value="99">Other Holes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes_other"><u>Sink Holes Data</u>:</label>
									<input type="text" class="form-control" id="sink_holes_other" name="sink_holes_other">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<input type="checkbox" class="filled-in form-control" id="sink_soap" name="sink_soap" value="1">
									<label for="sink_soap"><u>Soap Hole</u>?</label>
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_width"><u>Cutout Width</u>:</label>
									<input type="text" class="form-control" id="cutout_width" name="cutout_width" value="0">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_depth"><u>Cutout Depth</u>:</label>
									<input type="text" class="form-control" id="cutout_depth" name="cutout_depth" value="0">
								</fieldset>
							</div>

						</form>
						<div id="addSinkBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="add_sink('add_sink')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_sink" tabindex="-1" role="dialog" aria-labelledby="edit_sinkLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-plus text-warning"></i>  Add Sink / Cutout</h2></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<form id="edit_sink">
							<input type="hidden" name="action" value="update_sink">
							<input type="hidden" id="e-sink_id" name="sink_id" value="">
							<input type="hidden" id="e-sink_iid" name="sink_iid" value="">
							<input type="hidden" id="e-sink_price" name="sink_price" value="">
							<input type="hidden" id="e-sink_cost" name="sink_cost" value="">
							<input type="hidden" id="e-cutout_price" name="cutout_price" value="">

							<div class="row">
								<fieldset class="form-group col-4 d-inline">
									<label for="sink_part"><u>To which piece does the sink belong</u>: </label>
									<select class="mdb-select" id="e-sink_part" name="sink_part">
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_provided"><u>Customer provided</u>? </label>
									<select class="mdb-select" id="e-sink_provided" name="sink_provided">
										<option value="0">No</option>
										<option value="1">Yes</option>
									</select>
								</fieldset>
							</div>

							<hr class="w-100">
							<div class="row">
								<fieldset class="form-group col-9 d-inline">
									<label for="sink_model"><u>Sink Model</u>: </label>
                                    <div class="input-group">
										<input class="form-control" list="sinks" type="text" id="e-sink_model" name="sink_model">
                                    	<div class="input-group-append">
	                                        <button type="button" class="btn btn-muted" onClick="$('#sink_model').val('')"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
									<datalist id="sinks">
									<?
										$get_accs = new project_action;
										$rows = $get_accs->get_accs(1);
										foreach ($rows as $row) {
											echo "<option accs_id='" . $row['accs_id'] . "'  width='" . $row['accs_width'] . "'  depth='" . $row['accs_depth'] . "' price='" . $row['accs_price'] . "' cost='" . $row['accs_cost'] . "'>" . $row['accs_model'] . " - " . $row['accs_name'] . "</option>";
										}
									?>
									</datalist>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_mount"><u>Cutout</u>: </label>
									<select class="mdb-select" id="e-sink_mount" name="sink_mount">
										<option value="0">None</option>
										<option value="1">Undermount</option>
										<option value="2">Drop-In</option>
										<option value="3">Vessel</option>
										<option value="4">Apron/Farm Style</option>
										<option value="5">Top Zero</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes"><u>Faucet Spread / Holes</u>:</label>
									<select class="mdb-select holeOpt" id="e-sink_holes" name="sink_holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="sink_holes_other" value="99">Other Holes</option>
									</select>
								</fieldset>
								<fieldset class="form-group col-3 d-inline">
									<label for="sink_holes_other"><u>Sink Holes Data</u>:</label>
									<input type="text" class="form-control" id="e-sink_holes_other" name="sink_holes_other">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<input type="checkbox" class="filled-in form-control" id="e-sink_soap" name="sink_soap" value="1">
									<label for="sink_soap"><u>Soap Hole</u>?</label>
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_width"><u>Cutout Width</u>:</label>
									<input type="text" class="form-control" id="e-cutout_width" name="cutout_width" value="0">
								</fieldset>
								<fieldset class="form-group col-2 d-inline">
									<label for="cutout_depth"><u>Cutout Depth</u>:</label>
									<input type="text" class="form-control" id="e-cutout_depth" name="cutout_depth" value="0">
								</fieldset>
							</div>

						</form>
						<div id="updateSinkBtn" class="btn btn-lg btn-primary mt-3 w-100" onClick="update_sink('edit_sink')">Submit</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<!--<div aria-hidden="true" aria-labelledby="qr_scannerLabel" class="modal fade" id="qr_scanner" role="dialog" tabindex="55">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-qrcode h2 text-warning"></i> Scan Code</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<fieldset class="form-group col-6 col-lg-3">
						<label class="qrcode-text-btn"></label>
						<div class="input-group">
							<label class="qrcode-text-btn"></label>
							<div class="input-group-prepend">
								<label class="qrcode-text-btn"><button class="btn btn-muted" type="button"><label class="qrcode-text-btn"><i class="fas fa-qrcode"></i></label></button></label>
							</div><input accept="image/*" onchange="openQRCamera(this);" tabindex="-1" type="file">
						</div>
					</fieldset>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
				</div>
			</div>
		</div>
	</div>
</div>
-->
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
									<input checked class="form-check-input with-gap ml-4" id="not_confirmed" name="type" type="radio" value="0">
									<label class="w-100" for="not_confirmed">Not Conformed</label>
									<p class="d-inline ml-4"></p>
								</div>
								<div class="form-check col-4">
									<input class="form-check-input with-gap ml-4" id="confirmed" name="type" type="radio" value="1">
									<label class="w-100" for="confirmed">Confirmed</label>
								</div>
								<div class="form-check col-4">
									<input class="form-check-input with-gap ml-4" id="reschedule" name="type" type="radio" value="2">
									<label class="w-100" for="reschedule">To be Rescheduled</label>
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


<div aria-hidden="true" aria-labelledby="user_discountsLabel" class="modal fade" id="user_discounts" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-fas fa-percent h2 text-warning"></i> Adjust Customer Discounts</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">User Discount for: <span id="custDiscount"></span></h2>
					</div>
					<hr>
					<form id="user_discount_form" class="row">
						<input name="action" type="hidden" value="user_discount">
						<fieldset class="form-group col-12">
							<div class="row">
								<fieldset class="form-group col-6">
									<label for="mDisc"><u>Marble &amp; Granite</u>:</label>
									<input type="number" class="form-control form-control-lg" id="mDisc" name="mDisc" <? if($_SESSION['access_level'] != 1) { ?> max="15" <? } else { ?> max="35" <? } ?> step='0.01' value='0.00'>
								</fieldset>
								<fieldset class="form-group col-6">
									<label for="qDisc"><u>Quartz</u>:</label>
									<input type="number" class="form-control form-control-lg" id="qDisc" name="qDisc" <? if($_SESSION['access_level'] != 1) { ?> max="10" <? } else { ?> max="10" <? } ?> step='0.01' value='0.00' data-transform="input-control">
								</fieldset>
							</div>
						</fieldset>
					</form>
					<div id="updateDiscounts" class="btn btn-lg btn-primary mt-3 w-100" onClick="update_discounts(<?= $_SESSION['access_level'] ?>)">Submit</div>
				</div>
				<hr>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div aria-hidden="true" aria-labelledby="entryRejectLabel" class="modal fade" id="entryReject" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title">
					<h2 class="d-inline text-primary"><i class="fas fa-thumbs-down h2 text-warning"></i> Reject from Entry</h2>
				</div><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&#10008;</span></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<h2 class="col-12">User Discount for: <span id="custDiscount"></span></h2>
					</div>
					<hr>
					<form id="entry_reject" class="row">
						<input name="action" type="hidden" value="entry_reject">
						<fieldset class="form-group col-12">
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="qDisc"><u>Quartz</u>:</label>
									<textarea class="form-control" id="r-cmt_comment" name="cmt_comment"></textarea>
								</fieldset>
							</div>
						</fieldset>
					</form>
					<div id="updateDiscounts" class="btn btn-lg btn-primary mt-3 w-100" onClick="update_discounts(<?= $_SESSION['access_level'] ?>)">Submit</div>
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
$(document).ready(function(){
	$('.mdb-select').material_select('destroy');
	$("#searchBox").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$(".filter").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$('.table').DataTable({
		"pageLength": 100,
		"aoColumnDefs" : [{
			'bSortable' : false,
			'aTargets' : [ -1 ]
		}]
	});
	$('select').addClass('mdb-select');
	$("#mdb-lightbox-ui").load("/mdb-addons/mdb-lightbox-ui.html");
	$('select[name=DataTables_Table_0_length]').addClass('mdb-select');
	$('.mdb-select').material_select();
	
});
<?
	require_once ('js/bootstrap-combobox.js');
?>

</script>
<script src="js/pikaday.js"></script>
<script src="js/pikaday.jquery.js"></script>
<script>
	  var res = `<?php echo json_encode($output); ?>`; //for the template_date 
    var resforinstall = `<?php echo json_encode($outputforinstall); ?>`; //for the install_date 
    
    var holi = '<?php echo json_encode($holidays); ?>';
    var currently_sqft = '<?php echo $limitinfo[0]['install_sqft']; ?>';
    var template_num = '<?php echo $limitinfo[0]['templates_number']; ?>';
    var access_level = '<?php echo $_SESSION['access_level']; ?>';
    var session_id = '<?php echo $_SESSION['id']; ?>';
  console.log("session id",session_id);
    res = res.replace(/\\n/g, "\\n")  
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
  // remove non-printable and other non-valid JSON chars
    res = res.replace(/[\u0000-\u0019]+/g,"");
  
    resforinstall = resforinstall.replace(/\\n/g, "\\n")  
               .replace(/\\'/g, "\\'")
               .replace(/\\"/g, '\\"')
               .replace(/\\&/g, "\\&")
               .replace(/\\r/g, "\\r")
               .replace(/\\t/g, "\\t")
               .replace(/\\b/g, "\\b")
               .replace(/\\f/g, "\\f");
  // remove non-printable and other non-valid JSON chars
    resforinstall = resforinstall.replace(/[\u0000-\u0019]+/g,"");

	  var obj = jQuery.parseJSON(res);
    var insobj = jQuery.parseJSON(resforinstall);
    //console.log(res);
  
    var holidays = jQuery.parseJSON(holi);
  
  // for template date
    var atr = 0;
    var cur_day = [];
    var approv_day = [];
    var cur_mo = [];
    var approv_mon = [];
  
  // for install date  
    var atr_ins = 0;
    var cur_day_ins = [];
    var approv_day_ins = [];
    var cur_mo_ins = [];
    var approv_mon_ins = [];
  
    var disable = false;
  
    var cur_d = new Date();

    var _cur_day = cur_d.getDate();
  
    function distance(lat1, lon1, lat2, lon2) {
        var radlat1 = Math.PI * lat1/180
        var radlat2 = Math.PI * lat2/180
        var theta = lon1-lon2
        var radtheta = Math.PI * theta/180
        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
        dist = Math.acos(dist)
        dist = dist * 180/Math.PI
        dist = dist * 60 * 1.1515;
        return dist
    }

	  var $datepicker = $('.datepicker').pikaday({
        firstDay: 1,
        minDate: new Date(),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2000,2020],
        disableDayFn: function(theDate) {
        var formattedDate = new Date(theDate);
        var jday = formattedDate.getDay();
        var d = formattedDate.getDate();
        var st_d = d;
        var m =  formattedDate.getMonth();
        var st_m = m;
        m += 1;  // JavaScript months are 0-11
        var y = formattedDate.getFullYear();
        if (d < 10) {
          d = "0" + d;
        }
        if (m < 10) {
          m = "0" + m;
        }
          
          var job_day = formattedDate.getDay();
          
          var curdate = y+'-'+m+'-'+d;
          //console.log(curdate,"-----", jday);          
          var flag = false;
          if(jday == 0 || jday == 6) flag = true;
          $.each(obj, function(key, value){
            if(value['template_date'] == curdate){
              var jobs_num = value['detail'].length;
              if (jobs_num >= template_num){
                flag = true;
              }else{  
                var lat1 = 36.1181642;
                var lon1 = -80.0626623;
                var lat2 = $('#p-geo-lat').val();
                var lon2 = $('#p-geo-long').val();
                //console.log(lat2,"************************", lon2);
                var distan = distance(lat1,lon1,lat2,lon2);
                if(distan > 25){
                  $.each(value['detail'], function(k,v){
                    var temp_lat = v['job_lat'];
                    var temp_lang = v['job_long'];
                    var each_dis = distance(lat2, lon2, temp_lat, temp_lang);
                    if(each_dis < 15){
                      atr = 1;

                    }
                  })
                  if ( atr == 1){
                    cur_day.push(st_d);
                    cur_mo.push(st_m);
                    atr = 0;
                  }else{
                    approv_day.push(st_d);
                    approv_mon.push(st_m);
                  }
                }
              }
            }
          });
          
          $.each(holidays, function(k, v){
            var f_day = new Date(v['start_date']);
            var e_day = new Date(v['end_date']);
            if(Date.parse(f_day) <= Date.parse(formattedDate) && Date.parse(e_day) >= Date.parse(formattedDate)){
              flag = true;
            }
            
          });
          return flag;
        },
        onDraw(){
          var curmm = $('.pika-select').val();
          var d = new Date();
          var n = d.getMonth();
          //console.log(cur_day);
          //if(n == curmm){
          for(var i=0;i<cur_day.length;i++){
            if(curmm == cur_mo[i]){
              var class_btn = ".pika-button[data-pika-day='"+cur_day[i]+"']";
              $(class_btn).css({
                "background":"rgb(144, 186, 255)",
                "color":"black"
              });
            }
          }
          for(var i=0;i<approv_day.length;i++){
            if(curmm == approv_mon[i]){
              var class_btn = ".pika-button[data-pika-day='"+approv_day[i]+"']";
              $(class_btn).css({
                "background":"rgb(244, 151, 159)",
                "color":"black"
              }); 
            }
          }
          //}
        }
    });
    
    var $datepicker1 = $('.datepicker1').pikaday({
        firstDay: 1,
        minDate: new Date(),
        maxDate: new Date(2020, 12, 31),
        yearRange: [2000,2020],
        disableDayFn: function(theDate) {
          var formattedDate = new Date(theDate);
          var jday = formattedDate.getDay();
          var d = formattedDate.getDate();
          var st_d = d;
          
          var m =  formattedDate.getMonth();
          var st_m = m;
          m += 1;  // JavaScript months are 0-11
          var y = formattedDate.getFullYear();
          if (d < 10) {
              d = "0" + d;
          }
          if (m < 10) {
              m = "0" + m;
          }
          
          var job_day = formattedDate.getDay();
          
          var curdate = y+'-'+m+'-'+d;
          //console.log(curdate,"-----", jday);          
          var flag = false;
          if(jday == 0 || jday == 6) flag = true;
//           if((access_level != 1 || access_level != 14 ) && st_d < _cur_day + 7 ) flag = true;
          if(!(session_id == 1 || session_id == 14 ) && st_d < _cur_day + 7 ) flag = true;
          $.each(insobj, function(key, value){
            if(value['install_date'] == curdate){
              var sum_sqft = 0;
              $.each(value['detail'], function(k,v){
				console.log( parseInt(v['job_sqft']) );
                sum_sqft += parseInt(v['job_sqft']);
              })
              var cur_sqft = $('#p-job-sqft').val();
              sum_sqft += parseInt(cur_sqft*1);
				console.log('sum_sqft=' + sum_sqft);
        console.log('cur_sqft=' + cur_sqft);
        console.log('currently_limit_sqft', currently_sqft);
        console.log('current_day',curdate);
              
              if (sum_sqft > currently_sqft){
                flag = true;
              }else{  
                var lat1 = 36.1181642;
                var lon1 = -80.0626623;
                var lat2 = $('#p-geo-lat').val();
                var lon2 = $('#p-geo-long').val();
                //console.log(lat2,"************************", lon2);
                var distan = distance(lat1,lon1,lat2,lon2);
                if(distan > 25){
                  $.each(value['detail'], function(k,v){
                    var temp_lat = v['job_lat'];
                    var temp_lang = v['job_long'];
                    var each_dis = distance(lat2, lon2, temp_lat, temp_lang);
                    if(each_dis < 15){
                      atr_ins = 1;
                    }
                  })
                  if ( atr_ins == 1){
                    cur_day_ins.push(st_d);
                    cur_mo_ins.push(st_m);
                    atr_ins = 0;
                  }else{
                    approv_day_ins.push(st_d);
                    approv_mon_ins.push(st_m);
                  }
                }
              }
            }
          });

          $.each(holidays, function(k, v){
            var f_day = new Date(v['start_date']);
            var e_day = new Date(v['end_date']);
            if(Date.parse(f_day) <= Date.parse(formattedDate) && Date.parse(e_day) >= Date.parse(formattedDate)){
              flag = true;
            }
            
          });
          if(session_id == 1 || session_id == 14 )  flag = false;
          return flag;
          
        },
        onDraw(){
          var curmm = $('.pika-select').val();
          var d = new Date();
          var n = d.getMonth();
          //console.log(cur_day);
          //if(n == curmm){
          for(var i=0;i<cur_day_ins.length;i++){
            if(curmm == cur_mo_ins[i]){
              var class_btn = ".pika-button[data-pika-day='"+cur_day_ins[i]+"']";
              $(class_btn).css({
                "background":"rgb(144, 186, 255)",
                "color":"black"
              });
            }
          }
          for(var i=0;i<approv_day_ins.length;i++){
            if(curmm == approv_mon_ins[i]){
              var class_btn = ".pika-button[data-pika-day='"+approv_day_ins[i]+"']";
              $(class_btn).css({
                "background":"rgb(244, 151, 159)",
                "color":"black"
              }); 
            }
          }
          //}
        }
    });
</script>
<style>
  .pika-button.pika-day{font-weight:bold!important;color:grey;}
</style>
</body>
</html>