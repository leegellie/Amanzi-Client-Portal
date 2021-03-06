<?PHP 
 // IF USER ACCESS  = 1 THEN USER IS AN ADMIN. SHOW ADMIN MENU
if ($access_level < 11) {
	if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1444 || $_SESSION['id'] == 13) {
?>
			<div id="jobsOn" class="m-0 p-0" style="position: fixed; width:100vw;z-index: 5;"></div>
<?
		}
?>
<header class=" d-print-none">

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="top:0px">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        	<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#"><img src="../images/icon.png" style="max-width:52px"></a>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav m-auto">
<?
		if ( $access_level < 4 && $access_level != "") {
			$link = '/admin/projects.php?timeline';
		} elseif ($access_level == 4) {
			$link = '/admin/projects.php?templates';
		} elseif ($access_level == 5) {
			$link = '/admin/projects.php?programming';
		} elseif ($access_level == 6) {
			$link = '/admin/materials.php';
		} elseif ($access_level == 7) {
			$link = '/admin/projects.php?saw';
		} elseif ($access_level == 8) {
			$link = '/admin/projects.php?cnc';
		} elseif ($access_level == 9) {
			$link = '/admin/projects.php?polishing';
		} elseif ($access_level == 10) {
			$link = '/admin/projects.php?installs';
		}
?>
				<li class="nav-item py-3 px-4">
					<a class="element" href="<?= $link ?>"><span class="icon-home"></span></a>
				</li>
<?
	if ($access_level < 4 || $_SESSION['id'] == 1448 || $_SESSION['id'] == 1582) {
		if ($_SESSION['id'] == 1 || $_SESSION['id'] == 13 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1444 || $_SESSION['id'] == 1447 || $_SESSION['id'] == 1456) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="userdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
					<div class="dropdown-menu" aria-labelledby="userdropdown">
<?
			if ($_SESSION['id'] != 1447 && $_SESSION['id'] != 1456) {
?>
						<a class="dropdown-item text-dark" href="admin.php?profit">Profit/Loss</a>
						<a class="dropdown-item text-dark" href="admin.php?approval">Need Approval</a>
						<a class="dropdown-item text-dark" href="admin.php?holds">Hold List</a>
						<a class="dropdown-item text-dark" href="admin.php?precalltemp">Precall Templates</a>
						<a class="dropdown-item text-dark" href="admin.php?precall">Precall Installs</a>
<?
			}
?>
						<a class="dropdown-item text-dark" href="admin.php?stats">Stats</a>
						<a class="dropdown-item text-dark" href="admin.php?invoices">Invoicing</a>
						<a class="dropdown-item text-dark" href="admin.php?pay">Installer Pay</a>
<?
			if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1283) {
?>
						<a class="dropdown-item text-dark" href="admin.php?order">Ordering</a>
<?
			}
?>
					</div>
				</li>
<?
		}
	}
	if ($access_level < 4 || $_SESSION['id'] == 1448 || $_SESSION['id'] == 1582 || $_SESSION['id'] == 1449) {
?>

				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="userdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Customers</a>
					<div class="dropdown-menu" aria-labelledby="userdropdown">
						<a class="dropdown-item text-dark" href="users.php?edit">View Customers</a>
						<a class="dropdown-item text-dark" href="users.php?add">Add Customers</a>
					</div>
				</li>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="pjtdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Projects</a>
					<div class="dropdown-menu" aria-labelledby="pjtdropdown">
						<a class="dropdown-item text-dark" href="projects.php?edit">View Projects</a>
						<a class="dropdown-item text-dark" href="projects.php?add">Add a Project</a>
						<a class="dropdown-item text-dark" href="projects.php?entry">To Enter</a>
						<a class="dropdown-item text-dark" href="projects.php?templates">Templates</a>
						<a class="dropdown-item text-dark" href="projects.php?programming">Programming</a>
						<a class="dropdown-item text-dark" href="projects.php?saw">Saw</a>
						<a class="dropdown-item text-dark" href="projects.php?cnc">CNC</a>
						<a class="dropdown-item text-dark" href="projects.php?polishing">Polishing</a>
						<a class="dropdown-item text-dark" href="projects.php?installs">Installs</a>
						<a class="dropdown-item text-dark" href="projects.php?timeline">Timeline</a>
<?
	if ($_SESSION['id'] == 1448) {
?>
						<a class="dropdown-item text-dark" href="admin.php?pay">Installer Pay</a>
<?
	}
?>
					</div>
				</li>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Prices</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/projects.php?marbgran">Marble/Granite</a>
						<a class="dropdown-item text-dark" href="/admin/projects.php?quartz">Quartz</a>
					</div>
				</li>
<?
	}
	if ($access_level == 6 || $access_level == 1 || $_SESSION['id'] == 1545 || ($division == "2B" && $department == 0)) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Materials</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/materials.php">Material Needed</a>
						<a class="dropdown-item text-dark" href="/admin/accessories.php">Accessories Needed</a>
						<a class="dropdown-item text-dark" href="/admin/pull_list_mats.php">Pull Materials</a>
						<a class="dropdown-item text-dark" href="/admin/pull_list.php">Pull Accessories</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?marble">Marble/Granite</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?quartz">Quartz</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?accessories">Accessories</a>
<?
			if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1283) {
?>
						<a class="dropdown-item text-dark" href="admin.php?order">Ordering</a>
						<a class="dropdown-item text-dark" href="admin_inventory_manager.php">Inventory</a>
						<a class="dropdown-item text-dark" href="admin_item_edit.php">Item Lookup</a>
<?
			}
?>
					</div>
				</li>
<?
	}
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/time_off.php">Time Off
						</a>
					</div>
				</li>			
			</ul>
			<h3 class="text-primary">Hi <?= $first_name ?> </h3>
			<a href="/logout.php" class="btn nav-item aqua-gradient my-auto text-white">Log Out</a>
		</div>
	</nav>
</header>
<?
}
?>
