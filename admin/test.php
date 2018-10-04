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
	include('include_css.php');
	?>
	<script>
		$uAccess = <?= $_SESSION['access_level'] ?>;
	</script>
	
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/pikaday.css">
	<link rel="stylesheet" href="css/site.css">

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="bootgrid/jquery.bootgrid.min.css">
</head>
<body class="metro" style="background-color: rgb(239, 234, 227);" >
	<?PHP include('menu.php'); ?>
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
include ('modal_job_material.php');
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
include ('modal_date_change.php');
?>
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="/js/jquery.validate.js" type="text/javascript"></script>
<? 
	include ('javascript.php');
	include('include_js.php');
?>

	<script src="js/projects.js?<?= $version ?>"></script>
	<script src="js/printThis.js"></script>
	<script>
		<?PHP 
		if(isset($_GET['add'])){
			require_once ('js/project_add.js');
		}else{
			require_once ('js/project_edit.js');
		}
		?>
	</script>

</body>
</html>