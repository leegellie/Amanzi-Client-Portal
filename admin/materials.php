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
	<script src="/js/jquery-form-validate/javascripts/jquery.validate.js" type="text/javascript"></script>
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
<? include ('footer.php'); ?>
<? echo $access_level ?>
<div class="modal fade" id="editPjt">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="pjt_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid pr-0">
					<form id="editPjtOne" class="row">
						<input type="hidden" id="p-pid" name="id" value="">
						<input type="hidden" id="p-uid" name="uid" value="">

						<fieldset class="form-check col-12 text-right">
							<label for="p-isActive" class="pr-4">Is Project active:</label>
							<input id="p-isActive" class="form-check-input with-font" name="isActive" type="checkbox" value="1">
						</fieldset>

						<fieldset class="form-group col-6 col-md-3">
							<label for="quote-num">Quote #:</label>
							<input class="form-control" id="p-quote_num" name="quote_num" type="text">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="order-num">Order #:</label>
							<input class="form-control" id="p-order_num" name="order_num" type="text">
						</fieldset>

						<fieldset class="form-group col-6 col-md-3">
							<label for="template-date">Template Date:</label>
							<input class="form-control" id="p-template_date" name="template_date" type="date">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="install-date">Install Date:</label>
							<input class="form-control" id="p-install_date" name="install_date" type="date">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="job-name">Job Name:</label>
							<input required class="form-control" id="p-job_name" name="job_name" type="text" data-required="true">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="account-rep">Account Rep:</label>
							<select class="form-control" id="p-acct_rep" name="acct_rep">
								<option value="0">Unspecified</option>


							</select>
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="builder-name">Builder / Cabinet Company:</label>
							<input class="form-control" id="p-builder" name="builder" type="text">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="po-cost">P.O. Cost:</label>
							<input class="form-control currency" id="p-po_cost" name="po_cost" type="text">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="po-num">P.O. #:</label>
							<input class="form-control" id="p-po_num" name="po_num" type="text">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-name">Site Contact:</label>
							<input class="form-control" id="p-contact_name" name="contact_name" type="text">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-phone">Contact Telephone:</label>
							<input class="form-control" id="p-contact_number" name="contact_number" type="tel">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-phone">Contact Email:</label>
							<input class="form-control" id="p-contact_email" name="contact_email" type="tel">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-name2">Alternative Contact:</label>
							<input class="form-control" id="p-alternate_name" name="alternate_name" type="text">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-phone2">Alternative Telephone:</label>
							<input class="form-control" id="p-alternate_number" name="alternate_number" type="tel">
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="contact-phone2">Alternative Email:</label>
							<input class="form-control" id="p-alternate_email" name="alternate_email" type="tel">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="site-address">Site Address:</label>
							<input class="form-control" id="p-address_1" name="address_1" type="text">
						</fieldset>
						<fieldset class="form-group col-12">
							<input class="form-control" id="p-address_2" name="address_2" type="text">
						</fieldset>
						<fieldset class="form-group col-md-5">
							<label for="site-address">City:</label>
							<input class="form-control" id="p-city" name="city" type="text">
						</fieldset>
						<fieldset class="form-group col-8 col-md-5">
							<label for="site-address">State:</label>
							<select class="form-control" id="p-state" name="state">
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
							<input class="form-control" id="p-zip" name="zip" type="text">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="site-address">Notes:</label>
							<textarea class="form-control" id="p-job_notes" name="job_notes" type="text" rows="4"></textarea>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
							</label>
						</fieldset>
						<fieldset class="form-group container">
							<label id="p-uploadContain" class="row" for="imgUploads">
								<input class="col-6 mb-2" onchange="addUpload(this);" name="imgUploads[]" type="file">
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editInstall">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Edit: <span id="inst_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid pr-0">
					<form id="updateInstall" class="row">
						<input type="hidden" id="i-iid" name="id" value="">
						<input type="hidden" id="i-pid" name="pid" value="">
						<fieldset class="form-group col-12">
							<label for="install1-name">Area/Install Name:</label>
							<input class="form-control" id="i-install_name" name="install_name" type="text" data-required="true" required>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6 col-lg-3">
							<div class="row">
								<legend class="col-form-legend col-12">Job Type:</legend>
								<div class="col-12">
									<div class="form-check form-check-inline col-12">
										<label for="typea">
											<input checked="" class="form-check-input with-font" id="i-typea" name="type" type="radio" value="New">
											<p>New Install</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="typeb">
											<input class="form-check-input with-font" id="i-typeb" name="type" type="radio" value="Remodel">
											<p>Remodel</p>
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
										<label for="tear-outa">
											<input class="form-check-input with-font" id="i-tear_outa" name="tear_out" type="radio" value="Yes">
											<p>Yes</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="tear-outb">
											<input checked="" class="form-check-input with-font" id="i-tear_outb" name="tear_out" type="radio" value="No">
											<p>No</p>
										</label>
									</div>
								</div>
							</div>
						</fieldset>
	
	
	
						<fieldset class="form-group col-12 col-lg-6">
							<label for="i-material">Material:</label>
							<select class="form-control" id="i-material" name="material">
								<option value="0">Not Selected</option>
								<option value="marbgran">Marble/Granite</option>
								<option value="quartz">Quartz/Quartzite</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<label for="color">Color:</label>
							<input class="form-control matControl" list="i-color" id="i-color-box" name="color" type="text">
								<datalist id="i-color" class="colorChoose">
								</datalist>
							<div class="btn btn-primary matPickerBtn" onClick="matModalOpen(this);"><i class="fa fa-eye"></i></div>
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="lot">Lot #:</label>
							<input class="form-control matControl" id="i-lot" name="lot" type="text">
						</fieldset>
						<fieldset class="form-group col-6 col-lg-3">
							<label for="SqFt">SqFt:</label>
							<input class="form-control matControl" id="i-SqFt" name="SqFt" type="number" value="0">
						</fieldset>
	
	
						<fieldset class="form-group col-6 col-md-3">
							<div class="row">
								<legend class="col-form-legend col-12">Customer Selected?</legend>
								<div class="col-12">
									<div class="form-check form-check-inline col-6">
										<label class="selected1a">
											<input checked="" class="form-check-input with-font" id="i-selecteda" name="selected" type="radio" value="Yes"><p>Yes</p>
										</label>
									</div>
									<div class="form-check form-check-inline">
										<label for="selected1b">
											<input class="form-check-input with-font" id="i-selectedb" name="selected" type="radio" value="No"><p>No</p>
										</label>
									</div>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group col-6 col-lg-3">
							<label for="i-price_calc">Calculated Cost:</label>
							<input class="form-control" id="i-price_calc" name="price_calc" type="number" value="0" readonly>
						</fieldset>

						<fieldset class="form-group col-6 col-lg-3">
							<label for="i-price_extra">Extra Costs:</label>
							<input class="form-control" id="i-price_extra" name="price_extra" type="number" value="0">
						</fieldset>


						<fieldset class="form-group col-12">
							<label for="edge">Edge:</label>
							<select class="form-control" id="i-edge" name="edge">
								<option value="0">None</option>
								<option value="1">1" Bevel</option>
								<option value="2">1/2" Bevel</option>
								<option value="3">1/4" Bevel</option>
								<option value="4">Half Bullnose</option>
								<option value="5">Full Bullnose</option>
								<option value="6">Demi Bullnose</option>
								<option value="7">Flat</option>
								<option value="8">Pencil</option>
								<option value="9">Heavy Pencil</option>
								<option value="10">Ogee</option>
								<option value="99">Other</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Backsplash?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="backsplash">
												<input class="form-control form-inline col-9 col-lg-10 float-right bs_detail" id="i-bs_detail" name="bs_detail" placeholder="Details" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Riser?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="riser">
												<input class="form-control form-inline col-9 col-lg-10 float-right rs_detail" id="i-rs_detail" name="rs_detail" placeholder="Details" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-6 col-sm-4">
							<div class="row">
								<legend class="col-form-legend col-12">Sink(s)?</legend>
								<div class="col-12">
									<div class="row">
										<div class="form-check form-check-inline w-100">
											<label class="form-check-label container" for="sinks">
												<input class="form-control form-inline col-9 col-lg-10 float-right sk_detail" id="i-sk_detail" name="sk_detail" placeholder="Details/Model" type="text">
											</label>
										</div>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<div class="row">
								<div class="form-group col-12">
									<label for="range_type">Range Type:</label>
									<select class="form-control" id="i-range_type" name="range_type">
										<option value="0">None</option>
										<option value="1">Free Standing</option>
										<option value="2">Cooktop</option>
										<option value="3">Slide-In</option>
									</select>
								</div>
							</div>
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="model">Model #:</label>
									<input class="form-control" id="i-range_model" name="range_model" type="text">
								</fieldset>
							</div>
							<div class="row">
								<fieldset class="form-group col-12">
									<label for="cutout">Cutout:</label>
									<input class="form-control" id="i-cutout" name="cutout" type="text">
								</fieldset>
							</div>
						</fieldset>
						<fieldset class="form-group col-12 col-md-6">
							<div class="row">
								<div class="form-group col-12">
									<label for="holes">Faucet Spread / Holes:</label>
									<select class="form-control holeOpt" id="i-holes" name="holes">
										<option value="0">None</option>
										<option value="1">1 Hole - Center</option>
										<option value="2">3 Hole - 4"</option>
										<option value="3">3 Hole - 8"</option>
										<option class="controller" data-control="holes_other" value="99">Other Holes</option>
									</select>
								</div>
							</div>
							<label for="holes">Specify other holes needed:</label>
							<input class="form-control" id="i-holes_other" name="holes_other" type="text">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="install_notes">Install Notes:</label>
							<textarea class="form-control" id="i-install_notes" name="install_notes" rows="3"></textarea>
						</fieldset>
						<fieldset class="form-group container">
							<label id="uploadContain2" class="row" for="imgUploads">
								<input class="col-6 mb-2" onchange="addUpload(this);" name="imgUploads[]" type="file">
							</label>
						</fieldset>
						<input id="isActive" name="isActive" type="hidden" value="1">
						<input id="i-instUID" name="instUID" type="hidden" value="">
						<input id="i-action" name="action" type="hidden" value="update_install_data"><br>
						<div class="btn btn-primary" name="instUpdate" id="instUpdate" style="width:100%; font-size:x-large; font-weight:800; line-height:40px;">Update Install</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="selectCompany" tabindex="-1" role="dialog" aria-labelledby="selectCompanyLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<span class="icon icon-user-3"></span>
				<div class="modal-title"><h3>Search Project Owners</h3></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<form name="findToAdd" id="findToAdd" action="#" class="AdvancedForm row">
					<fieldset class="col-6 col-md-3">
						<div id="user_infoDIV" class="input-control text input-box" data-role="input-control">
							<input class="form-control" name="search" id="search" type="text" placeholder="Search Term" value="" />
						</div>
					</fieldset>
					<fieldset class="col-6 col-md-3">
						<div id="user_infoDIV" class="input-control select" data-role="input-control">
							<select class="form-control" name="user_find" id="user_find" data-transform="input-control">
								<option value="username">Username</option>
								<option value="email">Email</option>
								<option value="company" selected>Company</option> 
								<option value="fname">First Name</option>
								<option value="lname">Last Name</option>   
							</select>
						</div>
					</fieldset>
					<fieldset class="col-3 col-md-1">
						<div id="user_infoDIV" class="input-control checkbox margin10" data-role="input-control">
							<label style="padding-bottom:9px;">
								Active?
								<input class="with-font" type="checkbox" name="isActive" id="isActive" value="1" checked >
								<span class="check"></span>
							</label>
						</div>
					</fieldset>
					<fieldset class="col-3 col-md-2">
						<div id="user_infoDIV" class="input-control checkbox margin10" data-role="input-control">
							<label style="padding-bottom:9px;">
								My Clients
								<input class="with-font" type="checkbox" name="mine" id="mine" value="1" <? if (!in_array($_SESSION['id'],array('1','13','14','985'),true)) {echo 'checked';}; ?> >
								<span class="check"></span>
							</label>
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
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onClick="addClient();">Add Client <i class="fa fa-plus"></i></button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>



<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="addClientLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
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
										<select class="form-control" name="user_type" id="user_type" data-transform="input-control">
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
										<select class="form-control" name="state" id="state" value="" data-transform="input-control">
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
										<select class="form-control" name="billing_state" id="billing_state" value="" data-transform="input-control">
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
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
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
						<select name="cmt_priority" id="cmt_priority" class="form-control col-12 col-md-8">
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
	<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
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
						<h3 class="text-success">Data successfully sent to Anya.</h3>
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