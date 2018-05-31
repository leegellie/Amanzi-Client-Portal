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
<title>ACP | Admin - Time Off</title>
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
    <script src="js/time_off.js"></script>


<?PHP include ('javascript.php'); ?>
</head>
<body class="metro" style="background-color: rgb(239, 234, 227);" >
<?PHP include('menu.php'); ?>
<?PHP include ('header.php'); ?>
<div id="loadOver"></div>
<div class="container">
	<h1><br>Time Off Requests<br></h1>
	<br>
	<div id="strategies" style="margin-top:15px;" class=" padding10 ribbed-yellow"></div>
	<br>
</div>
<!-- START BODY CONTENT AREA -->
<div class="container">
   	<div class="row pageLook">
		<div class="container">
<?
$division = '';
$department = '';
$isManager = '';
$staffStatus = new user_action;
foreach($staffStatus->get_staff_level() as $results) {
	$division = "'" . $results['division'] . "'";
	$department = $results['department'];
	$isManager = $results['isManager'];
}

if ( $isManager == 1 ) {
	?>
			<div class="row mb-4">
				<h3 class="text-dark w-100 ml-2">Manager Options</h3>
				<div class="col-md-6 mb-2">
					<div class="btn btn-primary btn-lg text-center w-100" id="view_time_off_btn">See Time Off Requests</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="btn btn-primary btn-lg text-center w-100" id="view_staff_summary_btn">Staff Summary</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="btn btn-primary btn-lg text-center w-100" onClick="$('#enterRTO').modal('show')">Enter Staff Time Off</div>
				</div>
			</div>

	<?
}
?>
			<div class="row">
				<h3 class="text-dark w-100 ml-2">Staff Options</h3>
				<div class="col-md-6 mb-2">
					<div class="btn btn-primary btn-lg text-center w-100" id="view_timesheet_btn">See My Time Sheet</div>
				</div>
				<div class="col-md-6 mb-2">
					<div class="btn btn-primary btn-lg text-center w-100" onClick="$('#requestRTO').modal('show')">Request Time Off</div>
				</div>
			</div>
		
			<div id="time-off-block" class="content">
				<div class="col-12" id="rtoResults"></div>
			</div>
		</div>
	</div>
</div>
<!-- END BODY CONTENT AREA -->
<? include ('footer.php'); ?>
<? echo $access_level ?>
<div class="modal fade" id="enterRTO">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Enter Time Off for Staff</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form id="enter_time_off" class="row">

						<input type="hidden" id="enter_action" name="action" value="submitRTO">
						<input type="hidden" id="enter_hours_paid" name="hours_paid" value="0">
						<input type="hidden" id="enter_hours_unpaid" name="hours_unpaid" value="0">
						<input type="hidden" id="enter_approval" name="approval" value="1">

						<fieldset class="form-group col-md-6">
							<label for="quote-num">Staff Member:</label>
							<select class="mdb-select" id="enter_staff" name="staff">
								<option value="0">Select Staff Member... </option>
	<?
	$staffOptions = '';
	$_POST = array();
	$staffMember = new user_action;
	$_POST['division'] = $division;
	$_POST['department'] = $department;
	$_POST['user'] = '';
	if ( ($division=='7') || ($division=='3') || ($division=='1') ) {
		$_POST['user'] = 'exec';
	} else {
		$_POST['user'] = 'manager';
	}
	foreach ( $staffMember->get_staff_names( $_POST ) as $results ) {
		$staffOptions .= '<option email="' . $results['email'] . '" value="' . $results['id'] . '">' . $results['username'] . ' - ' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	}
	echo $staffOptions;
	echo '<option value="' . $division . '">' . $_POST['user'] . '</option>';
	$_POST = array();
	?>
							</select>
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="respond_email">Notify Email:</label>
							<input class="form-control" id="enter_respond_email" name="respond_email" type="email">
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="respond_email">Time Off Type:</label>
							<select class="mdb-select" id="enter_type" name="type">
								<option value="Sick">Sick Day(s)</option>
								<option value="Vacation">Vacation</option>
							</select>
						</fieldset>

						<fieldset class="form-group col-md-4">
							<label for="start_date">Start Date:</label>
							<input class="form-control" id="enter_start_date" name="start_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T09:00';?>" step="1800">
						</fieldset>

						<fieldset class="form-group col-md-4">
							<label for="end_date">End Date:</label>
							<input class="form-control" id="enter_end_date" name="end_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T17:00';?>" step="1800">
						</fieldset>

						<fieldset class="form-group col-12">
							<label for="notes">Notes:</label>
							<textarea class="form-control" id="enter_notes" name="notes" rows="3"></textarea>
						</fieldset>
						<div class="btn btn-primary btn-lg col-12" id="enter_time_off_btn">Save to Timesheets</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="updateRTO">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Update Time Off Request</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form id="update_time_off" class="row">

						<input type="hidden" id="update_action" name="action" value="updateRTO">
						<input type="hidden" id="update_hours_paid" name="hours_paid" value="0">
						<input type="hidden" id="update_hours_unpaid" name="hours_unpaid" value="0">

						<fieldset class="form-group col-md-6">
							<label for="quote-num">Staff Member:</label>
							<select class="mdb-select" id="update_staff" name="staff" readonly >
	<?
	$_POST = array();
	$_POST['division'] = $division;
	$_POST['department'] = $department;
	$staffOptions = '';
	$staffMember = new user_action;
	if ( ( $division == '7' ) || ( $division == '3' ) || ( $division == '1' && $department == 0 ) ) {
		$_POST['user'] = 'exec';
	} else if ( $isManager == '1' ) {
		$_POST['user'] = 'manager';
	}
	foreach ( $staffMember->get_staff_names( $_POST ) as $results ) {
		$staffOptions .= '<option email="' . $results['email'] . '" value="' . $results['id'] . '">' . $results['username'] . ' - ' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	}
	echo $staffOptions;
	$_POST = array();
	?>
							</select>
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="respond_email">Respond to Email:</label>
							<input class="form-control" id="update_respond_email" name="respond_email" type="email" value="<?= $staffEmail ?>">
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="respond_email">Time Off Type:</label>
							<select class="mdb-select" id="update_type" name="type">
								<option value="Sick">Sick Day(s)</option>
								<option value="Vacation">Vacation</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="start_date">Start Date:</label>
							<input class="form-control" id="update_start_date" name="start_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T09:00';?>" step="1800">
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="end_date">End Date:</label>
							<input class="form-control" id="update_end_date" name="end_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T17:00';?>" step="1800">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="notes">Notes:</label>
							<textarea class="form-control" id="update_notes" name="notes" rows="3"></textarea>
						</fieldset>
						<div class="btn btn-primary btn-lg col-12" id="update_time_off_btn">Update Request</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="requestRTO">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Request Time Off</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<form id="request_time_off" class="row">

						<input type="hidden" id="request_action" name="action" value="submitRTO">
						<input type="hidden" id="request_hours_paid" name="hours_paid" value="0">
						<input type="hidden" id="request_hours_unpaid" name="hours_unpaid" value="0">
						<input type="hidden" id="enter_approval" name="approval" value="0">

						<fieldset class="form-group col-md-6">
							<label for="quote-num">Staff Member:</label>
							<select class="mdb-select" id="request_staff" name="staff" readonly>
							<?
$staffOptions = '';
$staffEmail = '';
$staffMember = new user_action;
foreach($staffMember->get_staff_name() as $results) {
	$staffOptions .= '<option value="' . $results['id'] . '">' . $results['username'] . ' - ' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	$staffEmail = $results['email'];
}
echo $staffOptions;
							?>
							</select>
						</fieldset>
						<fieldset class="form-group col-md-6">
							<label for="respond_email">Respond to Email:</label>
							<input class="form-control" id="request_respond_email" name="respond_email" type="email" value="<?= $staffEmail ?>">
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="respond_email">Time Off Type:</label>
							<select class="mdb-select" id="request_type" name="type">
								<option value="Vacation">Vacation</option>
								<option value="Sick">Sick Day(s)</option>
							</select>
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="start_date">Start Date:</label>
							<input class="form-control" id="request_start_date" name="start_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T09:00';?>" step="1800">
						</fieldset>
						<fieldset class="form-group col-md-4">
							<label for="end_date">End Date:</label>
							<input class="form-control" id="request_end_date" name="end_date" type="datetime-local" value="<? echo date('Y-m-d') . 'T17:00';?>" step="1800">
						</fieldset>
						<fieldset class="form-group col-12">
							<label for="notes">Notes:</label>
							<textarea class="form-control" id="request_notes" name="notes" rows="3"></textarea>
						</fieldset>
						<div class="btn btn-primary btn-lg col-12" id="request_time_off_btn">Request Time Off</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="successRTO">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Success</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid successModal">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewRTOs">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Time Off Requests</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid viewModal">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="summaryTimeOff">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Summary By Staff</h3>
				<button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<form id="pullSummaryByYear" class="d-flex">
					<select name="summaryYear" class="col-6 mdb-select">
						<option value="2017">2017</option>
						<option value="2018" selected>2018</option>
					</select>
					<div class="btn btn-primary col-6" onClick="summaryPull()"><i class="fa fa-eye"></i> View</div>
				</form>
				<div class="container-fluid summaryModal">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
			</div>
		</div>
	</div>
</div>


<script>

var $division = <?= $division ?>;
var $department = <?= $department ?>;
var $isManager = <?= $isManager ?>;

function compareTime(time1, time2) {
	return new Date(time1) > new Date(time2); // true if time1 is later
}

if ( $division == '7' || $division == '3' || ($division == '1' && $department == 0) ) {
	$pullType = 'exec';
	$pull = 0;
} else  {
	$pullType = 'manager';
	$pull = $division;
}


$('#view_time_off_btn').click( function() {
	var datastring = 'action=viewRTOs&type=' + $pullType + '&pull=' + $division + '&department=' + $department;
	console.log(datastring);
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		success: function(data) {
			console.log(data);
			$('.mdb-select').material_select('destroy');
			$('.viewModal').html('');
			$('.viewModal').html(data);
			$('.mdb-select').material_select();
			$('#viewRTOs').modal('show');
		},
		error: function(data) {
			$('.mdb-select').material_select('destroy');
			$('.viewModal').html('');
			$('.viewModal').html(data);
			$('.mdb-select').material_select();
			$('#viewRTOs').modal('show');
		}
	});
})

$('#view_timesheet_btn').click( function() {
	var data = 'action=viewRTOs&type=personal&pull=<?= $_SESSION['id'] ?>&department=' + $department;
	console.log(data);
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: data,
		success: function(data) {
			$('.mdb-select').material_select('destroy');
			$('.viewModal').html('');
			$('.viewModal').html(data);
			$('.mdb-select').material_select();
			$('#viewRTOs').modal('show');
		},
		error: function(data) {
			alert(JSON.stringify(data));
			$('.mdb-select').material_select('destroy');
			$('.viewModal').html('');
			$('.viewModal').text(data);
			$('.mdb-select').material_select();
			$('#viewRTOs').modal('show');
		}
	});
})

$('#view_staff_summary_btn').click( function() {
	$('#summaryTimeOff').modal('show');
})

function summaryPull() {
	var $year = $('select[name=summaryYear] option:selected').val()
	var data = 'action=staff_summary&year=' + $year;

	if ( $division == '7' || ( $division == '1' && $department == 0 ) || $division == '3' ) {
		data += '&user=exec&division=0&department=0';

	} else if ( $isManager == 1 ) {

		data += '&user=manager&division=' + $division + '&department=' + $department;

	}

	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: data,
		success: function(data) {
			$('.mdb-select').material_select('destroy');
			$('.summaryModal').html('');
			$('.summaryModal').html(data);
			$('.mdb-select').material_select();
			$('.summaryModal').append('Success');
		},
		error: function(data) {
			alert(JSON.stringify(data));
			$('.mdb-select').material_select('destroy');
			$('.summaryModal').html('');
			$('.summaryModal').text(data);
			$('.mdb-select').material_select();
			$('.summaryModal').append('Failed');
		}
	});
}

$('#request_time_off_btn').click( function() {
	if ( $('#request_respond_email').val() == "" ) {
		alert('You must have an email to receive a response.');
		return false;
	}
	var startTime = new Date($('#request_start_date').val());
	var endTime = new Date($('#request_end_date').val());
	if( startTime > endTime ) {
		alert('End Date must be after Start Date.');
		return false;
	}
	   //start is less than End
	var datastring = $("form#request_time_off").serialize();
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		complete: function() {
			$('#requestRTO').modal('hide');
			$('.successModal').html('');
			$('.successModal').html('<h3 class="text-success">Your request has been submitted. You will hear back on the email provided.</h3>');
			$('#successRTO').modal('show');
		}
	});
})

$('#enter_time_off_btn').click( function() {
	if ( $('#enter_staff').val() == 0 ) {
		alert('You must choose a staff member.');
		return false;
	}
	if ( $('#enter_respond_email').val() == "" ) {
		alert('You must have an email to receive a response.');
		return false;
	}
	var startTime = new Date($('#enter_start_date').val());
	var endTime = new Date($('#enter_end_date').val());
	if( startTime > endTime ){
		alert('End Date must be after Start Date.');
		return false;
	}
	var datastring = $("form#enter_time_off").serialize();
	$.ajax({
		type: "POST",
		url: "ajax.php",
		data: datastring,
		complete: function(data) {
			$('#enterRTO').modal('hide');
			$('.successModal').html('');
			$('.successModal').html('<h3 class="text-success">You have entered Staff Member Time Off hours.</h3>');
			$('#successRTO').modal('show');
		}
	});
})

$('#enter_staff').on('change', function() {
	var $email = $('#enter_staff option:selected').attr('email');
	$('#enter_respond_email').val($email);
})

</script>
</body>
</html>