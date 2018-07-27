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
		<h1><br>Materials</h1>
	</div>
</div>
<!-- START BODY CONTENT AREA -->
<div class="container pageLook">
	<div class="grid fluid">
    	<div class="row">
            <div class="col-12" style="margin-left:0">
                <div id="user-data" class="col-12">
                    <div id="user-block" class="content">
						<div id="resultsTable1" class="row striped">
							<ul class="nav nav-tabs nav-justified w-100 mb-3 d-print-none" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="toOrder-tab" data-toggle="tab" href="#toOrder" role="tab" aria-controls="toOrder" aria-selected="true"><h5>To Order/Schedule</h5></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="mOrdered-tab" data-toggle="tab" href="#mOrdered" role="tab" aria-controls="mOrdered" aria-selected="false"><h5>Materials Ordered</h5></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="mOnHand-tab" data-toggle="tab" href="#mOnHand" role="tab" aria-controls="mOrdered" aria-selected="false"><h5>Materials Here</h5></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="toDeliver-tab" data-toggle="tab" href="#toDeliver" role="tab" aria-controls="toDeliver" aria-selected="false"><h5>Pull Sheet</h5></a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="mAccs-tab" data-toggle="tab" href="#mAccs" role="tab" aria-controls="mAccs" aria-selected="false"><h5>Accessories</h5></a>
								</li>
							</ul>
							<div class="tab-content w-100 pt-0" id="myTabContent">
								<div id="toOrder" 	class="tab-pane fade show active" role="tabpanel" aria-labelledby="toOrder-tab"></div>
								<div id="mOrdered" 	class="tab-pane fade" role="tabpanel" aria-labelledby="mOrdered-tab"></div>
								<div id="mOnHand" 	class="tab-pane fade" role="tabpanel" aria-labelledby="mOnHand-tab"></div>
								<div id="toDeliver" class="tab-pane fade" role="tabpanel" aria-labelledby="toDeliver-tab"></div>
								<div id="mAccs" 		class="tab-pane fade" role="tabpanel" aria-labelledby="mSaw-tab">
									<ul class="nav nav-tabs nav-justified green w-100 mb-3 mx-0 d-print-none" id="myTab2" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="sAccsMat-tab" data-toggle="tab" href="#sAccsMat" role="tab" aria-controls="sAccsMat" aria-selected="true"><h5>Accessories by Material</h5></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="sAccsJob-tab" data-toggle="tab" href="#sAccsJob" role="tab" aria-controls="sAccsJob" aria-selected="false"><h5>Accessories by Job</h5></a>
										</li>
									</ul>
									<div class="tab-content w-100 pt-0" id="myTab2Content">
										<div id="sAccsMat" class="tab-pane fade show active" role="tabpanel" aria-labelledby="sAccsMat-tab"></div>
										<div id="sAccsJob" class="tab-pane fade" role="tabpanel" aria-labelledby="sAccsJob-tab"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="pjt-block" class="content">
						<div class="col-12" id="pjtResults"></div>
					</div>
					<div id="inst-list" class="content mt-4">
						<div class="col-12" id="pjtDetails"></div>
					</div>
					<div id="inst-block" class="content">
						<div class="col-12" id="instDetails"></div>
					</div>

				</div>
			</div>
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
include ('modal_material_select.php');
include ('modal_material_assign.php');
include ('modal_material_order.php');
include ('modal_hold_notice.php');
include ('modal_mat_hold.php');
include ('modal_release_hold.php');
?>
<script>
$(document).ready(function(){
    mat_list_pull();
});
</script>
</body>
</html>