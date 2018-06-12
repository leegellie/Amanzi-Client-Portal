<?PHP 
// IF USER ACCESS  = 1 THEN USER IS AN ADMIN. SHOW ADMIN MENU
if ($access_level < 11) {
?>
<header class=" d-print-none">

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark" style="top:0px; z-index:5">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        	<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#"><img src="../images/icon.png" style="max-width:52px"></a>
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav m-auto">
<?
		if ( $access_level < 4 && $access_level != "") {
			$link = 'Location: /admin/dashboard.php';
		} elseif ($access_level == 4) {
			$link = 'Location: /admin/projects.php?templates';
		} elseif ($access_level == 5) {
			$link = 'Location: /admin/projects.php?programming';
		} elseif ($access_level == 7) {
			$link = 'Location: /admin/projects.php?saw';
		} elseif ($access_level == 8) {
			$link = 'Location: /admin/projects.php?cnc';
		} elseif ($access_level == 9) {
			$link = 'Location: /admin/projects.php?polishing';
		} elseif ($access_level == 10) {
			$link = 'Location: /admin/projects.php?installs';
		}
?>
				<li class="nav-item py-3 px-4">
					<a class="element" href="<?= $link ?>"><span class="icon-home"></span></a>
				</li>
<?
	if ($access_level < 4) {
		if ($_SESSION['id'] == 1 || $_SESSION['id'] == 14 || $_SESSION['id'] == 1447) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="userdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
					<div class="dropdown-menu" aria-labelledby="userdropdown">
<?
			if ($_SESSION['id'] != 1447) {
?>
						<a class="dropdown-item text-dark" href="admin.php?profit">Profit/Loss</a>
<?
			}
?>
						<a class="dropdown-item text-dark" href="admin.php?stats">Stats</a>
					</div>
				</li>
<?
		}
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
	if ($access_level == 6 || $access_level == 1) {
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Materials</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/materials.php">Material Needed</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?marble">Marble/Granite</a>
						<a class="dropdown-item text-dark" href="/admin/admin.php?quartz">Quartz</a>
					</div>
				</li>
<?
	}
?>
				<li class="nav-item py-3 px-4 dropdown">
					<a class="dropdown-toggle text-white" id="toolsdropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Staff</a>
					<div class="dropdown-menu" aria-labelledby="toolsdropdown">
						<a class="dropdown-item text-dark" href="/admin/time_off.php">Time Off</a>
					</div>
				</li>			
			</ul>
			<h3 class="text-primary">Hi <?= $first_name ?> </h3>
			<a href="/logout.php" class="btn nav-item btn-secondary my-auto text-white">Log Out</a>
		</div>
	</nav>
</header>
<?
}
?>
