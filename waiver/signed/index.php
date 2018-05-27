<?
if(!session_id()) session_start();

define('db_host','172.30.200.249');
define('db_user','user001');
define('db_password','cL4MpUjCtNdNRoYY');
define('db_name','Portal');

if (!isset($_SESSION['old_id'])) {
	$_SESSION['old_id'] = '';
};

class waiver {
	public function get_sales_reps($a) {
		$dbh = new PDO("mysql:host=" . db_host . ";dbname=" . db_name . "",db_user,db_password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			
		$q = $dbh->prepare("SELECT id,fname,lname FROM users WHERE sales = :sales");
		$q->bindParam('sales',$a['isSales']);
		$q->execute();
		return $row = $q->fetchAll();
	}
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">

    <title>Amanzi Client Waiver</title>

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/ie10.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">

    <script type="text/javascript" src="/js/addtohomescreen.min.js"></script>
</head>

<body>
    <div class="site-wrapper">
        <div class="pt-5">
            <div class="container">
				<div class="row mb-5 navbar-fixed-top">
                    <div class="col-2"><img class="w-100" alt="Amanzi Granite" longdesc="http://amanzigranite.com" src="/images/web-logo.png"></div>
					<h2 class="col-10 text-dark">Amanzi Waivers Signed</h2>
				</div>
				<div class="row mt-5">
					<div class="w-100" id="station_data">
					</div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="repSelect" tabindex="-1" role="dialog" aria-labelledby="repSelectLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg text-primary" role="document" style="margin-top: 7rem;">
		<div class="modal-content">
			<div class="modal-header">
				<i class="fa fa-user"></i>
				<div class="modal-title">Select Sales Rep</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&#10008;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="container">
						<div class="row px-0">
							<select class="repBox col-12 mb-3 form-control input-lg" onChange="repChange(this);">
								<option>Select Rep...</option>
								<?
									$rep = "";
									$uOptions = '';
									$salesReps = new waiver;
									$_POST['isSales'] = '1';
									foreach($salesReps->get_sales_reps($_POST) as $results) {
										$uOptions .= '<option value="' . $results['id'] . '" ';
										$uOptions .= '>' . $results['fname'] . ' ' . $results['lname'] . '</option>';
									}
									echo $uOptions;
								?>
							</select>
						</div>
					</div>
					<div id="itemBox" class="row">


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

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/popper.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/ie10.js"></script>

<script>
$lastID ='';
$clientID = '';
$acct_rep = '';
$reps = {};

$(document).ready(function(){
    loadStation();
});

function loadStation(){
//	var datastring = 'action="load_results"';
//	$.ajax({
//		type: "POST",
//		url: "station.php",
//		data: datastring,
//		success: function(data) {
//			$("#station_data").prepend(data);
//		},
//		error: function(xhr, status, error) {
//			// alert("Error submitting form: " + xhr.responseText);
//			successNote = "Error submitting form: "+xhr.responseText;
//			$('#editSuccess').html(succesStarter+successNote+successEnder);
//			document.getElementById('closeFocus').focus();
//		}
//	});

	$("#station_data").load("station.php");
	//loadRep();
	setTimeout(loadStation, 10000);
}

function selectRep($client) {
	$clientID = $client;
	$('#repSelect').modal('show');
}

function repChange($this){
	$acct_rep = $("option:selected", $this).val();
	var datastring = 'acct_rep=' + $acct_rep + '&id=' + $clientID;
	$.ajax({
		type: "POST",
		url: "rep.php",
		data: datastring,
		success: function(data) {
			$("#repSelect").modal('hide');
			$('select').prop('selectedIndex',0);
		},
		error: function(xhr, status, error) {
			// alert("Error submitting form: " + xhr.responseText);
			successNote = "Error submitting form: "+xhr.responseText;
			$('#editSuccess').html(succesStarter+successNote+successEnder);
			document.getElementById('closeFocus').focus();
		}
	});
}


</script>

</body>
</html>