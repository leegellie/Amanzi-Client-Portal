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
<title>ACP | Admin - Add a User</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--
	<script src="/js/jquery.min.js"></script>
	<script src="/js/master/build/js/metro.min.js"></script>
    <link href="/styles/bootstrap/docs/css/metro-bootstrap.css" rel="stylesheet">
    <link href="/styles/bootstrap/docs/css/metro-bootstrap-responsive.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/styles/bootstrap/docs/css/docs.css">
    <link rel="stylesheet" type="text/css" href="/styles/bootstrap/docs/css/iconFont.css">
-->
    <!-- Local JavaScript -->

<?
// INCLUDE THE JS and CSS files needed on all ADMIN PAGES
include('includes.php');

?>

    <script src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css">
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
    <script src="/admin/js/users.js"></script>
<script>
<?PHP 
if(isset($_GET['add'])){
	require_once ('js/user_add.js');
}else{
	require_once ('js/user_edit.js');
}
?>
</script>
<?
// INCLUDE THE javascript.php FILE. THIS FILE IS USED TO DISPLAYS JAVASCRIPT THAT WILL BE USED THROUGHOUT THE ADMIN AREA
include('javascript.php');
?>
</head>
<body class="metro" style="background-color: rgb(239, 234, 227);" onLoad="">
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div class="container">
	<div class="row pl-3">
		<h1>User Menus<br></h1>
        <hr>
		<div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
        <br>
	</div>
</div>
<!-- START BODY CONTENT AREA -->
<div class="container pageLook">
   	<div class="row">

<?
if(isset($_GET['add'])){
	require_once ('user_add.php');
}else{
	require_once ('user_edit.php');
}
?>

		<div id="editSuccess"></div>
	</div>
</div>
<!-- END BODY CONTENT AREA -->
<?PHP include('footer.php'); ?>
<!--
POPUP EDIT BOX CODE START
-->

<div class="modal fade" id="uEditMod">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Client: <span id="client_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
				<div class="modal-body">
					<div class="container-fluid">

						<form name="edit_user_data" id="edit_user_data" action="#" class="AdvancedEditForm row">
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">User Role:</div>
									<div class="col-7">
										<select class="mdb-select" name="access_level" id="access_level" data-transform="input-control">
											<option value="0">Select User Type</option> 
											<option value="0" disabled>&nbsp;&nbsp;Internal Employees</option>
								<!-- THE FOLLOWING PHP LOOPS THROUGH AND ECHOS INTERNAL "EMPLOYEE" USER ROLES -->
											<?
												$internal_user_roles = new user_action;
												$rows = $internal_role_rows = $internal_user_roles->get_user_roles("1","0");
												foreach ($rows as $row) {
													echo "<option value='$row[0]'>$row[2]</option>";
												}
											?>
											<option value="0" disabled></option>
											<option value="0" disabled>&nbsp;&nbsp;External Customers</option>
											<?
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


							<div class="col-12 col-md-3">
								<div class="row">

									<div class="hidden" id="accs"><?= $_SESSION['access_level'] ?></div>
									<div class="col-6">
										<p>Marb/Gran Discount %: </p>
									</div>
									<div class="col-6">
										<input class="form-control" name="discount" id="discount" type='number' <? if($_SESSION['access_level'] != 1) { ?> max="15" <? } else { ?> max="35" <? } ?> step='0.01' value='0.00' data-transform="input-control">
										<span id="usernameError"></span>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-3">
								<div class="row">
									<div class="col-6">
										<p>Quartz Discount %: </p>
									</div>
									<div class="col-6">
										<input class="form-control" name="discount_quartz" id="discount_quartz" type='number' <? if($_SESSION['access_level'] != 1) { ?> max="10" <? } else { ?> max="10" <? } ?> step='0.01' value='0.00' data-transform="input-control">
										<span id="usernameError"></span>
									</div>
								</div>
							</div>


							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Username: </p>
									</div>
									<div class="col-7">
										<input class="form-control" name="username" id="username" tabindex="1" type="text" value="" data-transform="input-control">
										<span id="usernameError"></span>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">Account Rep:</div>
									<div class="col-7">
										<select class="mdb-select" name="acct_rep" id="acct_rep" data-transform="input-control">
											<option value="0">Select Account Rep</option> 
											<?
	
	$uOptions = '';
	$salesReps = new project_action;
	$_POST['isSales'] = '1';
	foreach($salesReps->get_sales_reps($_POST) as $results) {
		$uOptions .= '<option value="' . $results['id'] . '">' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	}
	echo $uOptions;

											?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div id="changePW" class="btn btn-primary float-right" onClick="changePW();">
								Change Password
								</div>
							</div>
							<div class="col-12">
								<h4>Contact Info:</h4>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>First Name: </p>
									</div>
									<div class="col-7">
										<div id="fnameDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="fname" id="fname" value="" tabindex="2" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Last Name: </p>
									</div>
									<div class="col-7">
										<div id="lnameDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="lname" id="lname" tabindex="3" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Company: </p>
									</div>
									<div class="col-7">
										<div id="companyDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="company" id="company" tabindex="4" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Email: </p>
									</div>
									<div class="col-7">
										<div id="emailDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="email" id="email" tabindex="5" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Phone: </p>
									</div>
									<div class="col-7">
										<div id="phoneDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="phone" id="phone" value="" tabindex="6" data-transform="input-control" placeholder="Just number, no spaces or format" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Address:</p>
									</div>
									<div class="col-7">
										<div id="address1DIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="address1" id="address1" tabindex="7" value="" data-transform="input-control" />
										</div>
										<div id="address2DIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="address2" id="address2" tabindex="8" value="" placeholder="Optional" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>City: </p>
									</div>
									<div class="col-7">
										<div id="cityDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="city" id="city" tabindex="9" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>State: </p>
									</div>
									<div class="col-7">
										<div id="stateDIV" class="input-control select" data-role="input-control">
											<select class="mdb-select" name="state" id="state" value="" tabindex="10" data-transform="input-control">
												<option value="">Choose a State</option>
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
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Zip: </p>
									</div>
									<div class="col-7">
										<div id="zipDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="zip" id="zip" tabindex="11" value="" data-transform="input-control">
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-12">
										<input class="filled-in form-check-input" id="e-isActive" name="isActive" type="checkbox" value="">
										<label for="e-isActive">User is active:</label>
									</div>
								</div>
							</div>

							<div class="col-12 p-0 text-left">
								<h4 class="d-inline">Comments</h4>
								<div id="makeCommentBtn" class="btn btn-primary d-inline ml-2 float-right" cmt_type="usr" onClick="makeComment(this,<? $_SESSION['id']?>);"><i class="fa fa-comment"></i></div>
								<hr>
								<div id="commentList" class="col-12"></div>
								<hr>
							</div>
							<div class="col-12 p-0 text-right">
								<input name="action" id="action" type="hidden" value="update_user_data" />
								<input name="id" id="id" type="hidden" value="">
								<span id="updateSuc" class="text-warning px-2 h3" style="display:none">User Data Saved</span>
								<div name="submit" class="btn btn-primary editForm float-right mb-2" tabindex="12" id="EditSubmit" value="Save User Data" data-transform="input-control">Save User Data</div>
							</div>
						</form>
					</div>
					<hr>
					<div class="container-fluid pr-0">
						<form name="user_billing" id="user_billing" action="#" class="AdvancedBillingForm row">
							<div class="col-12">
								<h4>Billing Information:</h4>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-12">
										<div style="display:inline-block" class="input-control switch margin10" data-role="input-control">
											<input class="filled-in form-check-input" style="display:inline-block" id="sameAdd" name="sameAdd" type="checkbox" value="sameAs" data-transform="input-control" data-transform-type="switch" onChange="autoFillBilling()" >
											<label for="sameAdd" style="display:inline-block">Same as User Account?</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Name: </p>
									</div>
									<div class="col-7">
										<div id="billing_fnameDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="billing_name" id="billing_name" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Company: </p>
									</div>
									<div class="col-7">
										<div id="billing_companyDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="billing_company" id="billing_company" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Address: </p>
									</div>
									<div class="col-7">
										<div id="billing_address1DIV" class="input-control text" data-role="input-control">
										<input class="form-control" name="billing_address1" id="billing_address1" value="" data-transform="input-control" />
										</div>
										<div id="billing_address2DIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="billing_address2" id="billing_address2" placeholder="Optional" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>City: </p>
									</div>
									<div class="col-7">
										<div id="billing_cityDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="billing_city" id="billing_city" value="" data-transform="input-control" />
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>State: </p>
									</div>
									<div class="col-7">
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
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="row">
									<div class="col-5">
										<p>Zip: </p>
									</div>
									<div class="col-7">
										<div id="billing_zipDIV" class="input-control text" data-role="input-control">
											<input class="form-control" name="billing_zip" id="billing_zip" value="" data-transform="input-control" />
										</div>
										<input name="uid" id="uid" type="hidden" value="">
									</div>
								</div>
							</div>
							<div class="col-12 p-0 text-right">
								<input name="action" id="action" type="hidden" value="add_user_billing">
								<span id="billingSuc" class="text-warning px-2 h3" style="display:none">Billing Data Saved</span>
								<div name="submit" class="btn btn-primary float-right" id="BillingSubmit" value="Save User &amp; Billing Data" data-transform="input-control">Save User &amp; Billing Data</div>
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

<div class="modal fade" id="uPassEdit">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3><span id="user_name"></span></h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<form id="changePassword" class="container">
					<div class="row">
						<input type="hidden" name="pw-uid" id="pw-uid" value="">
						<input type="hidden" name="action" value="set_password">
						<fieldset class="col-12 col-md-6">
							<label class="col-12 col-md-6" for="pw1">Enter Password</label>
							<input class="form-control col-12" type="password" name="pw1" id="pw1">
						</fieldset>
						<fieldset class="col-12 col-md-6">
							<label class="col-12 col-md-6" for="pw1">Re-Enter Password</label>
							<input class="form-control col-12" type="password" name="pw2" id="pw2">
						</fieldset>
						<hr class="col-12">
						<div class="h2 col-12 text-primary" id="pwSuccess" style="display:none;">Password Saved Successfully!</div>
						<div class="h2 col-12 text-danger" id="pwFail" style="display:none;">Password Failed to Saved!</div>
						<div name="submit" class="btn btn-success col-12" tabindex="12" id="pwSubmit" value="Set Password" data-transform="input-control">Set Password</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
						<select name="cmt_priority" id="cmt_priority" class="mdb-select col-12 col-md-8">
							<option value="Normal" selected>Regular</option>
							<option value="911">Important</option>
						</select>
						<label class="form-label col-12 col-md-4">Comment: </label>
						<textarea class="form-control" id="cmt_comment" name="cmt_comment" rows="5"></textarea>
						<hr>
						<div id="submitComments" class="btn btn-lg btn-primary col-12">Submit Comments <i class="fab fa-telegram-plane"></i></div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

</body>
</html>