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
	<script>
		$uAccess = <?= $_SESSION['access_level'] ?>;
	</script>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
	<!-- START BODY CONTENT AREA -->
	<?
	if (isset($_GET['add'])){
		require_once ('project_add.php');
	} elseif (isset($_GET['entry'])) {
		require_once ('project_entry.php');
	} elseif (isset($_GET['templates'])) {
		require_once ('project_templates.php');
	} elseif (isset($_GET['programming'])) {
		require_once ('project_programming.php');
	} elseif (isset($_GET['saw'])) {
		require_once ('project_saw.php');
	} elseif (isset($_GET['cnc'])) {
		require_once ('project_cnc.php');
	} elseif (isset($_GET['polishing'])) {
		require_once ('project_polishing.php');
	} elseif (isset($_GET['installs'])) {
		require_once ('project_installs.php');
	} elseif (isset($_GET['completed'])) {
		require_once ('project_comp_installs.php');
	} elseif (isset($_GET['edit'])) {
		require_once ('project_edit.php');
	} elseif (isset($_GET['marbgran'])) {
		require_once ('project_marbgran.php');
	} elseif (isset($_GET['quartz'])) {
		require_once ('project_quartz.php');
	} elseif (isset($_GET['timeline'])) {
		require_once('project_timeline.php');
	} elseif (isset($_GET['test'])) {
		require_once('project_test.php');
	}

	include ('footer.php');
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
	include ('modal_approval_reject.php');
	include ('modal_job_lookup.php');
	include ('modal_select_installers.php');
	?>

	<script src="js/pikaday.js"></script>
	<script src="js/pikaday.jquery.js"></script>
	<script src="js/bootstrap-combobox.js"></script>

	<script>
	var res = <?= json_encode($output); ?>; //for the template_date 
	var resforinstall = <?= json_encode($outputforinstall); ?>; //for the install_date 
	var holi = '<?php echo json_encode($holidays); ?>';
	var currently_sqft = '<?php echo $limitinfo[0]['install_sqft']; ?>';
	var template_num = '<?php echo $limitinfo[0]['templates_number']; ?>';
	var access_level = '<?php echo $_SESSION['access_level']; ?>';
	var session_id = '<?php echo $_SESSION['id']; ?>';
	console.log("session id",session_id);

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
	var _cur_mon = cur_d.getMonth();
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
			console.log("here --- ", curdate);
			//console.log(curdate,"-----", jday); 
			var flag = false;
			if(jday == 0 || jday == 6) flag = true;
			$.each(res, function(key, value){
				if(value['template_date'] == curdate){
					var jobs_num = value['detail'].length;
					if (jobs_num >= template_num){
						flag = true;
					}else{  
						var lat1 = 36.1181642;
						var lon1 = -80.0626623;
						var lat2 = $('#p-geo-lat').val();
						var lon2 = $('#p-geo-long').val();
						console.log(lat2,"************************", lon2);
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
			if (session_id == 1 || session_id == 13 || session_id == 14  || session_id == 985 || session_id == 1444 || session_id == 4 || session_id == 1452)  flag = false;
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
			console.log("currenlty date = ",curdate);          
			var flag = false;
			if(jday == 0 || jday == 6) flag = true;
	console.log("today: ", _cur_day, "currently month = ", _cur_mon);
			//           if((access_level != 1 || access_level != 14 ) && st_d < _cur_day + 7 ) flag = true;
			var $repair = $('input[name=repair]').val();
			if(!(session_id == 1 || session_id == 13 || session_id == 14 || session_id == 985 || session_id == 1444 || session_id == 1448 || session_id == 1452) && (st_m == _cur_mon && st_d < _cur_day + 7 )) flag = true;
			$.each(resforinstall, function(key, value){
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
					if (sum_sqft > currently_sqft) {
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
			if(session_id == 1 || session_id == 13  || session_id == 14  || session_id == 985 || session_id == 1444 || session_id == 1448 || session_id == 1452 || $repair == 1)  flag = false;
			return flag;
		},
		onDraw() {
			var curmm = $('.pika-select').val();
			var d = new Date();
			var n = d.getMonth();
			// console.log(cur_day);
			// if(n == curmm) {
			for (var i=0; i<cur_day_ins.length; i++) {
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