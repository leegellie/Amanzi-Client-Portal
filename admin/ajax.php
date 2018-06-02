<?PHP
if(!session_id()) session_start();
require_once (__DIR__ . '/../include/class/user.class.php');
require_once (__DIR__ . '/../include/class/project.class.php');
require_once (__DIR__ . '/../include/class/materials.class.php');
/*
USER AJAX REQUESTS 
*/
$action = trim(htmlspecialchars($_POST['action']));
$to_cost = 7.5;
$marbgran_rate = 6;

function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                   "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                   'â€"', 'â€"', 'â€', 'â€', ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;
}

function get_working_hours($from,$to) {
    // timestamps
    $from_timestamp = strtotime($from);
    $to_timestamp = strtotime($to);
    // work day seconds
    $workday_start_hour = 9;
    $workday_end_hour = 17;
    $workday_seconds = ($workday_end_hour - $workday_start_hour) * 3600;
    // work days beetwen dates, minus 1 day
    $from_date = date('Y-m-d',$from_timestamp);
    $to_date = date('Y-m-d',$to_timestamp);
    $workdays_number = count(get_workdays($from_date,$to_date)) - 1;
    $workdays_number = $workdays_number < 0 ? 0 : $workdays_number;
    // start and end time
    $start_time_in_seconds = date("H",$from_timestamp) * 3600 + date("i",$from_timestamp) * 60;
    $end_time_in_seconds = date("H",$to_timestamp) * 3600 + date("i",$to_timestamp) * 60;
    // final calculations
    $working_hours = ($workdays_number * $workday_seconds + $end_time_in_seconds - $start_time_in_seconds) / 86400 * 24;
    return $working_hours;
}

function get_workdays($from,$to) {
    // arrays
    $days_array = array();
    $skipdays = array("Saturday", "Sunday");
    $skipdates = get_holidays();
    // other variables
    $i = 0;
    $current = $from;
    if($current == $to) // same dates
    {
        $timestamp = strtotime($from);
        if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
            $days_array[] = date("Y-m-d",$timestamp);
        }
    }
    elseif($current < $to) // different dates
    {
        while ($current < $to) {
            $timestamp = strtotime($from." +".$i." day");
            if (!in_array(date("l", $timestamp), $skipdays)&&!in_array(date("Y-m-d", $timestamp), $skipdates)) {
                $days_array[] = date("Y-m-d",$timestamp);
            }
            $current = date("Y-m-d",$timestamp);
            $i++;
        }
    }
    return $days_array;
}

function createDateRangeArray($strDateFrom,$strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script
    $aryRange=array();
    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function get_holidays() {
    // arrays
    $days_array = array();
	$get_holidays = new user_action;

	foreach($get_holidays -> get_holidays() as $results) {
		$arr = createDateRangeArray($results['start_date'],$results['end_date']);
		foreach ($arr as $key => $value) {
			array_push($days_array, $value);
		}
	}
    return $days_array;
}

// ADMIN ADD USERS

if ($action=="get_address_geo") {
	$result = '';
	$address = $_POST['address_1'] .' '. $_POST['address_2'] . ' ' . $_POST['city'] . ' ' . $_POST['zip'];
	$geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBqPzFs8u8_yAC5N-nWXFp0eNz02xaGik4&address='.urlencode($address).'&sensor=false');
	$geo = json_decode($geo, true); // Convert the JSON to an array

	if (isset($geo['status']) && ($geo['status'] == 'OK')) {
		$latitude = $geo['results'][0]['geometry']['location']['lat']; // Latitude
		$longitude = $geo['results'][0]['geometry']['location']['lng']; // Longitude
		$result = $latitude . '::' . $longitude;
	} else {
		$result = 'Failed';
	}
	print $result;
}



// GET RTO LIST.
if ($action=="viewRTOs") {
	unset($_POST['action']);
	$html = '';
	$get_rtos = new user_action;
	foreach( $get_rtos -> get_rtos($_POST) as $r ) {
		$sDate = strtotime($r['start_date']);
		$sDate = date("m/d/Y H:i",$sDate);
		$eDate = strtotime($r['end_date']);
		$eDate = date("m/d/Y H:i",$eDate);
		$aDate = strtotime($r['approval_date']);
		$aDate = date("m/d/Y",$aDate);
		$html .= '<div class="container d-flex" onClick="viewRTOdetails(' . $r['id'] . ')">';
		$html .= '<div class="col-1">Type: ' . $r['type'] . '</div>';
		$html .= '<div class="col-2">' . $r['sLname'] . ', ' . $r['sFname'] . '</div>';
		$html .= '<div class="col-4">' . $sDate . ', ' . $eDate . '</div>';
		$html .= '<div class="col-2">Hours Off: ' . $r['hours_paid'] . '</div>';
		if ($r['approval'] == 1) {
			$html .= 'Approved by ' . $r['mFname'] . ' ' . $r['mLname'] . ' on: ' . $aDate;
		} else {
			if ( $_POST['type'] == 'personal' || $r['staff'] == $_SESSION['id'] ) {
				$html .= 'Not yet approved.';
			} else {
				$html .= '<div class="col-3 btn btn-lg btn-success" onClick="approveRTO(' . $r['id'] . ',' . $uid . ')"><i class="fas fa-check"></i> Approve</div>';
			}
		}
		$html .= '</div><hr class="col-12">';	
	}
	print $html;
}



// ADD TIME OFF REQUEST.
if ($action=="submitRTO") {
	unset($_POST['action']);
	if ( $_POST['approval'] == 1 ) {
		$_POST['approval_id'] = $_SESSION['id'];
		$_POST['approval_date'] = date("Y-m-d H:i:s");
	}
	$_POST['hours_paid'] = get_working_hours($_POST['start_date'],$_POST['end_date']);
	$submit_rto = new user_action;
	echo $submit_rto -> submit_rto($_POST);
}

if ($action=="staff_summary") {
	unset($_POST['action']);
	$year = $_POST['year'];
	$division = $_POST['division'];
	$department = $_POST['department'];
	$user = $_POST['user'];
	unset($_POST['year']);
	$html = "";
	$dString = strtotime($year . '-01-01');
	$thisYear = new DateTime(date("Y-m-d",$dString));

	$uVaca = 0;
	$uSick = 0;
	$sVaca = 0;

	$summary = new user_action;
	foreach( $summary->staff_summary($_POST) as $r ) {
		$hire_date = new DateTime(date("Y-m-d",strtotime($r['hire_date'])));
		$diff = $thisYear->diff($hire_date);
		$years_active = $diff->y;
		if  ( $r['fulltime'] == 0 ) {
			if ( $r['pto_override'] > 0 ) {
				$actual_time = $r['pto_override'];
			} else {
				$actual_time = 0;
			}
		} else {
			if ( $years_active < 1 ) {
				$calc_time = 0;
			} elseif ( $years_active < 3 ) {
				$calc_time = 80;
			} elseif ( $years_active < 5 ) {
				$calc_time = 120;
			} elseif ( $years_active < 15 ) {
				$calc_time = 160;
			} else {
				$calc_time = 200;
			}
			if ( $r['pto_override'] > $calc_time ) {
				$actual_time = $r['pto_override'];
			} else {
				$actual_time = $calc_time;
				$r['pto_override'] = 0;
			}
		}
		$html .= '<div class="col-12"><div class="font-weight-bold text-uppercase w-25">' . $r['lname'] . ', ' . $r['fname'] . '</div> Hire Date: ' . date("Y-m-d",strtotime($r['hire_date'])) . ' - Years Active: ' . $years_active . '</div>';
		$html .= '<div class="container d-flex" onClick="viewStaffDetails(' . $r['id'] . ')">';
		$html .= '<div class="col-2">PTO: <b>' . $actual_time . '</b></div>';
		$html .= '<div class="col-2">Override: ' . $r['pto_override'] . '</div>';

		$usedSick = new user_action;
		foreach ( $usedSick -> sick_days( $r['id'],$year ) as $item ) {
			$uSick = $item['sick_days'];
			if ( $uSick < 1 ) {
				$uSick = 0;
			}
			$html .= '<div class="col-2">Sick Hours: ' . $uSick . '</div>';
		}

		$usedVacation = new user_action;
		foreach ($usedVacation -> used_vacation($r['id'],$year) as $item) {
			$uVaca = $item['used_vacation'];
			$html .= '<div class="col-3">Vacation Used: ' . $uVaca . '</div>';
		}

		$usedTotal = $uSick + $uVaca;
		$html .= '<div class="col-3">Total Used: ' . $usedTotal . '</div>';

		$html .= '</div>';
		$html .= '<div class="container d-flex" onClick="viewStaffDetails(' . $r['id'] . ')">';
		if ( $usedTotal < $actual_time ) {
			$left = $actual_time - $usedTotal;
			$html .= '<div class="col-4">PTO Left: ' . $left . '</div>';
			$html .= '<div class="col-4">Unpaid Time: 0</div>';
		} else {
			$upto = $usedTotal - $actual_time;
			$html .= '<div class="col-4">PTO Left: 0</div>';
			$html .= '<div class="col-4">Unpaid Time: ' . $upto . '</div>';
		}
		$scheduledVacation = new user_action;
		foreach ($scheduledVacation -> scheduled_vaca($r['id'],$year) as $item) {
			$sVaca = $item['scheduled_vaca'];
			$html .= '<div class="col-4">Vacation Scheduled: ' . $sVaca . '</div>';
		}


		$html .= '</div>';
		$html .= '<hr class="col-12">';	
		
	}
	echo $html;
}

if ($action=="get_staff_list") {

	unset($_POST['action']);
	$results = "";
	$search = new user_action;

	echo "<hr>";
	echo '<div id="resultsTable1" class="row"><select id="weekSelect">';
	echo '<option value="0">Select Week</option>';

	define('NL', "\n");

	$year           = 2018;
	$firstDayOfYear = mktime(0, 0, 0, 1, 1, $year);
	$nextSunday     = strtotime('sunday', $firstDayOfYear);
	$nextSaturday     = strtotime('saturday', $nextSunday);

	while (date('Y', $nextSunday) == $year) {
		echo date('c', $nextSunday), '-', date('c', $nextSaturday), NL;

		$nextSunday = strtotime('+1 week', $nextSunday);
		$nextSaturday = strtotime('+1 week', $nextSaturday);
	}
	

	echo '</seletc></div>';
	echo '<div id="resultsTable1" class="row">';
	echo '<h2 id="" class="text-success w-100">Staff</h2>';

	foreach($search->get_staff_list() as $results) {
		if (($results['job_status'] < 41 && $results['job_status'] > 24) || ($results['job_status'] > 13 && $results['job_status'] < 41  && $results['acct_rep'] == 6)) {
			?>
				<div  class="col-9 col-md-5 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-2 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-2 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-flex">
						<div class="col-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-flex">
						<div class="col-2">Material: <?= $row['material']; ?></div>
						<div class="col-4">Color: <?= $row['color']; ?></div>
						<div class="col-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-2">Lot: <?= $row['lot']; ?></div>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '<hr style="height:5px;margin-top:15px;background:magenta;">';

	echo '<h2 id="" class="text-success w-100">Materials Ordered / In Staging</h2>';
	foreach($search->get_materials_needed() as $results) {
		if ($results['job_status'] > 40 && $results['job_status'] < 44 && $results['job_status'] != 26) {
			?>
				<div  class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			<?
			$installs = new materials_action;

			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-flex">
						<div class="col-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-flex">
						<div class="col-2">Material: <?= $row['material']; ?></div>
						<div class="col-4">Color: <?= $row['color']; ?></div>
						<div class="col-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-2">Lot: <?= $row['lot']; ?></div>
					</div>
					<div class="container d-flex">
					<?
						if($row['material_status'] == 1) {
					?>
						<div class="col-6 text-danger"><b>Status: To be assigned/ordered.</b></div>
						<div class="col-3 btn btn-sm btn-primary orderMaterials" onClick="matOredered(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')" >Ordered</div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 2) {
					?>
						<div class="col-6 text-success"><b>Status: Materials ordered. Est. delivery <?= date('Y-m-d', strtotime($row['material_date'])) ?></b></div>
						<div class="col-3">Reference: <?= $row['assigned_material'] ?></div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 3) {
					?>
						<div class="col-6 text-primary"><b>Status: Materials On Hand</b></div>
						<div class="col-6">Assigned Material: <?= $row['assigned_material'] ?></div>
					<?
						}
					?>

					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '<hr style="height:5px;margin-top:15px;background:magenta;">';
	echo '<h2 id="" class="text-success w-100">Materials On Hold</h2>';
	foreach($search->get_materials_needed() as $results) {
		if ($results['job_status'] == 49 && $results['job_status'] != 26) {
			?>
				<div  class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-flex">
						<div class="col-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-flex">
						<div class="col-2">Material: <?= $row['material']; ?></div>
						<div class="col-4">Color: <?= $row['color']; ?></div>
						<div class="col-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-2">Lot: <?= $row['lot']; ?></div>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '<hr style="height:5px;margin-top:15px;background:magenta;">';
	echo '<h2 id="" class="text-success w-100">Delivered to Saw</h2>';
	foreach($search->get_materials_needed() as $results) {
		if ($results['job_status'] == 44 && $results['job_status'] != 26) {
			?>
				<div  class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
				<hr>
			<?
		}
	}
	echo "</div>";
	echo '<hr style="height:5px;margin-top:15px;background:magenta;">';
}

if ($action=="location_log") {
	unset($_POST['action']);
	$logUser = $_SESSION['id'];
	$lat = $_POST['latitude'];
	$long = $_POST['longitude'];
	$update_location = new log_action;
	echo $update_location -> location_log($logUser,$lat,$long);
}

if ($action=="ordered_material") {
	unset($_POST['action']);
	$run = new materials_action;
	$run -> ordered_material($_POST);
	echo $run;
}

if ($action=="add_marble") {
	unset($_POST['action']);
	$add_marble = new materials_action;
	$add_marble -> add_marble($_POST);
}
if ($action=="delete_marble") {
	unset($_POST['action']);
	$delete_marble = new materials_action;
	$delete_marble -> delete_marble($_POST);
}
if ($action=="update_marble") {
	unset($_POST['action']);
	$update_marble = new materials_action;
	$update_marble -> update_marble($_POST);
}

if ($action=="add_quartz") {
	unset($_POST['action']);
	$add_quartz = new materials_action;
	$add_quartz -> add_quartz($_POST);
}
if ($action=="delete_quartz") {
	unset($_POST['action']);
	$delete_quartz = new materials_action;
	$delete_quartz -> delete_quartz($_POST);
}
if ($action=="update_quartz") {
	unset($_POST['action']);
	$update_quartz = new materials_action;
	$update_quartz -> update_quartz($_POST);
}

if ($action=="assign_material") {
	unset($_POST['action']);
	$run = new materials_action;
	$run -> assign_material($_POST);
}

if ($action=="no_material") {
	unset($_POST['action']);
	$run = new materials_action;
	$run -> no_material($_POST);
}

if ($action=="material_delivered") {
	$pid = $_POST['pid'];
	unset($_POST['action']);
	unset($_POST['pid']);
	$run = new materials_action;
	$run -> material_delivered($pid);

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Delivered to Fabrication.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);
}


if ($action=="get_materials_needed") {

	unset($_POST['action']);
	$results = "";
	$search = new materials_action;

	echo "<hr>";
	echo '<div id="resultsTable1" class="row striped">';

	echo '<ul class="nav nav-tabs w-100 mb-3" id="myTab" role="tablist">';
	echo '<li class="nav-item">';
	echo '<a class="nav-link active" id="toOrder-tab" data-toggle="tab" href="#toOrder" role="tab" aria-controls="toOrder" aria-selected="true"><h5>To Order/Schedule</h5></a>';
	echo '</li>';
	echo '<li class="nav-item">';
	echo '<a class="nav-link" id="mOrdered-tab" data-toggle="tab" href="#mOrdered" role="tab" aria-controls="mOrdered" aria-selected="false"><h5>Materials Ordered</h5></a>';
	echo '</li>';
	echo '<li class="nav-item">';
	echo '<a class="nav-link" id="mOnHand-tab" data-toggle="tab" href="#mOnHand" role="tab" aria-controls="mOrdered" aria-selected="false"><h5>Materials Here</h5></a>';
	echo '</li>';
	echo '<li class="nav-item">';
	echo '<a class="nav-link" id="toDeliver-tab" data-toggle="tab" href="#toDeliver" role="tab" aria-controls="toDeliver" aria-selected="false"><h5>Pull Sheet</h5></a>';
	echo '</li>';
	echo '<li class="nav-item">';
	echo '<a class="nav-link" id="mSaw-tab" data-toggle="tab" href="#mSaw" role="tab" aria-controls="mSaw" aria-selected="false"><h5>Delivered to Saw</h5></a>';
	echo '</li>';
	echo '<li class="nav-item">';
	echo '<a class="nav-link" id="mHold-tab" data-toggle="tab" href="#mHold" role="tab" aria-controls="mHold" aria-selected="false"><h5>On Hold</h5></a>';
	echo '</li>';
	echo '</ul>';
	echo '<div class="tab-content w-100" id="myTabContent">';
	echo '<div id="toOrder" class="tab-pane fade show active" role="tabpanel" aria-labelledby="toOrder-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['install_date'] == '2200-01-01') {
			$results['install_date'] = 'Not Set.';
		}
		if ($results['template_date'] == '2200-01-01') {
			$results['template_date'] = 'Not Set.';
		}

		if ( $results['job_status'] > 11 && $results['job_status'] < 41 ) {
			?>
			<div class="w-100 d-flex">
				<div class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			</div>
			<div class="w-100 d-flex">
				<div class="col-6">Template Date: <?= $results['template_date']; ?></div><div class="col-6">Install Date: <?= $results['install_date']; ?></div>
			</div>
			<hr>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-md-flex">
						<div class="col-md-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-md-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-md-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-md-flex">
						<div class="col-md-2">Material: <?= $row['material']; ?></div>
						<div class="col-md-3">Color: <?= $row['color']; ?></div>
						<div class="col-md-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-md-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-md-3">Lot: <?= $row['lot']; ?></div>
					</div>
					<hr>
					<div class="container d-flex">
					<?
						if($row['material_status'] == 1) {
					?>
						<div class="col-7 text-danger"><b>Status: To be assigned/ordered.</b></div>
						<div class="col-1 btn btn-sm btn-danger mr-2" onClick="noMaterial(<?= $row['id'] ?>)">N/A <i class="fas fa-ban"></i></div>
						<div class="col-2 btn btn-sm btn-success mr-2 orderMaterials" onClick="matOredered(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')" >Ordered <i class="far fa-calendar-check"></i></div>
						<div class="col-2 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials <i class="fas fa-check"></i></div>
					<?
						} else if($row['material_status'] == 2) {
					?>
						<div class="col-6 text-success"><b>Status: Materials ordered. Est. delivery <?= date('Y-m-d', strtotime($row['material_date'])) ?></b></div>
						<div class="col-3">Reference: <?= $row['assigned_material'] ?></div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 3) {
					?>
						<div class="col-6 text-primary"><b>Status: Materials On Hand</b></div>
						<div class="col-6">Assigned Material: <?= $row['assigned_material'] ?></div>
					<?
						} else if($row['material_status'] == 4) {
					?>
						<div class="col-6 text-muted"><b>Status: Materials not needed.</b></div>
					<?
						}
					?>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '</div>';

	echo '<div id="mOrdered" class="tab-pane fade" role="tabpanel" aria-labelledby="mOrdered-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['install_date'] == '2200-01-01') {
			$results['install_date'] = 'Not Set.';
		}
		if ($results['template_date'] == '2200-01-01') {
			$results['template_date'] = 'Not Set.';
		}
		if ($results['job_status'] == 41) {
			?>
			<div class="w-100 d-flex">
				<div class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			</div>
			<div class="w-100 d-flex">
				<div class="col-6">Template Date: <?= $results['template_date']; ?></div><div class="col-6">Install Date: <?= $results['install_date']; ?></div>
			</div>
			<hr>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-md-flex">
						<div class="col-md-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-md-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-md-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-md-flex">
						<div class="col-md-2">Material: <?= $row['material']; ?></div>
						<div class="col-md-3">Color: <?= $row['color']; ?></div>
						<div class="col-md-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-md-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-md-3">Lot: <?= $row['lot']; ?></div>
					</div>
					<hr>
					<div class="container d-flex">
					<?
						if($row['material_status'] == 1) {
					?>
						<div class="col-7 text-danger"><b>Status: To be assigned/ordered.</b></div>
						<div class="col-1 btn btn-sm btn-danger mr-2" onClick="noMaterial(<?= $row['id'] ?>)">N/A <i class="fas fa-ban"></i></div>
						<div class="col-2 btn btn-sm btn-success mr-2 orderMaterials" onClick="matOredered(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')" >Ordered <i class="far fa-calendar-check"></i></div>
						<div class="col-2 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials <i class="fas fa-check"></i></div>
					<?
						} else if($row['material_status'] == 2) {
					?>
						<div class="col-6 text-success"><b>Status: Materials ordered. Est. delivery <?= date('Y-m-d', strtotime($row['material_date'])) ?></b></div>
						<div class="col-3">Reference: <?= $row['assigned_material'] ?></div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 3) {
					?>
						<div class="col-6 text-primary"><b>Status: Materials On Hand</b></div>
						<div class="col-6">Assigned Material: <?= $row['assigned_material'] ?></div>
					<?
						} else if($row['material_status'] == 4) {
					?>
						<div class="col-6 text-muted"><b>Status: Materials not needed.</b></div>
					<?
						}
					?>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '</div>';


	echo '<div id="mOnHand" class="tab-pane fade" role="tabpanel" aria-labelledby="mOnHand-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['install_date'] == '2200-01-01') {
			$results['install_date'] = 'Not Set.';
		}
		if ($results['template_date'] == '2200-01-01') {
			$results['template_date'] = 'Not Set.';
		}
		if ($results['job_status'] == 42) {
			?>
			<div class="w-100 d-flex">
				<div class="col-9 col-md-8 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-md-1 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			</div>
			<div class="w-100 d-flex">
				<div class="col-6">Template Date: <?= $results['template_date']; ?></div><div class="col-6">Install Date: <?= $results['install_date']; ?></div>
			</div>
			<hr>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-md-flex">
						<div class="col-md-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-md-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-md-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-md-flex">
						<div class="col-md-2">Material: <?= $row['material']; ?></div>
						<div class="col-md-3">Color: <?= $row['color']; ?></div>
						<div class="col-md-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-md-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-md-3">Lot: <?= $row['lot']; ?></div>
					</div>
					<hr>
					<div class="container d-flex">
					<?
						if($row['material_status'] == 1) {
					?>
						<div class="col-7 text-danger"><b>Status: To be assigned/ordered.</b></div>
						<div class="col-1 btn btn-sm btn-danger mr-2" onClick="noMaterial(<?= $row['id'] ?>)">N/A <i class="fas fa-ban"></i></div>
						<div class="col-2 btn btn-sm btn-success mr-2 orderMaterials" onClick="matOredered(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')" >Ordered <i class="far fa-calendar-check"></i></div>
						<div class="col-2 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials <i class="fas fa-check"></i></div>
					<?
						} else if($row['material_status'] == 2) {
					?>
						<div class="col-6 text-success"><b>Status: Materials ordered. Est. delivery <?= date('Y-m-d', strtotime($row['material_date'])) ?></b></div>
						<div class="col-3">Reference: <?= $row['assigned_material'] ?></div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 3) {
					?>
						<div class="col-6 text-primary"><b>Status: Materials On Hand</b></div>
						<div class="col-6">Assigned Material: <?= $row['assigned_material'] ?></div>
					<?
						} else if($row['material_status'] == 4) {
					?>
						<div class="col-6 text-muted"><b>Status: Materials not needed.</b></div>
					<?
						}
					?>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '</div>';

	echo '<div id="toDeliver" class="tab-pane fade" role="tabpanel" aria-labelledby="toDeliver-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['job_status'] == 42 || $results['job_status'] == 43) {
			$cDate = strtotime("now");
			$weekOut = date('Y-m-d', strtotime($cDate . "+7 days"));
			$iDate = strtotime($results['install_date']);
			$installDate = date('Y-m-d', strtotime($iDate));
			if( $iDate < $cDate ) {
				?>
				<div class="w-100 d-flex">
	
					<div class="col-5 text-primary"><h3><?= $results['job_name']; ?></h3></div>
					<div class="col-3">
						<h3>Order: <?= $results['order_num']; ?></h3>
					</div>
					<div class="col-4 text-right">
						<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);"><span class="hidden-md-down">View </span><i class="fas fa-eye"></i></div>
						<div id="<?= $results['id']; ?>" class="btn btn-sm btn-success" onClick="material_delivered(this.id);"><span class="hidden-md-down">Delivered </span><i class="fas fa-truck"></i></div>
					</div>
					
				</div>
				<div class="w-100 d-flex">
					<div class="col-3">Install Date: <b><?= $results['install_date']; ?></b></div>
					<div class="col-9">Job Notes: <?= $results['job_notes']; ?></div>
				</div>
				<hr>
				<?
				$installs = new materials_action;
				foreach($search->get_install_materials($results['id']) as $row) {
					?>
					<div class="col-12">
						<div class="container">
							<div class="col-12">Sink: <?= $row['sk_detail']; ?></div>
							<div class="col-12 text-muted">Sales Note: <?= $row['lot']; ?> - <?= $row['color']; ?></div>
							<div class="col-12">Assigned: <?= $row['assigned_material']; ?></div>
							<div class="col-12">Notes: <?= $row['install_notes']; ?></div>
						</div>
					</div>
					<hr>
					<?
				}
			?>
				<hr>
			<?
			}
		}
	}
	echo '</div>';


	echo '<div id="mHold" class="tab-pane fade" role="tabpanel" aria-labelledby="mHold-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['install_date'] == '2200-01-01') {
			$results['install_date'] = 'Not Set.';
		}
		if ($results['template_date'] == '2200-01-01') {
			$results['template_date'] = 'Not Set.';
		}
		if ($results['job_status'] == 49) {
			?>
			<div class="w-100 d-flex">
				<div class="col-9 col-md-5 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-md-3 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-md-3 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-1 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			</div>
			<div class="w-100 d-flex">
				<div class="col-6">Template Date: <?= $results['template_date']; ?></div><div class="col-6">Install Date: <?= $results['install_date']; ?></div>
			</div>
			<hr>
			<?
			$installs = new materials_action;
			foreach($search->get_install_materials($results['id']) as $row) {
			?>
				<div class="col-12">
					<div class="container d-md-flex">
						<div class="col-md-4">Install: <?= $row['install_name']; ?></div>
						<div class="col-md-4">Sink: <?= $row['sk_detail']; ?></div>
						<div class="col-md-4">Range: <?= $row['range_model']; ?></div>
					</div>
					<div class="container d-md-flex">
						<div class="col-md-2">Material: <?= $row['material']; ?></div>
						<div class="col-md-3">Color: <?= $row['color']; ?></div>
						<div class="col-md-2">SqFt: <?= $row['SqFt']; ?></div>
						<div class="col-md-2">Selected: <?= $row['selected']; ?></div>
						<div class="col-md-3">Lot: <?= $row['lot']; ?></div>
					</div>
					<hr>
					<div class="container d-flex">
					<?
						if($row['material_status'] == 1) {
					?>
						<div class="col-7 text-danger"><b>Status: To be assigned/ordered.</b></div>
						<div class="col-1 btn btn-sm btn-danger mr-2" onClick="noMaterial(<?= $row['id'] ?>)">N/A <i class="fas fa-ban"></i></div>
						<div class="col-2 btn btn-sm btn-success mr-2 orderMaterials" onClick="matOredered(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')" >Ordered <i class="far fa-calendar-check"></i></div>
						<div class="col-2 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials <i class="fas fa-check"></i></div>
					<?
						} else if($row['material_status'] == 2) {
					?>
						<div class="col-6 text-success"><b>Status: Materials ordered. Est. delivery <?= date('Y-m-d', strtotime($row['material_date'])) ?></b></div>
						<div class="col-3">Reference: <?= $row['assigned_material'] ?></div>
						<div class="col-3 btn btn-sm btn-primary haveMaterials" onClick="matOnHand(<?= $row['id'] ?>,'<?= $row['install_name']; ?>')">Have Materials</div>
					<?
						} else if($row['material_status'] == 3) {
					?>
						<div class="col-6 text-primary"><b>Status: Materials On Hand</b></div>
						<div class="col-6">Assigned Material: <?= $row['assigned_material'] ?></div>
					<?
						} else if($row['material_status'] == 4) {
					?>
						<div class="col-6 text-muted"><b>Status: Materials not needed.</b></div>
					<?
						}
					?>
					</div>
				</div>
				<hr>
			<?
			}
			?>
				<hr>
			<?
		}
	}
	echo '</div>';

	echo '<div id="mSaw" class="tab-pane fade" role="tabpanel" aria-labelledby="mSaw-tab">';
	foreach($search->get_materials_needed() as $results) {
		if ($results['job_status'] == 44) {
			?>
			<div class="w-100 d-flex">
				<div  class="col-9 col-md-5 text-primary"><h3><?= $results['job_name']; ?></h3></div>
				<div class="col-3 hidden-md-down">
					<h3><?= $results['quote_num']; ?></h3>
				</div>
				<div class="col-3 hidden-md-down">
					<h3><?= $results['order_num']; ?></h3>
				</div>
				<div class="col-3 col-md-1 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="$('#instDetails').html('');viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
			</div>
			<hr>
			<?
		}
	}
	echo "</div>";
	echo '</div>';
	echo '</div>';
	echo '<hr style="height:5px;margin-top:15px;background:magenta;">';
}





// ADD COMMENT.
if ($action=="loss_approval") {
	unset($_POST['action']);
	$loss_approval = new project_action;
	echo $loss_approval -> loss_approval($_POST);
}




// GET JOB STATUS
if ($action=="get_job_status") {
	unset($_POST['action']);
	$get_job_status = new project_action;
	$return = '';
	foreach($get_job_status -> get_job_status($_POST) as $r) {
		$return .=  $r['sid'] . '|' . $r['sname'];
	}
	echo $return;
}




if ($action=="update_job_status") {
	unset($_POST['action']);
	$update_job_status = new project_action;
	echo $update_job_status -> update_job_status($_POST);
//	if ($_POST['job_status'] == 19 || $_POST['job_status'] == 39 || $_POST['job_status'] == 49 || $_POST['job_status'] == 59 || $_POST['job_status'] == 69 || $_POST['job_status'] == 79 || $_POST['job_status'] == 89 ) {
//		$hold_job_status = new project_action;
//		foreach( $hold_job_status -> get_hold_user($_POST['pid']) as $results ) {
//			$EmailTo = $user;
//			$Subject = 'Job Placed on Hold - ' . $jobName;
//			// prepare email body text
//			$Body = "<h2>" . $quoNum . " - " . $ordNum . "</h2>";
//			$Body .= '<a href="/admin/projects.php?edit&pid=' . $pid . '&uid=' . $uid . '"><button>View Project</button></a>';
//			$Body .= "<br><br><p>Alert Version 1.2</p>";
//			$headers = "From: Amanzi Portal <portal@amanziportal.com>\r\n";
//			//$headers .= "Reply-To: " . $fname . " " . $lname . " <" . $EmailFrom . ">\r\n";
//			$headers .= "BCC: leegellie@gmail.com\r\n";
//			$headers .= "MIME-Version: 1.0\r\n";
//			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//			$headers .= "X-Priority: 1 (Highest)\r\n";
//			$headers .= "X-MSMail-Priority: High\r\n";
//			$headers .= "Importance: High\r\n";
//			// send email
//			mail($EmailTo, $Subject, $Body, $headers);
//		}
//	}
}

if ($action=="get_status_list") {
	unset($_POST['action']);
	$get_status_list = new project_action;
	$return = '0|Select...';
	foreach($get_status_list -> get_status_list($_POST) as $r) {
		$return .=  ':' . $r['id'] . '|' . $r['name'];
	}
	echo $return;
}

if ($action=="get_material") {
	unset($_POST['action']);
	$return = '';
	if ($_POST['material']=='marbgran') {
		$getMarble = new project_action;
		$marbReturn = '';
		foreach($getMarble->get_marble($_POST) as $r) {
			$count = 0;
			$price = 0;
			if ($r['price_0'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_0'];
			}
			if ($r['price_1'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_1'];
			}
			if ($r['price_2'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_2'];
			}
			if ($r['price_3'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_3'];
			}
			if ($r['price_4'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_4'];
			}
			if ($r['price_5'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_5'];
			}
			if ($r['price_6'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_6'];
			}
			if ($r['price_7'] > 0) {
				$count = $count + 1;
				$price = $price + $r['price_7'];
			}
			$cost =  ceil($price / $count);
			$price = $cost * $marbgran_rate;
			if ($price < 48.01) {
				$price = 48;
				$level = 1;
			} elseif ($price < 60.01) {
				$price = 60;
				$level = 2;
			} elseif ($price < 78.01) {
				$price = 78;
				$level = 3;
			} elseif ($price < 102.01) {
				$price = 102;
				$level = 4;
			} elseif ($price < 132.01) {
				$price = 132;
				$level = 5;
			} elseif ($price < 168.01) {
				$price = 168;
				$level = 6;
			} elseif ($price < 216.01) {
				$price = 216;
				$level = 7;
			} elseif ($price < 252.01) {
				$price = 252;
				$level = 8;
			}  else {
				$level = 9;
			}
			$marbReturn .= $r['id'];
			$marbReturn .= '|';
			$marbReturn .= $r['name'];
			$marbReturn .= '|';
			$marbReturn .= $r['image'];
			$marbReturn .= '|';
			$marbReturn .= $price;
			$marbReturn .= '|';
			$marbReturn .= $level;
			$marbReturn .= '|';
			$marbReturn .= $cost;
			$marbReturn .= ':';
		}
		$marbReturn = rtrim($marbReturn, ':');
		echo $marbReturn;
	} elseif ($_POST['material']=='quartz') {
		$getQuartz = new project_action;
		$quartzReturn = '';
		foreach($getQuartz->get_quartz($_POST) as $r) {
			$price = 0;
//			if ($r['price_3'] == 'NA') {
//				$price = $r['price_2'];
//			} elseif ($r['price_3'] > 1) {
//				$price = $r['price_3'];
//			} else {
//				$price = $r['cat_price'];
//			}
			$cost = $price;
			$price = $price * $marbgran_rate;
			if ($price <= 48.01) {
				$price = 48;
				$level = 1;
			} elseif ($price < 60.01) {
				$price = 60;
				$level = 2;
			} elseif ($price < 78.01) {
				$price = 78;
				$level = 3;
			} elseif ($price < 102.01) {
				$price = 102;
				$level = 4;
			} elseif ($price < 132.01) {
				$price = 132;
				$level = 5;
			} elseif ($price < 168.01) {
				$price = 168;
				$level = 6;
			} elseif ($price < 216.01) {
				$price = 216;
				$level = 7;
			} elseif ($price < 252.01) {
				$price = 252;
				$level = 8;
			}  else {
				$level = 9;
			}
			$cost = $r['slab_cost'];
			$quartzReturn .= $r['id'];
			$quartzReturn .= '|';
			$quartzReturn .= $r['name'];
			$quartzReturn .= '|';
			$quartzReturn .= $r['image'];
			$quartzReturn .= '|';
			$quartzReturn .= $price;
			$quartzReturn .= '|';
			$quartzReturn .= $level;
			$quartzReturn .= '|';
			$quartzReturn .= $cost;
			$quartzReturn .= ':';
		}
		$quartzReturn = rtrim($quartzReturn, ':');
		echo $quartzReturn;

	}
}

if ($action=="get_price_levels") {
	unset($_POST['action']);
	$getMult = new project_action;
	$return = '';
	foreach($getMult->get_price_levels($_POST) as $results) {
		$return .= $results['id'] . ' | ' . $results['max_price'] . ':';
	}
	echo $return;
}


if ($action=="get_price_multiplier") {
	unset($_POST['action']);
	$getMult = new project_action;
	foreach($getMult->get_price_multiplier($_POST) as $results) {
		print $results['multiplier'] * $results['extra'];
	}
}

if ($action=="entered_anya") {
	$pid = $_POST['pid'];

	unset($_POST['action']);
	$set_entry = new project_action;
	echo $set_entry -> set_entry($pid,2);

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Project entered in E2.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

}

if ($action=="entry_reject") {
	$pid = $_POST['pid'];

	unset($_POST['action']);
	$reject_entry = new project_action;
	echo $reject_entry -> set_entry($pid,3);

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Rejected by Entry.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

}
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE
	/////////// LEE

if ($action=="templates_list") {

	function getWeekday($date) {
    $dayOfWeek = date('w', strtotime($date));
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
		echo $days[$dayOfWeek];
	}

	$results = "";
	unset($_POST['action']);
	$today = date('Y-m-d');
	if (date('w', strtotime($today)) != 0 && date('w', strtotime($today)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $today ?> : <? getWeekday($today) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $today){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$datetime = new DateTime('tomorrow');
	$tomorrow = $datetime->format('Y-m-d');
	if (date('w', strtotime($tomorrow)) != 0 && date('w', strtotime($tomorrow)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $tomorrow ?> : <? getWeekday($tomorrow) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $tomorrow){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus2 = date('Y-m-d', strtotime("+2 days"));
	if (date('w', strtotime($plus2)) != 0 && date('w', strtotime($plus2)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus2 ?> : <? getWeekday($plus2) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus2){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus3 = date('Y-m-d', strtotime("+3 days"));
	if (date('w', strtotime($plus3)) != 0 && date('w', strtotime($plus3)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus3 ?> : <? getWeekday($plus3) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus3){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus4 = date('Y-m-d', strtotime("+4 days"));
	if (date('w', strtotime($plus4)) != 0 && date('w', strtotime($plus4)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus4 ?> : <? getWeekday($plus4) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus4){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus5 = date('Y-m-d', strtotime("+5 days"));
	if (date('w', strtotime($plus5)) != 0 && date('w', strtotime($plus5)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus5 ?> : <? getWeekday($plus5) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus5){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus6 = date('Y-m-d', strtotime("+6 days"));
	if (date('w', strtotime($plus6)) != 0 && date('w', strtotime($plus6)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus6 ?> : <? getWeekday($plus6) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus6){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
	$plus7 = date('Y-m-d', strtotime("+7 days"));
	if (date('w', strtotime($plus7)) != 0 && date('w', strtotime($plus7)) != 6 ) {
		?>
		<div class="row">
			<h3><?= $plus7 ?> : <? getWeekday($plus7) ?></h3>
		</div>
		<?
		$get_entries = new project_action;
		foreach($get_entries->get_templates($_SESSION['id']) as $results) {
			if ($results['template_date'] == $plus7){
				?>
				<div class="row">
					<div class="col-9 col-md-1 <? if ( $results['template_team'] == 0 ) { echo 'text-muted'; } else { echo 'text-primary'; }; ?>"><?= $results['team']; ?></div>
					<div class="col-9 col-md-1 text-danger"><? if ($results['temp_first_stop'] == 1) { echo '1st Stop'; } elseif ($results['temp_am'] == 1) { echo 'AM'; } elseif ($results['temp_pm'] == 1) { echo 'PM'; } ?></div>
					<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
					<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
					<div class="col-9 col-md-4 text-primary">
					<?
						$address = '';
						$address .= $results['address_1'];
						if ($results['address_2'] > '') {
							$address .= ', ' . $results['address_2'];
						}
						$address .= ', ' . $results['city'];
						$address .= ', ' . $results['state'];
						$address .= ', ' . $results['zip'];
						echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
					?></div>
					<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
				</div>
				<hr>
				<?
			}
		}
	}
}


if ($action=="installs_list") {

	function getWeekday($date) {
    	$dayOfWeek = date('w', strtotime($date));
		$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday','Thursday','Friday', 'Saturday');
		echo $days[$dayOfWeek];
	}
	$results = "";
	unset($_POST['action']);

	$today = date('Y-m-d');
	if (date('w', strtotime($today)) != 0 && date('w', strtotime($today)) != 6 ) {
	?>
		<div class="row">
			<h3><?= $today ?> : <? getWeekday($today) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $today){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$datetime = new DateTime('tomorrow');
	$tomorrow = $datetime->format('Y-m-d');

	if (date('w', strtotime($tomorrow)) != 0 && date('w', strtotime($tomorrow)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $tomorrow ?> : <? getWeekday($tomorrow) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $tomorrow){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus2 = date('Y-m-d', strtotime("+2 days"));
	if (date('w', strtotime($plus2)) != 0 && date('w', strtotime($plus2)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus2 ?> : <? getWeekday($plus2) ?></h3>
		</div>
	<?		
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus2){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus3 = date('Y-m-d', strtotime("+3 days"));
	if (date('w', strtotime($plus3)) != 0 && date('w', strtotime($plus3)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus3 ?> : <? getWeekday($plus3) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus3){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus4 = date('Y-m-d', strtotime("+4 days"));
	if (date('w', strtotime($plus4)) != 0 && date('w', strtotime($plus4)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus4 ?> : <? getWeekday($plus4) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus4){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus5 = date('Y-m-d', strtotime("+5 days"));
	if (date('w', strtotime($plus5)) != 0 && date('w', strtotime($plus5)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus5 ?> : <? getWeekday($plus5) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus5){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus6 = date('Y-m-d', strtotime("+6 days"));
	if (date('w', strtotime($plus6)) != 0 && date('w', strtotime($plus6)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus6 ?> : <? getWeekday($plus6) ?></h3>
		</div>
	<?
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus6){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}

	$plus7 = date('Y-m-d', strtotime("+7 days"));
	if (date('w', strtotime($plus7)) != 0 && date('w', strtotime($plus7)) != 6 ) {

	?>
		<div class="row">
			<h3><?= $plus7 ?> : <? getWeekday($plus7) ?></h3>
		</div>
	<?		
		$get_entries = new project_action;
		foreach($get_entries->get_installs($_SESSION['id']) as $results) {
			if ($results['install_date'] == $plus7){
			?>
			<div class="row">
				<?
				if ($results['install_team'] == 0) {
					?>
					<div class="col-9 col-md-1 text-muted">Unassigned</div>
					<?
				} else {
					?>
					<div class="col-9 col-md-1 text-primary"><?= $results['team']; ?></div>
					<?
				}
				?>
				<div class="col-9 col-md-1 text-danger"><? if ($results['first_stop'] == 1) { echo '1st Stop'; } elseif ($results['am'] == 1) { echo 'AM'; } elseif ($results['pm'] == 1) { echo 'PM'; } ?></div>
				<div class="col-9 col-md-3 text-primary"><?= $results['job_name']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['quote_num']; ?></div>
				<div class="col-9 col-md-1 text-primary"><?= $results['order_num']; ?></div>
				<div class="col-9 col-md-4 text-primary">
				<?
					$address = '';
					$address .= $results['address_1'];
					if ($results['address_2'] > '') {
						$address .= ', ' . $results['address_2'];
					}
					$address .= ', ' . $results['city'];
					$address .= ', ' . $results['state'];
					$address .= ', ' . $results['zip'];
					echo '<a class="text-success" target="_blank" href="https://maps.google.com/?q=' . $address . '">' . $address . '</a>';
				?></div>
				<div  class="col-1"><div id="<?= $results['id']; ?>" class="btn btn-primary w-100" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);"><i class="fas fa-eye"></i></div></div>
			</div>
			<hr>
		
			<?
			}
		}
	}


}


if ($action=="timelines_list") {
	$results = "";
	unset($_POST['action']);
	$get_entries = new project_action;
	$template_pro = $get_entries->get_templates_timeline($_SESSION['id']);

	$temp_list = array();
	foreach($template_pro as $pro){
		switch($pro['short_name']) {
// TEMPLATES
			case 'estapproved':     //Status = 12:Blue Button
				$temp_app['button'] = 'bg-info estapproved';
				$temp_app['details'] = $pro['detail'];
				$temp_list[0] = $temp_app;
				break;
			case 'tempsched':       //Status = 13:Orange Button 
				$temp_sched['button'] = 'bg-warning tempsched';    
				$temp_sched['details'] = $pro['detail'];
				$temp_list[1] = $temp_sched;
				break;
			case 'tempinroute':     //Status = 14:Purple Button
				$temp_route['button'] = 'bg-secondary tempinroute';  
				$temp_route['details'] = $pro['detail'];
				$temp_list[4] = $temp_route;
				break;
			case 'tempstart':       //Status = 15:Green Button
				$temp_start['button'] = 'bg-success tempstart';
				$temp_start['details'] = $pro['detail'];
				$temp_list[3] = $temp_start;
				break;
			case 'tempincomp':      //Status = 16:Red Button
				$temp_incomp['button'] = 'bg-danger tempincomp';
				$temp_incomp['details'] = $pro['detail'];
				$temp_list[5] = $temp_incomp;
				break;
//			case 'tempcomp':        //Status = 17:Orange Button
//				$temp_comp['button'] = 'bg-warning'; 
//				$temp_comp = $pro['detail'];
//				$temp_list[6] = $temp_comp;
//				break;
			case 'temphold':        //Status = 19: Red Button
				$temp_hold['button'] = 'bg-danger temphold';
				$temp_hold['details'] = $pro['detail'];
				$temp_list[2] = $temp_hold;
				break;
// SALES
			case 'quoteprep':       //Status = 21
				$sale_prep['button'] = 'bg-primary quoteprep';
				$sale_prep['details'] = $pro['detail'];
				$sale_list[1] = $sale_prep;
				break;
			case 'quotecheck':      //Status = 22
				$sale_check['button'] = 'bg-warning quotecheck';
				$sale_check['details'] = $pro['detail'];
				$sale_list[2] = $sale_check;
				break;
			case 'quoted':          //Status = 23
				$sale_quo['button'] = 'bg-success quoted';
				$sale_quo['details'] = $pro['detail'];
				$sale_list[3] = $sale_quo;
				break;
			case 'quotealter':      //Status = 24
				$sale_alter['button'] = 'bg-info quotealter';
				$sale_alter['details'] = $pro['detail'];
				$sale_list[4] = $sale_alter;
				break;
			case 'quotereject':     //Status = 26
				$sale_reject['button'] = 'bg-danger quotereject';
				$sale_reject['details'] = $pro['detail'];
				$sale_list[0] = $sale_reject;
				break;
// fabrication

			case 'quoteaccept':     //Status = 25: Yellow Button
				$fabrication['button'] = 'bg-primary quoteaccept prog'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[0] = $fabrication;
				break;
			case 'progsched':       //Status = 30:Blue Button
				$fabrication['button'] = 'bg-primary progsched prog'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[1] = $fabrication;
				break;
			case 'progstart':       //Status = 31
				$fabrication['button'] = 'bg-primary progstart prog'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[2] = $fabrication;
				break;
			case 'progcomp':        //Status = 32
				$fabrication['button'] = 'bg-primary progcomp matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[4] = $fabrication;
				break;
			case 'proghold':        //Status = 39
				$fabrication['button'] = 'bg-danger proghold prog'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[3] = $fabrication;
				break;
			case 'matsched':        //Status = 40
				$fabrication['button'] = 'bg-success matsched matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[5] = $fabrication;
				break;
			case 'matordered':        //Status = 41
				$fabrication['button'] = 'bg-success matordered matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[6] = $fabrication;
				break;
			case 'matsonhand':        //Status = 42
				$fabrication['button'] = 'bg-success matsonhand matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[7] = $fabrication;
				break;
			case 'matsready':        //Status = 43
				$fabrication['button'] = 'bg-success matsready matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[8] = $fabrication;
				break;
			case 'matdeliv':        //Status = 44
				$fabrication['button'] = 'bg-warning matdeliv saw'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[10] = $fabrication;
				break;
			case 'mathold':        //Status = 49
				$fabrication['button'] = 'bg-danger mathold matr'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[9] = $fabrication;
				break;
			case 'sawsched':        //Status = 50
				$fabrication['button'] = 'bg-warning sawsched saw'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[11] = $fabrication;
				break;
			case 'sawstart':        //Status = 51
				$fabrication['button'] = 'bg-warning sawstart saw'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[12] = $fabrication;
				break;
			case 'sawcomp':        //Status = 52
				$fabrication['button'] = 'bg-warning sawcomp saw'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[13] = $fabrication;
				break;
			case 'sawdeliv':        //Status = 53
				$fabrication['button'] = 'bg-warning sawdeliv cnc'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[15] = $fabrication;
				break;
			case 'sawhold':        //Status = 59
				$fabrication['button'] = 'bg-danger sawhold saw'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[14] = $fabrication;
				break;
			case 'cncsched':        //Status = 60
				$fabrication['button'] = 'bg-secondary cncsched cnc'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[16] = $fabrication;
				break;
			case 'cncstart':        //Status = 61
				$fabrication['button'] = 'bg-secondary cncstart cnc'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[17] = $fabrication;
				break;
			case 'cnccomp':        //Status = 62
				$fabrication['button'] = 'bg-secondary cnccomp cnc'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[18] = $fabrication;
				break;
			case 'cncdeliv':        //Status = 63
				$fabrication['button'] = 'bg-info cncdeliv polish'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[20] = $fabrication;
				break;
			case 'cnchold':        //Status = 69
				$fabrication['button'] = 'bg-danger cnchold cnc'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[19] = $fabrication;
				break;
			case 'polishsched':        //Status = 70
				$fabrication['button'] = 'bg-info polishsched polish'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[21] = $fabrication;
				break;
			case 'polishstart':        //Status = 71
				$fabrication['button'] = 'bg-info polishstart polish'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[22] = $fabrication;
				break;
			case 'polishcomp':        //Status = 72
				$fabrication['button'] = 'bg-info polishcomp polish'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[23] = $fabrication;
				break;
			case 'polishhold':        //Status = 79
				$fabrication['button'] = 'bg-danger polishhold polish'; 
				$fabrication['details'] = $pro['detail'];
				$fabrication_list[24] = $fabrication;
				break;
// INSTALLS
			case 'polishdeliv':        //Status = 73
				$install['button'] = 'bg-light polishdeliv'; 
				$install['details'] = $pro['detail'];
				$install_list[0] = $install;
				break;
			case 'instsched':        //Status = 80: Blue Button
				$install['button'] = 'bg-primary instsched'; 
				$install['details'] = $pro['detail'];
				$install_list[1] = $install;
				break;
			case 'insttruck':        //Status = 81
				$install['button'] = 'bg-success insttruck'; 
				$install['details'] = $pro['detail'];
				$install_list[2] = $install;
				break;
			case 'instinroute':        //Status = 82
				$install['button'] = 'bg-success instinroute'; 
				$install['details'] = $pro['detail'];
				$install_list[3] = $install;
				break;
			case 'inststart':        //Status = 83
				$install['button'] = 'bg-warning inststart'; 
				$install['details'] = $pro['detail'];
				$install_list[4] = $install;
				break;
			case 'instincomp':        //Status = 84
				$install['button'] = 'bg-danger instincomp'; 
				$install['details'] = $pro['detail'];
				$install_list[6] = $install;
				break;
			case 'instcomp':        //Status = 85
				$install['button'] = 'bg-alert instcomp'; 
				$install['details'] = $pro['detail'];
				$install_list[5] = $install;
				break;
			case 'instapproved':        //Status = 86
				$proghold = $pro['detail'];
				break;
			case 'insthold':        //Status = 89: Red Button
				$install['button'] = 'bg-danger insthold'; 
				$install['details'] = $pro['detail'];
				$install_list[7] = $install;
				break;

		}
	}
	echo 		'<ul class="nav nav-tabs nav-justified mdb-color darken-3" role="tablist">';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_overview" role="tab">Overview</a></li>';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_templates" role="tab">Templates</a></li>';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_sales" role="tab">Sales</a></li>';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_materials" role="tab">Materials</a></li>';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_fab" role="tab">Fabrication</a></li>';
	echo 		'	<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel_installs" role="tab">Installs</a></li>';
	echo 		'</ul>';

	echo 		'<div class="tab-pane fade in show active" id="panel_overview" role="tabpanel">';

	echo 	'<div class="row">';
	echo    	'<div id="resultsTable1" class="col-sm-3 striped">';

	echo       	'<h3>Templating</h3>';

	$classInfo = "'btn-info'";
	$classPrimary = "'btn-primary'";
	$classDanger = "'btn-danger'";
	$classAlert = "'btn-alert'";
	$classSecondary = "'btn-secondary'";
	$classWarning = "'btn-warning'";
	$classSuccess = "'btn-success'";
	$classLight = "'btn-light'";
	echo 		'<div class="row d-flex justify-content-between">';
	$thisBtn = "'.estapproved'";
	echo 			'<div class="btn btn-info px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Estimate Approved" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classInfo.'); $(this).toggleClass('.$classLight.');"><i class="far fa-file-check"></i></div>';
	$thisBtn = "'.tempsched'";
	echo 			'<div class="btn btn-warning px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Template Scheduled" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classWarning.'); $(this).toggleClass('.$classLight.');"><i class="far fa-calendar-alt"></i></div>';
	$thisBtn = "'.tempinroute'";
	echo 			'<div class="btn btn-secondary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Templaters in Route" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSecondary.'); $(this).toggleClass('.$classLight.');"><i class="far fa-car"></i></div>';
	$thisBtn = "'.tempstart'";
	echo 			'<div class="btn btn-success px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Template Started" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSuccess.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-ruler"></i></div>';
	$thisBtn = "'.tempincomp'";
	echo 			'<div class="btn btn-danger px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Template Incomplete" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classDanger.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-exclamation-triangle"></i></div>';
	$thisBtn = "'.temphold'";
	echo 			'<div class="btn btn-danger px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Template on Hold" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classDanger.'); $(this).toggleClass('.$classLight.'); "><i class="fas fa-times-octagon"></i></div>';
	echo 		'</div><hr>';
			foreach($temp_list as $temp) {
				foreach($temp['details'] as $t) {
	echo        			'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$temp['button'].'" style="width:100%">';
					if ($t['order_num'] > 0) {
						echo 'O-'.$t['order_num'].' - ';
					} elseif ($t['quote_num'] > 0) {
						echo 'q-'.$t['quote_num'].' - ';
					}
	echo 					$t['job_name'].'</button>';
	echo        			'</div>';
				}
			}
	echo    	'</div>';
	echo    	'<div id="resultsTable2" class="col-sm-3 striped">';
	echo        	'<h3>In Sales</h3>';
	echo 		'<div class="row d-flex justify-content-between">';
	$thisBtn = "'.quoteprep'";
	echo 			'<div class="btn btn-primary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Preparing Quote" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classPrimary.'); $(this).toggleClass('.$classLight.');"><i class="far fa-pencil-alt"></i></div>';
	$thisBtn = "'.quotecheck'";
	echo 			'<div class="btn btn-warning px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Quote Check" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classWarning.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-check"></i></div>';
	$thisBtn = "'.quoted'";
	echo 			'<div class="btn btn-success px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Quoted" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSuccess.'); $(this).toggleClass('.$classLight.');"><i class="fab fa-telegram-plane"></i></div>';
	$thisBtn = "'.quotealter'";
	echo 			'<div class="btn btn-info px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Altering Quote" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classInfo.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-ruler-combined"></i></div>';
	$thisBtn = "'.quotereject'";
	echo 			'<div class="btn btn-danger px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Quote Rejected" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classDanger.'); $(this).toggleClass('.$classLight.');"><span class="fa-layers fa-fw"><i class="fas fa-dollar-sign" data-fa-transform="grow-2"></i><span class="fa-layers-text fa-inverse" data-fa-transform="shrink-5 rotate--30" style="font-weight:900">Reject</span></span></div>';
	echo 		'</div><hr>';
			foreach($sale_list as $sale) {
				foreach($sale['details'] as $s) {
	echo        			'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$sale['button'].'" style="width:100%">';
					if ($s['order_num'] > 0) {
						echo 'O-'.$s['order_num'].' - ';
					} elseif ($s['quote_num'] > 0) {
						echo 'q-'.$s['quote_num'].' - ';
					}
	echo 					$s['job_name'].'</button>';
	echo       				'</div>';
				}
			}
	echo 		'</div>';
	echo		'<div id="resultsTable3" class="col-sm-3 striped">';
	echo			'<h3>Fabrication</h3>';
	echo 		'<div class="row d-flex justify-content-between">';
	$thisBtn = "'.prog'";
	echo 			'<div class="btn btn-primary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Programming" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classPrimary.'); $(this).toggleClass('.$classLight.');"><i class="far fa-file-check"></i></div>';
	$thisBtn = "'.matr'";
	echo 			'<div class="btn btn-success px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Materials Staging" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSuccess.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-container-storage"></i></div>';
	$thisBtn = "'.saw'";
	echo 			'<div class="btn btn-warning px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Saw" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classWarning.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-sun"></i></div>';
	$thisBtn = "'.cnc'";
	echo 			'<div class="btn btn-secondary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="CNC" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSecondary.'); $(this).toggleClass('.$classLight.');"><span class="fa-layers fa-fw"><i class="fas fa-certificate"></i><span class="fa-layers-text fa-inverse" data-fa-transform="shrink-1 rotate--30" style="font-weight:900; color:black">CNC</span></span></div>';
	$thisBtn = "'.polish'";
	echo 			'<div class="btn btn-info px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Polishing" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classInfo.'); $(this).toggleClass('.$classLight.');"><i class="far fa-shield-alt"></i></div>';
	echo 		'</div><hr>';
	echo					'<div class="row">';
	echo						'<h4>Programming</h4>';
	echo					'</div>';
			foreach($fabrication_list as $fabrication) {
	//               if(isset($fabrication_list[$i])){
				foreach($fabrication['details'] as $f) {
					if ($f['stage'] == 3) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$fabrication['button'].'" style="width:100%">';
						if ($f['order_num'] > 0) {
							echo 'O-'.$f['order_num'].' - ';
						} elseif ($f['quote_num'] > 0) {
							echo 'q-'.$f['quote_num'].' - ';
						}
	echo 					$f['job_name'].'</button>';
	echo					'</div>';
					}
				}
			}
	echo					'<div class="row">';
	echo						'<h4>Materials</h4>';
	echo					'</div>';
			foreach($fabrication_list as $fabrication) {
	//               if(isset($fabrication_list[$i])){
				foreach($fabrication['details'] as $f) {
					if ($f['stage'] == 4) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$fabrication['button'].'" style="width:100%">';
						if ($f['order_num'] > 0) {
							echo 'O-'.$f['order_num'].' - ';
						} elseif ($f['quote_num'] > 0) {
							echo 'q-'.$f['quote_num'].' - ';
						}
	echo 					$f['job_name'].'</button>';
	echo					'</div>';
					}
				}
			}
	echo					'<div class="row">';
	echo						'<h4>Saw</h4>';
	echo					'</div>';
			foreach($fabrication_list as $fabrication) {
	//               if(isset($fabrication_list[$i])){
				foreach($fabrication['details'] as $f) {
					if ($f['stage'] == 5) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$fabrication['button'].'" style="width:100%">';
						if ($f['order_num'] > 0) {
							echo 'O-'.$f['order_num'].' - ';
						} elseif ($f['quote_num'] > 0) {
							echo 'q-'.$f['quote_num'].' - ';
						}
	echo 					$f['job_name'].'</button>';
	echo					'</div>';
					}
				}
			}
	echo					'<div class="row">';
	echo						'<h4>CNC</h4>';
	echo					'</div>';
			foreach($fabrication_list as $fabrication) {
	//               if(isset($fabrication_list[$i])){
				foreach($fabrication['details'] as $f) {
					if ($f['stage'] == 6) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$fabrication['button'].'" style="width:100%">';
						if ($f['order_num'] > 0) {
							echo 'O-'.$f['order_num'].' - ';
						} elseif ($f['quote_num'] > 0) {
							echo 'q-'.$f['quote_num'].' - ';
						}
	echo 					$f['job_name'].'</button>';
	echo					'</div>';
					}
				}
			}
	echo					'<div class="row">';
	echo						'<h4>Polishing</h4>';
	echo					'</div>';
			foreach($fabrication_list as $fabrication) {
	//               if(isset($fabrication_list[$i])){
				foreach($fabrication['details'] as $f) {
					if ($f['stage'] == 7) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$fabrication['button'].'" style="width:100%">';
						if ($f['order_num'] > 0) {
							echo 'O-'.$f['order_num'].' - ';
						} elseif ($f['quote_num'] > 0) {
							echo 'q-'.$f['quote_num'].' - ';
						}
	echo 					$f['job_name'].'</button>';
	echo					'</div>';
					}
				}
			} 
	echo		'</div>';
	echo		'<div id="resultsTable4" class="col-sm-3 striped">';
	echo			'<h3>Installs</h3>';
	echo 		'<div class="row d-flex justify-content-between">';
	$thisBtn = "'.polishdeliv'";
	echo 			'<div class="btn btn-primary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Ready to Install" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classPrimary.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-container-storage"></i></div>';
	$thisBtn = "'.instsched'";
	echo 			'<div class="btn btn-success px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install Scheduled" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSuccess.'); $(this).toggleClass('.$classLight.');"><i class="far fa-calendar-alt"></i></div>';
	$thisBtn = "'.insttruck'";
	echo 			'<div class="btn btn-success px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install In Truck" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSuccess.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-truck-container"></i></div>';
	$thisBtn = "'.instinroute'";
	echo 			'<div class="btn btn-warning px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install in Route" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classWarning.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-truck"></i></div>';
	$thisBtn = "'.inststart'";
	echo 			'<div class="btn btn-secondary px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install Started" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classSecondary.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-chess-clock-alt"></i></div>';
	$thisBtn = "'.instincomp'";
	echo 			'<div class="btn btn-danger px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install Incomplete" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classDanger.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-exclamation-triangle"></i></div>';
	$thisBtn = "'.insthold'";
	echo 			'<div class="btn btn-danger px-3" data-placement="top" data-trigger="hover" data-toggle="popover" data-content="Install On Hold" onClick="$('.$thisBtn.').toggle(); $(this).toggleClass('.$classDanger.'); $(this).toggleClass('.$classLight.');"><i class="fas fa-times-octagon"></i></div>';
	echo 		'</div><hr>';
			foreach($install_list as $install) {
				foreach($install['details'] as $in) {
	echo					'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$install['button'].'" style="width:100%">';
					if ($in['order_num'] > 0) {
						echo 'O-'.$in['order_num'].' - ';
					} elseif ($f['quote_num'] > 0) {
						echo 'q-'.$in['quote_num'].' - ';
					}
	echo 					$in['job_name'].'</button>';
	echo					'</div>';
				}
			}
	echo		'</div>';
	echo	'</div>';
	echo 	'</div>';

	echo	'<div class="tab-pane fade in " id="panel_templates" role="tabpanel">';
	echo 	'	<div class="col-12 col-md-3"><h3>Templates to Scedule</h3>';
			foreach($temp_list as $temp) {
				foreach($temp['details'] as $t) {
					if ( $t['job_status'] == 12 ) {
	echo        			'<div class="row">';
	echo          			'<button class="btn btn-sm text-left '.$temp['button'].'" style="width:100%">';
					if ($t['order_num'] > 0) {
						echo 'O-'.$t['order_num'].' - ';
					} elseif ($t['quote_num'] > 0) {
						echo 'q-'.$t['quote_num'].' - ';
					}
	echo 					$t['job_name'].'</button>';
	echo        			'</div>';
					}
				}
			}
	echo 	'	</div>';
	echo 	'</div>';

	echo	'<div class="tab-pane fade in " id="panel_sales" role="tabpanel">';
	echo 	'</div>';

	echo	'<div class="tab-pane fade in " id="panel_materials" role="tabpanel">';
	echo 	'</div>';

	echo	'<div class="tab-pane fade in " id="panel_fab" role="tabpanel">';
	echo 	'</div>';

	echo	'<div class="tab-pane fade in " id="panel_installs" role="tabpanel">';
	echo 	'</div>';

	echo 	'</div>';

}


if ($action=="entry_list") {

	$results = "";
	unset($_POST['action']);
	$get_entries = new project_action;

	echo '<div id="resultsTable1" class="row striped">';

	echo '<div class="col-9 col-md-5 thead">Install</div><div class="col-3 hidden-md-down thead"></div><div class="col-3 hidden-md-down thead"></div><div class="col-3 col-md-1 thead text-right">Edit</div>';

	foreach($get_entries->get_entries($_SESSION['id']) as $results) {
		$statusText = '';
		$statusBar = '';
		if ($results['job_status'] == 19 || $results['job_status'] == 39 || $results['job_status'] == 49 || $results['job_status'] == 59 || $results['job_status'] == 69 || $results['job_status'] == 79 || $results['job_status'] == 89 ) {
			$statusText = 'text-danger';
			$statusBar = 'progress-bar progress-bar-striped progress-bar-animated bg-danger';
		} else {
			$statusText = 'text-primary';
			$statusBar = 'progress-bar progress-bar-striped';
		}

		?>
        	<div  class="col-9 col-md-6 text-primary"><h3><?= $results['job_name']; ?></h3></div>
        	<div class="col-2 hidden-md-down">
				<h3><?= $results['quote_num']; ?></h3>
			</div>
        	<div class="col-2 hidden-md-down">
				<h3><?= $results['order_num']; ?></h3>
			</div>
	        <div class="col-3 col-md-2 text-right">
				<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);">
					<span class="hidden-md-down">View </span>
					<i class="fas fa-eye"></i>
				</div>
			</div>
			<div class="col-12">
				<div id="progressStatus" class="w-100">
					<div class="progress w-100">
						<div class="<?= $statusBar ?>" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:<?= $results['job_status']; ?>%">
						<?= $results['status'] ?>
						</div>
					</div>
				</div>
			</div>
			<hr>
		<?
	}

	echo '<div class="col-9 col-md-5 tfoot">Install</div><div class="col-3 hidden-md-down tfoot"></div><div class="col-3 hidden-md-down tfoot"></div><div class="col-3 col-md-1 tfoot text-right">Edit</div>';

	echo "</div>";
	echo "<hr>";


}



	////////////////////////////   EMAIL ANYA   ///////////////////////////////

if ($action=="email_anya") {

	$jobName = $_POST['jobName'];
	$quoNum =  $_POST['quoNum'];
	$ordNum =  $_POST['ordNum'];
	$pid =  $_POST['pid'];
	$uid = $_POST['uid'];


	$set_entry = new project_action;
	echo $set_entry -> set_entry($pid,1);

	//$EmailTo = "leegellie@gmail.com";
	$EmailTo = 'afarmer@amanzigranite.com';
	$Subject = 'Job Install Date Set / Job Changed - ' . $jobName;

	// prepare email body text
	$Body = "<h2>" . $quoNum . " - " . $ordNum . "</h2>";
	$Body .= '<a href="/admin/projects.php?edit&pid=' . $pid . '&uid=' . $uid . '"><button>View Project</button></a>';
	$Body .= "<br><br><p>Alert Version 1.2</p>";

	$headers = "From: Amanzi Portal <portal@amanziportal.com>\r\n";
	//$headers .= "Reply-To: " . $fname . " " . $lname . " <" . $EmailFrom . ">\r\n";
	$headers .= "BCC: lee@hallenmedia.net\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "X-Priority: 1 (Highest)\r\n";
	$headers .= "X-MSMail-Priority: High\r\n";
	$headers .= "Importance: High\r\n";

	// send email
	mail($EmailTo, $Subject, $Body, $headers);

	$_POST = array();
	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Sent to Entry';
	$_POST['cmt_priority'] = 'log';

	$log = new log_action;
	$log -> pjt_changes($_POST);

}
	//////////////////////////   END EMAIL ANYA   //////////////////////////////



// VERIFIY THE USERNAME TO ADD DOESN'T EXIST YET
if ($action=="add_user_verify_username") {
	if( $username = trim(htmlspecialchars(strtolower($_POST['username']))) )
	{
		$verify_username = new user_action;
		echo $verify_username->set_username_check("$username");
	} else {
		echo "X";
	}
}


if ($action=="recalculate") {
	unset($_POST['action']);
	$recalculate = new project_action;
	echo $recalculate -> recalculate($_POST);
}


// VERIFIY THE EMAIL TO ADD DOESN'T EXIST YET
if ($action=="add_user_verify_email") {
	if( $email = trim(htmlspecialchars(strtolower($_POST['email']))) ) {
		$verify_email = new user_action;
		echo $verify_email->set_email_check("$email");
	} else {
		echo "X";
	}
}

// GET USER NAME FOR COMMENTS

if ($action=="comments_user_name") {
	unset($_POST['action']);
	$getUserName = new comment_action;
	echo $getUserName -> get_user_name($_POST);
}

// ADD COMMENT.
if ($action=="submit_comment") {
	unset($_POST['action']);
	$_POST['cmt_user'] = $_SESSION['id'];

	$add_comment = new comment_action;
	echo $add_comment -> add_comment($_POST);
}

// GET COMMENTS

if ($action == "get_comments") {
	$cmt_ref_id = $_POST['cmt_ref_id'];
	$cmt_type = $_POST['cmt_type'];
	unset($_POST['cmt_ref_id']); 
	unset($_POST['cmt_type']); 
	unset($_POST['action']);
	$cList = '';
	$comments = new comment_action;
	foreach($comments->get_comments($cmt_ref_id,$cmt_type) as $results) {
		$dt = $results['timestamp'];
		list($dDate, $dTime) = explode(' ',$dt);
		list($dYear, $dMonth, $dDay) = explode('-',$dDate);
		$stampy = $dMonth . '/' . $dDay . '/' . $dYear . ' - ' . $dTime;
		$cList .= '<div class="col-12 ';
		if ($results['cmt_priority'] == "911") {
			$cList .= 'text-danger';
		}	
		$cList .= '">' . $stampy . ' - <span id="cmtUser">' . $results['fname'][0] . '. ' . $results['lname']  . '</span> - ' . $results['cmt_comment'] . '</div><hr>';
	}
	echo $cList;
}


// ADD NEW USER DATA. GET NEW USER ID. RETURN EITHER THE ID OR ERROR MESSAGE.
if ($action=="add_user_data") {
	$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$_POST['username'] = strtolower($_POST['username']);
	$_POST['email'] = strtolower($_POST['email']);
	$_POST['acct_rep'] = $_SESSION['id'];
	if (!isset($_POST['discount'])) {
		$_POST['discount'] = 0;
	}
	unset($_POST['v_password']);
	unset($_POST['action']);
	//print_r($_POST);
	$add_user = new user_action;
	echo $add_user -> add_internal_user($_POST);
}

// USING USER ID, ADD USER BILLING INFO
if ($action=="add_user_billing") {
	unset($_POST['action']);
	unset($_POST['sameAdd']);
	$add_billing = new user_action;
	echo $add_billing -> add_internal_billing($_POST);
	//print_r($_POST);
}

if ($action=="get_new_user_name") {
	unset($_POST['action']);
	$getUserName = new user_action;
	$results = $getUserName -> get_new_user_name($_POST);
	echo $results[0] . ' ' . $results[1] . ' - ' . $results[2];
}

// SEARCH USERS. RETURN ARRAY
if ($action=="user_search_list") {
	$results = "";
	if (empty($_POST['isActive'])) {
		$_POST['isActive'] = '0';
	}
	if ($_POST['isActive'] != '1') {
		$_POST['isActive'] = '0';
	}
	if ($_POST['search'] == '') {
		$_POST['user_find'] = 'id';
	}
	if (empty($_POST['mine'])) {
		$_POST['mine'] = 0;
	} else {
		$_POST['mine'] = $_SESSION['id'];
	}

	$_POST['user_find'] = trim(htmlspecialchars($_POST['user_find']));
	$_POST['search'] = "%" . $_POST['search'] . "%";
	if ($_POST['user_find'] == "username") {
		$_POST['search'] = strtolower($_POST['search']);
	}
	unset($_POST['action']);
	$search = new user_action;

	echo '<div class="container">';
	echo '<hr>';
	if ($_POST['userAccess'] != 1) {
		foreach($search->user_data_search($_POST) as $results) {
			if ($results['access_level'] > 10) {
				?>
				<div class="row">
					<div class="col-12 col-md-5 text-primary"><h5><?= $results['company']; ?></h5></div>
					<div class="col-3 hidden-md-down"><?= $results['email']; ?></div>
					<div class="col-6 col-md-2 text-primary"><?= $results['fname']; ?> <?= $results['lname']; ?></div>
					<div class="col-3 col-md-1 text-right">
						<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="editThisUser(this.id);">Edit <i class="icon-wrench"></i></div>
					</div>
					<div class="col-3 col-md-1 text-right">
						<div id="" class="btn btn-sm btn-success" uid="<?= $results['id'] ?>" uNameC="<?= $results['company'] ?>" uNameF="<?= $results['fname'] ?>" uNameL="<?= $results['lname'] ?>" onClick="custAddPjt(this);">New Pjt <i class="fas fa-tasks"></i></div>
					</div>
				</div>
				<hr>
				<?
			}
		}
	} else {
		foreach($search->user_data_search($_POST) as $results) {
			if ($results['access_level'] > 0) {
				?>
				<div class="row">
					<div class="col-12 col-md-5 text-primary"><h5><?= $results['company']; ?></h5></div>
					<div class="col-3 hidden-md-down"><?= $results['email']; ?></div>
					<div class="col-6 col-md-2 text-primary"><?= $results['fname']; ?> <?= $results['lname']; ?></div>
					<div class="col-3 col-md-1 text-right">
						<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="editThisUser(this.id);">Edit <i class="icon-wrench"></i></div>
					</div>
					<div class="col-3 col-md-1 text-right">
						<div id="" class="btn btn-sm btn-success" uid="<?= $results['id'] ?>" uNameC="<?= $results['company'] ?>" uNameF="<?= $results['fname'] ?>" uNameL="<?= $results['lname'] ?>" onClick="custAddPjt(this);">New Pjt <i class="fas fa-tasks"></i></div>
					</div>
				</div>
				<hr>
				<?
			}
		}
	}
	echo "</div>";

}

// GET USER DATA AND/OR BILLING DATA
if ($action=="get_all_user_data") {
	unset($_POST['action']);
	//print_r($_POST);
	$user_data = new userData;


	if ($_POST['get_data']=="1") {
		$user_data -> set_selection($_POST['selection'],$_POST['uid']);
		$list =  'access_level' . "::" . $user_data -> get_results('access_level') . ',';
		$list .=  'username' . "::" . $user_data -> get_results('username') . ',';
		$list .=  'email' . "::" . $user_data -> get_results('email') . ',';
		$list .=  'fname' . "::" . $user_data -> get_results('fname') . ',';
		$list .=  'lname' . "::" . $user_data -> get_results('lname') . ',';

		$list .=  'company' . "::" . $user_data -> get_results('company') . ',';
		$list .=  'phone' . "::" . $user_data -> get_results('phone') . ',';
		$list .=  'address1' . "::" . $user_data -> get_results('address1') . ',';
		$list .=  'address2' . "::" . $user_data -> get_results('address2') . ',';
		$list .=  'city' . "::" . $user_data -> get_results('city') . ',';
		$list .=  'state' . "::" . $user_data -> get_results('state') . ',';
		$list .=  'zip' . "::" . $user_data -> get_results('zip') . ',';
		$list .=  'isActive' . "::" . $user_data -> get_results('isActive') . ',';
		$list .=  'parent_id' . "::" . $user_data -> get_results('parent_id') . ',';
		$list .=  'acct_rep' . "::" . $user_data -> get_results('acct_rep') . ',';
		$list .=  'discount' . "::" . $user_data -> get_results('discount') . ',';
		$list .=  'discount_quartz' . "::" . $user_data -> get_results('discount_quartz') . ',';
	}


	//$user_billing = new userData;
	if ($_POST['get_billing']=="1") {
		$user_data -> set_billing_selection($_POST['selection'],$_POST['uid']);
		echo $user_data -> get_results('billing_name') . ',';
		$list .=  'billing_company' . "::" . $user_data -> get_results('billing_company') . ',';
		$list .=  'billing_address1' . "::" . $user_data -> get_results('billing_address1') . ',';
		$list .=  'billing_address2' . "::" . $user_data -> get_results('billing_address2') . ',';
		$list .=  'billing_city' . "::" . $user_data -> get_results('billing_city') . ',';
		$list .=  'billing_state' . "::" . $user_data -> get_results('billing_state') . ',';
		$list .=  'billing_zip' . "::" . $user_data -> get_results('billing_zip') . ',';
		$list .=  'billing_country' . "::" . $user_data -> get_results('billing_country');
	}
	echo $list;

}

// UPDATE USER DATA
if ($action ==  "update_user_data") {
	unset($_POST['action']);
	if (isset($_POST['password'])) {
		if (($_POST['password']=="") || ($_POST['password'] != $_POST['v_password'])) {
			unset($_POST['password']);
		} else {
			$_POST['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT );
		}
		unset($_POST['v_password']);
	}
	
	if (!isset($_POST['isActive'])) {
		$_POST['isActive'] = '0';
	}
	$id  =$_POST['id'];
	unset($_POST['id']);
	
	$update_user = new userData;
	$update_user -> update_user_data($_POST,$id);
	echo '1';
}

if ($action ==  "set_password") {
	unset($_POST['action']);
	if (isset($_POST['pw1'])) {
		if (($_POST['pw1']=="") || ($_POST['pw1'] != $_POST['pw2'])) {
			unset($_POST['pw1']);
		} else {
			$_POST['pw1'] = password_hash($_POST['pw1'],PASSWORD_DEFAULT );
		}
		unset($_POST['pw2']);
	}
	$_POST['password'] = $_POST['pw1'];
	unset($_POST['pw1']);
	$id = $_POST['pw-uid'];
	unset($_POST['pw-uid']);

	$update_user = new userData;
	$update_user -> update_pw_data($_POST,$id);
	echo '1';
}


//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
///////////////////////////                        ///////////////////////////
///////////////////////////    PROJECT ACTIONS     ///////////////////////////
///////////////////////////                        ///////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////

if ($action=="add_sink") {
	unset($_POST['action']);
	$iid = $_POST['sink_iid'];
	$add_sink = new project_action;
	$add_sink->add_sink($_POST);
}

if ($action=="update_sink") {
	$id = $_POST['sink_id'];
	unset($_POST['action']);
	unset($_POST['sink_id']);
	$update_sink = new project_action;
	$update_sink->update_sink($_POST,$id);
}

if ($action=="add_faucet") {
	unset($_POST['action']);
	$iid = $_POST['sink_iid'];
	unset($_POST['action']);
	$_POST['sink_mount'] = 0;
	$add_faucet = new project_action;
	$add_faucet->add_faucet($_POST);
}

if ($action=="recalculate_install") {
	unset($_POST['action']);
	$compile_install_price = new project_action;
	$price = $compile_install_price -> compile_install_price($_POST);
	return $price;
}

if ($action=="mat_price_recalc") {
	unset($_POST['action']);
	$mat_price_recalc = new project_action;
	$r = $mat_price_recalc -> mat_price_recalc($_POST);
	echo $r;
}

if ($action=="quartz_sqft_calc") {
	unset($_POST['action']);
	$quartz_sqft_calc = new project_action;
	$SqFt = 0;
	foreach($quartz_sqft_calc->quartz_sqft_calc($_POST) as $results) {
		$SqFt = $results['sumSqFt'] . '::' . $results['slabs'];
	}
	echo $SqFt;
}
if ($action=="quartz_sqft_calc_update") {
	unset($_POST['action']);
	$quartz_sqft_calc_update = new project_action;
	$SqFt = 0;
	foreach($quartz_sqft_calc_update->quartz_sqft_calc_update($_POST) as $results) {
		$SqFt = $results['sumSqFt'] . '::' . $results['slabs'];
	}
	echo $SqFt;
}

if ($action=="update_discounts") {
	unset($_POST['action']);
	$update_discounts = new project_action;
	$update_discounts->update_discounts($_POST);
}


if ($action=="delete_sink") {
	unset($_POST['action']);
	$iid = $_POST['iid'];
	unset($_POST['iid']);
	$delete_sink = new project_action;
	$delete_sink->delete_sink($_POST);

	$iid = $_POST['iid'];
	$_POST = array();
	$_POST['iid'] = $iid;

}


if ($action=="get_pieces") {
	$sink_part = 0;
	if (isset($_POST['sink_part']) && $_POST['sink_part'] > 0) {
		$sink_part = $_POST['sink_part'];
	}
	unset($_POST['action']);
	unset($_POST['sink_part']);
	$pOptions = '';
	$get_pieces = new project_action;
	foreach($get_pieces->get_pieces($_POST) as $results) {
		$pOptions .= '<option value="' . $results['piece_id'] . '" ';
		if ($sink_part == $results['piece_id']) {
			$pOptions .= 'selected';
		}
		$pOptions .= '>' . $results['piece_name'] . '</option>';
	}
	echo $pOptions;
}

if ($action=="delete_piece") {
	unset($_POST['action']);
	$iid = $_POST['iid'];
	unset($_POST['iid']);

	$delete_piece = new project_action;
	$delete_piece -> delete_piece($_POST);


//	$_POST = array();
//	$_POST['iid'] = $iid;
//
//	$get_cp_sqft = new project_action;
//	$cpSqFt = $get_cp_sqft -> get_cp_sqft($_POST);
//
//	$cpSqFt = $cpSqFt['cpSqFt'];
//	if ( $cpSqFt<1 ) {
//		$cpSqFt = 0;
//	}
//
//	$get_inst_sqft = new project_action;
//	$newSqFt = $get_inst_sqft -> get_inst_sqft($_POST);
//
//	$newSqFt = $newSqFt['sumSqFt'];
//
//	$_POST = array();
//
//	$_POST['iid'] = $iid;
//	$_POST['SqFt'] = $newSqFt;
//
//	$setup = $newSqFt * $cpSqFt;
//
//	$set_inst_sqft = new project_action;
//	$totSqFt = $set_inst_sqft -> set_inst_sqft($_POST);
//
//	$_POST[] = array();
//	$_POST['iid'] = $iid;
//	$sum_sinks = new project_action;
//	$sinks_prices = $sum_sinks->sum_sinks($_POST);
//	$_POST['accs_prices'] = $sinks_prices['sinkTotal'];
//
//	$set_sinks_price = new project_action;
//	$set_sinks_price->set_sinks_price($_POST);

}

if ($action=="delete_install") {
	$install_name = $_POST['install_name'];
	$pid = $_POST['pid'];
	unset($_POST['action']);
	unset($_POST['install_name']);
	unset($_POST['pid']);
	$iid = $_POST['id'];

	$delete_install = new project_action;
	$delete_install -> delete_install($_POST);

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Install "' . $install_name .  '" deleted.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

}

if ($action=="add_piece") {
	unset($_POST['action']);
	unset($_POST['size_x']);
	unset($_POST['size_y']);
	$price_extra = $_POST['price_extra'];
	$pcSqFt = $_POST['pcSqFt'];
	unset($_POST['price_extra']);
	unset($_POST['pcSqFt']);
	$piece_name = $_POST['piece_name'];
	$pid = $_POST['pid'];
	if (!isset($_POST['piece_id'])) {
		$_POST['piece_id'] = 0;
	}
	$piece;

	if ($_POST['piece_id'] > 0) {
		$update_piece = new project_action;
		$piece = $update_piece -> update_piece($_POST);
	} else {
		unset($_POST['piece_id']);
		$add_piece = new project_action;
		$piece = $add_piece -> add_piece($_POST);
	}

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Piece "' . $piece_name .  '" added.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

	return $piece;
}

if ($action=="get_piece_for_edit") {
	unset($_POST['action']);
	$pieces = array();
	$return_string = '';

	$get_piece_data = new project_action;

	$array = $get_piece_data->get_piece_data($_POST);
	foreach($array as $result) {
		$return_string .= 'piece_id::' . $result['piece_id'] . ',';
		$return_string .= 'iid::' . $result['iid'] . ',';
		$return_string .= 'pid::' . $result['pid'] . ',';
		$return_string .= 'piece_name::' . $result['piece_name'] . ',';
		$return_string .= 'shape::' . $result['shape'] . ',';
		$return_string .= 'size_a::' . $result['size_a'] . ',';
		$return_string .= 'size_b::' . $result['size_b'] . ',';
		$return_string .= 'size_c::' . $result['size_c'] . ',';
		$return_string .= 'size_d::' . $result['size_d'] . ',';
		$return_string .= 'size_e::' . $result['size_e'] . ',';
		$return_string .= 'size_f::' . $result['size_f'] . ',';
		$return_string .= 'piece_edge::' . $result['piece_edge'] . ',';
		$return_string .= 'edge_length::' . $result['edge_length'] . ',';
		$return_string .= 'bs_height::' . $result['bs_height'] . ',';
		$return_string .= 'bs_length::' . $result['bs_length'] . ',';
		$return_string .= 'rs_height::' . $result['rs_height'] . ',';
		$return_string .= 'rs_length::' . $result['rs_length'] . ',';
		$return_string .= 'piece_active::' . $result['piece_active'] . ',';
		$return_string .= 'SqFt::' . $result['SqFt'];
	}
	echo rtrim($return_string, ",");

	

}


if ($action == "find_sales_reps") {
	$rep = "";
	if (isset($_POST['selectedRep'])) {
		$rep = $_POST['selectedRep'];
	}
	unset($_POST['action']);
	unset($_POST['selectedRep']);
	$uOptions = '';
	$salesReps = new project_action;
	foreach($salesReps->get_sales_reps($_POST) as $results) {
		$uOptions .= '<option value="' . $results['id'] . '" ';
		if ($results['id'] == $rep) {
			$uOptions .= 'selected';
		};
		$uOptions .= '>' . $results['fname'] . ' ' . $results['lname'] . '</option>';
	}
	echo $uOptions;
}

if ($action == "get_rep_name") {
	unset($_POST['action']);
	$_POST['repID'] = $_POST['repID'];
	$rep = '';
	$salesRep = new project_action;
	foreach($salesRep->get_rep_name($_POST) as $results) {
		$rep .=  $results['fname'] . ' ' . $results['lname'];
	}
	echo $rep;
}

if ($action == "get_client_name") {
	unset($_POST['action']);
	$getuid = '';
	$userNameShow = new project_action;
	foreach($userNameShow->get_client_name($_POST) as $results) {
		$getuid = $results['company'] . ' ' . $results['fname'] . ' ' . $results['lname'];
	}
	echo $getuid;
}

//if ($action == "find_inst_parts") {
//	unset($_POST['action']);
//	$getName = new project_action;
//	$rName = '';
//	if (isset($_POST['getEdge'])) {
//		foreach($getName->get_edge_name($_POST) as $results) {
//			$rName .=  $results['edge_name'];
//		}
//	}
//	if (isset($_POST['getHoles'])) {
//		foreach($getName->get_holes_name($_POST) as $results) {
//			$rName .=  $results['hole_name'];
//		}
//	}
//	if (isset($_POST['getRange'])) {
//		foreach($getName->get_range_type($_POST) as $results) {
//			$rName .=  $results['range_type'];
//		}
//	}
//	echo $rName;
//}



if ($action == "user_project_user_search") {
	$results = "";
	if (empty($_POST['isActive'])) {
		$_POST['isActive'] = '0';
	}
	if ($_POST['isActive'] != '1') {
		$_POST['isActive'] = '0';
	}
	if (empty($_POST['mine'])) {
		$_POST['mine'] = 0;
	} else {
		$_POST['mine'] = $_SESSION['id'];
	}

	$_POST['user_find'] = trim(htmlspecialchars($_POST['user_find']));
	$_POST['search'] = "%" . $_POST['search'] . "%";
	if ($_POST['user_find'] == "username") {
		$_POST['search'] = strtolower($_POST['search']);
	}
	unset($_POST['action']);
	$search = new user_action;

	echo '<div class="container">';

	foreach($search->user_data_search($_POST) as $results) {
		if ($results['access_level'] > 10) {
			?>
			<hr>
			<div class="row">
				<div class="col-12 col-md-6 text-primary"><?= $results['company']; ?></div>
				<div class="col-9 col-md-5 text-primary"><?= $results['fname']; ?> <?= $results['lname']; ?></div>
					<?PHP if ($results['company']=="") {
						$a = $results['fname'] . " " . $results['lname'];
					} else {
						$a = $results['company'];
					}
					?>
				<div class="col-3 col-md-1">
					<div id="<?= $results['id']; ?>" access_level="<?= $results['access_level']; ?>" class="btn btn-primary float-right" onClick="selectThisUser(this.id,'<?= $a; ?>');">Select</div>
				</div>
			</div>
			<?
		}
	}
	echo "</div>";

	echo "<hr>";
}

if ($action == "update_project_data") {


	if ($_POST['job_lat']=='') {
		unset($_POST['job_lat']);
	}
	if ($_POST['job_long']=='') {
		unset($_POST['job_long']);
	}

	if (isset($_POST['job_name'])) {
		$pid = $_POST['id'];
	} else {$pid = '';};
	if (isset($_POST['uid'])) {
		$emailUid = $_POST['uid'];
	} else {$emailUid = '';};
	if (isset($_POST['job_name'])) {
		$jobName = $_POST['job_name'];
	} else {$jobName = '';};
	if (isset($_POST['quote_num'])) {
		$quoNum = $_POST['quote_num'];
	} else {$quoNum = '';};
	if (isset($_POST['order_num'])) {
		$ordNum = $_POST['order_num'];
	} else {$ordNum = '';};
	if (isset($_POST['template_date'])) {
		$tempDate = $_POST['template_date'];
	} else {$tempDate = '';};
	if (!isset($_POST['urgent'])) {
		$_POST['urgent'] = "0";
	} else {
		$_POST['urgent'] = 1;
	}
	if (!isset($_POST['am'])) {
		$_POST['am'] = 0;
	} else {
		$_POST['am'] = 1;
	}
	if (!isset($_POST['first_stop'])) {
		$_POST['first_stop'] = 0;
	} else {
		$_POST['first_stop'] = 1;
	}
	if (!isset($_POST['pm'])) {
		$_POST['pm'] = 0;
	} else {
		$_POST['pm'] = 1;
	}
	if (!isset($_POST['temp_am'])) {
		$_POST['temp_am'] = 0;
	} else {
		$_POST['temp_am'] = 1;
	}
	if (!isset($_POST['temp_first_stop'])) {
		$_POST['temp_first_stop'] = 0;
	} else {
		$_POST['temp_first_stop'] = 1;
	}
	if (!isset($_POST['temp_pm'])) {
		$_POST['temp_pm'] = 0;
	} else {
		$_POST['temp_pm'] = 1;
	}
	if (!isset($_POST['tax_free'])) {
		$_POST['tax_free'] = 0;
	} else {
		$_POST['tax_free'] = 1;
	}
	if (!isset($_POST['job_tax'])) {
		$_POST['job_tax'] = 0.00;
	}
	if (!isset($_POST['job_lat'])) {
		unset($_POST['job_lat']);
	}
	if (!isset($_POST['job_long'])) {
		unset($_POST['job_long']);
	}
	if (!isset($_POST['job_tax'])) {
		$_POST['job_tax'] = 0.00;
	}

	if (empty($_POST['isActive'])) {
		$_POST['isActive'] = '0';
	}
	if ($_POST['isActive'] != "1") {
		$_POST['isActive'] = "0";
	}

	if ($_POST['job_name'] == "") {
		echo "You must have a Job Name.";
		exit;
	}
	if ($_POST['acct_rep'] < 1) {
		echo "You must specify an Account Rep.";
		exit;
	}

	unset($_POST['action']);

	$update_project = new project_action;
	$results = $update_project -> update_project($_POST,$pid);


	////////////////////////////   FILE UPLOADS   //////////////////////////////
	//CREATE DIRECTORIES
	$user_path =  base_dir . "job-files/" . $_POST['uid'];
	$path = base_dir . "job-files/" . $_POST['uid'] . "/" . $_POST['id'];

	$total = count($_FILES['imgUploads']['name']);
	
	// Loop through each file
	for($i=0; $i<$total; $i++) {
		//Get the temp file path
		$tmpFilePath = $_FILES['imgUploads']['tmp_name'][$i];
		
		//Make sure we have a filepath
		if ($tmpFilePath != ""){
			//Setup our new file path
			$newFilePath = base_dir . "job-files/" . $_POST['uid'] . "/" . $_POST['id'] . "/" . $_FILES['imgUploads']['name'][$i];

			//Upload the file into the temp dir
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {

				//Handle other code here

			}
		}
	}
	//////////////////////////   END FILE UPLOADS   ////////////////////////////



	//////////////////////////   LOG UPDATE   ////////////////////////////

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Project Edited.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

	//////////////////////////   END LOG UPDATE   ////////////////////////////


//	////////////////////////////   EMAIL ANYA   ///////////////////////////////
//	if (isset($_POST['template_date'])) {
//		if ($tempDate != '2200-01-01') {
//			//$EmailTo = "leegellie@gmail.com";
//			$EmailTo = 'afarmer@amanzigranite.com';
//			$Subject = 'Job Install Date Set / Job Changed' . $jobName;
//			
//			// prepare email body text
//			$Body = "<h2>Job Quote #: <b>" . $quoNum . "</b> - Order #: <b>" . $ordNum . "</b></h2>";
//
//			$Body .= '<a href="/admin/projects.php?edit&pid=' . $pid . '&uid=' . $emailUid . '"><button>View Project</button></a>';
//
//			$Body .= "<br><br><p>Alert Version 1.0</p>";
//			
//			$headers = "From: Amanzi Portal <portal@amanziportal.com>\r\n";
//			//$headers .= "Reply-To: " . $fname . " " . $lname . " <" . $EmailFrom . ">\r\n";
//			$headers .= "BCC: lee@hallenmedia.net\r\n";
//			$headers .= "MIME-Version: 1.0\r\n";
//			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//			$headers .= "X-Priority: 1 (Highest)\r\n";
//			$headers .= "X-MSMail-Priority: High\r\n";
//			$headers .= "Importance: High\r\n";
//			
//			
//			// send email
//			mail($EmailTo, $Subject, $Body, $headers);
//		}
//	}
//	//////////////////////////   END EMAIL ANYA   //////////////////////////////
}

if ($action == "update_install_data") {
	if ($_POST['install_name'] == "") {
		echo "You must have an Install Name.";
		exit;
	}
	
	$iName = $_POST['install_name'];
	$uid = $_POST['instUID'];
	$iid = $_POST['id'];
	$pid = $_POST['pid'];
	unset($_POST['action']);
	unset($_POST['isActive']);
	unset($_POST['instUID']);
	if (!isset($_POST['tearout_sqft'])) {
		$_POST['tearout_sqft'] = 0;
	}
	if ($_POST['tear_out'] == "Yes") {
		$_POST['tearout_cost'] = $_POST['tearout_sqft'] * $to_cost;
	} else {
		$_POST['tearout_cost'] = 0;
	}

	if (!isset($_POST['materials_cost'])) {
		$_POST['materials_cost'] = 0;
	}
	if ($_POST['materials_cost'] < 1) {
		$_POST['materials_cost'] = 0;
	}


	$price_calc = $_POST['price_calc'];
	$accs_prices = $_POST['accs_prices'];
	$price_extra = $_POST['price_extra'];
	$install_price = $price_calc + $accs_prices + $price_extra + $_POST['tearout_cost'];
	$_POST['install_price'] = $install_price;


	$update_project = new project_action;
	$results = $update_project -> update_install($_POST,$pid,$iid);

	//ECHO OUT RETURNED NUMBER TO BE USED AS PID
	echo $results;

	//CREATE DIRECTORIES
	$user_path =  base_dir . "job-files/" . $uid . "/" . $pid;
	$path = base_dir . "job-files/" . $uid . "/" . $pid . "/" . $iid;

	$total = count($_FILES['imgUploads']['name']);
	
	// Loop through each file
	for($i=0; $i<$total; $i++) {
		//Get the temp file path
		$tmpFilePath = $_FILES['imgUploads']['tmp_name'][$i];
		
		//Make sure we have a filepath
		if ($tmpFilePath != ""){
			//Setup our new file path
			$newFilePath = $path . "/" . $_FILES['imgUploads']['name'][$i];

			//Upload the file into the temp dir
			if(move_uploaded_file($tmpFilePath, $newFilePath)) {

				//Handle other code here

			}
		}
	}


	//////////////////////////   LOG UPDATE   ////////////////////////////

	$_POST = array();

	$_POST['cmt_ref_id'] = $pid;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Install "' . $iName .  '" Edited.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

	//////////////////////////   END LOG UPDATE   ////////////////////////////


}

if ($action == "add_project_step1") {

	if (!isset($_POST['job_lat'])) {
		$_POST['job_lat'] = "";
	}
	if (!isset($_POST['job_long'])) {
		$_POST['job_long'] = "";
	}

	if ($_POST['job_lat'] == '') {
		$_POST['job_lat'] = NULL;
	}
	if ($_POST['job_long'] == '') {
		$_POST['job_long'] = NULL;
	}

	if (!is_numeric($_POST['uid'])) {
		echo "No project owner selected.";
		exit;
	}

	if ($_POST['job_name'] == "") {
		echo "You must have a Job Name.";
		exit;
	}

	if ($_POST['acct_rep'] < 1) {
		echo "You must specify an Account Rep.";
		exit;
	}

	if (!isset($_POST['isActive'])) {
		$_POST['isActive'] = "0";
	}

	if (!isset($_POST['urgent'])) {
		$_POST['urgent'] = "0";
	} else {
		$_POST['urgent'] = 1;
	}

	if (!isset($_POST['am'])) {
		$_POST['am'] = 0;
	} else {
		$_POST['am'] = 1;
	}

	if (!isset($_POST['first_stop'])) {
		$_POST['first_stop'] = 0;
	} else {
		$_POST['first_stop'] = 1;
	}

	if (!isset($_POST['pm'])) {
		$_POST['pm'] = 0;
	} else {
		$_POST['pm'] = 1;
	}

	if (!isset($_POST['temp_am'])) {
		$_POST['temp_am'] = 0;
	} else {
		$_POST['temp_am'] = 1;
	}

	if (!isset($_POST['temp_first_stop'])) {
		$_POST['temp_first_stop'] = 0;
	} else {
		$_POST['temp_first_stop'] = 1;
	}

	if (!isset($_POST['temp_pm'])) {
		$_POST['temp_pm'] = 0;
	} else {
		$_POST['temp_pm'] = 1;
	}

	if (!isset($_POST['tax_free'])) {
		$_POST['tax_free'] = 0;
	} else {
		$_POST['tax_free'] = 1;
	}

	if (!isset($_POST['job_tax'])) {
		$_POST['job_tax'] = 0.00;
	}

	if ($_POST['job_discount'] < 1) {
		$_POST['job_discount'] = 0.00;
	}

	unset($_POST['action']);

	$pid = '';
	$add_project = new project_action;
	$results = $add_project -> add_project($_POST);
	$pid = $results;
	if (is_numeric($results)) {
		//ECHO OUT RETURNED NUMBER TO BE USED AS PID
		echo $results;

		//CREATE DIRECTORIES
		$user_path =  base_dir . "job-files/" . $_POST['uid'];
		$path = base_dir . "job-files/" . $_POST['uid'] . "/" . $results;

		if (file_exists($user_path)) {
			// USER ALREADY HAS A PROJECT AND THEIR FOLDER EXISTS
		} else {
			//USER'S FIRST PROJECT. MAKE THEIR USER IMAGE FOLDER
			mkdir($user_path,0755);
		}

		if (file_exists($path)) {
			echo "Project directory already exists.";
		} else {
			mkdir($path,0755);
		}
		$total = count($_FILES['imgUploads']['name']);
		
		// Loop through each file
		for($i=0; $i<$total; $i++) {
			//Get the temp file path
			$tmpFilePath = $_FILES['imgUploads']['tmp_name'][$i];
			
			//Make sure we have a filepath
			if ($tmpFilePath != ""){
				//Setup our new file path
				$newFilePath = base_dir . "job-files/" . $_POST['uid'] . "/" . $results . "/" . $_FILES['imgUploads']['name'][$i];

				//Upload the file into the temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {

					//Handle other code here

				}
			}
		}
	}
	else {
		echo $results; 
	}

	$_POST = array();

	$_POST['cmt_ref_id'] = $results;
	$_POST['cmt_type'] = 'pjt';
	$_POST['cmt_user'] = $_SESSION['id'];
	$_POST['cmt_comment'] = 'Project added.';
	$_POST['cmt_priority'] = 'log';

	$log_project = new log_action;
	$log = $log_project -> pjt_changes($_POST);

}

if ($action == "add_install_step2") {

	$uid = $_POST['instUID'];
	unset($_POST['action']);
	unset($_POST['instUID']);
	unset($_POST['backsplash']);
	unset($_POST['riser']);
	unset($_POST['sink']);
	if (!isset($_POST['tearout_sqft'])) {
		$_POST['tearout_sqft'] = 0;
	}
	$_POST['tearout_cost'] = $_POST['tearout_sqft'] * $to_cost;

	$add_project = new project_action;
	$results = $add_project -> insert_install($_POST);

	if (is_numeric($results)) {
		//ECHO OUT RETURNED NUMBER TO BE USED AS PID
		echo $results;

		//CREATE DIRECTORIES
		$user_path =  base_dir . "job-files/" . $uid . "/" . $_POST['pid'];
		$path = base_dir . "job-files/" . $uid . "/" . $_POST['pid'] . "/" . $results;

		if (file_exists($user_path)) {
			// USER ALREADY HAS A PROJECT AND THEIR FOLDER EXISTS
		} else {
			//USER'S FIRST PROJECT. MAKE THEIR USER IMAGE FOLDER
			mkdir($user_path,0755);
		}

		if (file_exists($path)) {
			echo "Install directory already exists.";
		} else {
			mkdir($path,0755);
		}
		$total = count($_FILES['imgUploads']['name']);
		
		// Loop through each file
		for($i=0; $i<$total; $i++) {
			//Get the temp file path
			$tmpFilePath = $_FILES['imgUploads']['tmp_name'][$i];
			//Make sure we have a filepath
			if ($tmpFilePath != ""){
				//Setup our new file path
				$newFilePath = $path . "/" . $_FILES['imgUploads']['name'][$i];
				//Upload the file into the temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					//Handle other code here
				}
			}
		}
	} else {
		echo $results; 
	}
	$iid = $results;
	$_POST = array();
	$_POST['iid'] = $iid;
	$compile_install_price = new project_action;
	$compile_install_price -> compile_install_price($_POST);
}


// SEARCH USERS FOR PROJECTS. RETURN ARRAY
if ($action=="pjt_user_list") {
	unset($_POST['action']);
	$results = "";

	if (empty($_POST['isActive'])) {
		$_POST['isActive'] = '0';
	}

	if ($_POST['isActive'] != '1') {
		$_POST['isActive'] = '0';
	}

	if (empty($_POST['mine'])) {
		$_POST['mine'] = 0;
	} else {
		$_POST['mine'] = $_SESSION['id'];
	}

	$_POST['user_find'] = trim(htmlspecialchars($_POST['user_find']));
	$_POST['search'] = "%" . $_POST['search'] . "%";
	if ($_POST['user_find'] == "order_num" || $_POST['user_find'] == "quote_num" || $_POST['user_find'] == "job_name") {
		$search = new project_action;
		echo '<div id="resultsTable1" class="row striped">';
		echo '	<div class="col-9 col-md-8 thead">Install</div>';
		echo '	<div class="col-1 hidden-md-down thead">Quote #</div>';
		echo '	<div class="col-1 hidden-md-down thead">Order #</div>';
		echo '	<div class="col-3 col-md-2 thead text-right">Edit</div>';
		foreach($search->project_data_search($_POST) as $results) {
			$statusText = '';
			$statusBar = '';
			if ($results['entry'] == 3) {
				$statusText = 'text-warning';
				$statusBar = 'progress-bar progress-bar-striped progress-bar-animated bg-warning';
			} else {
			
				if ($results['job_status'] == 19 || $results['job_status'] == 39 || $results['job_status'] == 49 || $results['job_status'] == 59 || $results['job_status'] == 69 || $results['job_status'] == 79 || $results['job_status'] == 89 ) {
					$statusText = 'text-danger';
					$statusBar = 'progress-bar progress-bar-striped progress-bar-animated bg-danger';
				} else {
					$statusText = 'text-primary';
					$statusBar = 'progress-bar progress-bar-striped';
				}
			}
				//echo $results['id'];
			?>
				<hr>
				<div class="col-9 col-md-8 <?= $statusText ?>"><h5> 
				<?
				if ( $results['entry'] == 0 ) {
					?> <i class="fas fa-desktop"></i> <?
				} elseif ( $results['entry'] == 1 ) {
					?> <i class="fas fa-paper-plane"></i> <?
				} elseif ( $results['entry'] == 2 ) {
					?> <i class="fas fa-database"></i> <?
				} else {
					?> <i class="fas fa-thumbs-down"></i> <?
				}
				?>
				<?= $results['job_name']; ?></h5></div>
				<div class="col-1 hidden-md-down"><h5><?= $results['quote_num']; ?></h5></div>
				<div class="col-1 hidden-md-down"><h5><?= $results['order_num']; ?></h5></div>
				<div class="col-3 col-md-2 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-primary" onClick="viewThisProject(this.id,<?= $results['uid']; ?>);">
						<span class="hidden-md-down">View </span>
						<i class="fas fa-eye"></i>
					</div>
				</div>
				<div class="col-12">
					<div id="progressStatus" class="w-100">
						<div class="progress w-100">
							<div class="<?= $statusBar ?>" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:<?= $results['job_status']; ?>%">
							<?= $results['status'] ?>
							</div>
						</div>
					</div>
				</div>
			<?
		}
		echo "</div>";
		echo "<hr>";
	} else {
		if ($_POST['user_find'] == "username") {
			$_POST['search'] = strtolower($_POST['search']);
		}
		$search = new user_action;
		echo '<div id="resultsTable1" class="row striped">';
		echo '	<div class="col-9 col-md-6 thead">Company</div>';
		echo '	<div class="col-1 hidden-md-down thead">Username</div>';
		echo ' 	<div class="col-2 hidden-md-down thead">Email</div>';
		echo '	<div class="col-2 thead">Name</div>';
		echo '	<div class="col-3 col-md-1 thead text-right">View</div>';
		foreach($search->user_data_search($_POST) as $results) {
			if ($results['access_level'] > 10) {
			?>
				<hr>
				<div class="col-9 col-md-5 text-primary"><h5><?= $results['company']; ?></h5></div>
				<div class="col-2 hidden-md-down"><?= $results['username']; ?></div>
				<div class="col-2 hidden-md-down"><?= $results['email']; ?></div>
				<div class="col-2 text-primary"><?= $results['fname']; ?> <?= $results['lname']; ?></div>
				<div class="col-3 col-md-1 text-right">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="projectsForUser(this.id);">
						<span class='hidden-md-down'>View </span><i class="fas fa-eye"></i>
					</div>
				</div>
			<?
			}
		}
		echo '	<hr>';
		echo '	<div class="col-9 col-md-6 tfoot">Company</div>';
		echo '	<div class="col-1 hidden-md-down tfoot">Username</div>';
		echo '	<div class="col-2 hidden-md-down tfoot">Email</div>';
		echo '	<div class="col-2 tfoot">Name</div>';
		echo '	<div class="col-3 col-md-1 tfoot text-right">View</div>';
		echo "</div>";
		echo "<hr>";
	}
}


// SEARCH PROJECTS FOR USER. RETURN ARRAY
if ($action=="find_user_pjts") {
	$results = "";
	unset($_POST['action']);
	$search = new project_action;
	echo '<div id="resultsTable1" class="row striped">';
	echo '<div class="col-9 col-md-5 thead">Install</div><div class="col-3 hidden-md-down thead"></div><div class="col-3 hidden-md-down thead"></div><div class="col-3 col-md-1 thead text-right">Edit</div>';
	foreach($search->project_list_search($_POST) as $results) {
		?>
        	<div  class="col-9 col-md-6 text-primary"><h3><?= $results['job_name']; ?></h3></div>
        	<div class="col-1 hidden-md-down">
				<h3><?= $results['quote_num']; ?></h3>
			</div>
        	<div class="col-1 hidden-md-down">
				<h3><?= $results['order_num']; ?></h3>
			</div>
	        <div class="col-3 col-md-2 text-right">
				<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="viewThisProject(this.id,$uid);">
					<span class="hidden-md-down">View </span>
					<i class="fas fa-eye"></i>
				</div>
			</div>
		<?
	}
	echo '<div class="col-9 col-md-5 tfoot">Install</div><div class="col-3 hidden-md-down tfoot"></div><div class="col-3 hidden-md-down tfoot"></div><div class="col-3 col-md-1 tfoot text-right">Edit</div>';

	echo "</div>";
	echo "<hr>";
}


// DISPLAY PROJECT DETAILS TO BE EDITED RETURN ARRAY
if ($action=="get_pjt_for_update") {
	$return_string = "";
	unset($_POST['action']);
	$pjt_data = new project_action;

	$array = $pjt_data->project_edit_data($_POST['id']);
	foreach($array as $result) {
		$return_string .= 'id::' . $result['id'] . ',';
		$return_string .= 'uid::' . $result['uid'] . ',';
		$return_string .= 'job_name::' . $result['job_name'] . ',';
		$return_string .= 'quote_num::' . $result['quote_num'] . ',';
		$return_string .= 'order_num::' . $result['order_num'] . ',';
		$return_string .= 'install_date::' . $result['install_date'] . ',';
		$return_string .= 'template_date::' . $result['template_date'] . ',';
		$return_string .= 'po_cost::' . $result['po_cost'] . ',';
		$return_string .= 'po_num::' . $result['po_num'] . ',';
		$return_string .= 'acct_rep::' . $result['acct_rep'] . ',';
		$return_string .= 'builder::' . $result['builder'] . ',';
		$return_string .= 'address1::' . $result['address_1'] . ',';
		$return_string .= 'address2::' . $result['address_2'] . ',';
		$return_string .= 'city::' . $result['city'] . ',';
		$return_string .= 'state::' . $result['state'] . ',';
		$return_string .= 'zip::' . $result['zip'] . ',';
		$return_string .= 'contact_name::' . $result['contact_name'] . ',';
		$return_string .= 'contact_number::' . $result['contact_number'] . ',';
		$return_string .= 'contact_email::' . $result['contact_email'] . ',';
		$return_string .= 'alternate_name::' . $result['alternate_name'] . ',';
		$return_string .= 'alternate_number::' . $result['alternate_number'] . ',';
		$return_string .= 'alternate_email::' . $result['alternate_email'] . ',';
		$return_string .= 'job_notes::' . $result['job_notes'] . ',';
		$return_string .= 'job_status::' . $result['job_status'] . ',';
		$return_string .= 'job_discount::' . $result['job_discount'] . ',';
		$return_string .= 'urgent::' . $result['urgent'] . ',';
		$return_string .= 'job_tax::' . $result['job_tax'] . ',';
		$return_string .= 'tax_free::' . $result['tax_free'] . ',';
		$return_string .= 'am::' . $result['am'] . ',';
		$return_string .= 'first_stop::' . $result['first_stop'] . ',';
		$return_string .= 'pm::' . $result['pm'] . ',';
		$return_string .= 'temp_am::' . $result['temp_am'] . ',';
		$return_string .= 'temp_first_stop::' . $result['temp_first_stop'] . ',';
		$return_string .= 'temp_pm::' . $result['temp_pm'] . ',';
    	$return_string .= 'job_lat::' . $result['job_lat'] . ',';
    	$return_string .= 'job_long::' . $result['job_long'] . ',';
    	$return_string .= 'job_sqft::' . $result['job_sqft'] . ',';
		$return_string .= 'isActive::' . $result['isActive'];
    
	}
	echo rtrim($return_string, ",");
}

// DISPLAY INSTALL DETAILS TO BE EDITED RETURN ARRAY
if ($action=="get_inst_for_update") {

	unset($_POST['action']);
	$pjt_data = new project_action;

	$array = $pjt_data->install_edit_data($_POST['id']);
	foreach($array as $result) {

		$return_string = 'id::' . $result['id'] . ',';
		$return_string .= 'pid::' . $result['pid'] . ',';
		$return_string .= 'install_name::' . $result['install_name'] . ',';
		$return_string .= 'type::' . $result['type'] . ',';
		$return_string .= 'remodel::' . $result['remodel'] . ',';
		$return_string .= 'tear_out::' . $result['tear_out'] . ',';
		$return_string .= 'material::' . $result['material'] . ',';
		$return_string .= 'color::' . $result['color'] . ',';
		$return_string .= 'lot::' . $result['lot'] . ',';
		$return_string .= 'selected::' . $result['selected'] . ',';
		$return_string .= 'edge::' . $result['edge'] . ',';
		$return_string .= 'backsplash::' . $result['backsplash'] . ',';
		$return_string .= 'bs_detail::' . $result['bs_detail'] . ',';
		$return_string .= 'riser::' . $result['riser'] . ',';
		$return_string .= 'rs_detail::' . $result['rs_detail'] . ',';
		$return_string .= 'sink::' . $result['sink'] . ',';
		$return_string .= 'sk_detail::' . $result['sk_detail'] . ',';
		$return_string .= 'range_type::' . $result['range_type'] . ',';
		$return_string .= 'cutout::' . $result['cutout'] . ',';
		$return_string .= 'range_model::' . $result['range_model'] . ',';
		$return_string .= 'holes::' . $result['holes'] . ',';
		$return_string .= 'holes_other::' . $result['holes_other'] . ',';
		$return_string .= 'install_notes::' . $result['install_notes'] . ',';
		$return_string .= 'status::' . $result['status'] . ',';
		$return_string .= 'installer_id::' . $result['installer_id'] . ',';
		$return_string .= 'install_diff::' . $result['install_diff'] . ',';
		$return_string .= 'SqFt::' . $result['SqFt'] . ',';
		$return_string .= 'edge_inches::' . $result['edge_inches'] . ',';
		$return_string .= 'price_extra::' . $result['price_extra'] . ',';
		$return_string .= 'accs_prices::' . $result['accs_prices'] . ',';
		$return_string .= 'price_calc::' . $result['price_calc'] . ',';
		$return_string .= 'install_room::' . $result['install_room'] . ',';
		$return_string .= 'slabs::' . $result['slabs'] . ',';
		$return_string .= 'cpSqFt_override::' . $result['cpSqFt_override'] . ',';
		$return_string .= 'tearout_sqft::' . $result['tearout_sqft'] . ',';
		$return_string .= 'color_id::' . $result['color_id'];
	}
	echo rtrim($return_string, ",");
}

// DISPLAY PROJECT AND INSTALLS FOR PJT. RETURN ARRAY
if ($action=="view_selected_pjt") {

	$noProg = '';
	if ($_SESSION['access_level'] == 5) {
		$noProg = 'd-none';
	}
	$results = "";
	unset($_POST['action']);
	$search = new project_action;
	$html = '';

	$pid = $_POST['pjtID'];
	$cmt_type = 'pjt';


	$getSqFt = new project_action;
	$eSqFt = $getSqFt -> sum_sqft($pid);

	$getPjtCost = new project_action;
	$ePjtCost = $getPjtCost -> sumPjtCost($pid);

	$cList = '';
	$comments = new comment_action;
	foreach($comments->get_comments($pid,$cmt_type) as $results) {
		$dt = $results['timestamp'];
		list($dDate, $dTime) = explode(' ',$dt);
		list($dYear, $dMonth, $dDay) = explode('-',$dDate);
		$stampy = $dMonth . '/' . $dDay . '/' . $dYear . ' - ' . $dTime;
		$cList .= '<div class="col-12 ';
		if ($results['cmt_priority'] == "911") {
			$cList .= 'text-danger';
		}	
		$cList .= '">' . $stampy . ' - <span id="cmtUser">' . $results['fname'][0] . '. ' . $results['lname']  . '</span> - ' . $results['cmt_comment'] . '</div><hr>';
	}

		//	$get_pjt_sqft = new project_action;
		//	$eSqFt = $getSqFt -> sum_sqft($pid);


	foreach($search->project_data_fetch($_POST) as $results) {

		$pid = $results['id'];
		$html = '<div class="row d-none w-100 d-print-flex">';

		$html .= '<div class="col-4 mt-5 text-left">';
		$html .= '<h2 class="text-primary">ESTIMATE</h2>';
		$html .= $results['clientCompany'] . '<br>';
		$html .= 'FAO: ' . $results['clientFname'] . ' ' . $results['clientLname'] . '<br>';
		if ($results['cAdd1'] > 0) {
			$html .= $results['cAdd1'] . '<br>'; 
		}
		if ($results['cAdd2'] > 0) {
			$html .= $results['cAdd2'] . '<br>'; 
		}
		$html .= $results['cCity'] . '<br>'; 
		$html .= $results['cState'] . ', ' . $results['cZip']; 
		$html .= '</div>'; 
		if ($results['job_discount'] < 1){
			$results['job_discount'] = 0;
		}
		if ($results['job_tax'] < 1){
			$results['job_tax'] = 0;
		}
		$print_disc = number_format($results['job_discount'], 2, '.', ','); 
		$print_pre = number_format($ePjtCost[0], 2, '.', ','); 
		$ePjtCost = $ePjtCost[0] - $results['job_discount']; 
		$price_print = number_format($ePjtCost, 2, '.', ','); 
		$tax_rate = $results['job_tax']; 
		$tax = $ePjtCost*$tax_rate/100;
		$price_tax = $ePjtCost + $tax; 
		$tax = number_format($tax, 2, '.', ','); 
		$tax_print = number_format($price_tax, 2, '.', ','); 
		$html .= '<div class="col-4 text-center pr-0"><img src="../images/logo-bw.png" class="w-100">';
		$html .= '<h2 class="w-100 text-primary text-center mt-4">Est. Cost: $' . $tax_print . '</h2>';
		$html .= '</div>';

		$html .= '<div class="col-4 mt-5 text-right pr-0">';
		$html .= '<h2>' . date("m/d/Y") . '</h2>';
		$html .= 'Amanzi Marble, Granite & Tile<br>';
		$html .= 'Rep: ' . $results['repFname'] . ' ' . $results['repLname'] . '<br>';
		$html .= '<a href="mailto:' . $results['repEmail'] . '" target="_blank">' . $results['repEmail'] . '</a><br>';
		$html .= '336.993.9998<br>';
		$html .= '703 Park Lawn Ct.<br>';
		$html .= 'Kernersville, NC 27084';
		$html .= '</div>';


		$html .= '</div>';


		$html .= '<div class="col-12 d-print-none"><div class="btn btn-warning float-right" onClick="pjtBack()"><i class="fas fa-reply"></i>&nbsp;&nbsp; Back</div></div>';
		$printThis = "$('#pjtDetails').printThis()";
		$html .= '<div class="col-12 d-print-none ' . $noProg . '"><div class="btn btn-primary float-right mr-3" onClick="' . $printThis . '"><i class="fas fa-print"></i>&nbsp;&nbsp; Estimate</div></div>';
		$html .= '<h2 class="d-print-none">Client:</h2>';
		$html .= '<h2 id="clientName" class="d-inline d-print-none text-primary">' . $results['clientCompany'] . ' ' . $results['clientFname'] . ' ' . $results['clientLname'] . ' <em><sup class=" ' . $noProg . '">(' . $eSqFt[0] . ' SqFt - $' . $tax_print .')</sup></em></h2>';
		$html .= '<hr class="d-print-none">';
		$html .= '<h2 class="col-12 col-md-4 col-lg-2 float-left pl-0 d-print-none">Status:</h2>';
		$html .= '<select id="changeStatus" onChange="statusUpdate(this.value)" class="mdb-select float-right col-12 col-md-4 col-lg-2 d-print-none ' . $noProg . '">';

		$statusText = '';
		$get_status_list = new project_action;
		$statList = '<option value="0" class="d-print-none">Select...</option>';

		foreach($get_status_list -> get_status_list($_POST) as $r) {
			$statList .= '<option ';
			if ( $r['id'] == $results['job_status'] ) {
				$statList .= 'selected="selected" ';
				$statusText = $r['name'];
			}
			$statList .= 'value="' . $r['id'] . '">' . $r['name'] . '</option>';
		}

		$html .= $statList;
		$html .= '</select>';
		$rejectSale = '<div class="btn btn-sm btn-danger" onClick="statusUpdate(26)"><i class="fas fa-times"></i> Job Rejected</div>';
		$rejectTempl = '<div class="btn btn-sm btn-danger" onClick="statusUpdate(19)"><i class="fas fa-times"></i> Template Hold</div>';

//		if ($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 2) {
//			if ($results['job_status'] == 10) {
//				$html .= '<div class="btn btn-sm btn-success" onClick="statusUpdate(11)"><i class="fas fa-check"></i> Estimated</div>';
//				$html .= $rejectSale;
//			}
//			if ($results['job_status'] == 11) {
//				$html .= '<div class="btn btn-sm btn-success" onClick="statusUpdate(12)"><i class="fas fa-check"></i> Estimate Approved</div>';
//				$html .= $rejectSale;
//			}
//		}
//		if ($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 4) {
//			if ($results['job_status'] == 10) {
//				$html .= '<div class="btn btn-sm btn-success" onClick="statusUpdate(11)"><i class="fas fa-check"></i> Template Sc</div>';
//
//				$html .= $rejectTempl;
//			}
//			if ($results['job_status'] == 11) {
//				$html .= '<div class="btn btn-sm btn-success" onClick="statusUpdate(12)"><i class="fas fa-check"></i> Estimate Approved</div>';
//				$html .= $rejectTempl;
//			}
//		}


		$html .= '<div id="progressStatus" class="w-100 d-print-none">';

		$html .= '<div class="progress w-100"><div class="progress-bar progress-bar-striped progress-bar-animated ';
		if ($results['job_status'] == 19 || $results['job_status'] == 39 || $results['job_status'] == 49 || $results['job_status'] == 59 || $results['job_status'] == 69 || $results['job_status'] == 79 || $results['job_status'] == 89 ) {
			$html .= 'bg-danger';
		} else {
			$html .= 'bg-primary';
		}

		$html .= '" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:' . $results['job_status']. '%">';
		$html .= $statusText;
		$html .= '</div></div>';



		$html .= '</div>';


		$html .= '<hr>';
		$html .= '<h2 class="d-print-none">Project details for:</h2>';
		$html .= '<h2 class="d-none d-print-inline">Job: </h2>';
		$html .= '<h2 class="d-inline text-primary" id="projectName">' . $results['job_name'] . '</h2>';

		if ($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 3 ) {
			$html .= '<div id="enteredDbBtn" class="btn btn-sm btn-warning d-inline ml-2 float-right d-print-none" onClick="entered_anya(' . $results['id'] . ');">Entered <i class="fas fa-database"></i></div>';
			$html .= '<div id="rejectedDbBtn" class="btn btn-sm btn-danger d-inline ml-2 float-right d-print-none" onClick="entry_reject(' . $results['id'] . ');">Reject <i class="fas fa-thumbs-down"></i></div>';
		}

		//if ( $results['order_num'] > 0 ) {
			//$html .= '<a target="_blank" id="viewMaster" class="btn btn-sm btn-info d-inline d-print-none ml-2 float-right" href="http://dashboard.amanzigranite.com/eFiles/' . $results['order_num'] . '/' . $results['order_num'] . '_shop_sheet.pdf">View Template <i class="fas fa-file-pdf"></i></a>';
		//}

		$html .= '<div id="sendAnya" class="btn btn-sm btn-success d-print-none ml-2 float-right ' . $noProg . '" onClick="sendQuoteData();">Send to Entry <i class="fas fa-paper-plane"></i></div>';
		$html .= '<div id="editPjtBtn" class="btn btn-sm btn-primary d-print-none ml-2 float-right ' . $noProg . '" onClick="pullEditPjt(' . $results['id'] . ');">Edit <i class="fas fa-wrench"></i></div>';

		$html .= '<div class="clearfix"></div>'; 
		$html .= '<hr class="d-print-none">'; 

		$html .= '<div class="row">'; 
		$html .= '<h3 id="discountPercent" class="text-warning text-right col-10 d-print-none ' . $noProg . '">Marble/Granite Discount: '; 
		if ($results['clientDiscount'] < 1) { 
			$html .= '<span id="pct">0</span>'; 
		} else { 
			$html .= '<span id="pct">' . $results['clientDiscount'] . '</span>'; 
		} 
		$html .= "% - Quartz Discount: "; 
		if ($results['discount_quartz'] < 1) { 
			$html .= '<span id="qpct">0</span>'; 
		} else { 
			$html .= '<span id="qpct">' . $results['discount_quartz'] . '</span>'; 
		} 
		$html .= '%</h3>'; 
		$adjustText = "adjustDiscoutsM('" . $results['clientCompany'] . ' - ' . $results['clientFname'] . ' ' . $results['clientLname'] . "'," . $results['clientDiscount'] .",". $results['discount_quartz'] .")"; 
		$html .= '<div onClick="'.$adjustText.'" class="btn btn-sm btn-success col-2 mx-0 mt-0 mb-2 ' . $noProg . ' d-print-none">Adjust <i class="fas fa-percent"></i></div>';  
		$html .= '</div>'; 

		if ($results['clientDiscount'] > 0) { 
			$html .= '<h4 id="discountPercent" class="text-dark text-right col-12 d-none d-print-block">Discounts: Marble/Granite: <span id="pct">' . $results['clientDiscount'] . '</span>% - Quartz: <span id="qpct">' . $results['discount_quartz'] . '</span>%</h4><div class="text-dark text-right d-none d-print-block h6 pr-3"><small>Applied before totals.</small></div>'; 
		} 
		$profit = 0;
		$project_costs = 0;
		
		$prof_calc = new project_action; 
		$matCost = $prof_calc->sum_costs($pid); 
		$wSqFt = $eSqFt[0]; 
		$labor = $wSqFt * 20; 
		$labor = $labor * 1.2; 
		$project_costs = $labor + $matCost; 
		$profit = $ePjtCost - $project_costs; 
		
		$html .= '<hr>'; 
		if ($profit < 100) {
			$html .= '<div class="row">'; 
			if ($results['mngr_approved'] == 0) {
				$html .= '	<div class="col-10 text-center"><h2 class="text-center text-danger col-12">This Project is NOT YET APPROVED by Amanzi Management</h2></div>'; 
				if ($_SESSION['access_level'] == 1) { 
					$html .= '	<button class="col-2 btn btn-success d-print-none float-right mx-0" type="button" onClick="approveLoss(1,' . round($price_tax,2) . ',' . $_SESSION['id'] . ')">Approve <i class="far fa-check mr-2"></i></button>'; 
				}
			} else {
				if (round($results['mngr_approved_price'],2) != round($price_tax,2)) {
					$html .= '	<div class="col-10 text-center"><h2 class="text-center text-danger col-12">This job has changed since it was approved and will need new approval.</h2></div>'; 
					if ($_SESSION['access_level'] == 1) { 
						$html .= '	<button class="col-2 btn btn-success d-print-none float-right mx-0" type="button" onClick="approveLoss(1,' . round($price_tax,2) . ',' . $_SESSION['id'] . ')">Approve <i class="far fa-check"></i></button>'; 
					}
				}
			}
			$html .= '</div>'; 
			$html .= '<div class="clearfix"></div>'; 
		}
		if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1444) { 

			$format_costs = number_format($project_costs, 2, '.', ','); 
			$format_profit = number_format($profit, 2, '.', ','); 
			$html .= '<button class="btn btn-sm btn-primary d-print-none float-right my-0" type="button" data-toggle="collapse" data-target="#profCalc" aria-expanded="false" aria-controls="collapseExample"><i class="far fa-balance-scale-right mr-2"></i></button>';

			$html .= '<div class="collapse" id="profCalc">';

			$html .= '	<div class="row text-center"><h2 class="text-center text-danger col-12">Costs: $' . $format_costs . ' - Profit: $' . $format_profit . '</h2></div>'; 

			$html .= '	<button class="btn btn-sm btn-primary d-print-none  float-right my-0" type="button" data-toggle="collapse" data-target="#profBreakdown" aria-expanded="false" aria-controls="collapseExample"><i class="far fa-clipboard-list"></i> &nbsp; &nbsp;

 </button>';

			$html .= '	<div class="collapse" id="profBreakdown">';

			$html .= '		<div class="row text-center"><p class="text-center text-muted col-12">Materials &amp; Accs. Costs: $' . number_format($matCost, 2, '.', ',') . ' - Labor &amp; Logistics: $' . number_format($labor, 2, '.', ',') . '</p></div>'; 
			$html .= '	</div>';

			
			$html .= '</div>';
			$html .= '<div class="clearfix"></div>';
			$html .= '	<hr>'; 
		}
		if (empty($eSqFt[0])) {
			$eSqFt[0] = 0;
		}
		$db_profit_update = new project_action; 
		$db_profit_update->db_profit_update($pid,$ePjtCost,$eSqFt[0],$profit,$project_costs); 


		$html .= '<div class="row">'; 
		$html .= '<div class="col-6 col-md-6 col-lg-3" id="s-quote_num">Quote #: <b>' . $results['quote_num'] . '</b></div>'; 
		$html .= '<div class="col-6 col-md-6 col-lg-3" id="s-order_num">Order #: <b>' . $results['order_num'] . '</b></div>'; 
		$html .= '<div class="col-6 col-md-6 col-lg-3">Template Date: <b>'; 
		if ($results['template_date'] == '2200-01-01') {
			$html .= 'Not Set';
		} else { 
			$html .= $results['template_date']; 
		} 
		$html .= '<br>'; 
		if ($results['temp_first_stop'] == 1) { 
			$html .= '1st Stop '; 
		} 
		if ($results['temp_am'] == 1) {
			$html .= 'AM '; 
		}
		if ($results['temp_pm'] == 1) {
			$html .= 'PM '; 
		}

		$html .= '</b></div>'; 
		$html .= '<div class="col-6 col-md-6 col-lg-3">Install Date: <b>';
		if ($results['install_date'] == '2200-01-01') {
			$html .= 'Not Set';
		} else {
			$html .= $results['install_date'];
		}
		$html .= '<br>'; 
		if ($results['first_stop'] == 1) {
			$html .= '1st Stop '; 
		}
		if ($results['am'] == 1) {
			$html .= 'AM '; 
		}
		if ($results['pm'] == 1) {
			$html .= 'PM '; 
		}
		$html .= '</b></div>'; 

		$html .= '</div>'; 
		$html .= '<hr>'; 
		$html .= '<div class="row">'; 
		$html .= '<div class="col-12 d-print-none">'; 
		$html .= '	<div class="row">'; 
		$html .= '		<div class="col-6 col-md-2 ' . $noProg . '">Job Price: <br><b>$' . $print_pre . '</b></div>'; 
		$html .= '		<div class="col-6 col-md-2 ' . $noProg . '">Extra Discount: <br><b>$' . $print_disc . '</b></div>'; 
		$html .= '		<div class="col-6 col-md-2 ' . $noProg . '">Tax: <br><b>$' . $tax . ' @ ' . $tax_rate . '%</b></div>'; 
		$html .= '		<div class="col-6 col-md-2 ' . $noProg . '">Total: <br><b>$' . $tax_print . '</b></div>'; 
		$html .= '		<div class="col-6 col-md-2">PO #: <br><b>' . $results['po_num'] . '</b></div>'; 
		$html .= '		<div class="col-6 col-md-2">Account Rep: <br><b>'. $results['repFname'] . ' ' . $results['repLname'] .'</b></div>'; 
		$html .= '		<div id="repID" class="d-none">'. $results['acct_rep'] . '</div>'; 
		$html .= '	</div>'; 
		$html .= '</div>'; 

		$html .= '<div class="col-12 d-none d-print-block">'; 
		$html .= '	<div class="row">'; 
		$html .= '		<div class="col-3">Job Price: <b>$' . $print_pre . '</b></div>'; 
		$html .= '		<div class="col-3 col-md-2">Extra Discount: <b>$' . $print_disc . '</b></div>'; 
		$html .= '		<div class="col-3 col-md-2">Tax: <b>$' . $tax . ' @ ' . $tax_rate . '%</b></div>'; 
		$html .= '		<div class="col-3 col-md-2">Total: <b>$' . $tax_print . '</b></div>'; 
		$html .= '		<div class="col-3 col-md-2">PO #: <b>' . $results['po_num'] . '</b></div>'; 
		$html .= '		<div class="col-3 col-md-2">Account Rep: <b>'. $results['repFname'] . ' ' . $results['repLname'] .'</b></div>'; 
		$html .= '	</div>'; 
		$html .= '</div>'; 

		$html .= '</div>'; 
		$html .= '<hr>'; 
		$html .= '<div class="row">'; 

		$html .= '<div class="col-12 col-md-12 ' . $noProg . '">';
		$html .= '	<div class="row">'; 
		$html .= '		<div class="col-12">Builder: <b>' . $results['builder'] . '</b></div>'; 
		$html .= '		<div class="d-none" id="address_verify">' . $results['address_1'] . '</div>';
		$html .= '		<div class="col-12">Address: <b><a class="text-primary" target="_blank" href="https://maps.google.com/?q=' . $results['address_1'] . ', ';
		if ($results['address_2'] > 0) {
			$html .= $results['address_2'] . ', ';
		}
		$html .= $results['city'] . ', ' . $results['state'] . ' ' . $results['zip'] . '"><i class="fas fa-map d-print-none"></i> ' . $results['address_1'] . ', ';
		if ($results['address_2'] > 0) {
			$html .= $results['address_2'] . ', ';
		}
		$html .= $results['city'] . ', ' . $results['state'] . ' ' . $results['zip'] . '</a></b></div>';
		
		$html .= '	</div>';
		$html .= '</div>';

		$html .= '</div>'; 
		$html .= '<hr>'; 
		$html .= '<div class="row ' . $noProg . '">'; 

		$html .= '<div class="col-6 col-md-6">';
		$html .= '<div class="col-12">Contact: <b>' . $results['contact_name'] . '</b></div>'; 
		$html .= '<div class="col-12">Number: <b>';
		if ($results['contact_number'] > 0) {
			$html .= '<a class="text-success" href="tel:' . $results['contact_number'] . '" target="_blank"><i class="fas fa-phone d-print-none"></i> ' . $results['contact_number'] . '</a>';
		}
		$html .= '</b></div>';
		$html .= '<div class="col-12">Email: <b><a class="text-primary" href="mailto:' . $results['contact_email'] . '">' . $results['contact_email'] . '</a></b></div>'; 
		$html .= '</div>';

		$html .= '<div class="col-6 col-md-6">';
		$html .= '<div class="col-12">Alt. Contact: <b>' . $results['alternate_name'] . '</b></div>'; 
		$html .= '<div class="col-12">Number: <b>';
		if ($results['alternate_number'] > 0) {
			$html .= '<a class="text-success" href="tel:' . $results['alternate_number'] . '" target="_blank"><i class="fas fa-phone d-print-none"></i> ' . $results['alternate_number'] . '</a>';
		}
		$html .= '</b></div>';
		$html .= '<div class="col-12">Email: <b><a class="text-primary" href="mailto:' . $results['alternate_email'] . '">' . $results['alternate_email'] . '</a></b></div>'; 
		$html .= '</div>';

		$html .= '<hr>'; 

		$html .= '<div class="col-12">Notes: <b>' . $results['job_notes'] . '</b></div>'; 

		$html .= '</div>';
		$html .= '<hr>'; 
		$_SESSION['repID'] = $results['acct_rep'];
	}


	// Comments Section

	$cmt_user = "'" . $_SESSION['id'] . "'";
	$html .= '	<div class="d-print-none">';
	$html .= '		<h4 class="d-inline">Comments</h4><div id="makeCommentBtn" class="btn btn-primary d-inline ml-2 float-right" cmt_type="pjt" onClick="makeComment(this,' . $cmt_user . ');"><i class="fas fa-comment"></i></div>';
	$html .= '		<hr>'; 
	$html .= '		<div id="commentList" class="col-12">';
	$html .= $cList;
	$html .= '		</div>';
	$html .= '		<hr>'; 
	$html .= '	</div>';

	// Attachment Section
	$folderPath = base_dir . "job-files/" . $_POST['userID'] . "/" . $_POST['pjtID'] . "/";
	if (file_exists($folderPath)) {
		$fileList = array_diff(scandir($folderPath), array('..', '.'));
		if (!empty($fileList)) {
			$html .= '<div id="attachments" class="col-12 d-print-none"><h4>Job Attachments</h4>';
		}
		foreach($fileList as $filename) {
			if (strpos($filename, '.') !== false) {
				$filename = str_replace('#','%23',$filename);
				$html .= "<a class='btn btn-primary mb-2 mr-2 d-inline-block' href='/job-files/" . $_POST['userID'] . "/" . $_POST['pjtID'] . "/" . $filename . "' target='_blank'>" . $filename . "</a>";
			}
		}
		if (!empty($fileList)) {
			$html .= '<hr>';
			$html .= '</div>';
		}
	}

	echo $html;

	unset($_POST['userID']);
	echo '';
	echo '	<hr class="" style="height:5px;margin-top:15px;background:magenta;">';
	echo '	<div id="pjtInstalls" class="row">';
	echo '		<div class="h1 col-12 col-md-9 d-print-none">Installs</div>';
	echo '		<div class="h1 col-12 col-md-9 d-none d-print-block">Areas:</div>';
	echo '		<div class="btn btn-lg btn-primary float-right col-md-2 d-print-none ' . $noProg . '" onClick="newInstall()">Add <i class="fas fa-plus"></i></div>';
	echo '		<hr class="d-print-none">';
	echo '		<div class="col-9 col-md-10 thead d-print-none">Install</div><div class="col-3 col-md-2 thead text-right d-print-none">View</div>';

	foreach($search->install_data_search($_POST) as $results) {
		?>
			<hr>
			<div class="row w-100 d-flex d-print-flex">
	        	<div class="col-4 col-md-4 text-primary"><div class="d-inline d-print-none" onClick="delete_install(<?= $results['id']; ?>,<?= $results['pid']; ?>,'<?= $results['install_name']; ?>')"> <i class="fas fa-trash text-danger"></i></div><h4 class="d-inline"> <?= $results['type_name']; ?> - <?= $results['install_name']; ?> </h4></div>
    	    	<div class="col-3 col-md-3 text-dark"><h5><?= $results['color']; ?></h5></div>
        		<div class="col-3 col-md-2 text-right text-dark"><h5><?= $results['SqFt']; ?> SqFt</h5></div>
	        	<div class="col-2 col-md-3 text-right text-success float-right d-none d-print-block"><h4>$<?= number_format($results['install_price'], 2, '.', ','); ?></h4></div>
    	    	<div class="col-3 col-md-2 text-right text-dark d-print-none"><h4>$<?= number_format($results['install_price'], 2, '.', ','); ?></h4></div>
		        <div class="col-2 col-md-1 text-right d-print-none">
					<div id="<?= $results['id']; ?>" class="btn btn-sm btn-primary" onClick="viewThisInstall(this.id,$uid,$pid);">View <i class="icon-eye"></i></div>
				</div>
			</div>
			<div class="w-100 row d-none d-print-none">
				<div class="col-5 text-dark"><h5>Sink: <?= $results['sk_detail']; ?></h5></div>
				<div class="col-3 text-dark"><h5>Edge: <?= $results['edge_name']; ?></h5></div>
				<div class="col-2 text-dark"><h5>Backsplash: <?= $results['bs_detail']; ?></h5></div>
				<div class="col-2 text-dark"><h5>Riser: <?= $results['rs_detail']; ?></h5></div>
			</div>
			<hr class="w-100 d-none d-print-block">

			<div class="container px-4" id="inst_details">
			<?
			if ($results['tear_out'] == "Yes") {
				?>
				<div class="row w-100 d-flex d-print-flex">
					<div class="col-12 text-dark"><h5><small>Tear Out: <small><?= $results['tearout_sqft'] ?> SqFt</small><span class="float-right pr-5 mr-5">$<?= $results['tearout_cost'] ?></span></small></h5></div>
				</div>
				<?
			} 
			$_POST = array();
			$_POST['instID'] = $results['id'];

			$instP = new project_action;
			foreach( $instP->pieces_data_fetch($_POST) as $r ) {
				?>
				<div class="row w-100 d-flex d-print-flex">
					<div class="col-12 text-dark"><h5><small>Piece: <?= $r['piece_name'] ?> - <?= $r['edge_name'] ?><? if ($r['bs_height'] > 0){ echo ' - Backsplash = ' . $r['bs_height'] . '"';} ?><? if ($r['rs_height'] > 0){ echo ' - Riser = ' . $r['rs_height'] . '"';} ?><span class="float-right pr-5 mr-5"><?= $r['SqFt'] ?> SqFt</span></small></h5></div>
				</div>
				<?
			}


			$instS = new project_action;
			foreach( $instS->sink_data_fetch($_POST) as $r ) {
				?>
				<div class="row w-100 d-flex d-print-flex">
					<div class="col-12 text-dark"><h5><small><? if ($r['sink_name'] > '') { ?>Includes Sink:  <? echo $r['sink_name']; } elseif ($r['faucet_name'] > '') {?>Includes Faucet: <? echo $r['faucet_name']; }?></small></h5></div>
				</div>
				<?
			}
			if ($results['install_notes'] != "") {
			?>
			<div class="w-100 row d-none d-print-flex">
				<div class="col-12 text-dark"><h5>Notes: <small><?= $results['install_notes']; ?></small></h5></div>
			</div>
            <?
			}
			?>

			</div>
			<div class="container d-flex d-print-none">
			<?
				if($results['material_status'] == 1) {
			?>
				<div class="col-6 text-danger"><b>Material Status: To be assigned/ordered.</b></div>
			<?
				} else if($results['material_status'] == 2) {
			?>
				<div class="col-6 text-success"><b>Material Status: Materials ordered. Est. delivery <?= $results['material_date'] ?></b></div>
			<?
				} else if($results['material_status'] == 3) {
			?>
				<div class="col-6 text-primary"><b>Material Status: Materials On Hand</b></div>
				<div class="col-6">Assigned Material: <?= $results['assigned_material'] ?></div>
			<?
				}
			?>

			</div>

		<?
	}
	echo "<hr>";
	echo '<h3 class="col-12 d-none d-print-block">Notice:</h3>';
	echo '<div class="col-12 d-none d-print-block" id="estimate">This is an estimated cost for the project requested and is not an actual quatation. After accepting an estimate, a deposit will be required. At that point a template will be scheduled and carried out which will then allow us to provide you with an in depth <b>quotation</b> for the job.</div>';
	echo '<h5 class="col-12 d-none d-print-block text-center mt-5">&copy; ' . date('Y') . ' - Amanzi Marble, Granite &amp; Tile. All rights reserved.</h5>';


	echo '<div class="col-9 col-md-10 tfoot d-print-none">Install</div><div class="col-3 col-md-2 tfoot text-right d-print-none">View</div>';
	echo "</div>";
	echo '</div>';

}

// GET SqFt

if ($action=="get_sqft") {
	unset($_POST['action']);
	$getUserName = new project_action;
	$eSqFt = $getUserName -> sum_sqft($_POST);
	echo $eSqFt[0];
}

// DISPLAY INSTALLS FOR PROJECT. RETURN ARRAY
if ($action=="view_selected_inst") {
	$results = "";
	unset($_POST['action']);
	$search = new project_action;
	$html = '';
	$instToCopy = "'instToCopy'";
	$clipboard = '	<div class="modal fade" id="entry_clipboard" tabindex="55" role="dialog" aria-labelledby="entry_clipboardLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
							<div class="modal-content">
								<div class="modal-header">
									<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-copy h2 text-warning"></i>  Copy for E2</h2></div>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&#10008;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="container">
										<!--<div class="col-12 btn btn-success copyBtn" data-clipboard-target="#instToCopy"><i class="fas fa-copy"></i> Copy to Clipboard</div> -->
										<div id="instToCopy">';

	$programming = '	<div class="modal fade" id="programming_clipboard" tabindex="55" role="dialog" aria-labelledby="programming_clipboardLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document" style="margin-top: 7rem;">
							<div class="modal-content">
								<div class="modal-header">
									<div class="modal-title"><h2 class="d-inline text-primary"><i class="fas fa-copy h2 text-warning"></i>  Copy for Programming</h2></div>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&#10008;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="container">
										<!--<div class="col-12 btn btn-success copyBtn" data-clipboard-target="#instToCopy"><i class="fas fa-copy"></i> Copy to Clipboard</div> -->
										<div id="instToCopy">';




	$copyModal = "$('#entry_clipboard').modal('show');";
	$programmingModal = "$('#programming_clipboard').modal('show');";
	$instNotes = '';
	$cbAttachments = '';

	foreach($search->install_data_fetch($_POST) as $results) {

		$html = '<h3>Install details for: </h3>';
		$html .= '<h1 class="d-inline text-primary" id="installName">' . $results['type_name'] . ' - ' . $results['install_name'] . '</h1>';
		if ($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 5) {
			$html .= '<div class="btn btn-success btnCopy float-right" onClick="' . $programmingModal . '"><i class="fas fa-copy"></i></div>';
		}

		if ($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 3) {
			$html .= '<div class="btn btn-success btnCopy float-right" onClick="' . $copyModal . '"><i class="fas fa-copy"></i></div>';
		}

		$html .= '<div id="editInstBtn" class="btn btn-primary d-inline ml-2 float-right" onClick="pullEditInst(' . $results['id'] . ');">Edit <i class="fas fa-wrench"></i></div>';

		$html .= '<hr>';
		$html .= '<div>';
		$html .= '<div class="row">';
		$html .= '	<div class="d-none" id="type_cost">' . $results['type_cost'] . '</div>';
		$html .= '	<div class="col-12 col-md-3">Install Type: <b>' . $results['type'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-3">Tear Out? <b>';
		if ($results['tear_out'] == "Yes") {
			$html .= $results['tear_out'] . ' <sup>' . $results['tearout_sqft'] . ' SqFt</sup>';
		} else {
			$html .= $results['tear_out'];
		} 
		$html .= '</b></div>';
		$html .= '	<div class="col-12 col-md-3">Customer Selected? <b>' . $results['selected'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-3">Slabs? <b>' . $results['slabs'] . '</b></div>';
		$html .= '	<hr>';
		$html .= '	<div class="col-12 col-md-3">Material: <b>';
		if ($results['material'] == 'marbgran') {
			$html .= 'Marble/Granite';
		} elseif ($results['material'] == 'quartz') {
			$html .= 'Quartz';
		} 
		$html .= '</b></div>';
		$html .= '	<div class="col-12 col-md-3">Color: <b>' . $results['color'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-2">Lot: <b>' . $results['lot'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-2">SqFt: <b>' . $results['SqFt'] . '</b>';
		$html .= '		<div id="pullCpSqFt" class="d-none">' . $results['cpSqFt'] . '</div>';
		$html .= '		<div id="pullPriceExtra" class="d-none">' . $results['price_extra'] . '</div>';
		$html .= '	</div>';
		$html .= '	<div class="col-12 col-md-2">Price p/SqFt: <b>$' . $results['cpSqFt'] . '</b>';
		if ($results['cpSqFt_override'] > 0) {
			$html .= '<sup class="d-print-none">~</sup>';
		}
		$html .= '  </div>';
		$html .= '	<hr>';
		$html .= '	<div class="col-12 col-md-3">Default Edge: <b>' . $results['edge_name'] . '</b><div id="dEdge" class="d-none">' . $results['edge'] . '</div></div>';
		$html .= '	<div class="col-12 col-md-3">Sinks &amp; Faucets: <b>$' . $results['accs_prices'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-2">Range Type: <b>' . $results['rangeT'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-2">Range Model: <b>' . $results['range_model'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-2">Cooktop Cutout: <b>' . $results['cutout'] . '</b></div>';
		$html .= '	<hr>';
		$html .= '</div>';

		$html .= '<div class="text-muted mb-3 row d-print-none" style="border-radius:4px;border: 2px solid #ccc;">';
		$html .= '	<h3 class="d-inline text-muted w-100">To be discontinued</h3>';
		$html .= '	<div class="col-12 col-md-4">Backsplash: <b>';
		if ( $results['backsplash'] == 'Yes') {
			$html .= 'Yes - ';
		}
		$html .= $results['bs_detail'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-4">Riser: <b>';
		if ( $results['riser'] == 'Yes') {
			$html .= 'Yes - ';
		}
		$html .=  $results['rs_detail'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-4">Sink: <b>' . $results['sk_detail'] . '</b></div>';
		$html .= '	<hr>';
		$html .= '	<div class="col-12 col-md-4">Holes: <b>' . $results['hole_name'] . '</b></div>';
		$html .= '	<div class="col-12 col-md-4">Holes (other): <b>' . $results['holes_other'] . '</b></div>';
		$html .= '</div>';


		$html .= '<div class="col-12">Install Notes: <b>' . $results['install_notes'] . '</b></div>';
		$html .= '<hr>';


		// =======================================  COMPILE CLIPBOARD DATA =========================================

		$clipboard .= $results['install_name'];
		$clipboard .= " - " . $results['SqFt'] . " SqFt";
		$clipboard .= " - Install Type: " . $results['type'];
		$clipboard .= " - Tear-Out: " . $results['tear_out'] . '-' . $results['tearout_sqft'] . ' SqFt';
		$clipboard .= " - Material: " . $results['color'];

		$programming .= $results['type_name'] . ' - ' . $results['install_name'] . '<br>';
		$programming .= "Material: " . $results['color'] . "<br>";

		$clipboard .= " - Customer Selected: " . $results['selected'];
		if ($results['lot'] != '') {
			$clipboard .= " - Lot: " . $results['lot'];
		}
		if ($results['edge'] != 0) {
			$clipboard .= " - Default Edge: " . $results['edge_name'];
			$programming .= " Edge: " . $results['edge_name'] . "<br>";
		}
		if ($results['range_type'] != 0) {
			$clipboard .= " - Range: " . $results['rangeT'];
			$programming .= "Range: " . $results['rangeT'] . "<br>";
		}
		if ($results['range_model'] != '') {
			$clipboard .= " - Range Model: " . $results['range_model'];
			$programming .= "Range Model: " . $results['range_model'] . "<br>";
		}
		if ($results['cutout'] != '') {
			$clipboard .= " - Cooktop Cutout: " . $results['cutout'];
			$programming .= "Cutout: " . $results['cutout'] . "<br>";
		}
		if ($results['install_notes'] != '') {
			$instNotes .= ' - Notes: ' . $results['install_notes'];
		}

		// =====================================  END COMPILE CLIPBOARD DATA =======================================


	}

	// ADD ATTACHMENTS TO VIEW

	$folderPath = base_dir . "job-files/" . $_POST['userID'] . "/" . $_POST['pjtID'] . "/" . $_POST['instID'] . "/";
	if (file_exists($folderPath)) {
		$fileList = array_diff(scandir($folderPath), array('..', '.'));
		if (!empty($fileList)) {
			$html .= '	<div id="attachments" class="col-12"><h4>Install Attachments</h4>';
		}
		foreach($fileList as $filename) {
			if (strpos($filename, '.') !== false) {
				$filename = str_replace('#','%23',$filename);
				$html .= "<a class='btn btn-primary mb-2 mr-2 d-inline-block' href='/job-files/" . $_POST['userID'] . "/" . $_POST['pjtID'] . "/" . $_POST['instID'] . "/" . $filename . "' target='_blank'>" . $filename . "</a><p>";

				// ========== Clipboard Attachments  ===========
				$cbAttachments .= "<span style='font-size:0.1px;'> - &lt;a target='_blank' href='/job-files/" . $_POST['userID'] . "/" . $_POST['pjtID'] . "/" . $_POST['instID'] . "/" . $filename . "'&gt;" . $filename . "&lt;/a&gt;</span>";
				// ======== End Clipboard Attachments  =========

			}
		}
	}
	$html .= "			<hr>";
	$html .= '	</div>';
	$html .= '</div>';


	// ADD PIECES TO VIEW

	$modalName = "'#shape_info'";
	$modalAction = "'show'";
	$html .= '<div class="d-print-none w-100">';
	$html .= '	<h3 class="d-inline text-primary">Pieces </h3>';
	$html .= '	<div class="btn-floating btn-sm btn-warning text-center" onClick="$(' . $modalName . ').modal(' . $modalAction . ')"><i class="fas fa-info p-absolute" style="top: 10px; position: absolute; margin-left: -3px;"></i></div>';
	$html .= '	<div class="btn btn-success ml-2" onClick="pieceAdder()">Add <i class="fas fa-plus"></i></div>';
	$html .= '	<hr>';
	$html .= '	<div id="pieceList" class="col-12 d-print-none">';
	$instR = new project_action;
	foreach( $instR->pieces_data_fetch($_POST) as $r ) {
		$html .= '	<div class="row">';
		$html .= '		<h4 class="d-inline col-12 col-md-2 text-warning"><i class="fas fa-trash-alt text-danger h6" style="cursor:pointer" onClick="deletePiece(' . $r['piece_id'] . ')"></i> <i class="fas fa-wrench text-primary h6" style="cursor:pointer" onClick="edit_piece(' . $r['piece_id'] . ')"></i> ' . $r['piece_name'] . '</h4>';

		$html .= '	</div>';
		$html .= '	<div class="row">';
		$html .= '		<div class="d-inline col-12 col-md-2">Shape: ';

		$cbs = ceil(($r['bs_height'] * $r['bs_length'])/144);
		$crs = ceil(($r['rs_height'] * $r['rs_length'])/144);
		$cSqFt = $r['SqFt'] - $cbs - $crs;

		$clipboard .= "&lt;br&gt; --- Piece: " . $r['piece_name'] . " - " . $cSqFt . " SqFt";

		if ($r['shape'] == 1) {
			$html .= 'Rectangle';
			$clipboard .= ' Rectangle';
		} elseif ($r['shape'] == 2) {
			$html .= 'L-Shaped';
			$clipboard .= ' L-Shaped';
		} elseif ($r['shape'] == 2) {
			$html .= 'Odd Shaped';
			$clipboard .= ' Odd Shaped';
		} else {
			$html .= 'SqFt';
			$clipboard .= ' ';
		}
		$html .= '		</div>';


		if ($r['shape'] == 1 || $r['shape'] == 3) {
			$html .= '	<div class="d-inline col-6 col-md-1">x: ' . $r['size_a'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">y: ' . $r['size_b'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-2"><b><sup>(SqFt: ' . $cSqFt . ')</sup></b></div>';
			$html .= '	<div class="d-inline col-12 col-md-6 text-right"><b>SqFt: ' . $r['SqFt'] . '</b></div>';

		} elseif ($r['shape'] == 2){

			$html .= '	<div class="d-inline col-6 col-md-1">a: ' . $r['size_a'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">b: ' . $r['size_b'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">c: ' . $r['size_c'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">d: ' . $r['size_d'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">e: ' . $r['size_e'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-1">f: ' . $r['size_f'] . '"</div>';
			$html .= '	<div class="d-inline col-6 col-md-2"><b><sup>(SqFt: ' . $cSqFt . ')</sup></b></div>';
			$html .= '	<div class="d-inline col-12 col-md-2 text-right"><b>SqFt: ' . $r['SqFt'] . '</b></div>';

		} else {
			$html .= '	<div class="d-inline col-2 col-md-2"><b><sup>(SqFt: ' . $cSqFt . ')</sup></b></div>';
			$html .= '	<div class="d-inline col-10 col-md-8 text-right"><b>SqFt: ' . $r['SqFt'] . '</b></div>';
		}
		$html .= '	</div>';


		if ($r['edge_name'] != "None") {
			$clipboard .= ' - Edge: ' . $r['edge_name'] . '"';
			$clipboard .= ' - Edge Length: ' . $r['edge_length'] . '"';
		}

		if ($r['bs_height'] != 0) {
			$clipboard .= ' - Backsplash Height: ' . $r['bs_height'] . '"';
			$clipboard .= ' - Backsplash Width: ' . $r['bs_length'] . '"';
			$clipboard .= ' - SqFt: ' . $cbs . '"';
		}

		if ($r['rs_height'] != 0) {
			$clipboard .= ' - Riser Height: ' . $r['rs_height'] . '"';
			$clipboard .= ' - Riser Width: ' . $r['rs_length'] . '"';
			$clipboard .= ' - SqFt: ' . $crs . '"';
		}

		$html .= '	<div class="row">';
		$html .= '		<div class="col-md-4">';
		$html .= '			<div class="row">';
		$html .= '				<div class="w-100"><u>Edging</u></div>';
		$html .= '				<div class="d-inline col-md-4">Edge: ' . $r['edge_name'] . '</div>';
		$html .= '				<div class="d-inline col-md-4">Length: ' . $r['edge_length'] . '</div>';
		$html .= '			</div>';
		$html .= '		</div>';
		$html .= '		<div class="col-md-4">';
		$html .= '			<div class="row">';
		$html .= '				<div class="w-100"><u>Backsplash</u><b><sup> ' . ceil(($r['bs_height'] * $r['bs_length'])/144) . ' SqFt</sup></b></div>';
		$html .= '				<div class="d-inline col-md-4">Height: ' . $r['bs_height'] . '</div>';
		$html .= '				<div class="d-inline col-md-4">Length: ' . $r['bs_length'] . '</div>';
		$html .= '			</div>';
		$html .= '		</div>';
		$html .= '		<div class="col-md-4">';
		$html .= '			<div class="row">';
		$html .= '				<div class="w-100"><u>Riser</u><b><sup> ' . ceil(($r['rs_height'] * $r['rs_length'])/144) . ' SqFt</sup></b></div>';
		$html .= '				<div class="d-inline col-md-4">Height: ' . $r['rs_height'] . '</div>';
		$html .= '				<div class="d-inline col-md-4">Length: ' . $r['rs_length'] . '</div>';
		$html .= '			</div>';
		$html .= '		</div>';
		$html .= '	</div>';
		$html .= '	<hr>'; 
	}
	$html .= '	</div>';
	$html .= '</div>';


	// ADD SINKS AND FAUCETS TO VIEW

	$html .= '<div class="d-print-none w-100">';
	$html .= '	<h3 class="d-inline text-primary">Sinks / Faucets </h3>';
	$html .= '	<div class="btn btn-success ml-2" onClick="sinkAdder()">Add <i class="fas fa-plus"></i></div>';
	$html .= '	<hr>';
	$html .= '	<div id="accsList" class="col-12 d-print-none">';
	$instS = new project_action;
	foreach( $instS->sink_data_fetch($_POST) as $r ) {
		$html .= '	<div class="row">';
		$sink_pull = $r['sink_id'] . "," . $r['sink_iid'] . "," . $r['sink_part'] . "," . $r['sink_model'] . "," . $r['sink_mount'] . "," . $r['sink_provided'] . "," . $r['sink_holes'] . "," . $r['sink_soap'] . "," . $r['cutout_width'] . "," . $r['cutout_depth'] . "," . $r['sink_cost'] . "," . $r['sink_price'] . "," . $r['cutout_price'];
		$html .= '<div class="d-none" id="sho_' . $r['sink_id'] . '">' . $r['sink_holes_other'] . '</div>';
		$html .= '		<h4 class="d-inline col-12 text-warning"><i class="fas fa-trash-alt text-danger h6" style="cursor:pointer" onClick="deleteSink(' . $r['sink_id'] . ')"></i> <i class="fas fa-wrench text-primary h6" style="cursor:pointer" onClick="editSink(' . $sink_pull . ')"></i> ';
		if ($r['sink_name'] > '') {
			if ($r['piece_name'] > 0) {
				$html .= 'Sink for piece ' . $r['piece_name'] . '<br>';
				$clipboard .= '&lt;br&gt; --- Sink for piece' . $r['piece_name'];
			} else {
				$html .= 'Sink for job<br>';
				$clipboard .= '&lt;br&gt; --- Sink for job';
			}
		} else {
			if ($r['piece_name'] > 0) {
				$html .= 'Faucet for ' . $r['piece_name'] . '<br>';
				$clipboard .= ' --- Faucet for ' . $r['piece_name'];
			} else {
				$html .= 'Faucet for job<br>';
				$clipboard .= '&lt;br&gt; --- Faucet for job';
			}
		}
		if ($r['sink_name'] > '') {
			$html .= '<span id="sink_' . $r['sink_id'] . '" class="text-primary">' . $r['sink_name'] . '</span></h4>';
			$clipboard .= ' - ' . $r['sink_name'];
		} else {
			$html .= '<span id="sink_' . $r['sink_id'] . '" class="text-primary">' . $r['faucet_name'] . '</span></h4>';
			$clipboard .= ' - ' . $r['faucet_name'];
			$programming .= 'Faucet: ' . $r['faucet_name'];
			$programming .= 'Holes: ' . $r['hole_name'] . ' ' . $r['sink_holes_other'] . '<br>';
		}

		$html .= '		<div class="d-inline col-12 col-md-2">Customer Provided?<br> <b>';
		if ($r['sink_provided'] == 1) {
			$html .= 'Yes';
			$clipboard .= " - Customer Provided!";
		} else {
			$html .= 'No';
		}
		$html .= '		</b></div>';

		if ($r['sink_name'] > '') {
			$html .= '	<div class="d-inline col-12 col-md-2">Cutout: <br>x: <strong>' . $r['cutout_width'] . '"</strong> - y: <strong>' . $r['cutout_depth'] . '"</strong></div>';
			$html .= '	<div class="d-inline col-12 col-md-2">Mount: <br><strong>' . $r['mount_name'] . '</strong></div>';
			$html .= '	<div class="d-inline col-12 col-md-2">Holes: <br><strong>' . $r['hole_name'] . '</strong></div>';
			$html .= '	<div class="d-inline col-12 col-md-2">Holes Data: <br><strong>' . $r['sink_holes_other'] . '</strong></div>';

			$clipboard .= ' - Mount: ' . $r['mount_name'];
			$clipboard .= ' - Holes: ' . $r['hole_name'];
			if ($r['sink_holes_other'] != '') {
				$clipboard .= ' - Holes Data: ' . $r['sink_holes_other'];
			}

			$programming .= 'Sink: ' . $r['sink_name'] . '<br>';
			$programming .= 'Holes: ' . $r['hole_name'] . ' ' . $r['sink_holes_other'] . '<br>';
			$programming .= 'Cutout: ' . $r['cutout_width'] . 'w ' . $r['cutout_depth'] . 'd<br>';

			$html .= '	<div class="d-inline col-12 col-md-2">Soap Hole: <br><b>';

			if ($r['sink_soap'] == 1){
				$html .= 'Yes';
				$clipboard .= ' - Soap Hole!';
				$programming .= 'Soap Hole!<br>';
			} else {
				$html .= 'No';
			}
			$html .= '	</b></div>';
		} else {
			$html .= '	<div class="d-inline col-12 col-md-2"></div>';
		}
		$html .= '		<div class="d-inline col-12 text-right">Price: <b>$';
		if ($r['sink_name'] > '') {
			$html .= $r['sink_price'] + $r['cutout_price'];
		} else {
			$html .= $r['faucet_price'];
		}
		$html .= '		</b></div>';

		$html .= '	</div>';

		$html .= '	<hr>'; 
	}

	$html .= '	</div>';
	$html .= '</div>';
	$html .= '<hr>'; 

	$clipboard .= $instNotes;
	//$clipboard .= '<textarea class="w-100" placeholder="Extra Notes: "></textarea>';
	$clipboard .= $cbAttachments;

	if ($results['install_notes'] != '') {
		$programming .= 'Notes: ' . $results['install_notes'] . "<br>";
	}

	$programming .= '
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
							</div>
						</div>
					</div>
				</div>';


	$clipboard .= '
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close &#10008;</button>
							</div>
						</div>
					</div>
				</div>';
	
	$html .= $clipboard;
	$html .= $programming;

	echo $html;

}

// SEARCH INSTALLS FOR PROJECT. RETURN ARRAY
if ($action=="install_search_list") {
	$results = "";
	unset($_POST['action']);
	$search = new project_action;


	// LEE EDIT FROM TABLE TO DIVs
	echo '<div id="resultsTable1" class="row striped">';

	echo '<div class="col-9 col-md-10 thead">Install</div><div class="col-3 col-md-2 thead text-right">Edit</div>';

	foreach($search->install_data_search($_POST) as $results) {
		?>
        	<div class="col-9 col-md-10 text-primary">
				<h3><?= $results['install_name']; ?></h3>
			</div>
	        <div class="col-3 col-md-2 text-right">
				<div id="<?= $results['id']; ?>" class="btn btn-primary" onClick="pullEditInst(this.id);">Edit <i class="icon-wrench"></i></div>
			</div>
		<?
	}
	echo "</div>";
	echo "<hr>";
}

if ($action=="") {
	echo "I got nothin'\n";
	print_r($_POST);
}

?>